<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		$date_attendance = $_POST['attendace_date'];
		$sql = "DELETE FROM attendance WHERE id = '$id'";
		$sqlot = "DELETE FROM overtime WHERE date_overtime = '$date_attendance'";

		if($conn->query($sql) && $conn->query($sqlot)){
			$_SESSION['success'] = 'Attendance deleted successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Select item to delete first';
	}

	header('location: attendance.php');
	
?>