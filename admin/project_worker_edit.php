<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$position = $_POST['position'];
		$project_date = $_POST['project_date'];
		$project_date_end = $_POST['project_date_end'];
		
		
		$currentDate = date('Y-m-d');
        if($currentDate >= $project_date && $currentDate < $project_date_end)
        {
          $status = "On going";
        }
        else {
           $status = "Vacant";
        }
		
		
		$sql = "UPDATE project_employee SET position = '$position', status = '$status', timeline_sched = '$project_date', project_date_end = '$project_date_end' WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Project Worker updated successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Fill up edit form first';
	}

header('Location: ' . $_SERVER['HTTP_REFERER']);
