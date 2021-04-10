<?php
include 'includes/session.php';

if (isset($_POST['edit'])) {

	$empid = $_POST['id'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$address = $_POST['address'];
	$birthdate = $_POST['birthdate'];
	$contact = $_POST['contact'];
	$gender = $_POST['gender'];
	$position = $_POST['position'];
	$schedule = $_POST['schedule'];

	$sss = !empty($_POST['sss']) ? $_POST['sss'] : "N/A";
	$philhealth = !empty($_POST['philhealth']) ? $_POST['philhealth'] : "N/A";
	$pagibig = !empty($_POST['pagibig']) ? $_POST['pagibig'] : "N/A";
	$tin = !empty($_POST['tin']) ? $_POST['tin'] : "N/A";

	$sql = "UPDATE employees SET firstname = '$firstname', 
	lastname = '$lastname', 
	address = '$address', 
	birthdate = '$birthdate', 
	contact_info = '$contact', 
	gender = '$gender', 
	position_id = '$position', 
	schedule_id = '$schedule', 
	sss = '$sss', 
	philhealth = '$philhealth', pagibig = '$pagibig', tin = '$tin' 
	WHERE id = '$empid'";
	// 		$sql = "UPDATE employees SET firstname = '$firstname', lastname = '$lastname', address = '$address', birthdate = '$birthdate', contact_info = '$contact', gender = '$gender', schedule_id = '$schedule' WHERE id = '$empid'";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Employee updated successfully';
	} else {
		$_SESSION['error'] = $conn->error;
	}
} else {
	$_SESSION['error'] = 'Select employee to edit first';
}

header('location: employee.php');
