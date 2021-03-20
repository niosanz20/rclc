<?php 
	include 'includes/session.php';

	if(isset($_POST['materials_id'])){
		$materials_id = $_POST['materials_id'];
		$sql = "SELECT * FROM materials WHERE materials_id = '$materials_id'";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		echo json_encode($row);
	}
?>