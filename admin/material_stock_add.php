<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$id = $_POST['id'];
		$currentstock = $_POST['stock'];
        $stock = $_POST['stock_add'];
        
        $total = $currentstock + $stock;
        
		$sql = "UPDATE materials SET stock = '$total' WHERE materials_id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Material stock added successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: materials.php');

?>
