<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$name = $_POST['employee'];
		$date = $_POST['date'];
		$description = $_POST['description'];
		$price = $_POST['price'];
		
		$sql = "UPDATE damagematerials SET date = '$date', name = '$name', description = '$description',price = '$price' WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Damage material updated successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Fill up edit form first';
	}

	header('location:damagematerial.php');

?>