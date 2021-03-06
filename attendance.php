<?php
if (isset($_POST['employee'])) {
	$output = array('error' => false);

	include 'conn.php';
	include 'timezone.php';

	date_default_timezone_set("Asia/Manila");
	$time_now = date('H:i:s');


	$employee = $_POST['employee'];
	$status = $_POST['status'];

	$sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
	$query = $conn->query($sql);

	//if Employee Exist
	if($query->num_rows > 0){
		$sql = "SELECT * FROM employees LEFT JOIN project_employee ON project_employee.name=employees.employee_id LEFT JOIN project ON project.project_id=project_employee.projectid WHERE employees.employee_id = '$employee' AND project_employee.status = 'On going'";
	$query = $conn->query($sql);


	if ($query->num_rows > 0) {
		$row = $query->fetch_assoc();
		// 			$id = $row['id'];
		$id = $row['employee_id'];

		$date_now = date('Y-m-d');

		if ($status == 'in') {
			$sql = "SELECT * FROM attendance WHERE employee_id = '$id' AND date = '$date_now' AND time_in IS NOT NULL";
			$query = $conn->query($sql);
			if ($query->num_rows > 0) {
				$output['error'] = true;
				$output['status'] = "Already Time-in";
				$output['message'] = 'Looks like you already have timed in for today.<br> Please comeback later!';
			} else {
				//updates
				$sched = $row['schedule_id'];
				$lognow = date('H:i:s');
				$sql = "SELECT * FROM schedules WHERE id = '$sched'";
				$squery = $conn->query($sql);
				$srow = $squery->fetch_assoc();
				$logstatus = ($lognow > $srow['time_in']) ? 0 : 1;
				//
				$sql = "INSERT INTO attendance (employee_id, date, time_in, status) VALUES ('$id', '$date_now', '$time_now', '$logstatus')";
				if ($conn->query($sql)) {
					$output['status'] = "Time-in";
					$output['message'] = 'Time in: ' . $row['firstname'] . ' ' . $row['lastname'] . '<br>Position: ' . $row['position'] . '<br>Project: ' . $row['project_name'] . '<br> Location: ' . $row['project_address'];
					// 		$output['message'] = 'Location: '.$row['project_name'];
				} else {
					$output['error'] = true;
					$output['status'] = "Warning";
					$output['message'] = $conn->error;
				}
			}
		} else {

			$sql = "SELECT *, attendance.employee_id AS uid FROM attendance LEFT JOIN employees ON employees.employee_id=attendance.employee_id LEFT JOIN project_employee ON project_employee.name=employees.employee_id LEFT JOIN project ON project.project_id=project_employee.projectid WHERE attendance.employee_id = '$id' AND date = '$date_now'";

			$query = $conn->query($sql);
			if ($query->num_rows < 1) {
				$output['error'] = true;
				$output['status'] = "Warning";
				$output['message'] = 'Cannot Timeout. No time in.';
			} else {
				$row = $query->fetch_assoc();
				if ($row['time_out'] != '00:00:00') {
					//$output['error'] = true;
					$output['status'] = "Already Time-out";
					$output['message'] = 'Looks like you already have timed out for today.<br> Please comeback later!';
				} else {

					// 		$sql = "UPDATE attendance SET time_out = NOW() WHERE id = '".$row['uid']."'";
					$sql = "UPDATE attendance SET time_out = '$time_now' WHERE employee_id = '" . $row['uid'] . "'";
					if ($conn->query($sql)) {
						$output['status'] = "Time-out";
						$output['message'] = 'Time out: ' . $row['firstname'] . ' ' . $row['lastname'] . '<br>Position: ' . $row['position'] . '<br>Project: ' . $row['project_name'] . '<br> Location: ' . $row['project_address'];

						// 			$sql = "SELECT * FROM attendance WHERE id = '".$row['uid']."'";
						$sql = "SELECT * FROM attendance WHERE employee_id = '" . $row['uid'] . "' and date = '$date_now'";
						$query = $conn->query($sql);
						$urow = $query->fetch_assoc();

						$time_in = $urow['time_in'];
						$time_out = $urow['time_out'];

						// 			$sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.id = '$id'";
						$sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.employee_id = '$id'";
						$query = $conn->query($sql);
						$srow = $query->fetch_assoc();


						if ($srow['time_in'] > $urow['time_in']) {
							$time_in = DateTime::createFromFormat('H:i:s', $srow['time_in']);
						} else
							$time_in = DateTime::createFromFormat('H:i:s', $urow['time_in']);

						$stime_out = DateTime::createFromFormat('H:i:s', $srow['time_out']);
						$time_out = DateTime::createFromFormat('H:i:s', $urow['time_out']);
						// Pagkuha ng OT
						if ($srow['time_out'] < $urow['time_out']) {
							$sql = "SELECT * FROM employees LEFT JOIN position ON position.id=employees.position_id WHERE employees.employee_id = '$id'";
							$query = $conn->query($sql);
							$prow = $query->fetch_assoc();
							$position = $prow['description'];
							$rate = $prow['rate'];

							$othour = date_diff($stime_out, $time_out)->format('%H');
							$otmin = date_diff($stime_out, $time_out)->format('%i');
							$otint = $othour * 60 + $otmin;

							if ($otint > 30) {
								$amount = ($rate * ($otint / 60)) * .25;
								$sql = "INSERT INTO overtime (employee_id, date_overtime, hours, rate, amount) VALUES ('$id', '$date_now', '$otint', '$rate', '$amount')";
								$conn->query($sql);
								$time_out = $stime_out;
							}
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



						// 			$sql = "UPDATE attendance SET num_hr = '$int' WHERE id = '".$row['uid']."'";
						$sql = "UPDATE attendance SET num_hr = '$int' WHERE employee_id = '" . $row['uid'] . "'";
						$conn->query($sql);
					} else {
						$output['error'] = true;
						$output['message'] = $conn->error;
					}
				}
			}
		}
	}
	// } else if ($query2->num_rows > 0) {
	// 	$row2 = $query2->fetch_assoc();
	// 	$output['error'] = true;
	// 	$output['message'] = 'Employee has no project!';
	// } 
	else {
		$output['error'] = true;
		$output['status'] = "No project on-going";
		$output['message'] = 'Employee has no project on-going';
	}
	}else{
		$output['error'] = true;
		$output['status'] = "Invalid QR Code";
		$output['message'] = 'Employee not found!';
	}
}

$data = array(
	'status'      =>  $output['status'],
	'message'      =>  $output['message']
);

echo json_encode($data);
	
	//echo json_encode($output);
