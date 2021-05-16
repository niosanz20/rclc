<?php include 'includes/session.php'; ?>
<?php
include '../timezone.php';
$range_to = date('m/d/Y');
$range_from = date('m/d/Y', strtotime('-30 day', strtotime($range_to)));
?>
<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="php/printer.css">

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/menubar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Overtime
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Overtime</li>
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
                            <div class="box-header with-border" style="max-height:10px">
                                <div class="panel" id="printout" style="visibility: hidden;">
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <span><strong>Status: </strong></span>
                                        <select class="form-control" id="">
                                            <option>View All</option>
                                            <option>Approved</option>
                                            <option>Declined</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2" id="filter-date-section">
                                        <span><strong>Select Cutoff Date: </strong></span>
                                        <select class="form-control cutoffdate" id="cuttoffdate_value">
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
                                    <div class="col-lg-2">
                                        <span><strong>Project: </strong></span>
                                        <select class="form-control" id="">
                                            <option>View All</option>
                                            <option>Approved</option>
                                            <option>Declined</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12" style="text-align: center;">
                                    <h3>Overtime for Approved | From: old_date to: new_date</h3>
                                </div>
                                <div class="row col-lg-12">
                                    <div class="panel" id="">
                                        <table id="example1" class="table table-bordered">
                                            <thead>
                                                <th class="hidden"></th>
                                                <th>Name</th> <!-- with position -->
                                                <th>Shift Schedule</th>
                                                <th>QR Logs</th>
                                                <th>Minutes of OT</th>
                                                <th>OT Amount</th>
                                                <th>Status | Timestamps</th>
                                                <th>Reasons</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                            // $sql = "SELECT *, overtime.id AS otid, employees.employee_id AS empid FROM overtime LEFT JOIN employees ON employees.id=overtime.employee_id ORDER BY date_overtime DESC";
                                            $sql = "SELECT *, overtime.id AS otid, employees.employee_id AS empid, schedules.time_in AS stime_in, schedules.time_out AS stime_out, attendance.time_in AS ttime_in, attendance.time_out AS ttime_out FROM overtime LEFT JOIN employees ON employees.employee_id=overtime.employee_id LEFT JOIN position ON position.id=employees.position_id LEFT JOIN attendance ON attendance.employee_id=overtime.employee_id LEFT JOIN schedules ON schedules.id=employees.schedule_id 
                                            WHERE overtime.date_overtime=attendance.date AND ot_status != 'New' ORDER BY date_overtime DESC ";
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
                                                <td>";
                                                if ($row['ot_status'] == "Approved") {
                                                    echo "
                                                    <p class='btn btn-success btn-sm btn-flat' data-id='" . $row['otid'] . "' style='cursor: text'><i class=' glyphicon glyphicon-ok-circle'></i> Approved on timestamp</p>
                                                ";
                                                            } else if ($row['ot_status'] == "Declined") {
                                                                echo "
                                                    <a class='btn btn-danger btn-sm btn-flat' data-id='" . $row['otid'] . "' style='cursor: text'><i class=' glyphicon glyphicon-ban-circle'></i> Declined on timestamp</a>
                                                ";
                                                            }
                                                            echo "
                                                </td>
                                                <td>REASONS</td>
                                            </tr>
                                            ";
                                            }
                                            ?>
                                            <style>
                                                a{
                                                    cursor: d;
                                                }
                                            </style>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <center>
                                    <form method="POST" action="php/generate_all_payroll.php" target="_blank">
                                            <input type="hidden" value="'.$cutoffID .'" name="cutoff_id">
                                            <button  type="submit" class="generate-all-payrollsdasd btn btn-success btn-lg btn-flat" id="'.$cutoffID .'"><span class="glyphicon glyphicon-print"></span> Generate Report</button>
                                        </form>
                                    </center>
                                </div>        
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include 'includes/footer.php'; ?>

    </div>
    <?php include 'includes/scripts.php'; ?>
    <script>
    /*--
    Generate Payroll of all employees
    -----------------------------------*/
    $(document).on('click', '.generate-all-payroll', function() {
    var cutoff_id = $(this).attr("id");

    if (cutoff_id != "") {
        $.ajax({
            url: "php/generate_payroll.php",
            method: "POST",
            data: {
                cutoff_id: cutoff_id
            },
            dataType: "json",
            success: function(data) {
                $('#payroll-all-employees').html(data.output);

                document.getElementById("printout").style.display = "none";
                document.getElementById("payroll-all-employees").style.display = "block";
                window.addEventListener('load', window.print());
                document.getElementById("payroll-all-employees").style.maxHeight = "10px";
            },
            complete: function(data) {
                document.getElementById("wrapper-height").style.overflow = "hidden";
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    });

    });
    </script>
</body>

</html>