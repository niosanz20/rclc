<?php
include '../../includes/conn.php';

require_once('../../../tcpdf/tcpdf.php');
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'ISO-8859-1', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Overtime Records: ');
$pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont('helvetica');
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetMargins(PDF_MARGIN_LEFT, '9', PDF_MARGIN_RIGHT);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetFont('cid0cs', '', 8, '', false);
$pdf->AddPage();
// $contents = '<style>' . file_get_contents('../payrollstyle.css') . '</style>';
// $temp = isset($_POST['status']) . "asd";
//echo $temp;

$status = $_POST['ot-filter-status'];
$date = $_POST['ot-filter-date'];
$project_id = $_POST['ot-filter-project'];
// $end_date = $_POST['report-cutoff-end-date'];

// echo $status, $date, $project_id;
$sqlCutoff =  !empty($start_date) ? "AND overtime.date_overtime BETWEEN '" . date('Y-m-d', strtotime($start_date)) . "' AND '" . date('Y-m-d', strtotime($end_date)) . "' " : "";
$sqlProject = !empty($project_id) ? "AND project_employee.projectid = '$project_id'" : "";
$sqlStatus = !empty($status) ? "AND overtime.ot_status = '$status'" : "AND overtime.ot_status != 'New'";

$sql = "SELECT *, schedules.time_in AS stime_in, schedules.time_out AS stime_out, attendance.time_in 
            AS ttime_in, attendance.time_out AS ttime_out, project.project_name AS project_name
            FROM overtime 
            LEFT JOIN employees ON employees.employee_id=overtime.employee_id 
            LEFT JOIN position ON position.id=employees.position_id 
            LEFT JOIN schedules ON schedules.id=employees.schedule_id 
            LEFT JOIN project_employee ON project_employee.name=employees.employee_id 
            LEFT JOIN project ON project.project_id=project_employee.projectid 
            LEFT JOIN attendance ON attendance.employee_id=employees.employee_id
            WHERE overtime.date_overtime=attendance.date $sqlCutoff $sqlProject $sqlStatus
            ORDER BY date_overtime DESC";

$result = $conn->query($sql);

$count = 0;
while ($row = $result->fetch_assoc()) {
	$count++;
	$ot_status = "";
	if ($row['ot_status'] == "Approved") {
		$ot_status = "
            <span class='badge badge-finish'><i class=' glyphicon glyphicon-ok-circle'></i> Approved on " . date('M d, Y h:i A', strtotime($row['timestamp'])) . "</span>
                ";
	} else if ($row['ot_status'] == "Declined") {
		$ot_status = "
            <span class='badge badge-pending'><i class=' glyphicon glyphicon-ban-circle'></i> Declined on " . date('M d, Y h:i A', strtotime($row['timestamp'])) . "</span>
			";
	}

	$contents .= "
		<div class='panel'>
			<table class='table table-bordered'>
			<thead>
				<th>Name</th>
				<th>Project Name</th>
				<th>Shift Schedule</th>
				<th>QR Logs</th>
				<th>Minutes of OT</th>
				<th>OT Amount</th>
				<th>Status | Timestamps</th>
				<th>Reasons</th>
			</thead>
			<tbody>
				<tr>
					<td><strong>" . $row['firstname'] . ' ' . $row['lastname'] . '</strong> | ' . $row['description'] . "</td>
					<td>" . $row['project_name'] . "</td>
					<td>" . date('h:i A', strtotime($row['stime_in'])) . ' - ' . date('h:i A', strtotime($row['stime_out'])) . "</td> 
					<td><strong>" . date('M d, Y', strtotime($row['date_overtime'])) . '</strong> | ' . date('h:i A', strtotime($row['ttime_in'])) . ' - ' . date('h:i A', strtotime($row['ttime_out'])) . "</td>
					<td>" . $row['hours'] . "</td>
					<td>" . number_format($row['amount'], 2) . "</td>
					<td>  $ot_status </td>
					<td>" .  $row['reason']  . "</td>
				</tr>
			</tbody>
			</table>
		</div>
		";
}
echo $contents;
$footertext = '<h3>Total of ' . $count . ' records.</h3>';
$pdf->writeHTML($contents);
$pdf->writeHTML($footertext, false, true, false, true);
$pdf->Output('payslip.pdf', 'I');
