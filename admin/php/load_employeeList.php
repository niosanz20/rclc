<?php
include '../includes/conn.php';

$output = '
           <div class="col-lg-12" style="text-align: center;">
                  <h3>Payroll Report (Pay Date)</h3>
                </div>
	';
	$output .= '<table id="example5" class="table table-bordered">
	                <thead>
	                  <th>Name</th>
	                  <th>Position</th>
	                  <th>Contact Info</th>
	                  <th>Action</th>
	                </thead>
	                <tbody>';


	$sql = "SELECT *, employees.id AS empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id";
  	$query = $conn->query($sql);
  	while ($row = $query->fetch_assoc()) {
			$output .= '
			<tr>
              <td>'.$row['firstname'] . ' ' . $row['lastname'].'</td>
              <td>'. $row['description'].'</td>
              <td>'.$row['contact_info'].'</td>
              <td>
                <button class="viewPayroll btn btn-success btn-sm edit btn-flat" data-toggle="tooltip" title="View" id="'.$row['employee_id'].'"><i class="fa fa-eye"></i> View </button>
              </td>
            </tr>';
	}

	$output .= '
					</tbody>
                      </table>
					  ';
	$output .= "
		 <script>
			$('#example5').DataTable({
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
		'employeeList' => $output

	);

	echo json_encode($data);