<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$list_id = $_POST['id'];
		$currentquantity = $_POST['quantity'];
        $quantity = $_POST['quantity_add'];
        
        $total = $currentquantity + $quantity;
        
		$sql = "UPDATE materials_list SET quantity = '$total' WHERE list_id = '$list_id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Material quantity added successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: list_materials.php');

?>
