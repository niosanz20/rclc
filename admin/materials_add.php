<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$materials_name = $_POST['materials_name'];
		$materials_description = $_POST['materials_description'];
		$unit = $_POST['unit'];
		$price = $_POST['price'];
		$stock = $_POST['stock'];

		$sql = "INSERT INTO materials (name, description, unit, price, stock) VALUES ('$materials_name', '$materials_description', '$unit', '$price', '$stock')";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Materials added successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: materials.php');

?>