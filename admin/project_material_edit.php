<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['materialId'];
	    $quantity = $_POST['quantity'];
	    $amnt_cost = $_POST['totalAmount'];

		$sql = "UPDATE project_materials SET quantity = '$quantity', amnt_cost = '$amnt_cost'
		WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Project Material updated successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Fill up edit form first';
	}

header('Location: ' . $_SERVER['HTTP_REFERER']);
