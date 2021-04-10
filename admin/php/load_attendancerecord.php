<?php
include '../includes/conn.php';

if (isset($_POST['cutoff_id'])) {
	$output = '<table id="example3" class="table table-bordered">
					  
                        <thead>
                          <th>Name</th>
                          <th>Total Hr</th>
                          <th>Cash Advance</th>
                          <th>Cost of Damage Materials</th>
                          <th>SSS</th>
                          <th>PhilHealth</th>
                          <th>Pag-ibig</th>
                          <th>OT</th>
                          <th>Actions</th>
                        </thead>
                        <tbody>';


	$cutoffID = $_POST['cutoff_id'];

	//assumming "0" ay default value or current cut off date
	if ($cutoffID != 0) {
		$sqlCutoffpayslip = "SELECT * FROM employees LEFT JOIN payslip ON payslip.employee_id=employees.employee_id LEFT JOIN cutoff ON cutoff.cutoff_id = payslip.cutoff_id 
		WHERE payslip.cutoff_id='$cutoffID'";
		$result = $conn->query($sqlCutoffpayslip);
	} else {
		//bago magload yung page ito yung e-eexcute niya (current cutoff date)
		$sqlCutoffpayslip = "SELECT * FROM employees LEFT JOIN payslip ON payslip.employee_id=employees.employee_id LEFT JOIN cutoff ON cutoff.cutoff_id = payslip.cutoff_id 
		WHERE payslip.cutoff_id=(SELECT MAX(cutoff_id) FROM cutoff)";
		$result = $conn->query($sqlCutoffpayslip);
	}


	while ($row = $result->fetch_assoc()) {
		if ($row['total_hour'] != 0) {
			$output .= '
			<tr>
			  <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>
			  <td>' . $row['total_hour'] . '</td>
			  <td>₱ ' . number_format($row['cash_advance'], 2) . '</td>
			  <td>₱ ' . number_format($row['material_cost'], 2) . '</td>
			  <td>₱ ' . number_format($row['sss'], 2) . '</td>
			  <td>₱ ' . number_format($row['philhealth'], 2) . '</td>
			  <td>₱ ' . number_format($row['hdmif'], 2) . '</td>
			  <td>₱ ' . number_format($row['ot'], 2) . '</td>
			  <td>
				<button class="viewPayrollDetails btn btn-success btn-sm btn-flat" refid="' . $cutoffID . '" data-toggle="tooltip" title="Print" id="' . $row['employee_id'] . '"><i class="glyphicon glyphicon-print"></i> Print</button>
				<button class="viewAttendance btn btn-success btn-sm  btn-flat" data-toggle="tooltip" refid="' . $cutoffID . '" title="View" id="' . $row['employee_id'] . '"><i class="fa fa-eye"></i> View</button>
			  </td>
			</tr>';
		}
	}

	$output .= '</tbody>
                      </table>
                      <div class="row">
                        <center>
                          <form method="POST" action="php/generate_all_payroll.php" target="_blank">
								<input type="hidden" value="'.$cutoffID .'" name="cutoff_id">
								<button  type="submit" class="generate-all-payrollsdasd btn btn-success btn-lg btn-flat" id="'.$cutoffID .'"><span class="glyphicon glyphicon-print"></span> Generate Payroll</button>
							</form>
                        </center>
                      </div>
					  ';
	$output .= "
		 <script>
			$('#example3').DataTable({
		  responsive: true,
		  'paging'      : true,
		  'lengthChange': false,
		  'searching'   : true,
		  'ordering'    : true,
		  'info'        : true,
		  'autoWidth'   : false
		})
		 </script>
		";

	$data = array(
		'attendanceRecord' => $output

	);

	echo json_encode($data);
}
