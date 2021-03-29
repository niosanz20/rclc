<?php
	include 'includes/session.php';

// 	if(isset($_POST['add'])){
// 		$date = $_POST['date'];
// 		$name = $_POST['name'];
// 		$material = $_POST['material'];
// 		$time_borrow = $_POST['time_borrow'];
// // 		$status = $_POST['status'];
//         $status = "In use";
// 		$conditon = "Not returned";
// //  		$time_return = $_POST['time_return'];
//         $time_return = "In use";
//         $price = "0";
// 		$project_id = $_POST['projectid'];

// // 		$sql = "INSERT INTO project_materials_log (date, name, material, time_borrow, status, time_return, proj_id) VALUES ('$date', '$name','$material', '$time_borrow', '$status', '$time_return','$project_id')";
// 		$sql = "INSERT INTO project_materials_log (date, name, material, time_borrow, status, con_dition, time_return, price, proj_id) VALUES ('$date', '$name','$material', '$time_borrow', '$status', '$conditon' , '$time_return' , '$price', '$project_id')";
// 		if($conn->query($sql)){
// 			$_SESSION['success'] = 'Project Materials Log added successfully';
// 		}
// 		else{
// 			$_SESSION['error'] = $conn->error;
// 		}
// 	}	
// 	else{
// 		$_SESSION['error'] = 'Fill up add form first';
// 	}


    
    if(isset($_POST['add'])){
		$date = $_POST['date'];
		$name = $_POST['name'];
		$material = $_POST['material'];
		$quantity = $_POST['quantity'];
		$time_borrow = $_POST['time_borrow'];
        $status = "In use";
		$conditon = "Not returned";
        $time_return = "In use";
        $price = "0";
		$project_id = $_POST['projectid'];
		
		$sql = "SELECT * FROM employees WHERE employee_id = '$name'";
		$query = $conn->query($sql);
		if($query->num_rows < 1){
			$_SESSION['error'] = 'Employee not found';
		}
		else{
		    $sql2 = "SELECT * FROM materials_list WHERE list_id = '$material'";
		    $query = $conn->query($sql2);
		    $srow = $query->fetch_assoc();
		    $quan = $srow['quantity'];
			$row = $query->fetch_assoc();
			
			  if($quan >= $quantity)
		        {
		            $employee_id = $row['id'];
		            $sql = "INSERT INTO project_materials_log (date, name, material, quantity1, time_borrow, status, con_dition, time_return, price, proj_id) VALUES ('$date', '$name','$material','$quantity', '$time_borrow', '$status', '$conditon' , '$time_return' , '$price', '$project_id')";
			        if($conn->query($sql)) {
		
    		            $sql = "UPDATE materials_list SET quantity = quantity - '$quantity' WHERE list_id = '$material'";
    				    $conn->query($sql);
    				    $_SESSION['success'] = 'Project Material Log added successfully';

			       
    		        }
    		        else{
    		             $_SESSION['error'] = $conn->error;
    		        }
			
		        }
		        else{
    		             $_SESSION['error'] = "Looks like you have " .$quan." item stocks in your inventory.";
    		        }
		        
		}
	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}


header('Location: ' . $_SERVER['HTTP_REFERER']);
