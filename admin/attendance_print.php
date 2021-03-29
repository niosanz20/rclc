<?php
include 'includes/session.php';

function generateRow($conn)
{
    $contents = '';

    $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id ORDER BY attendance.date DESC, attendance.time_in DESC";

    $query = $conn->query($sql);
    $total = 0;

    while ($row = $query->fetch_assoc()) {
        if ($row['status'] == 1)
            $status = "Ontime";
        else $status = "Late";
        $contents .= "
            <tr>
                <td>" . date('M d, Y', strtotime($row['date'])) . "</td>
                <td>" . $row['empid'] . "</td>
                <td>" . $row['lastname'] . ", " . $row['firstname'] . "</td>
                <td>" . $status . "</td>
				<td>" . date('h:i A', strtotime($row['time_in'])) . ' - ' . date('h:i A', strtotime($row['time_out'])) . "</td>
			</tr>
			";
    }

    return $contents;
}

require_once('../tcpdf/tcpdf.php');
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('RC Llaguno Construction - Attendance Report');
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
$content = '';
$content .= '
      	<h2 align="center">RC Llaguno Construction</h2>
      	<h4 align="center">Attendance Report</h4>
      	<table border="1" cellspacing="0" cellpadding="3">  
           <tr> 
                <th width="15%" align="center"><b>Date</b></th> 
                <th width="20%" align="center"><b>Employee ID</b></th>
                <th width="30%" align="center"><b>Employee Name</b></th>
                <th width="10%" align="center"><b>Status</b></th>
				<th width="25%" align="center"><b>Schedule</b></th> 
           </tr>  
      ';
$content .= generateRow($conn);
$content .= '</table>';
$pdf->writeHTML($content);
$pdf->Output('AttendanceReport.pdf', 'I');
