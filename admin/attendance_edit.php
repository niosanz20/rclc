<?php
include 'includes/session.php';

if (isset($_POST['edit'])) {
	$id = $_POST['id'];
	$date = $_POST['edit_date'];
	$time_in = $_POST['edit_time_in'];
	$time_in = date('H:i:s', strtotime($time_in));
	$time_out = $_POST['edit_time_out'];
	$time_out = date('H:i:s', strtotime($time_out));

	$sql = "UPDATE attendance SET date = '$date', time_in = '$time_in', time_out = '$time_out' WHERE id = '$id'";
	// $sql = "UPDATE attendance SET date = '$date', time_in = '$time_in', time_out = '$time_out' WHERE employee_id = '$id'";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Attendance updated successfully';

		$sql = "SELECT * FROM attendance WHERE id = '$id'";
		// $sql = "SELECT * FROM attendance WHERE employee_id = '$id'";
		$query = $conn->query($sql);
		$urow = $query->fetch_assoc();
		$emp = $urow['employee_id'];
		$time_in = $urow['time_in'];
		$time_out = $urow['time_out'];


		$sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.id = '$emp'";
		// $sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.employee_id = '$emp'";     
		$query = $conn->query($sql);
		$srow = $query->fetch_assoc();

		//updates
		$logstatus = ($time_in > $srow['time_in']) ? 0 : 1;
		//


		if ($srow['time_in'] > $urow['time_in']) {
			$time_in = DateTime::createFromFormat('H:i:s', $srow['time_in']);
		} else
			$time_in = DateTime::createFromFormat('H:i:s', $urow['time_in']);

		$stime_out = DateTime::createFromFormat('H:i:s', $srow['time_out']);
		$time_out = DateTime::createFromFormat('H:i:s', $urow['time_out']);
		// Pagkuha ng OT
		if ($srow['time_out'] < $urow['time_out']) {
			$sql = "SELECT * FROM employees LEFT JOIN position ON position.id=employees.position_id WHERE employees.employee_id = '$emp'";
			$query = $conn->query($sql);
			$prow = $query->fetch_assoc();
			$rate = $prow['rate'];

			$othour = date_diff($stime_out, $time_out)->format('%H');
			$otmin = date_diff($stime_out, $time_out)->format('%i');
			$otint = $othour + ($otmin / 60);
			$amount = ($rate * $otint) * .25;
			$sql = "INSERT INTO overtime (employee_id, date_overtime, hours, rate, amount) VALUES ('$emp', '$date', '$otint', '$rate', '$amount')";
			$conn->query($sql);
			$time_out = $stime_out;
		} else {
			$time_out = $time_out;
		}

		$time_out = DateTime::createFromFormat('H:i:s', $urow['time_out']);
		$hour = date_diff($time_in, $time_out)->format('%H');
		$min = date_diff($time_in, $time_out)->format('%i');
		$int = $hour + ($min / 60);

		if ($hour >= 9)
			$int = $int - 1.0;
		else if ($hour >= 6 && $hour < 9)
			$int = $int - .5;
		else if (($hour > 4) && $hour < 6)
			$int = $int - .25;

		$sql = "UPDATE attendance SET num_hr = '$int', status = '$logstatus' WHERE id = '$id'";
		// 			$sql = "UPDATE attendance SET num_hr = '$int', status = '$logstatus' WHERE employee_id = '$id'";
		$conn->query($sql);
	} else {
		$_SESSION['error'] = $conn->error;
	}
} else {
	$_SESSION['error'] = 'Fill up edit form first';
}

header('location:attendance.php');
