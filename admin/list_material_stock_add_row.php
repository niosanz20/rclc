<?php 
	include 'includes/session.php';

	if(isset($_POST['list_id'])){
		$list_id = $_POST['list_id'];
		$sql = "SELECT * FROM materials_list WHERE list_id = '$list_id'";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		echo json_encode($row);
	}
?>

