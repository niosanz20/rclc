<?php
include '../../includes/conn.php';

if (isset($_POST['status'])) {
    $output = '<table id="example1" class="table table-bordered">
                <thead>
                    <th>Name</th>
                    <th>Project Name</th>
                    <th>Shift Schedule</th>
                    <th>QR Logs</th>
                    <th>Minutes of OT</th>
                    <th>OT Amount</th>
                    <th>Status | Timestamps</th>
                    <th>Reasons</th>
                </thead>
                <tbody>';

    $status = $_POST['status'];
    $project_id = $_POST['project_id'];
    $cutoffID = $_POST['cutoff_id'];

    $sqlCutoff =  !empty($cutoffID) ? "AND payslip.cutoff_id='$cutoffID'" : "AND payslip.cutoff_id=(SELECT MAX(payslip.cutoff_id) FROM cutoff)";
    $sqlProject = !empty($project_id) ? "AND project_employee.projectid = '$project_id'" : "";
    $sqlStatus = !empty($status) ? "AND overtime.ot_status = '$status'" : "AND overtime.ot_status != 'New'";

    $sql = "SELECT *, schedules.time_in AS stime_in, schedules.time_out AS stime_out, attendance.time_in 
            AS ttime_in, attendance.time_out AS ttime_out, project_employee.name AS project_name
            FROM employees
            LEFT JOIN payslip ON payslip.employee_id = employees.employee_id
            LEFT JOIN cutoff ON cutoff.cutoff_id = payslip.cutoff_id
            LEFT JOIN project_employee ON project_employee.name = employees.employee_id
            LEFT JOIN overtime ON overtime.employee_id = employees.employee_id 
            LEFT JOIN position ON position.id = employees.position_id 
            LEFT JOIN attendance ON attendance.employee_id = overtime.employee_id 
            LEFT JOIN schedules ON schedules.id = employees.schedule_id
            WHERE overtime.date_overtime = attendance.date $sqlCutoff $sqlProject $sqlStatus GROUP BY timestamp
            ";

    $result = $conn->query($sql);
    $projectName = $cutoffDate = "";
    while ($row = $result->fetch_assoc()) {
        $ot_status = "";
        if ($row['ot_status'] == "Approved") {
            $ot_status = "
            <span class='label label-success' style='padding: 10px'><i class=' glyphicon glyphicon-ok-circle'></i> Approved on " .  $row['timestamp']  . "</span>
                ";
        } else if ($row['ot_status'] == "Declined") {
            $ot_status = "
            <span class='label label-danger' style='padding: 10px'><i class=' glyphicon glyphicon-ban-circle'></i> Declined on " .  $row['timestamp']  . "</span>
                    ";
        }
        $output .= "
            <tr>
                <td><strong>" . $row['firstname'] . ' ' . $row['lastname'] . '</strong> | ' . $row['description'] . "</td>
                <td>" . $row['project_name'] . "</td>
                <td>" . date('h:i A', strtotime($row['stime_in'])) . ' - ' . date('h:i A', strtotime($row['stime_out'])) . "</td> 
                <td><strong>" . date('M d, Y', strtotime($row['date_overtime'])) . '</strong> | ' . date('h:i A', strtotime($row['ttime_in'])) . ' - ' . date('h:i A', strtotime($row['ttime_out'])) . "</td>
                <td>" . $row['hours'] . "</td>
                <td>" . number_format($row['amount'], 2) . "</td>
                <td>  $ot_status </td>
                <td>" .  $row['reason']  . "</td>
            </tr>";
    }

    $output .= '</tbody>
            </table>
            <div class="row">
                <!-- button here -->
            </div>
            ';
    $output .= "
		 <script>
			$('#example1').DataTable({
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
        'output' => $output
    );

    echo json_encode($data);
}
