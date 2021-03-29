<?php
	include 'includes/session.php';
	
	if(isset($_POST['edit'])){
		$projectid = $_POST['id'];
		$project_name = $_POST['project_name'];
		$project_startdate = $_POST['project_startdate'];
		$project_enddate = $_POST['project_enddate'];
		$project_description = $_POST['project_description'];
		$project_owner = $_POST['project_owner'];
		$project_address = $_POST['project_address'];
		$project_budget = $_POST['project_budget'];
		$project_status = $_POST['project_status'];
		
		$sql = "UPDATE project SET project_name = '$project_name', project_startdate = '$project_startdate', project_enddate = '$project_enddate', project_description = '$project_description', project_owner = '$project_owner', project_address = '$project_address', project_budget = '$project_budget', project_status = '$project_status' WHERE project_id = '$projectid'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Project updated successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}

	}
	else{
		$_SESSION['error'] = 'Select Project to edit first';
	}

	header('location: project.php');
?>