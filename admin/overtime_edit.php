<?php
include 'includes/session.php';

if (isset($_POST['edit'])) {
	$id = $_POST['id'];
	$date = $_POST['date'];
	$hours = $_POST['hours'] + ($_POST['mins'] / 60);
	$rate = $_POST['rate'];

	$sql = "UPDATE overtime SET ot_status = 'Approved' WHERE id = '$id'";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Overtime approved successfully';
	} else {
		$_SESSION['error'] = $conn->error;
	}
} else {
	$_SESSION['error'] = 'Fill up edit form first';
}

header('location:overtime.php');
