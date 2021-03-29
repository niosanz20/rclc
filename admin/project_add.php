<?php
include 'includes/session.php';

if (isset($_POST['add'])) {
    $project_name = $_POST['project_name'];
    $project_startdate = $_POST['project_startdate'];
    $project_enddate = $_POST['project_enddate'];
    $project_description = $_POST['project_description'];
    $project_owner = $_POST['project_owner'];
    $project_address = $_POST['project_address'];
    $project_budget = $_POST['project_budget'];
    // $project_status = $_POST['project_status'];
    $project_status = "Pending";
    $filename = $_FILES['photo']['name'];
    if (!empty($filename)) {
        move_uploaded_file($_FILES['photo']['tmp_name'], '../images/projectimg/' . $filename);
    }
    //creating project id
    $letters = '';
    $numbers = '';
    // $frame_size = ;

    foreach (range('A', 'Z') as $char) {
        $letters .= $char;
    }
    for ($i = 0; $i < 10; $i++) {
        $numbers .= $i;
    }
    $project_id = substr(str_shuffle($letters), 0, 3) . substr(str_shuffle($numbers), 0, 9);

    // $path = '../images/qrimage/';
    // $file = $path . uniqid() . ".png";
    // $qrimage = $file;

    // $ecc stores error correction capability('L') 
    $ecc = 'L';
    $pixel_Size = 10;
    // $frame_Size = 10; 

    // Generates QR Code and Stores it in directory given 
    // QRcode::png($employee_id, $file, $ecc, $pixel_Size);

    // Displaying the stored QR code from directory 
    // echo "<center><img src='".$qrimage."'></center>";

    $sql = "INSERT INTO project (project_id, project_name, project_startdate,project_enddate, project_description, project_owner, project_address, project_budget, project_status, photo) 
                             VALUES ('$project_id', '$project_name', '$project_startdate', '$project_enddate', '$project_description', '$project_owner', '$project_address', '$project_budget', '$project_status', '$filename')";
    if ($conn->query($sql)) {
        // echo "
        //             <label for=qr class=col-sm-3 control-label align=center></label>
        // 			<center><img src='" . $file . "'width=100 height=100></center>
        // 			<a href='" . $file . "' download>Download Your QR Code</a>	
        // 			<a href=employee.php>Back</a>";
        $_SESSION['success'] = 'Project added successfully';
    } else {
        $_SESSION['error'] = $conn->error;
    }
} else {
    $_SESSION['error'] = 'Fill up add form first';
}
	  header('location: project.php');
