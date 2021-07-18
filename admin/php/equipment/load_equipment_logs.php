<?php
include '../../includes/conn.php';

if (isset($_POST['equipmentId'])) {
    $output = '<table id="example2" class="table table-bordered">
                <thead>
                    <th style="display:none">ID</th>
                    <th>DateTime Borrowed</th>
                    <th>Project Name</th>
                    <th>Employee Name</th>
                    <th>Quantity</th>
                    <th>Time Returned</th>
                    <th>Condition</th>
                    <th>Status</th>
                </thead>
                <tbody>';

    $equipmentId = $_POST['equipmentId'];
    $sql = "SELECT *
        FROM project_materials_log
        LEFT JOIN employees ON project_materials_log.name  = employees.employee_id
        LEFT JOIN materials_list ON project_materials_log.material = materials_list.list_id
        LEFT JOIN project ON project_materials_log.proj_id = project.project_id
        WHERE project_materials_log.material = $equipmentId ORDER BY project_materials_log.id DESC";
    
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $sqlLog = "SELECT time_return FROM project_materials_log WHERE material = ".$row['list_id']." AND name = '".$row['employee_id']."' ORDER BY id DESC";
        $queryLog = $conn->query($sqlLog);
        $rowLog = mysqli_fetch_row($queryLog);
        $dateTimeReturned = $rowLog[0];
        
        $output .= "
        <tr>
            <td style='display:none'>".$row['id']."</td>
            <td>".$row['date'] .' '. $row['time_borrow']."</td>
            <td>".$row['project_name']."</td>
            <td>".$row['firstname'] .' '. $row['lastname']."</td>
            <td>".$row['quantity1']."</td>
            <td>".$dateTimeReturned."</td>
            <td>".$row['con_dition']."</td>
            <td>".$row['status']."</td>
        </tr>";
    }

    $output .= '</tbody>
            </table>';

    $output .= "
		 <script>
			$('#example2').DataTable({
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