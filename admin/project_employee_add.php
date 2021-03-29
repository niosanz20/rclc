<?php
	include 'includes/session.php';

    if(isset($_POST['add'])){
		$name = $_POST['leader'];
		$projectid = $_POST['projectid'];

	    $sql = "INSERT INTO project_leader (name, projectid) VALUES ('$name','$projectid')";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Project Leader added successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	//header('location: project_view.php');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>