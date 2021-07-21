<?php
include 'includes/session.php';

if (isset($_POST['add'])) {
	$material_id = $_POST['material_id'];
	$quantity = $_POST['quantity'];
	$total_amount = $_POST['totalAmount'];
	$project_id = $_POST['projectid'];

	$sql = "INSERT INTO project_materials (material_id, quantity, amnt_cost, proj_id) VALUES ('$material_id', '$quantity', '$total_amount', '$project_id')";
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Project Materials added successfully';
	} else {
		$_SESSION['error'] = $conn->error;
	}
} else {
	$_SESSION['error'] = 'Fill up add form first';
}

header('Location: ' . $_SERVER['HTTP_REFERER']);

?>
