<?php
include 'includes/session.php';

if (isset($_POST['add'])) {
	$employee = $_POST['employee'];
	$date = $_POST['date'];
	$time_in = $_POST['time_in'];
	$time_in = date('H:i:s', strtotime($time_in));
	$time_out = $_POST['time_out'];
	$time_out = date('H:i:s', strtotime($time_out));

	$sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
	$query = $conn->query($sql);

	if ($query->num_rows < 1) {
		$_SESSION['error'] = 'Employee not found';
	} else {
		$row = $query->fetch_assoc();
		// 			$emp = $row['id'];
		$emp = $row['employee_id'];

		$sql = "SELECT * FROM attendance WHERE employee_id = '$emp' AND date = '$date'";
		$query = $conn->query($sql);

		if ($query->num_rows > 0) {
			$_SESSION['error'] = 'Employee attendance for the day exist';
		} else {
			//updates
			$sched = $row['schedule_id'];
			$sql = "SELECT * FROM schedules WHERE id = '$sched'";
			$squery = $conn->query($sql);
			$scherow = $squery->fetch_assoc();
			$logstatus = ($time_in > $scherow['time_in']) ? 0 : 1;


			//
			$sql = "INSERT INTO attendance (employee_id, date, time_in, time_out, status) 
			VALUES ('$emp', '$date', '$time_in', '$time_out', '$logstatus')";
			if ($conn->query($sql)) {
				$_SESSION['success'] = 'Attendance added successfully';
				$id = $conn->insert_id;


				$sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.employee_id = '$emp'";
				$query = $conn->query($sql);
				$srow = $query->fetch_assoc();

				
				$stime_out = $srow['time_out'];
				

				// Pagkuha ng OT
				if ($stime_out < $time_out) {
					$sql= "SELECT * FROM employees LEFT JOIN position ON position.id=employees.position_id WHERE employees.employee_id = '$emp'";
					$query = $conn->query($sql);
					$prow = $query->fetch_assoc();
					$position = $prow['description'];
					$rate = $prow['rate'];

					//$othour = date_diff($stime_out, $time_out)->format('%H');
					$othour = date_diff(date_create($stime_out), date_create($time_out))->format('%H');
					$otmin = date_diff(date_create($stime_out), date_create($time_out))->format('%i');
					$otint = $othour * 60 + $otmin;

					if ($otint > 30) {
						$amount = ($rate * ($otint / 60)) * .25;
						$sql = "INSERT INTO overtime (employee_id, date_overtime, hours, rate, amount) 
						VALUES ('$emp', '$date', '$otint', '$rate', '$amount')";
						$conn->query($sql);
						$time_out = $stime_out;
					} else $time_out = $stime_out;
				} else $time_out = $time_out;


				$hour = date_diff(date_create($time_in), date_create($time_out))->format('%H');
				$min = date_diff(date_create($time_in), date_create($time_out))->format('%i');
				$int = $hour + ($min / 60);

				if ($hour >= 9)
					$int = $int - 1.0;
				else if ($hour >= 6 && $hour < 9)
					$int = $int - .75;
				else if (($hour >= 4) && $hour < 6)
					$int = $int - .5;


				// 	$sql = "UPDATE attendance SET num_hr = '$int' WHERE id = '$id'";

				$sql = "UPDATE attendance SET num_hr = $int WHERE employee_id = '$emp' AND date = '$date' ";
				$conn->query($sql);
			} else {
				$_SESSION['error'] = $conn->error;
			}
		}
	}
} else {
	$_SESSION['error'] = 'Fill up add form first';
}

header('location: attendance.php');
