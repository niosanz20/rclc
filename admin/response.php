<?php

	include 'includes/session.php';
    
//      $response=array();
// 	if(isset($_GET['value'])){
	    
// // 		$desc = $_GET['value'];
// 		$sql = "SELECT unit FROM materials WHERE description = '".$_GET['value']."'";
// 		$result = mysqli_query($conn,$sql);
// 		while($row = mysqli_fetch_array($result, MYSQL_BOTH))
// 		{
// 		    array_push($response, $row);
// 		}
// // 		$query = $conn->query($sql);
// // 		$row = $query->fetch_assoc();

// 		echo json_encode($response);
// 	}



    if($_REQUEST['unit']){
        $sql = "SELECT * FROM materials WHERE description = '" . $_REQUEST['unit']."'";
        $resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));	
	    $data = array();
	    while($rows = mysqli_fetch_assoc($resultset))
	    {
	        $data = $rows;
	    }
        echo json_encode($data);
        
    }
    else {
	echo 0;	
}


?>