<?php
include '../../includes/conn.php';

if (!empty($_POST['report-title'])) {
	$report_title = $_POST['report-title'];
} else $report_title = "Overtime Report";



require_once('../../../tcpdf/tcpdf.php');
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'ISO-8859-1', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('OVERTIME REPORT');
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
$pdf->AddPage('L', 'LEGAL');
$pdf->Cell(0, 15, str_replace('<br>', ' | ', $report_title), 0, true, 'C', 0, '', 0, true, 'M', 'M');
$contents = '<style>' . file_get_contents('../otreport.css') . '</style>';
// $temp = isset($_POST['status']) . "asd";
//echo $temp;


$status = $_POST['ot-filter-status'];
$project_id = $_POST['ot-filter-project'];
$start_date = $end_date = "";

if (!empty($_POST['ot-filter-date'])) {
	$range = $_POST['ot-filter-date'];
	$ex = explode(' - ', $range);
	$start_date = date('Y-m-d', strtotime($ex[0]));
	$end_date = date('Y-m-d', strtotime($ex[1]));
}

$sqlCutoff =  !empty($start_date) ? "AND overtime.date_overtime BETWEEN '" . date('Y-m-d', strtotime($start_date)) . "' AND '" . date('Y-m-d', strtotime($end_date)) . "' " : "";
$sqlProject = !empty($project_id) ? "AND project_employee.projectid = '$project_id'" : "";
$sqlStatus = !empty($status) ? "AND overtime.ot_status = '$status'" : "AND overtime.ot_status != 'New'";

$sql = "SELECT *, schedules.time_in AS stime_in, schedules.time_out AS stime_out, attendance.time_in 
            AS ttime_in, attendance.time_out AS ttime_out, overtime.reason AS rs, project.project_name AS project_name
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
//echo $sql;
$contents .= '
		<div class="panel">
			<table class="greyGridTable">
				<thead>
					<tr>
						<th width="15%" align="center" class="title">Employee Name</th>
						<th width="12%" align="center" class="title">Project Name</th>
						<th width="11%" align="center" class="title">Shift Schedule</th>
						<th width="15%" align="center" class="title">QR Logs</th>
						<th width="7%" align="center" class="title">Minutes of OT</th>
						<th width="7%" align="center" class="title">OT Amount</th>
						<th width="32%" align="center" class="title">Status & Timestamps | Reasons</th>
					</tr>
				</thead>
				<tbody>
			';

$count = 0;
while ($row = $result->fetch_assoc()) {
	$count++;
	$ot_status = "";
	if ($row['ot_status'] == "Approved") {
		$ot_status = "
            <span>Approved on " . date('M d, Y h:i A', strtotime($row['timestamp'])) . "</span>
                ";
	} else if ($row['ot_status'] == "Declined") {
		$ot_status = "
            <span>Declined on " . date('M d, Y h:i A', strtotime($row['timestamp'])) . "</span>
			";
	}

	$contents .= '
					<tr>
						<td width="15%" align="left">' . $row['firstname'] . ' ' . $row['lastname'] . ' | ' . $row['description'] . '</td>
						<td width="12%" align="left">' . $row['project_name'] . '</td>
						<td width="11%" align="center">' . date('h:i A', strtotime($row['stime_in'])) . ' - ' . date('h:i A', strtotime($row['stime_out'])) . '</td> 
						<td width="15%" align="center">' . date('M d, Y', strtotime($row['date_overtime'])) . ' | ' . date('h:i A', strtotime($row['ttime_in'])) . ' - ' . date('h:i A', strtotime($row['ttime_out'])) . '</td>
						<td width="7%" align="center">' . $row['hours'] . '</td>
						<td width="7%" align="center">' . number_format($row['amount'], 2) . '</td>
						<td width="32%" align="center">' . $ot_status . ' | ' . $row['rs'] . '</td>
					</tr>
				';
}

$contents .= '
				</tbody>
			</table>
		</div>
';
// echo json_encode($contents);
// echo $contents;
$footertext = '<h3>Total of ' . $count . ' records.</h3>';
$pdf->writeHTML($contents);
$pdf->writeHTML($footertext, false, true, false, true);
$pdf->Output('payslip.pdf', 'I');