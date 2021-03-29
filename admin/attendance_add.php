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
			$sql = "INSERT INTO attendance (employee_id, date, time_in, time_out, status) VALUES ('$emp', '$date', '$time_in', '$time_out', '$logstatus')";
			if ($conn->query($sql)) {
				$_SESSION['success'] = 'Attendance added successfully';
				$id = $conn->insert_id;

				// 	$sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.id = '$emp'";
				$sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.employee_id = '$emp'";
				$query = $conn->query($sql);
				$srow = $query->fetch_assoc();

				// if($srow['time_in'] > $time_in){
				// 	$time_in = $srow['time_in'];
				// }

				// if($srow['time_out'] < $time_out){
				// 	$time_out = $srow['time_out'];
				// }
				$sql = "SELECT * FROM attendance WHERE employee_id = '$emp' AND date = '$date'";
				$query = $conn->query($sql);
				$urow = $query->fetch_assoc();

				$time_in = $urow['time_in'];
				$time_out = $urow['time_out'];

				// 			$sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.id = '$id'";


				// if ($srow['time_in'] > $time_in) {
				// 	$time_in = $srow['time_in'];
				// } else
				// 	$time_in = $time_in;

				// $time_in = new DateTime($time_in);
				// $time_out = new DateTime($time_out);
				// $interval = $time_in->diff($time_out);
				// $hrs = $interval->format('%h');
				// $mins = $interval->format('%i');
				// $mins = $mins / 60;
				// $int = $hrs + $mins;
				// if ($int > 4) {
				// 	$int = $int - 1;
				// }


				if ($srow['time_in'] > $urow['time_in']) {
					$time_in = DateTime::createFromFormat('H:i:s', $srow['time_in']);
				} else
					$time_in = DateTime::createFromFormat('H:i:s', $urow['time_in']);

				// Pagkuha ng OT
				// if ($srow['time_out'] > $urow['time_out']) {
				// 	$time_out = DateTime::createFromFormat('H:i:s', $srow['time_out']);
				// } else {
				// 	$time_out = DateTime::createFromFormat('H:i:s', $urow['time_out']);			
				// }

				$stime_out = DateTime::createFromFormat('H:i:s', $srow['time_out']);
				$time_out = DateTime::createFromFormat('H:i:s', $urow['time_out']);

				// Pagkuha ng OT
				if ($srow['time_out'] < $urow['time_out']) {
					$sql = "SELECT * FROM employees LEFT JOIN position ON position.id=employees.position_id WHERE employees.employee_id = '$emp'";
					$query = $conn->query($sql);
					$prow = $query->fetch_assoc();
					$position = $prow['description'];
					$rate = $prow['rate'];

					$othour = date_diff($stime_out, $time_out)->format('%H');
					$otmin = date_diff($stime_out, $time_out)->format('%i');
					$otint = $othour * 60 + $otmin;

					if ($otint > 30) {
						$amount = ($rate * ($otint / 60)) * .25;
						$sql = "INSERT INTO overtime (employee_id, date_overtime, hours, rate, amount) VALUES ('$emp', '$date', '$otint', '$rate', '$amount')";
						$conn->query($sql);
						$time_out = $stime_out;
					} else $time_out = $stime_out;
				} else {
					$time_out = $time_out;
				}




				$hour = date_diff($time_in, $time_out)->format('%H');
				$min = date_diff($time_in, $time_out)->format('%i');
				$int = $hour + ($min / 60);

				if ($hour >= 9)
					$int = $int - 1.0;
				else if ($hour >= 6 && $hour < 9)
					$int = $int - .5;
				else if (($hour > 4) && $hour < 6)
					$int = $int - .25;





				// 	$sql = "UPDATE attendance SET num_hr = '$int' WHERE id = '$id'";

				$sql = "UPDATE attendance SET num_hr = '$int' WHERE employee_id = '$emp'";
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
