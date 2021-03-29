<?php
	include 'includes/session.php';
	
	if(isset($_POST['aid']))
	{
	    $stmt = $conn->prepare("SELECT description FROM materials WHERE name=".$_POST['aid']);
	    $stmt->execute();
	    $description=$stmt->fetchAll(PDO::FETCH_ASSOC);
	    echo json_encode($description);
	}
  
	
?>	