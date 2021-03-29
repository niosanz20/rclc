<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$date = $_POST['date'];
		$name = $_POST['employee'];
		$description = $_POST['description'];
		$price = $_POST['price'];

		$sql = "INSERT INTO damagematerials (date, name, description, price) VALUES ('$date', '$name', '$description', '$price')";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Damage Material added successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: damagematerial.php');

?>