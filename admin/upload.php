<?php
 //include_once 'config.php';
 include 'includes/session.php';
 
if(isset($_POST['btn-upload']))
{    
         $project_id = $_POST['id'];
         $file = rand(1000,100000)."-".$_FILES['file']['name'];
         $file_loc = $_FILES['file']['tmp_name'];
         $file_size = $_FILES['file']['size'];
         $file_type = $_FILES['file']['type'];
         $folder="uploads/";
         
         // new file size in KB
         $new_size = $file_size/1024;  
         // new file size in KB
         
         // make file name in lower case
         $new_file_name = strtolower($file);
         // make file name in lower case
         
         $final_file=str_replace(' ','-',$new_file_name);
         
         if(move_uploaded_file($file_loc,$folder.$final_file))
         {
          $sql="INSERT INTO project_files(file,type,size, projectid) VALUES('$final_file','$file_type','$new_size', '$project_id')";
          
          if($conn->query($sql)){
			    $_SESSION['success'] = 'Files added successfully';
		    }
		  else{
		    	$_SESSION['error'] = $conn->error;
		    }
         }
         
         header('Location: ' . $_SERVER['HTTP_REFERER']);
		
}
  
?>
