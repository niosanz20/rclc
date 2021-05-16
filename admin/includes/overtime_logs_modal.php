<!-- Vertically Centered Modal End -->
<div id="overtime-logs" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="max-height: 580px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-file"></span>OVERTIME LOGS</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <table id="overtime-table" class="table table-bordered">
                        <thead>
                            <th class="hidden"></th>
                            <th>Name</th> <!-- with position -->
                            <th>Shift Schedule</th>
                            <th>QR Logs</th>
                            <th>Minutes of OT</th>
                            <th>OT Amount</th>
                            <th>Tools</th>
                            <th>Reasons</th>
                        </thead>
                        <tbody>
                            <?php
                            // $sql = "SELECT *, overtime.id AS otid, employees.employee_id AS empid FROM overtime LEFT JOIN employees ON employees.id=overtime.employee_id ORDER BY date_overtime DESC";
                            $sql = "SELECT *, overtime.id AS otid, employees.employee_id AS empid, schedules.time_in 
                  AS stime_in, schedules.time_out AS stime_out, attendance.time_in AS ttime_in, attendance.time_out 
                  AS ttime_out 
                  FROM overtime 
                  LEFT JOIN employees ON employees.employee_id=overtime.employee_id 
                  LEFT JOIN position ON position.id=employees.position_id 
                  LEFT JOIN attendance ON attendance.employee_id=overtime.employee_id 
                  LEFT JOIN schedules ON schedules.id=employees.schedule_id 
                  WHERE overtime.date_overtime=attendance.date 
                  AND ot_status != 'New' ORDER BY date_overtime DESC ";
                            $query = $conn->query($sql);
                            while ($row = $query->fetch_assoc()) {
                                echo "
                      <tr>
                        <td class='hidden'></td>
                        <td><strong>" . $row['firstname'] . ' ' . $row['lastname'] . '</strong> | ' . $row['description'] . "</td>
                        <td>" . date('h:i A', strtotime($row['stime_in'])) . ' - ' . date('h:i A', strtotime($row['stime_out'])) . "</td> 
                        <td><strong>" . date('M d, Y', strtotime($row['date_overtime'])) . '</strong> | ' . date('h:i A', strtotime($row['ttime_in'])) . ' - ' . date('h:i A', strtotime($row['ttime_out'])) . "</td>
                        <td>" . $row['hours'] . "</td>
                        <td>" . number_format($row['amount'], 2) . "</td>
                        <td> ";
                                if ($row['ot_status'] == "Approved") {
                                    echo "
                        <button class='btn btn-success btn-sm btn-flat edit' disabled data-id='" . $row['otid'] . "'><i class=' glyphicon glyphicon-ok-circle'></i> Approved</button>
                      ";
                                } else if ($row['ot_status'] == "Declined") {
                                    echo "
                        <button class='btn btn-danger btn-sm btn-flat delete' disabled data-id='" . $row['otid'] . "'><i class=' glyphicon glyphicon-ban-circle'></i> Declined</button>
                      ";
                                }
                                echo "
                    </td>
                     <td>REASONS</td>
                   </tr>
                   ";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>