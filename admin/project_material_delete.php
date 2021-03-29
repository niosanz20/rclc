<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		$sql = "DELETE FROM project_materials WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Project Material removed successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Select item to delete first';
	}

header('Location: ' . $_SERVER['HTTP_REFERER']);
