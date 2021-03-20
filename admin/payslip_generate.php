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
$pdf->SetTitle('Payslip: ' . $from_title . ' - ' . $to_title);
$pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont('helvetica');
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->SetFont('helvetica', '', 10);
$pdf->AddPage();
$contents = '';

// $sql = "SELECT *, SUM(num_hr) AS total_hr, attendance.employee_id AS empid, employees.employee_id AS employee FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id LEFT JOIN position ON position.id=employees.position_id WHERE date BETWEEN '$from' AND '$to' GROUP BY attendance.employee_id ORDER BY employees.lastname ASC, employees.firstname ASC";

$sql = "SELECT *, SUM(num_hr) AS total_hr, attendance.employee_id AS empid, employees.employee_id AS employee FROM attendance LEFT JOIN employees ON employees.employee_id=attendance.employee_id LEFT JOIN position ON position.id=employees.position_id WHERE date BETWEEN '$from' AND '$to' GROUP BY attendance.employee_id ORDER BY employees.lastname ASC, employees.firstname ASC";

$query = $conn->query($sql);
while ($row = $query->fetch_assoc()) {
	$empid = $row['empid'];
	$pmlogs = $row['employee_id'];

	$casql = "SELECT *, SUM(amount) AS cashamount FROM cashadvance WHERE employee_id='$empid' AND date_advance BETWEEN '$from' AND '$to'";

	$caquery = $conn->query($casql);
	$carow = $caquery->fetch_assoc();
	$cashadvance = $carow['cashamount'];


	// Cost of Damage Materials
	$sql = "SELECT *, SUM(price) AS totalprice FROM project_materials_log WHERE name='$pmlogs' AND date BETWEEN '$from' AND '$to'";
	$pmlquery = $conn->query($sql);
	$pmlrow = $pmlquery->fetch_assoc();
	$pmlogs_price = $pmlrow['totalprice'];


	$gross = $row['rate'] * $row['total_hr'];
	$total_deduction = $deduction + $cashadvance + $pmlogs_price;
	$net = $gross - $total_deduction;


	$contents .= '
			<h2 align="center">RC Llaguno Construction</h2>
			<h4 align="center">' . $from_title . " - " . $to_title . '</h4>
			<table cellspacing="0" cellpadding="1.7">  
    	       	<tr>  
            		<td width="25%" align="right">Employee Name: </td>
                 	<td width="25%"><b>' . $row['firstname'] . " " . $row['lastname'] . '</b></td>
				 	<td width="25%" align="right">Rate per Hour: </td>
                 	<td width="25%" align="right">' . number_format($row['rate'], 2) . '</td>
    	    	</tr>
    	    	<tr>
    	    		<td width="25%" align="right">Employee ID: </td>
				 	<td width="25%">' . $row['employee'] . '</td>   
				 	<td width="25%" align="right">Total Hours: </td>
				 	<td width="25%" align="right">' . number_format($row['total_hr'], 2) . '</td> 
    	    	</tr>
    	    	<tr> 
    	    		<td width="25%" align="right"></td> 
    	    		<td width="25%" align="right"></td>
				 	<td width="25%" align="right"><b>Gross Pay: </b></td>
				 	<td width="25%" align="right"><b>' . number_format(($row['rate'] * $row['total_hr']), 2) . '</b></td> 
    	    	</tr>
    	    	<tr> 
    	    		<td></td> 
    	    		<td></td>
				 	<td width="20%" align="right"><b>Deduction: </b></td>
    	    	</tr>
    	    	<tr> 
    	    		<td></td> 
    	    		<td></td>
				 	<td width="25%" align="right">Government: </td>
				 	<td width="25%" align="right">' . number_format($deduction, 2) . '</td> 
    	    	</tr>
    	    	<tr> 
    	    		<td width="25%" align="right"></td> 
    	    		<td width="15%" align="right"></td>
				 	<td width="35%" align="right">Cost of Damage Material: </td>
				 	<td width="25%" align="right">' . number_format($pmlogs_price, 2) . '</td> 
    	    	</tr>
    	    	<tr> 
    	    		<td width="25%" align="right"></td> 
    	    		<td width="25%" align="right"></td>
				 	<td width="25%" align="right">Cash Advance: </td>
				 	<td width="25%" align="right">' . number_format($cashadvance, 2) . '</td> 
    	    	</tr>
    	    	<tr> 
    	    		<td width="25%" align="right"></td> 
    	    		<td width="25%" align="right"></td>
				 	<td width="25%" align="right"><b>Total Deduction:</b></td>
				 	<td width="25%" align="right"><b>' . number_format($total_deduction, 2) . '</b></td> 
    	    	</tr>
    	    	<tr> 
    	    		<td width="25%" align="left"><b>Deductions:</b></td> 
    	    		<td width="25%" align="right"></td>
				 	<td width="25%" align="right"><b>Net Pay:</b></td>
				 	<td width="25%" align="right"><b>' . number_format($net, 2) . '</b></td> 
    	    	</tr>
				<tr> 
    	    		<td width="25%" align="left" style="font-size: 7px"><b>Government:</b></td> 
    	    		<td width="25%" align="right"></td>
				 	<td width="25%" align="right"></td>
				 	<td width="25%" align="right"></td> 
    	    	</tr>
				<tr>
					<td width="10%" align="right"></td>
				';
	$dsql = "SELECT * FROM deductions";
	$dquery = $conn->query($dsql);
	while ($drow = $dquery->fetch_assoc()) {
		$deducdesc = $drow['description'];
		$damount = $drow['amount'];
		$contents .= '	
				<td width="20%" align="left" style="font-size: 7px"><b>' . $deducdesc . '</b> = ' . number_format($damount, 2) . '</td> ';
	}
	$contents .= '</tr> ';
	$pml1sql = "SELECT * FROM project_materials_log where name='$pmlogs'";
	$pml1query = $conn->query($pml1sql);
	$pm1lrow = $pml1query->fetch_assoc();
	if ($pm1lrow['price'] != 0) {
		$contents .= ' 
				<tr>
					<td width="25%" align="left" style="font-size: 7px"><b>Materials:</b></td> 
				</tr>
				<tr>
					<td width="10%" align="right"></td>
				';
// 		$pmlsql = "SELECT * FROM project_materials_log where name='$pmlogs'";
		$pmlsql = "SELECT * FROM project_materials_log LEFT JOIN materials_list ON materials_list.list_id=project_materials_log.material where name='$pmlogs'";
		$pmlquery = $conn->query($pmlsql);
		while ($pmlrow = $pmlquery->fetch_assoc()) {
			$pmaterial = $pmlrow['materials_name'];
			$pprice = $pmlrow['price'];
			$contents .= '	
				<td width="20%" align="left" style="font-size: 7px"><b>' . $pmaterial . '</b> = ' . number_format($pprice, 2) . '</td> ';
		}
		$contents .= '
				</tr>';
	} else {
		$contents .= '
    	    </table>
    	    <br><hr>
		';
	}
}
$pdf->writeHTML($contents);
$pdf->Output('payslip.pdf', 'I');
