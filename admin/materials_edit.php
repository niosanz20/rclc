<?php
	include 'includes/session.php';
	
	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$name = $_POST['name'];
		$description = $_POST['description'];
		$unit = $_POST['unit'];
		$price = $_POST['price'];
		$stock = $_POST['stock'];
		
		$sql = "UPDATE materials SET name = '$name', description = '$description', unit = '$unit', price = '$price', stock = '$stock' WHERE materials_id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Materials updated successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}

	}
	else{
		$_SESSION['error'] = 'Select Material to edit first';
	}

	header('location: materials.php');
?>