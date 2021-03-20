<?php
	include 'includes/session.php';

	if(isset($_POST['upload'])){
		$project_id = $_POST['id'];
		$filename = $_FILES['photo']['name'];
		if(!empty($filename)){
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/projectimg/'.$filename);	
		}
		
		$sql = "UPDATE project SET photo = '$filename' WHERE project_id = '$project_id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Project photo updated successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}

	}
	else{
		$_SESSION['error'] = 'Select project to update photo first';
	}

	header('location: project.php');
?>