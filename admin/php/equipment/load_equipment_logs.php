<?php
include '../../includes/conn.php';

if (isset($_POST['equipmentId'])) {
    $output = '<table id="example2" class="table table-bordered">
                <thead>
                    <th>DateTime Borrowed</th>
                    <th>Project Name</th>
                    <th>Employee Name</th>
                    <th>Quantity</th>
                </thead>
                <tbody>';

    $equipmentId = $_POST['equipmentId'];
    $sql = "SELECT *
        FROM project_materials_log
        LEFT JOIN employees ON project_materials_log.name  = employees.employee_id
        LEFT JOIN materials_list ON project_materials_log.material = materials_list.list_id
        LEFT JOIN project ON project_materials_log.proj_id = project.project_id
        WHERE project_materials_log.material = $equipmentId";
    
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        
        $output .= "
        <tr>
            <td>".$row['date'] .' '. $row['time_borrow']."</td>
            <td>".$row['project_name']."</td>
            <td>".$row['firstname'] .' '. $row['lastname']."</td>
            <td>".$row['quantity1']."</td>
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