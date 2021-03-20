<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$list_id = $_POST['id'];
		$sql = "DELETE FROM materials_list WHERE list_id = '$list_id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Materials deleted successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Select item to delete first';
	}

	header('location: list_materials.php');
	
?>