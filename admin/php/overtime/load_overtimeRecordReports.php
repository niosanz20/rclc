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
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $project_id = $_POST['project_id'];

    $sqlCutoff =  !empty($start_date) ? "AND overtime.date_overtime BETWEEN '" . date('Y-m-d', strtotime($start_date)) . "' AND '" . date('Y-m-d', strtotime($end_date)) . "' " : "";
    $sqlProject = !empty($project_id) ? "AND project_employee.projectid = '$project_id'" : "";
    $sqlStatus = !empty($status) ? "AND overtime.ot_status = '$status'" : "AND overtime.ot_status != 'New'";

    $sql = "SELECT *, schedules.time_in AS stime_in, schedules.time_out AS stime_out, attendance.time_in 
            AS ttime_in, attendance.time_out AS ttime_out, project.project_name AS project_name
            FROM overtime 
            LEFT JOIN employees ON employees.employee_id=overtime.employee_id 
            LEFT JOIN position ON position.id=employees.position_id 
            LEFT JOIN schedules ON schedules.id=employees.schedule_id 
            LEFT JOIN project_employee ON project_employee.name=employees.employee_id 
            LEFT JOIN project ON project.project_id=project_employee.projectid 
            LEFT JOIN attendance ON attendance.employee_id=employees.employee_id
            WHERE overtime.date_overtime=attendance.date $sqlCutoff $sqlProject $sqlStatus
            ORDER BY date_overtime DESC
            ";
    //echo $sql;
    $result = $conn->query($sql);
    $projectName = $cutoffDate = "";
	while ($row = $result->fetch_assoc()) {
        $ot_status = "";
        if ($row['ot_status'] == "Approved") {
            $ot_status = "
            <span class='label label-success' style='padding: 10px'><i class=' glyphicon glyphicon-ok-circle'></i> Approved on ".  $row['timestamp']  ."</span>
                ";
        } else if ($row['ot_status'] == "Declined") {
            $ot_status = "
            <span class='label label-danger' style='padding: 10px'><i class=' glyphicon glyphicon-ban-circle'></i> Declined on ".  $row['timestamp']  ."</span>
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
                <td>".  $row['reason']  ."</td>
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