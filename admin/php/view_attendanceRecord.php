<?php
include '../includes/conn.php';

if(isset($_POST['empID'])){
$empID = $_POST['empID'];
$sql = "SELECT *, employees.id AS empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.employee_id='$empID'";
$query = $conn->query($sql);
$row = $query->fetch_assoc();

?>
<link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
<div class="panel" id="payrollSummary">
    <div class="box-body">
        <div class="row">
            <h4><span class="glyphicon glyphicon-file"></span>Attendance Record (Cut-off date)</h4>
        </div>
        <table id="example6" class="table table-bordered">
          <thead>
            <th>Date</th>
            <th>Time In</th>
            <th>Time out</th>
            <th>Number of Hours</th>
            <th>OT</th>
            <th>Total Hours</th>
            <th>Rate</th>
            <th>Project Name</th>
            <th>Project Location</th>
            <th>Income</th>
          </thead>
          <tbody>
              <!--
                Position - Employee table link to Position table
                Total_Hr - sum of num_hr in attendance table
                Cash Advance - cashadvance table
                Cost of Damage Materials - price sa project_materials_log
                Deduction -  (deductions table)
                OT - Attendance table
              -->
            <?php
            //Selecting of employee
            // $sql = "SELECT *, sum(num_hr) AS total_hr, attendance.employee_id AS empid FROM attendance LEFT JOIN employees ON employees.employee_id=attendance.employee_id LEFT JOIN position ON position.id=employees.position_id WHERE employee_id = '$empID'";
            // $query = $conn->query($sql);
            // $row_employee = $query->fetch_assoc();
            
            // //Selecting of Employee's Cashadvance
            // $casql = "SELECT *, SUM(amount) AS cashamount FROM cashadvance WHERE employee_id='$empID'";
            // $query = $conn->query($sql);
            // $row_cashadvance = $query->fetch_assoc();
            
            // //Selecting of Employee's Cost of Damage Materials
            // //variable name in this sql statement is the id of employee
            // $sql = "SELECT *, SUM(price) AS totalprice FROM project_materials_log WHERE name='$empID'";
            // $query = $conn->query($sql);
            // $row_CDM = $query->fetch_assoc();
            
            // //Selecting of Employee's Deductions(SSS, Pag-ibig, PhilHealth,..)
            // $sql = "SELECT *, SUM(amount) as total_amount FROM deductions";
            // $query = $conn->query($sql);
            
            //while (true) {//$row_deductions = $query->fetch_assoc()
            ?>
          
              <tr>
                <td>March 21, 2021</td>
                <td>8:00 AM</td>
                <td>9:00 PM</td>
                <td>13</td>
                <td>1</td>
                <td>12</td>
                <td>₱ 400</td>
                <td>Project Hukay</td>
                <td>Sta. Mesa, Manila</td>
                <td>₱ 400</td>
              </tr>
              <tr>
                <td>March 21, 2021</td>
                <td>8:00 AM</td>
                <td>9:00 PM</td>
                <td>13</td>
                <td>1</td>
                <td>12</td>
                <td>₱ 400</td>
                <td>Project Hukay</td>
                <td>Sta. Mesa, Manila</td>
                <td>₱ 400</td>
              </tr>
              <tr>
                <td>March 21, 2021</td>
                <td>8:00 AM</td>
                <td>9:00 PM</td>
                <td>13</td>
                <td>1</td>
                <td>12</td>
                <td>₱ 400</td>
                <td>Project Hukay</td>
                <td>Sta. Mesa, Manila</td>
                <td>₱ 400</td>
              </tr>
              <tr>
                <td>March 21, 2021</td>
                <td>8:00 AM</td>
                <td>9:00 PM</td>
                <td>13</td>
                <td>1</td>
                <td>12</td>
                <td>₱ 400</td>
                <td>Project Hukay</td>
                <td>Sta. Mesa, Manila</td>
                <td>₱ 400</td>
              </tr>
              <tr>
                <td>March 21, 2021</td>
                <td>8:00 AM</td>
                <td>9:00 PM</td>
                <td>13</td>
                <td>1</td>
                <td>12</td>
                <td>₱ 400</td>
                <td>Project Hukay</td>
                <td>Sta. Mesa, Manila</td>
                <td>₱ 400</td>
              </tr>
              <tr>
                <td>March 21, 2021</td>
                <td>8:00 AM</td>
                <td>9:00 PM</td>
                <td>13</td>
                <td>1</td>
                <td>12</td>
                <td>₱ 400</td>
                <td>Project Hukay</td>
                <td>Sta. Mesa, Manila</td>
                <td>₱ 400</td>
              </tr>
              <tr>
                <td>March 21, 2021</td>
                <td>8:00 AM</td>
                <td>9:00 PM</td>
                <td>13</td>
                <td>1</td>
                <td>12</td>
                <td>₱ 400</td>
                <td>Project Hukay</td>
                <td>Sta. Mesa, Manila</td>
                <td>₱ 400</td>
              </tr>
              <tr>
                <td>March 21, 2021</td>
                <td>8:00 AM</td>
                <td>9:00 PM</td>
                <td>13</td>
                <td>1</td>
                <td>12</td>
                <td>₱ 400</td>
                <td>Project Hukay</td>
                <td>Sta. Mesa, Manila</td>
                <td>₱ 400</td>
              </tr>
              <tr>
                <td>March 21, 2021</td>
                <td>8:00 AM</td>
                <td>9:00 PM</td>
                <td>13</td>
                <td>1</td>
                <td>12</td>
                <td>₱ 400</td>
                <td>Project Hukay</td>
                <td>Sta. Mesa, Manila</td>
                <td>₱ 400</td>
              </tr>
              
            <?php
            //}
            ?>
          </tbody>
        </table>
    </div>
</div>
<!-- DataTables -->
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $(function () {
    $('#example6').DataTable({
      responsive: true,
      'paging'      : true,
      'lengthChange': false,
      pageLength: 5,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
<?php } ?>
