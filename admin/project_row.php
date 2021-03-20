<?php 
	include 'includes/session.php';

	if(isset($_POST['project_id'])){
		$project_id = $_POST['project_id'];
		$sql = "SELECT * FROM project WHERE project_id = '$project_id'";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		echo json_encode($row);
	}
?>