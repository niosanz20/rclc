<?php
include '../includes/conn.php';

require_once('../../tcpdf/tcpdf.php');
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'ISO-8859-1', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Payslip: ' . "RCLC" . ' - ' . "RCLC");
$pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont('helvetica');
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetMargins(PDF_MARGIN_LEFT, '9', PDF_MARGIN_RIGHT);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetFont('cid0cs', '', 8, '', false);
$pdf->AddPage();
$contents = '
 <style>' . file_get_contents('payrollstyle.css') . '</style>

';
if (isset($_POST['cutoff_id'])) {
	$cutoffID = $_POST['cutoff_id'];

	//assumming "0" ay default value or current cut off date
	if ($cutoffID != 0) {
		$sqlCutoffpayslip = "SELECT *, employees.sss as empsss, employees.philhealth as empphil, employees.pagibig as emppag, employees.tin as emptin, yeartodate.sss as sss_ytd, payslip.sss as ps_sss, payslip.philhealth as ps_philhealth 
							FROM employees LEFT JOIN payslip ON payslip.employee_id=employees.employee_id 
							LEFT JOIN project_employee ON project_employee.name=employees.employee_id
							LEFT JOIN cutoff ON cutoff.cutoff_id = payslip.cutoff_id
							LEFT JOIN yeartodate ON yeartodate.employee_id = payslip.employee_id 
							WHERE payslip.cutoff_id='$cutoffID'";
	} else {
		//bago magload yung page ito yung e-eexcute niya (current cutoff date)
		$sqlCutoffpayslip = "SELECT *, employees.sss as empsss, employees.philhealth as empphil, employees.pagibig as emppag, employees.tin as emptin, yeartodate.sss as sss_ytd, payslip.sss as ps_sss, payslip.philhealth as ps_philhealth 
							FROM employees 
							LEFT JOIN payslip ON payslip.employee_id=employees.employee_id
							LEFT JOIN cutoff ON cutoff.employee_id = payslip.employee_id
							LEFT JOIN yeartodate ON yeartodate.employee_id = employees.employee_id
							WHERE payslip.cutoff_id=(SELECT MAX(cutoff_id) FROM cutoff)";
	}

	$result = $conn->query($sqlCutoffpayslip);


	$count = 0;
	while ($rowpayslipcutoff = $result->fetch_assoc()) {
		$count++;
		$contents .= '
		<div class="panel">
		  	<table class="greyGridTable">
				<thead>
					<tr>
						<th width="90%" align="center">RC Llaguno Construction</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td width="15%" align="left"><b>NAME</b></td>
						<td width="20%" align="left">: ' . $rowpayslipcutoff['firstname'] . ' ' . $rowpayslipcutoff['lastname'] . '</td>
						<td width="15%"></td>
						<td width="20%" align="left"></td>
						<td width="20%" align="left"></td>
					</tr>
					<tr>
						<td width="15%" align="left"><b>PAYROLL DATE</b></td>
						<td width="20%" align="left">: ' . date("M j, Y", strtotime($rowpayslipcutoff['payroll_date'])) . '</td>
						<td width="15%"></td>
						<td width="20%" align="left"><b>TIN</b></td>
						<td width="20%" align="left">: ' . $rowpayslipcutoff['emptin'] . '</td>
					</tr>
					<tr>
						<td width="15%" align="left"><b>DATE COVERED</b></td>
						<td width="25%" align="left">: (' . date("M j, Y", strtotime($rowpayslipcutoff['start_date'])) . ' - ' . $end_date = date("M j, Y", strtotime($rowpayslipcutoff['end_date'])) . ')</td>
						<td width="10%"></td>
						<td width="20%" align="left"><b>SSS NO.</b></td>
						<td width="20%" align="left">: ' . $rowpayslipcutoff['empsss'] . '</td>
					</tr>
					<tr>
						<td width="15%" align="left"><b>POSITION</b></td>
						<td width="15%" align="left">: ' . $rowpayslipcutoff['position'] . '</td>
						<td width="20%"></td>
						<td width="20%" align="left"><b>PHILHEALTH NO.</b></td>
						<td width="20%" align="left">: ' . $rowpayslipcutoff['empphil'] . '</td>
					</tr>
					<tr>
						<td width="15%" align="left"><b>PROJECT NAME</b></td>
						<td width="15%" align="left">: ' . $rowpayslipcutoff['project_name'] . '</td>
						<td width="20%"></td>
						<td width="20%" align="left"><b>HDMIF NO.</b></td>
						<td width="20%" align="left">: ' . $rowpayslipcutoff['emppag'] . '</td>
					</tr>
				</tbody>
		  	</table>
		  	<table class="greyGridTable">
				<thead>
					<tr>
						<th width="30%" align="center">COMPENSATION</th>
						<th width="30%" align="center">DEDUCTIONS</th>
						<th width="30%" align="center">YEAR-TO-DATE</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td width="20%" align="left"><b>RATE per HOUR</b></td>
						<td width="10%" align="left">' . number_format($rowpayslipcutoff['rate'], 2) . '</td>
						<td width="20%" align="left"><strong>TAX</strong></td>
						<td width="10%" align="right">' . number_format($rowpayslipcutoff['tax'], 2) . '</td>
						<td width="20%" align="left"><b>TAX</b></td>
						<td width="10%" align="right">' . number_format($rowpayslipcutoff['ytd_tax'], 2) . '</td>
					</tr>
					<tr>
						<td width="20%" align="left"><b>TOTAL HOURS</b></td>
						<td width="10%" align="right">' . $rowpayslipcutoff['total_hour'] . '</td>
						<td width="20%" align="left"><b>SSS</b></td>
						<td width="10%" align="right">' . number_format($rowpayslipcutoff['ps_sss'], 2) . '</td>
						<td width="20%" align="left"><b>SSS</b></td>
						<td width="10%" align="right">' . number_format($rowpayslipcutoff['ytd_sss'], 2) . '</td>
					</tr>
					<tr>
						<td width="20%" align="left"><b>BASIC</b></td>
						<td width="10%" align="right">' . number_format($rowpayslipcutoff['basic_pay'], 2) . '</td>
						<td width="20%" align="left"><b>PHILHEALTH</b></td>
						<td width="10%" align="right">' . number_format($rowpayslipcutoff['ps_philhealth'], 2) . '</td>
						<td width="20%" align="left"><b>PHILHEALTH</b></td>
						<td width="10%" align="right">' . number_format($rowpayslipcutoff['ytd_philhealth'], 2) . '</td>
					</tr>
					<tr>
						<td width="20%" align="left"><b>OT (' . $rowpayslipcutoff['ot_hours'] . ' hrs)</b></td>
						<td width="10%" align="right">' . $rowpayslipcutoff['ot'] . '</td>
						<td width="20%" align="left"><b>HDMIF</b></td>
						<td width="10%" align="right">' . number_format($rowpayslipcutoff['hdmif'], 2) . '</td>
						<td width="20%" align="left"><b>HDMIF</b></td>
						<td width="10%" align="right">' . number_format($rowpayslipcutoff['ytd_hdmif'], 2) . '</td>
					</tr>
					<tr>
						<td width="20%"><b></b></td>
						<td width="10%"></td>
						<td width="20%" align="left"><b>MATERIAL LOST</b></td>
						<td width="10%" align="right">' . number_format($rowpayslipcutoff['material_cost'], 2) . '</td>
						<td width="20%" align="left"><b>GROSS INCOME</b></td>
						<td width="10%" align="right">' . number_format($rowpayslipcutoff['ytd_grossincome'], 2) . '</td>
					</tr>
					<tr>
						<td width="20%" align="left"><b></b></td>
						<td width="10%" align="right"></td>
						<td width="20%" align="left"><b>CASH ADVANCE</b></td>
						<td width="10%" align="right">' . number_format($rowpayslipcutoff['cash_advance'], 2) . '</td>
						<td width="20%" align="left"><b></b></td>
						<td width="10%" align="right"></td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<th>TOTAL <br> COMPENSATION</th>
						<th>₱ ' . number_format($rowpayslipcutoff['total_compensation'], 2) . '</th>
						<th>TOTAL <br> DEDUCTIONS</th>
						<th>₱ ' . number_format($rowpayslipcutoff['total_deduc'], 2) . '</th>
						<th>NET PAY</th>
						<th>₱ ' . number_format($rowpayslipcutoff['netpay'], 2) . '</th>
					</tr>
				</tfoot>
			</table>
		</div>
	';
	}
	$contents .=
		'
			<h3>Total of ' . $count . ' records.</h3>
		';
	$pdf->writeHTML($contents);
	$pdf->Output('payslip.pdf', 'I');
}