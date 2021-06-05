<?php include 'includes/session.php'; ?>
<?php
include '../timezone.php';
$range_to = date('m/d/Y');
$range_from = date('m/d/Y', strtotime('-30 day', strtotime($range_to)));
?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/menubar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Attendance
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Attendance</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <?php
        if (isset($_SESSION['error'])) {
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              " . $_SESSION['error'] . "
            </div>
          ";
          unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              " . $_SESSION['success'] . "
            </div>
          ";
          unset($_SESSION['success']);
        }
        ?>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#attendance-logs" data-toggle="tab" aria-expanded="true">Attendance
                                            Logs
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="#attendance-records" data-toggle="tab" aria-expanded="false">Attendance
                                            Records
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="attendance-logs">
                                        <div class="box-header with-border">
                                            <a onclick=" window.open('../index.php','_blank')" data-toggle="modal"
                                                class="btn btn-primary btn-sm btn-flat"><i
                                                    class="glyphicon glyphicon-qrcode"></i> New</a>
                                            <a href="#addnew" data-toggle="modal"
                                                class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New
                                                Attendance</a>
                                            <!--<a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>-->
                                            <div class="pull-right">
                                                <form method="POST" class="form-inline" id="attendanceForm"
                                                    action="attendance_employee_print_generate.php" target="_blank">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control pull-right col-sm-8"
                                                            id="reservation" name="date_range"
                                                            value="<?php echo (isset($_GET['range'])) ? $_GET['range'] : $range_from . ' - ' . $range_to; ?>">
                                                    </div>
                                                    <!-- <button type="button" class="btn btn-success btn-sm btn-flat" id="attendanceprint"><span class="glyphicon glyphicon-print"></span> Print</button> -->
                                                    <!-- <button type="button" class="btn btn-primary btn-sm btn-flat" id="attendanceemployeeprint"><span class="glyphicon glyphicon-print"></span> Print per Employee</button>-->
                                                    <!-- <button type="submit" class="btn btn-primary btn-sm btn-flat" id="attendanceemployeeprint"><span class="glyphicon glyphicon-print"></span> Print per Employee</button> -->
                                                    <!-- <a href="attendance_print.php" class="btn btn-danger btn-sm btn-flat"><span class="glyphicon glyphicon-print"></span> Print All Attendance</a>-->
                                                </form>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <table id="example1" class="table table-bordered">
                                                <thead>
                                                    <th class="hidden"></th>
                                                    <th>Date</th>
                                                    <!--<th>Employee ID</th>-->
                                                    <th>Name</th>
                                                    <th>Time In</th>
                                                    <th>Time Out</th>
                                                    <th>Location</th>
                                                    <th>Project</th>
                                                    <th>Tools</th>
                                                </thead>
                                                <tbody>
                                                    <?php
                          // $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id ORDER BY attendance.date DESC, attendance.time_in DESC";

                          $to = date('Y-m-d');
                          $from = date('Y-m-d', strtotime('-30 day', strtotime($to)));

                          if (isset($_GET['range'])) {
                            $range = $_GET['range'];
                            $ex = explode(' - ', $range);
                            $from = date('Y-m-d', strtotime($ex[0]));
                            $to = date('Y-m-d', strtotime($ex[1]));
                          }

                          // $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid FROM attendance LEFT JOIN employees ON employees.employee_id=attendance.employee_id WHERE date BETWEEN '$from' AND '$to' ORDER BY attendance.date DESC, attendance.time_in DESC";

                          $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid, 
                            attendance.status AS astatus FROM attendance LEFT JOIN employees ON 
                            employees.employee_id=attendance.employee_id LEFT JOIN project_employee ON
                             project_employee.name=employees.employee_id LEFT JOIN project ON
                              project.project_id=project_employee.projectid WHERE date 
                              BETWEEN '$from' AND '$to' AND project_employee.status = 'On going' ORDER BY attendance.date DESC, attendance.time_in DESC";

                          $query = $conn->query($sql);
                          while ($row = $query->fetch_assoc()) {
                            $status = ($row['astatus']) ? '<span class="label label-warning pull-right">ontime</span>' : '<span class="label label-danger pull-right">late</span>';
                            echo "
                                <tr>
                                  <td class='hidden'></td>
                                  <td>" . date('Y-m-d', strtotime($row['date'])) . "</td>
                                 <!-- <td>" . $row['empid'] . "</td> -->
                                  <td>" . $row['firstname'] . ' ' . $row['lastname'] . "</td>
                                  <td>" . date('h:i A', strtotime($row['time_in'])) . $status . "</td>
                                  <td>" . date('h:i A', strtotime($row['time_out'])) . "</td>
                                  <td>" . $row['project_address'] . "</td>
                                  <td>" . $row['project_name'] . "</td>
                                  <td>
                                  <!--  <button class='btn btn-success btn-sm btn-flat edit' data-id='" . $row['attid'] . "'><i class='fa fa-edit'></i> Edit</button> -->
                                    <button class='btn btn-danger btn-sm btn-flat delete' data-id='" . $row['attid'] . "'><i class='fa fa-trash'></i> Remove</button>
                                  </td>
                                </tr>
                              ";
                          }
                          ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="attendance-records">
                                        <div class="col-lg-12" style="display: flex; justify-content: center;">
                                            <h3>Attendance Records</h3>
                                            <div class="col-lg-2">
                                                <select class="form-control cutoffdate" id="cuttoffdate_value"
                                                    style="margin-top: 1em">
                                                    <option value="" selected> Select Cut-Off Date</option>
                                                    <?php
                          $sqlcutoff = "SELECT * FROM cutoff ORDER BY end_date DESC";
                          $querycutoff = $conn->query($sqlcutoff);
                          while ($rowcutoff = $querycutoff->fetch_assoc()) {
                            $cutoff_id = $rowcutoff['cutoff_id'];
                            $start_date = date("M j, Y", strtotime($rowcutoff['start_date']));
                            $end_date = date("M j, Y", strtotime($rowcutoff['end_date']));
                            echo "
                    <option value='" . $cutoff_id . "'>" . $start_date . ' - ' . $end_date . "</option>
                   ";
                          }
                          ?>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="panel" id="tableSection">

                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-content -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Vertically Centered Modal End -->
        <div id="viewAttendance" class="modal fade">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style="max-height: 580px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" id="modal-view-attendance">

                    </div>
                </div>
            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
        <?php include 'includes/attendance_modal.php'; ?>
        <!--attendance_modal.php-->
    </div>
    <?php include 'includes/scripts.php'; ?>
    <script>
    $(function() {
        $(document).on('click', '.edit', function() {
            // e.preventDefault();
            $('#edit').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $(document).on('click', '.delete', function() {
            // e.preventDefault();
            $('#delete').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });
    });

    function getRow(id) {
        $.ajax({
            type: 'POST',
            url: 'position_row.php',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                $('#posid').val(response.id);
                $('#edit_title').val(response.description);
                $('#edit_rate').val(response.rate);
                $('#del_posid').val(response.id);
                $('#del_position').html(response.description);
            }
        });
    }

    function getRow(id) {
        $.ajax({
            type: 'POST',
            url: 'attendance_row.php',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                $('#datepicker_edit').val(response.date);
                $('#attendance_date').html(response.date);
                $('#attendance_date').val(response.date);
                $('#edit_time_in').val(response.time_in);
                $('#edit_time_out').val(response.time_out);
                $('#attid').val(response.attid);
                $('#employee_name').html(response.firstname + ' ' + response.lastname);
                $('#del_attid').val(response.attid);
                $('#del_employee_name').html(response.firstname + ' ' + response.lastname);
            }
        });
    }

    $(document).ready(function() {
        loadAttendanceRecord(0);
        /*--
        Display Table: Employee List Filtered by Cutoofdate
        -----------------------------------*/
        function loadAttendanceRecord(cutoff_id) {
            $.ajax({
                url: "php/load_attendanceRecordPerCutoff.php",
                method: "POST",
                data: {
                    cutoff_id: cutoff_id
                },
                dataType: "json",
                success: function(data) {

                    $('#tableSection').html(data.attendanceRecord);

                },
                error: function(data) {
                    console.log(data);
                }
            });

        }

        /*--
        Load Attendance Record by CutOff Date
        -----------------------------------*/
        $(document).on('click', '.cutoffdate', function() {
            var cutoff_id = $('#cuttoffdate_value').val();

            if (cutoff_id != "") {
                loadAttendanceRecord(cutoff_id);
            }
        });

        /*--
        Display Modal of Payroll for Employee
        -----------------------------------*/
        $(document).on('click', '.viewAttendance', function() {
            var empID = $(this).attr("id");
            var cutoffID = $(this).attr("refid");
            $.ajax({
                url: "php/view_attendanceRecord.php",
                method: "POST",
                data: {
                    empID: empID,
                    cutoffID: cutoffID
                },
                success: function(data) {
                    $('#modal-view-attendance').html(data);
                    $('#viewAttendance').modal('show');
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        $("#reservation").on('change', function() {
            var range = encodeURI($(this).val());
            window.location = 'attendance.php?range=' + range;
        });

        $('#attendanceprint').click(function(e) {
            e.preventDefault();
            $('#attendanceForm').attr('action', 'attendance_print_generate.php');
            $('#attendanceForm').submit();
        });
    });
    </script>
</body>

</html>