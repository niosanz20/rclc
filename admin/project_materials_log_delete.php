<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		$quantity = $_POST['quantity'];
		$list_id = $_POST['mat_list'];
		$sql = "DELETE FROM project_materials_log WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Project Materials Log removed successfully';
			
			$sql = "UPDATE materials_list SET quantity = quantity + '$quantity' WHERE list_id = '$list_id'";
			$conn->query($sql);
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Select item to delete first';
	}

header('Location: ' . $_SERVER['HTTP_REFERER']);
