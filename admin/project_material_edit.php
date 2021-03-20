<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$description = $_POST['description'];
	    $quantity = $_POST['quantity'];
	    $unit = $_POST['unit'];
	    $unit_cost = $_POST['unit_cost'];
	    $amnt_cost = $_POST['amnt_cost'];

		$sql = "UPDATE project_materials SET description = '$description', quantity = '$quantity', unit = '$unit', unit_cost = '$unit_cost', amnt_cost = '$amnt_cost' WHERE id = '$id'";
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
