<?php
	include 'includes/session.php';
	
	if(isset($_POST['edit'])){
		$list_id = $_POST['id'];
		$materials_name = $_POST['name'];
// 		$description = $_POST['description'];
// 		$unit = $_POST['unit'];
// 		$price = $_POST['price'];
// 		$stock = $_POST['stock'];
		
		$sql = "UPDATE materials_list SET materials_name = '$materials_name' WHERE list_id = '$list_id'";
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

	header('location: list_materials.php');
?>