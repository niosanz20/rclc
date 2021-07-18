<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$status = $_POST['status'];
	    $conditon = $_POST['material'];
	    $time_return = $_POST['time_return'];
	    $price = $_POST['price'];
	    $quantity = $_POST['quantity'];
	    $mat = $_POST['list_material'];
        // $name = $_POST['name'];
		
	//	$date = $_POST['date'];
	 //   $name = $_POST['name'];
	  //  $material = $_POST['material'];
	   // $time_borrow = $_POST['time_borrow'];
// 		$sql = "UPDATE project_materials_log SET date = '$date', name = '$name', material = '$material', time_borrow = '$time_borrow', status = '$status', time_return = '$time_return' WHERE id = '$id'";

		$sql = "UPDATE project_materials_log SET status = '$status', con_dition = '$conditon', time_return = '$time_return' , price = '$price' WHERE id = '$id'";
		
		if($conn->query($sql)){
		   
		   $_SESSION['success'] = 'Project Materials returned successfully';
		   
// 		   $pmsql = "SELECT * FROM materi WHERE id = '$id'";
// 		   $pmquery = $conn->query($pmsql);
// 		   $pmrow = $pmquery->fetch_assoc();
			
// 			$mat = $pmrow['material']; 
// 		    $quanti = $pmrow['quantity1'];
// 		    $total = $quantity + $quanti;
		      
		    $sql = "UPDATE materials_list SET quantity = quantity + '$quantity', item_borrowed = item_borrowed - '$quantity' WHERE list_id = '$mat'";
			$conn->query($sql);
		    
		}
		else{
			$_SESSION['error'] = $conn->error;
			
		}
	}
	else{
		$_SESSION['error'] = 'Fill up edit form first';
	}

header('Location: ' . $_SERVER['HTTP_REFERER']);
