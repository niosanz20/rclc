<?php
include 'includes/session.php';
define('TIMEZONE', 'Asia/Singapore');
date_default_timezone_set(TIMEZONE);

if (isset($_POST['delete'])) {
	$id = $_POST['id'];

	if(!empty($_POST['reason'])) {
        foreach($_POST['reason'] as $reason){
			$reasons .= $reason . ", ";
        }
    }
	
	$others = $_POST['others'];
	$timestamp = date("Y-m-d H:i:s");

	$sql = "UPDATE overtime SET ot_status = 'Declined', reason = '$reasons $others', timestamp = '$timestamp' WHERE id = '$id'";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Overtime declined successfully';
	} else {
		$_SESSION['error'] = $conn->error;
	}
} else {
	$_SESSION['error'] = 'Select item to delete first';
}

header('location: overtime.php');