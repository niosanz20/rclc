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
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <span><strong>Status: </strong></span>
                                        <select class="form-control" id="ot-filter-status">
                                            <option value="">Select All</option>
                                            <option value="Approved">Approved</option>
                                            <option value="Declined">Declined</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <span><strong>Select Cutoff Date: </strong></span>
                                        <select class="form-control cutoffdate" id="ot-filter-date">
                                            <option value="" selected> Select All</option>
                                            <?php
                                            $sqlcutoff = "SELECT * FROM cutoff ORDER BY end_date DESC";
                                            $querycutoff = $conn->query($sqlcutoff);
                                            while ($rowcutoff = $querycutoff->fetch_assoc()) {
                                                $cutoff_id = $rowcutoff['cutoff_id'];
                                                $start_date = date("M j, Y", strtotime($rowcutoff['start_date']));
                                                $end_date = date("M j, Y", strtotime($rowcutoff['end_date']));
                                                echo "
                                            <option value='" . $start_date . ' - ' . $end_date . "'>" . $start_date . ' - ' . $end_date . "</option>
                                            ";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <span><strong>Project: </strong></span>
                                        <select class="form-control cutoffdate" id="ot-filter-project">
                                            <option value="" selected> Select All</option>
                                            <?php
                                            $sql = "SELECT * FROM project ORDER BY project_name";
                                            $querycutoff = $conn->query($sql);
                                            while ($row = $querycutoff->fetch_assoc()) {
                                                echo "
                                            <option value='" . $row['project_id'] . "'>" . $row['project_name'] . "</option>
                                            ";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2" style="margin-top: 20px;">
                                        <a href="javascript:void(0)" class="btn btn-primary btn-md btn-flat filter-record">
                                            <i class="fa fa-filter"></i>
                                            Filter</a>
                                    </div>
                                </div>
                                <div class="col-lg-12" style="text-align: center;">
                                    <h3 id="ot-header-report">Overtime Reports</h3>
                                </div>
                                <div class="row col-lg-12">
                                    <div class="panel" id="overtime-records">

                                    </div>
                                </div>
                                <div class="row">
                                    <center>
                                        <form method="POST" action="php/overtime/generate_all_overtime.php" target="_blank">
                                            <input type="hidden" value="" id="report-status" name="report-status">
                                            <input type="hidden" value="" id="report-cutoff-start-date" name="report-cutoff-start-date">
                                            <input type="hidden" value="" id="report-cutoff-end-date" name="report-cutoff-end-date">
                                            <input type="hidden" value="" id="report-project" name="report-project">
                                            <button type="submit" class="btn btn-success btn-lg btn-flat">
                                                <i class="glyphicon glyphicon-print"></i>
                                                Generate Report
                                            </button>
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
        $(document).ready(function() {
            filter_overtime_table("", "", "");

            // /*--
            // Generate Payroll of all employees
            // -----------------------------------*/
            // $(document).on('click', '.generate-all-overtimesss', function() {
            //     var cutoff_id = $(this).attr("id");

            //     if (cutoff_id != "") {
            //         $.ajax({
            //             url: "php/generate_overtime.php",
            //             method: "POST",
            //             data: {
            //                 cutoff_id: cutoff_id
            //             },
            //             dataType: "json",
            //             success: function(data) {
            //                 $('#payroll-all-employees').html(data.output);

            //                 document.getElementById("printout").style.display = "none";
            //                 document.getElementById("payroll-all-employees").style.display =
            //                     "block";
            //                 window.addEventListener('load', window.print());
            //                 document.getElementById("payroll-all-employees").style.maxHeight =
            //                     "10px";
            //             },
            //             complete: function(data) {
            //                 document.getElementById("wrapper-height").style.overflow = "hidden";
            //             },
            //             error: function(data) {
            //                 console.log(data);
            //             }
            //         });
            //     }
            // });

            /*--
            Filter Reports
            -----------------------------------*/
            $(document).on('click', '.filter-record', function() {
                filter_overtime_table($("#ot-filter-status").val(), $("#ot-filter-date").val(), $(
                    "#ot-filter-project").val());
                set_generate_report_value($("#ot-filter-status").val(), $("#ot-filter-date").val(), $(
                    "#ot-filter-project").val());
            });

            function set_generate_report_value(status, cutoff_date, project_id) {
                var start_date;
                var end_date;

                if (cutoff_date != "") {
                    start_date = cutoff_date.split("-")[0];
                    end_date = cutoff_date.split("-")[1];
                } else start_date = end_date = "";

                document.getElementById('report-status').value = status;
                document.getElementById('report-cutoff-start-date').value = start_date;
                document.getElementById('report-cutoff-end-date').value = end_date;
                document.getElementById('report-project').value = project_id;
                alert(start_date);
            }

            function set_overtime_report_header() {
                var cutoffDate = document.getElementById('ot-filter-date');
                var projectName = document.getElementById('ot-filter-project');

                var headerStatus = $("#ot-filter-status").val() != "" ? $("#ot-filter-status").val() +
                    " Overtime Reports" : "Overtime Reports";
                var headerCutoffDate = $("#ot-filter-date").val() != 0 ? "<br> Cutoff Date:  " + cutoffDate.options[
                    cutoffDate.selectedIndex].text : "";
                var headerProjectName = $("#ot-filter-project").val() != 0 ? "<br> Project Name: " + projectName
                    .options[projectName.selectedIndex].text : "";

                $('#ot-header-report').html(headerStatus + headerCutoffDate + headerProjectName);
            }

            function filter_overtime_table(status, cutoff_date, project_id) {
                var start_date;
                var end_date;

                if (cutoff_date != "") {
                    start_date = cutoff_date.split("-")[0];
                    end_date = cutoff_date.split("-")[1];
                } else start_date = end_date = "";

                $.ajax({
                    url: "php/overtime/load_overtimeRecordReports.php",
                    method: "POST",
                    data: {
                        status: status,
                        start_date: start_date,
                        end_date: end_date,
                        project_id: project_id
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#overtime-records').html(data.output);
                        set_overtime_report_header();
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        });
    </script>
</body>

</html>