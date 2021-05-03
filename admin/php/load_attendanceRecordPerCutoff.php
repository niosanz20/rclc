<?php
include '../includes/conn.php';

if (isset($_POST['cutoff_id'])) {
  $output = '';
  $output .= '<table id="example3" class="table table-bordered">
                <thead>
                  <th>Name</th>
                  <th>Project Name</th>
                  <th>Location</th>
                  <th>Actions</th>
                </thead>
              <tbody>';


  $cutoffID = $_POST['cutoff_id'];

  //assumming "0" ay default value or current cut off date
  if ($cutoffID != 0) {
    $sqlCutoffpayslip = "SELECT * FROM employees LEFT JOIN payslip ON payslip.employee_id=employees.employee_id 
    LEFT JOIN cutoff ON cutoff.cutoff_id = payslip.cutoff_id 
    LEFT JOIN project_employee ON project_employee.name=employees.employee_id 
    LEFT JOIN project ON project.project_id=project_employee.projectid 
    WHERE payslip.cutoff_id='$cutoffID'";
    $result = $conn->query($sqlCutoffpayslip);
  } else {
    //bago magload yung page ito yung e-eexcute niya (current cutoff date)
    $sqlCutoffpayslip = "SELECT * FROM employees LEFT JOIN payslip ON payslip.employee_id=employees.employee_id 
    LEFT JOIN cutoff ON cutoff.cutoff_id = payslip.cutoff_id
    LEFT JOIN project_employee ON project_employee.name=employees.employee_id 
    LEFT JOIN project ON project.project_id=project_employee.projectid 
    WHERE payslip.cutoff_id=(SELECT MAX(cutoff_id) FROM cutoff)";
    $result = $conn->query($sqlCutoffpayslip);
  }


  while ($row = $result->fetch_assoc()) {
    if ($row['total_hour'] != 0) {
      $output .= '
      <tr>
        <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>
        <td>' . $row['project_name'] . '</td>
        <td>' . $row['project_address'] . '</td>
        <td>
        <button class="viewAttendance btn btn-success btn-sm  btn-flat" data-toggle="tooltip" refid="' . $cutoffID . '" title="View" id="' . $row['employee_id'] . '"><i class="fa fa-eye"></i> View</button>
        </td>
      </tr>';
    }
  }

  $output .= '</tbody>
            </table>
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