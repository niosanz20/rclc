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
$pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(TRUE, 60);
$pdf->SetFont('cid0cs', '', 10, '', false);
$pdf->AddPage();
$contents = '
<style>'.file_get_contents('printer.css').'</style>

';
if(isset($_POST['cutoff_id'])){
	$cutoffID = $_POST['cutoff_id'];
		
	//assumming "0" ay default value or current cut off date
	if($cutoffID != 0){
		$sqlCutoffpayslip = "SELECT * FROM employees LEFT JOIN payslip ON payslip.employee_id=employees.employee_id LEFT JOIN cutoff ON cutoff.cutoff_id = payslip.cutoff_id LEFT JOIN position ON position.id=employees.position_id 
		WHERE payslip.cutoff_id='$cutoffID'";
	}
	else{
		//bago magload yung page ito yung e-eexcute niya (current cutoff date)
		$sqlCutoffpayslip = "SELECT * FROM employees LEFT JOIN payslip ON payslip.employee_id=employees.employee_id LEFT JOIN cutoff ON cutoff.cutoff_id = payslip.cutoff_id LEFT JOIN position ON position.id=employees.position_id 
		WHERE payslip.cutoff_id=(SELECT MAX(cutoff_id) FROM cutoff)";
	}

	$result = $conn->query($sqlCutoffpayslip);
		
		
	$count = 0;
	while ($rowpaylsipcutoff = $result->fetch_assoc()) {
	$count++;
		$contents .= '
				 <div class="panel">
		  <table class="greyGridTable">
			<thead>
			  <tr>
				<th colspan="5" align="center">RC Llaguno Construction</th>
			  </tr>
			</thead>
			<tbody>
			  <tr>
				<td align="left"><strong>NAME</strong></td>
				<td  align="left">: ' . $rowpaylsipcutoff['firstname'] . ' ' . $rowpaylsipcutoff['lastname'] . '</td>
				<td ></td>
				<td align="left"><strong>TAX STATUS</strong></td>
				<td align="left">: ' . $rowpaylsipcutoff['tax_status'] . '</td>
			  </tr>
			  <tr>
				<td align="left"><strong>PAYROLL DATE</strong></td>
				<td  align="left">: ' . date("M j Y", strtotime($rowpaylsipcutoff['payroll_date'])) . '</td>
				<td ></td>
				<td align="left"><strong>TIN</strong></td>
				<td align="left">: 52341234</td>
			  </tr>
			  <tr>
				<td align="left"><strong>DATE COVERED</strong></td>
				<td align="left">: (' . date("M j, Y", strtotime($rowpaylsipcutoff['start_date'])) . ' - ' . $end_date = date("M j, Y", strtotime($rowpaylsipcutoff['end_date'])) . ')</td>
				<td ></td>
				<td align="left"><strong>SSS NO.</strong></td>
				<td align="left">: 52341234</td>
			  </tr>
			  <tr>
				<td align="left"><strong>POSITION</strong></td>
				<td  align="left">: ' . $rowpaylsipcutoff['description'] . '</td>
				<td ></td>
				<td align="left"><strong>PHILHEALTH NO.</strong></td>
				<td align="left">: 52341234</td>
			  </tr>
			  <tr>
				<td align="left"></td>
				<td  align="left"></td>
				<td ></td>
				<td  align="left"><strong>HDMIF NO.</strong></td>
				<td align="left">: 52341234</td>
			  </tr>
			</tbody>
		  </table>
		  <table class="greyGridTable" id="secondTable" >
			<thead>
			  <tr>
				<th colspan="2">COMPENSATION
				</th>
				<th colspan="2">DEDUCTIONS
				</th>
				<th colspan="2">YEAR-TO-DATE</th>
			  </tr>
			</thead>
			<tbody>
			  <tr>
				<td align="left"><strong>RATE per HOUR</strong></td>
				<td  align="left">' . $rowpaylsipcutoff['rate'] . '</td>
				<td align="left"><strong>CASH ADVANCE</strong></td>
				<td  align="right">' . $rowpaylsipcutoff['cash_advance'] . '</td>
				<td align="left"><strong>TAX</strong></td>
				<td align="right">' . $rowpaylsipcutoff['tax'] . '</td>
				</tr>
				<tr>
				  <td align="left"><strong>TOTAL HOURS</strong></td>
				  <td  align="right">' . $rowpaylsipcutoff['total_hour'] . '</td>
				  <td align="left"><strong>SSS</strong></td>
				  <td  align="right">' . $rowpaylsipcutoff['sss'] . '</td>
				  <td align="left"><strong>SSS</strong></td>
				  <td align="right">' . $rowpaylsipcutoff['ytd_sss'] . '</td>
				</tr>
				<tr>
				  <td align="left"><strong>BASIC</strong></td>
				  <td  align="right">' . $rowpaylsipcutoff['basic_pay'] . '</td>
				  <td align="left"><strong>PHILHEALTH</strong></td>
				  <td  align="right">' . $rowpaylsipcutoff['philhealth'] . '</td>
				  <td align="left"><strong>PHILHEALTH</strong></td>
				  <td align="right">' . $rowpaylsipcutoff['ytd_philhealth'] . '</td>
				</tr>
				<tr>
				  <td align="left"><strong>OT (10 hrs)</strong></td>
				  <td  align="right">' . $rowpaylsipcutoff['ot'] . '</td>
				  <td align="left"><strong>HDMIF</strong></td>
				  <td  align="right">' . $rowpaylsipcutoff['hdmif'] . '</td>
				  <td align="left"><strong>HDMIF</strong></td>
				  <td align="right">' . $rowpaylsipcutoff['ytd_hdmif'] . '</td>
				</tr>
				<tr>
				  <td align="left"><strong></strong></td>
				  <td  align="right"></td>
				  <td align="left"><strong>MATERIAL LOST</strong></td>
				  <td  align="right">' . $rowpaylsipcutoff['material_cost'] . '</td>
				  <td align="left"><strong>GROSS INCOME</strong></td>
				  <td align="right">' . $rowpaylsipcutoff['ytd_grossincome'] . '</td>
				</tr>
				</tbody>
				<tfoot>
				  <tr>
					<th>TOTAL <br> COMPENSATION
					</th>
					<th>₱ ' . $rowpaylsipcutoff['total_compensation'] . '</th>
					<th>TOTAL <br> DEDUCTIONS
					</th>
					<th>₱ ' . $rowpaylsipcutoff['total_deduc'] . '</th>
					<th>NET PAY</th>
					<th>₱ ' . $rowpaylsipcutoff['netpay'] . '</th>
				  </tr>
				</tfoot>
				</table>
				</div>
					';

	}
		$contents .= 
		'
		<div class="legend">
				  <table style="border:none">
					<thead>
					  <tr><th colspan="4">LEGEND</th></tr>
					</thead>
					<tbody>
					  <tr>
						<td>LH -</td>
						<td>Legal Holiday</td>
						<td>OT -</td>
						<td>Overtime</td>
					  </tr>
					  <tr>
						<td>SH -</td>
						<td>Special Holiday &nbsp</td>
						<td>RD -</td>
						<td>Rest Day</td>
					  </tr>
					  <tr>
						<td>DH -</td>
						<td>Double Holiday</td>
						<td></td>
						<td></td>
					  </tr>

					</tbody>
				  </table>
				   <h3>Total of '.$count.' records.</h3>
				</div>
		';
	$pdf->writeHTML($contents);
	$pdf->Output('payslip.pdf', 'I');
}