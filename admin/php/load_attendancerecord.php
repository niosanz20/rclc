<?php
include '../includes/conn.php';

if(isset($_POST['cutoff_id']))
{
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
	if($cutoffID != 0){
		$sqlCutoffpayslip = "SELECT * FROM employees LEFT JOIN payslip ON payslip.employee_id=employees.employee_id LEFT JOIN cutoff ON cutoff.cutoff_id = payslip.cutoff_id 
		WHERE payslip.cutoff_id='$cutoffID'";
		$result = $conn->query($sqlCutoffpayslip);
		
		
	}
	else{
		//bago magload yung page ito yung e-eexcute niya (current cutoff date)
		$sqlCutoffpayslip = "SELECT * FROM employees LEFT JOIN payslip ON payslip.employee_id=employees.employee_id LEFT JOIN cutoff ON cutoff.cutoff_id = payslip.cutoff_id 
		WHERE payslip.cutoff_id=(SELECT MAX(cutoff_id) FROM cutoff)";
		$result = $conn->query($sqlCutoffpayslip);
	}
 		
	
	while($row = $result->fetch_assoc()){
		if($row['total_hour'] != 0){
			$output .= '
			<tr>
			  <td>'. $row['firstname'] .' '. $row['lastname'] .'</td>
			  <td>'. $row['total_hour'] .'</td>
			  <td>'. $row['cash_advance'] .'</td>
			  <td>'. $row['material_cost'] .'</td>
			  <td>'. $row['sss'] .'</td>
			  <td>'. $row['philhealth'] .'</td>
			  <td>'. $row['hdmif'] .'</td>
			  <td>'. $row['ot'] .'</td>
			  <td>
				<button class="viewPayrollDetails btn btn-success btn-sm btn-flat" refid="'.$cutoffID .'" data-toggle="tooltip" title="Print" id="'. $row['employee_id'] .'"><i class="glyphicon glyphicon-print"></i> Print</button>
				<button class="viewAttendance btn btn-success btn-sm  btn-flat" data-toggle="tooltip" refid="'.$cutoffID .'" title="View" id="'. $row['employee_id'] .'"><i class="fa fa-eye"></i> View</button>
			  </td>
			</tr>';
		}
	}
	
		$output .= '</tbody>
                      </table>
                      <div class="row">
                        <center>
                          <form method="POST" class="form-inline" id="payForm" action="payroll_generate.php" target="_blank">
                            <button type="submit" class="btn btn-success btn-lg btn-flat" id="payroll"><span class="glyphicon glyphicon-print"></span> Generate Payroll</button>
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
	
		
                          
                        