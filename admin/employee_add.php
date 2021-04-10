<?php
include 'includes/session.php';
include 'phpqrcode/qrlib.php'; //QR Library
include 'includes/header.php';
// include 'employee_modal.php';

if (isset($_POST['add'])) {
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$address = $_POST['address'];
	$birthdate = $_POST['birthdate'];
	$contact = $_POST['contact'];
	$gender = $_POST['gender'];
	$position = $_POST['position'];
	$schedule = $_POST['schedule'];
	$sss = $_POST['sss'];
	$philhealth = $_POST['philhealth'];
	$pagibig = $_POST['pagibig'];
	$tin = $_POST['tin'];
	$filename = $_FILES['photo']['name'];
	// $qrimage = $_FILES['qrimage'];
	if (!empty($filename)) {
		move_uploaded_file($_FILES['photo']['tmp_name'], '../images/' . $filename);
	}
	//creating employee id
	$letters = '';
	$numbers = '';
	// $frame_size = ;

	foreach (range('A', 'Z') as $char) {
		$letters .= $char;
	}
	for ($i = 0; $i < 10; $i++) {
		$numbers .= $i;
	}
	$employee_id = substr(str_shuffle($letters), 0, 3) . substr(str_shuffle($numbers), 0, 9);

	$path = '../images/qrimage/';
	$file = $path . uniqid() . ".png";
	$qrimage = $file;

	// $ecc stores error correction capability('L') 
	$ecc = 'L';
	$pixel_Size = 10;
	// $frame_Size = 10; 

	// Generates QR Code and Stores it in directory given 
	QRcode::png($employee_id, $file, $ecc, $pixel_Size);

	// Displaying the stored QR code from directory 
	// echo "<center><img src='".$qrimage."'></center>";
	$ytdtax = $ytdsss = $ytdphilhealth = $ytdpagibig = $ytdgross_income = 0;

	$sqlytd = "INSERT INTO yeartodate (employee_id, tax, sss, philhealth, pagibig, gross_income) VALUES ('$employee_id', '$ytdtax', '$ytdsss', '$ytdphilhealth', '$ytdpagibig', '$ytdgross_income')";
	$conn->query($sqlytd);
	$sql = "INSERT INTO employees (employee_id, firstname, lastname, address, birthdate, contact_info, gender, position_id, schedule_id, photo, created_on, sss, philhealth, pagibig, tin, qrimage) VALUES ('$employee_id', '$firstname', '$lastname', '$address', '$birthdate', '$contact', '$gender', '$position', '$schedule', '$filename', NOW(), '$sss', '$philhealth', '$pagibig', '$tin', '$qrimage')";
	if ($conn->query($sql)) {
		echo "
		<div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h4 class='modal-title'><b> " . $firstname . "  " . $lastname . "</b></h4>
      </div>
      <div class='modal-body'>
          <label for=qr  control-label></label>
					<center><img src='" . $file . "'width=100 height=100></center>
		</div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-default btn-flat pull-left' data-dismiss='modal'><i class='fa fa-close'></i><a href='employee.php'>Back</a></button>
        <button type='submit' class='btn btn-primary btn-flat' name='download'><i class='fa fa-download'></i> <a href='" . $file . "' download style='color: white;'>Download</a></button>
      </div>
	</div>
</div>
		";
		$_SESSION['success'] = 'Employee added successfully';
	} else {
		$_SESSION['error'] = $conn->error;
	}
} else {
	$_SESSION['error'] = 'Fill up add form first';
}
//header('location: employee.php');
