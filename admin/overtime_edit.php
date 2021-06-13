<?php
include 'includes/session.php';
define('TIMEZONE', 'Asia/Singapore');
date_default_timezone_set(TIMEZONE);

if (isset($_POST['edit'])) {
	$id = $_POST['id'];
	$timestamp = date("Y-m-d H:i:s");

	$sql = "UPDATE overtime SET ot_status = 'Approved', timestamp = '$timestamp' WHERE id = '$id'";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Overtime approved successfully';
	} else {
		$_SESSION['error'] = $conn->error;
	}
} else {
	$_SESSION['error'] = 'Fill up edit form first';
}

header('location:overtime.php');