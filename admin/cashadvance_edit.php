<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$amount = $_POST['amount'];
		$notes = $_POST['notes'];
		
		$sql = "UPDATE cashadvance SET amount = '$amount', notes = '$notes' WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Cash advance updated successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Fill up edit form first';
	}

	header('location:cashadvance.php');