<?php
include 'includes/session.php';

if (isset($_POST['add'])) {
	$description = $_POST['description'];
	$quantity = $_POST['quantity'];
	$unit = $_POST['unit'];
	$unit_cost = $_POST['unit_cost'];
	$amnt_cost = $_POST['amnt_cost'];
	$project_id = $_POST['projectid'];

	$sql = "INSERT INTO project_materials (description, quantity, unit, unit_cost, amnt_cost, proj_id) VALUES ('$description', '$quantity', '$unit', '$unit_cost', '$amnt_cost','$project_id')";
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
