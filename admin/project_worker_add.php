<?php
include 'includes/session.php';

// if (isset($_POST['add'])) {
// 	//$leader = $_POST['leader'];
// 	$name = $_POST['worker'];
// 	$position = $_POST['position'];
// 	$status = "Assigned";
// 	$timeline_sched = $_POST['project_date']; 
// 	$timeline_sched_end = $_POST['project_date_end']; 
// 	$projectid = $_POST['projectid'];

// 	//$sql = "INSERT INTO project_employee (name,proj_id) VALUES ('$name','$projectid'),('$name2','$projectid'),('$name3','$projectid'),('$name4','$projectid'),('$name5','$projectid'),('$name6','$projectid'),('$name7','$projectid'),('$name8','$projectid'),('$name9','$projectid'),('$name10','$projectid'),('$leader','$projectid')";
// 	$sql = "INSERT INTO project_employee (name, position,  status, timeline_sched, project_date_end, projectid) VALUES ('$name', '$position', '$status', '$timeline_sched' ,'$timeline_sched_end' ,'$projectid')";
// 	if ($conn->query($sql)) {
// 		$_SESSION['success'] = 'Project Worker added successfully';
// 	} else {
// 		$_SESSION['error'] = $conn->error;
// 	}
// } else {
// 	$_SESSION['error'] = 'Fill up add form first';
// }


if(isset($_POST['add'])){
    
		$name = $_POST['worker'];
    	$position = $_POST['position'];
    // 	$status = "Vacant";
    	$timeline_sched = $_POST['project_date']; 
    	$timeline_sched_end = $_POST['project_date_end']; 
    // 	$project_address = $_POST['project_address']; 
    	$projectid = $_POST['projectid'];
    // 	$project_name = $_POST['project_name'];
		
		
		
		
		
		                $currentDate = date('Y-m-d');
            			if($currentDate >= $timeline_sched && $currentDate < $timeline_sched_end)
            			{
            			    $status = "On going";
            			}
            		    else {
            			    $status = "Vacant";
            			}
            	
            	
            	
            	
            			
		
		$sql = "SELECT * FROM employees WHERE employee_id = '$name'";
		$query = $conn->query($sql);
		if($query->num_rows < 1){
			$_SESSION['error'] = 'Employee not found';
		}
		else{
			$row = $query->fetch_assoc();
			$employee_id = $row['id'];
		    $sql = "INSERT INTO project_employee (name, position,  status, timeline_sched, project_date_end, projectid) VALUES ('$name', '$position', '$status', '$timeline_sched' ,'$timeline_sched_end' ,'$projectid')";
		  //  $sql = "INSERT INTO project_employee (name, position,  status, timeline_sched, project_date_end, project_name, projectid) VALUES ('$name', '$position', '$status', '$timeline_sched' ,'$timeline_sched_end' , '$project_name' ,'$projectid')";
			if($conn->query($sql)){
				$_SESSION['success'] = 'Project Worker added successfully';
			}
			else{
				$_SESSION['error'] = $conn->error;
			}
		}
	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

header('Location: ' . $_SERVER['HTTP_REFERER']);
