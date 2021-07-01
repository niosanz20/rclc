<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$employee = $_POST['employee'];
		$amount = $_POST['amount'];
		$notes = $_POST['notes'];
		
		$sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
		$query = $conn->query($sql);
		if($query->num_rows < 1){
			$_SESSION['error'] = 'Employee not found';
		}
		else{
			$row = $query->fetch_assoc();
// 			$employee_id = $row['id'];
	        $employee_id = $row['employee_id'];
			$sql = "INSERT INTO cashadvance (employee_id, date_advance, amount, notes) VALUES ('$employee_id', NOW(), '$amount', '$notes')";
			if($conn->query($sql)){
				$_SESSION['success'] = 'Cash Advance added successfully';
			}
			else{
				$_SESSION['error'] = $conn->error;
			}
		}
	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: cashadvance.php');