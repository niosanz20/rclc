<?php
include 'includes/session.php'; 


$range = $_POST['date_range'];
$ex = explode(' - ', $range);
$from = date('Y-m-d', strtotime($ex[0]));
$to = date('Y-m-d', strtotime($ex[1]));

$sql = "SELECT *, SUM(amount) as total_amount FROM deductions";
$query = $conn->query($sql);
$drow = $query->fetch_assoc();
$deduction = $drow['total_amount'];

$from_title = date('M d, Y', strtotime($ex[0]));
$to_title = date('M d, Y', strtotime($ex[1]));

require_once('../tcpdf/tcpdf.php');
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle(': ' . $from_title . ' - ' . $to_title);
$pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont('helvetica');
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->SetFont('helvetica', '', 11);
$pdf->AddPage();
$contents = '';

// $sql = "SELECT *, employees.employee_id AS empid, attendance.employee_id AS attempid, attendance.id AS attid, schedules.time_in AS schedin, schedules.time_out AS schedout FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id LEFT JOIN schedules ON employees.schedule_id = schedules.id WHERE date BETWEEN '$from' AND '$to' GROUP BY employees.employee_id ORDER BY employees.employee_id ,attendance.date DESC ";

    // $sql = "SELECT *, employees.employee_id AS empid, attendance.employee_id AS attempid, schedules.time_in AS schedin, schedules.time_out AS schedout FROM attendance LEFT JOIN employees ON employees.employee_id=attendance.employee_id LEFT JOIN schedules ON employees.schedule_id = schedules.id WHERE date BETWEEN '$from' AND '$to' GROUP BY employees.employee_id ORDER BY employees.employee_id ,attendance.date DESC ";
    
    $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attempid, attendance.employee_id AS attempid, schedules.time_in AS schedin, schedules.time_out AS schedout FROM attendance LEFT JOIN employees ON employees.employee_id=attendance.employee_id LEFT JOIN schedules ON employees.schedule_id = schedules.id WHERE date BETWEEN '$from' AND '$to' GROUP BY employees.employee_id ORDER BY employees.employee_id ,attendance.date DESC ";
    
    // $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid FROM attendance LEFT JOIN employees ON employees.employee_id=attendance.employee_id WHERE date BETWEEN '$from' AND '$to' ORDER BY attendance.date DESC, attendance.time_in DESC";
    

//   $sql = "SELECT *, employees.employee_id AS empid, attendance.employee_id AS attempid, attendance.id AS attid, schedules.time_in AS schedin, schedules.time_out AS schedout FROM attendance LEFT JOIN employees ON employees.employee_id=attendance.employee_id LEFT JOIN schedules ON employees.schedule_id = schedules.id WHERE date BETWEEN '$from' AND '$to' GROUP BY employees.employee_id ORDER BY employees.employee_id ,attendance.date DESC ";
   

$query = $conn->query($sql);
while ($row = $query->fetch_assoc()) {
    $ontime = 0;
    $late = 0;

    $empid = $row['empid'];
    $attidemp = $row['attempid'];

    $contents .= '
			<h2 align="center">RC Llaguno Construction</h2>
			<h4 align="center">' . $from_title . " - " . $to_title . '</h4>
			<table cellspacing="0" cellpadding="3">  
    	       	<tr>  
            		<td width="50%" align="left"><b>Employee ID:</b> ' . $row['empid'] . '</td>
                    <td width="50%" align="right"><b>Schedule:</b> ' . date('h:i A', strtotime($row['schedin'])) . ' - ' . date('h:i A', strtotime($row['schedout'])) . '</td>
                </tr>
                <tr> 
                    <td width="50%" align="left"><b>Name:</b> ' . $row['lastname'] . ", " . $row['firstname'] . '</td> 
                </tr>
                <tr>
                    <th width="30%" align="left"><b>Date</b></th>
                    <th width="15%" align="left"><b>Status</b></th>
                    <th width="30%" align="left"><b>Time in & Time out</b></th>
                    <th width="25%" align="left"><b>Minutes of Late</b></th>
                </tr>';
    // $asql = "SELECT *, employees.employee_id AS empid, attendance.date, lastname, firstname, attendance.time_in, attendance.time_out, attendance.status AS schedstatus FROM employees LEFT JOIN attendance ON attendance.employee_id=employees.id WHERE date BETWEEN '$from' AND '$to' AND (attendance.employee_id = '$attidemp') ORDER BY employees.employee_id, attendance.date DESC ";
    
    $asql = "SELECT *, employees.employee_id AS empid, attendance.date, lastname, firstname, attendance.time_in, attendance.time_out, attendance.status AS schedstatus FROM employees LEFT JOIN attendance ON attendance.employee_id=employees.employee_id WHERE date BETWEEN '$from' AND '$to' AND (attendance.employee_id = '$attidemp') ORDER BY employees.employee_id, attendance.date DESC ";
    
    $aquery = $conn->query($asql);
    while ($arow = $aquery->fetch_assoc()) {
        if ($arow['schedstatus'] == 1) {
            $status = "Ontime";
            $ontime++;
            $late = 0;
        } else {
            $status = "Late";
            $late++;
            $time1 = DateTime::createFromFormat('H:i:s', $row['schedin']);
            $time2 = DateTime::createFromFormat('H:i:s', $arow['time_in']);
            $hour = date_diff($time1, $time2)->format('%H');
            $min = date_diff($time1, $time2)->format('%i');
            $late = $hour * 60 + $min;
        }

        $contents .= ' 
                <tr>    
                    <td width="30%" align="left">' . date('M d, Y', strtotime($arow['date'])) . '</td>
                    <td width="15%" align="left">' . $status . '</td>
                    <td width="30%" align="left">' . date('h:i A', strtotime($arow['time_in'])) . ' - ' . date('h:i A', strtotime($arow['time_out'])) . '</td> 
                    <td width="25%" align="left">' . $late . '</td>
                </tr>';
    }
}
$contents .= '</table>';
$pdf->writeHTML($contents);
$pdf->Output('attendance.pdf', 'I');
