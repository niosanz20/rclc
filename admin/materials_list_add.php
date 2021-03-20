<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
// 		$materials_name = $_POST['materials_name'];
// 		$materials_description = $_POST['materials_description'];
// 		$unit = $_POST['unit'];
		$materials_name = $_POST['materials_name'];
		$quantity = $_POST['quantity'];

		$sql = "INSERT INTO materials_list (materials_name, quantity) VALUES ('$materials_name', '$quantity')";
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

	header('location: list_materials.php');

?>