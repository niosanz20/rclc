<?php include 'includes/session.php'; ?>
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
                    Project
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li>Project List</li>
                    <li class="active">Project</li>
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

                <?php
                if (isset($_GET['project_id'])) {

                    $project_id = $_GET['project_id'];
                    $sql = "SELECT * FROM project WHERE project_id = '$project_id'";
                    $run_project = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($run_project);
                    $project_name = $row['project_name'];
                    $project_startdate = $row['project_startdate'];
                    $project_enddate = $row['project_enddate'];
                    $project_description = $row['project_description'];
                    $project_address = $row['project_address'];
                    $project_budget = $row['project_budget'];
                    $project_status = $row['project_status'];
                    $photo = $row['photo'];
                    echo "<script>alert($project_id)</script>";
                }
                ?>

                <?php
                //For Status of project employees
                // if(isset($_GET['project_id'])){

                //  $currentDate = date('Y-m-d');
                // if($row['timeline_sched'] >= $currentDate && $row['project_date_end'] <= $currentDate){
                //     $status = "On going";
                //     $sql = "UPDATE project_employee SET status = '$status' ";
                //     $query = $conn->query($sql);

                // }
                // else if($row['timeline_sched'] < $currentDate && $row['project_date_end'] > $currentDate ){
                //     $status = "Vacant";
                //     $sql = "UPDATE project_employee SET status = '$status' ";
                //     $query = $conn->query($sql);

                // }

                //             $currentDate = date('Y-m-d');
                // 			if($currentDate >= $row['timeline_sched'] && $currentDate < $row['project_date_end'])
                // 			{
                // 			    $status = "On going";
                // 			}
                // 		    else {
                // 			    $status = "Vacant";
                // 			}


                // }

                ?>


                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <a href="project.php" class="btn btn-primary btn-sm btn-flat"><i
                                        class="fa fa-arrow-left"></i> Go Back</a>
                                <center>
                                    <h1 class="box-title" style="font-size: 40px;font-weight: bold;">
                                        <?php echo $project_name ?></h1>
                                </center>
                            </div>
                            <div class="box-body">
                                <div class="row" style="text-align: center;">
                                    <a class="btn btn-app active" href="#tab_1" data-toggle="tab">
                                        <i class="fa fa-info-circle "></i> Details
                                    </a>
                                    <a class="btn btn-app" href="#tab_2" data-toggle="tab">
                                        <i class="fa fa-users"></i> Employee
                                    </a>
                                    <a class="btn btn-app" href="#tab_3" data-toggle="tab">
                                        <i class="fa fa-wrench"></i> Materials
                                    </a>
                                    <a class="btn btn-app" href="#tab_4" data-toggle="tab">
                                        <i class="fa fa-file"></i> Equipment Logs
                                    </a>
                                </div>

                                <div class="nav-tabs-custom">
                                    <div class="tab-content">

                                        <!-- /.tab-pane DETAILS -->
                                        <div class="tab-pane active" id="tab_1">
                                            <div class="box box-solid box-success">
                                                <div class="box-header">
                                                    <h1 class="box-title">Project Information</h1>
                                                    <!-- details button sa gilid -->
                                                    <div class="pull-right">
                                                        <div class="btn-group-horizontal">
                                                            <!--<button type='button' class='edit btn btn-default' data-card-widget='edit' data-toggle='tooltip' title='Edit'><i class='fa fa-edit'></i></button>-->
                                                        </div>
                                                    </div>
                                                    <!-- /.details button sa gilid -->
                                                </div><!-- /.box-header -->
                                                <div class="box-body">
                                                    <!-- The body of the box -->
                                                    <!-- Main content -->
                                                    <section class="content">
                                                        <!-- Default box -->
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div
                                                                        class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                                                                        <div class="row">
                                                                            <div class="col-md-6 c col-6">
                                                                                <div class="info-box">
                                                                                    <span
                                                                                        class="info-box-icon bg-warning"><i
                                                                                            class="fa fa-rouble"></i></span>
                                                                                    <div class="info-box-content">
                                                                                        <span
                                                                                            class="info-box-text rclc-info-box-text">Budget</span>
                                                                                        <span
                                                                                            class="info-box-number"><?php echo $project_budget ?></span>
                                                                                    </div>
                                                                                    <!-- /.info-box-content -->
                                                                                </div>
                                                                                <!-- /.info-box -->
                                                                            </div>
                                                                            <!-- /.col -->
                                                                            <div class="col-md-6  col-6">
                                                                                <div class="info-box">
                                                                                    <span
                                                                                        class="info-box-icon bg-success"><i
                                                                                            class="fa fa-area-chart"></i></span>
                                                                                    <div class="info-box-content">
                                                                                        <span
                                                                                            class="info-box-text rclc-info-box-text">Status</span>
                                                                                        <span
                                                                                            class="info-box-number"><?php echo $row['project_status']; ?></span>
                                                                                    </div>
                                                                                    <!-- /.info-box-content -->
                                                                                </div>
                                                                                <!-- /.info-box -->
                                                                            </div>
                                                                            <!-- /.col -->
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                                                                        <!-- Details Box -->
                                                                        <strong class="text-muted"><i
                                                                                class="fa fa-book mr-1 "></i>
                                                                            Description</strong>
                                                                        <p class="text-muted">
                                                                            <?php echo $row['project_description']; ?>
                                                                        </p>
                                                                        <hr>
                                                                        <strong class="text-muted"><i
                                                                                class="fa fa-map-marker mr-1"></i>
                                                                            Address</strong>
                                                                        <p class="text-muted">
                                                                            <?php echo $row['project_address']; ?></p>
                                                                        <hr>
                                                                        <strong class="text-muted"><i
                                                                                class="fa fa-calendar mr-1"></i> Date
                                                                            Start</strong>
                                                                        <p class="text-muted">
                                                                            <?php echo date('M d, Y', strtotime($row['project_startdate'])); ?>
                                                                        </p>
                                                                        <hr>
                                                                        <strong class="text-muted"><i
                                                                                class="fa fa-calendar mr-1"></i> Date
                                                                            Finish</strong>
                                                                        <p class="text-muted">
                                                                            <?php echo date('M d, Y', strtotime($row['project_enddate'])); ?>
                                                                        </p>
                                                                        <hr>
                                                                        <!-- <strong class="text-muted"><i class="fa fa-file mr-1"></i> Notes</strong>
                                                                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p> -->
                                                                        <!-- /.card -->
                                                                        <hr>
                                                                        <h4 class="text-primary"> Project Files</h4>
                                                                        <form action="upload.php" method="post"
                                                                            enctype="multipart/form-data">
                                                                            <hr>
                                                                            <div class="text-center mt-5 mb-3">
                                                                                <!--<a href="upload.php" class="btn btn-sm btn-primary">Add files</a>-->
                                                                                <!--<a href="#" class="btn btn-sm btn-warning">Report contact</a>-->

                                                                                <input type="file" name="file" />
                                                                                <button type="submit" name="btn-upload"
                                                                                    class="btn btn-sm btn-primary">Add
                                                                                    files</button>
                                                                                <input type="hidden" name="id"
                                                                                    value="<?php echo $row['project_id']; ?>" />
                                                                            </div>
                                                                        </form>
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <th>File Name</th>
                                                                                <th>View</th>

                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                $sql = "SELECT * FROM project_files WHERE projectid = '$project_id' ";
                                                                                $query = $conn->query($sql);
                                                                                while ($row = $query->fetch_assoc()) {
                                                                                ?>
                                                                                <tr>
                                                                                    <td><?php echo $row['file']; ?></td>
                                                                                    <td><a href="uploads/<?php echo $row['file'] ?>"
                                                                                            target="_blank">View
                                                                                            file</a></td>

                                                                                </tr>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- /.card-body -->
                                                        </div>
                                                        <!-- /.card -->
                                                    </section>
                                                    <!-- /.content -->
                                                </div><!-- /.box-body -->
                                            </div>
                                        </div>


                                        <!-- /.tab-pane EMPLOYEE-->
                                        <div class="tab-pane" id="tab_2">
                                            <div class="box box-solid box-success">
                                                <div class="box-header">
                                                    <h1 class="box-title">Project Employee</h1>
                                                    <!-- employee button sa Gilid -->
                                                    <div class="pull-right">
                                                        <div class="btn-group-horizontal">

                                                            <!--<a href="#addnewleader" data-id="<?php echo $row['project_id']; ?>" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Assign Project Leader</a>-->
                                                            <a href="#addnewworker"
                                                                data-id="<?php echo $row['project_id']; ?>"
                                                                data-toggle="modal"
                                                                class="btn btn-primary btn-sm btn-flat"><i
                                                                    class="fa fa-plus"></i> Assign Project Workers</a>
                                                        </div>
                                                    </div>

                                                    <!-- /.employee button sa Gilid -->
                                                </div><!-- /.box-header -->
                                                <div class="box-body">
                                                    <!-- The body of the box -->
                                                    <!-- Main content for Project Emnployee-->
                                                    <section class="content">
                                                        <table id="example1" class="table table-bordered">
                                                            <thead>
                                                                <th>Name</th>
                                                                <th>Position</th>
                                                                <th>Status</th>
                                                                <th>Project Worker Start</th>
                                                                <th>Project Worker End</th>
                                                                <th>Tools</th>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                // $sql = "SELECT * FROM project_employee WHERE projectid = '$project_id'";
                                                                $sql = "SELECT *, project_employee.id, employees.employee_id FROM project_employee LEFT JOIN employees ON employees.employee_id=project_employee.name WHERE projectid = '$project_id'";
                                                                $query = $conn->query($sql);
                                                                while ($row = $query->fetch_assoc()) {
                                                                ?>
                                                                <tr>
                                                                    <!--<td><?php echo $row['name']; ?></td>-->
                                                                    <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?>
                                                                    </td>
                                                                    <td><?php echo $row['position']; ?></td>
                                                                    <td><?php echo $row['status']; ?></td>
                                                                    <td><?php echo $row['timeline_sched']; ?></td>
                                                                    <td><?php echo $row['project_date_end']; ?></td>
                                                                    <!--<td></td>-->
                                                                    <td>
                                                                        <button type="button" data-target="#edit"
                                                                            class="btn btn-success btn-sm edit btn-flat"
                                                                            data-card-widget="edit"
                                                                            data-toggle="tooltip" title="Edit"
                                                                            data-id="<?php echo $row['id']; ?>"><i
                                                                                class="fa fa-edit"></i> </button>

                                                                        <button type="button"
                                                                            class='btn btn-danger btn-sm delete btn-flat'
                                                                            data-card-widget='remove'
                                                                            data-toggle='tooltip' title='Remove'
                                                                            data-id="<?php echo $row['id']; ?>"><i
                                                                                class='fa fa-trash'></i></button>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>

                                                        </table>
                                                    </section>
                                                    <!-- /.Main content for Project Emnployee-->
                                                </div><!-- /.box-body -->
                                            </div>
                                        </div>
                                        <!-- END-->


                                        <!-- /.tab-pane MATERIALS-->
                                        <div class="tab-pane" id="tab_3">
                                            <div class="box box-solid box-success">
                                                <div class="box-header">
                                                    <h1 class="box-title">Project Materials</h1>
                                                    <!-- employee button sa Gilid -->
                                                    <div class="pull-right">
                                                        <div class="btn-group-horizontal">
                                                            <a href="#addnewmaterials"
                                                                data-id="<?php echo $row['project_id']; ?>"
                                                                data-toggle="modal"
                                                                class="btn btn-primary btn-sm btn-flat"><i
                                                                    class="fa fa-plus"></i> Add Project Materials</a>
                                                            <!-- /.$row['project_id']; -->

                                                        </div>
                                                    </div>
                                                    <!-- /.employee button sa Gilid -->
                                                </div><!-- /.box-header -->
                                                <!-- The body of the box -->
                                                <div class="box-body">
                                                    <!-- Main content for Project Emnployee-->
                                                    <section class="content">
                                                        <!-- Default box - Ito ung laman ng box-->
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <div class="box">
                                                                    <div class="box-body">
                                                                        <table id="example2"
                                                                            class="table table-bordered">
                                                                            <thead>
                                                                                <th>Description</th>
                                                                                <th>Quantity</th>
                                                                                <th>Unit</th>
                                                                                <th>Unit Cost</th>
                                                                                <th>Amount Cost</th>
                                                                                <!-- <th>Total Amount Cost</th> -->
                                                                                <th>Tools</th>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                $sql = "SELECT * FROM project_materials WHERE proj_id = '$project_id'";
                                                                                $query = $conn->query($sql);
                                                                                while ($row = $query->fetch_assoc()) {
                                                                                ?>
                                                                                <tr>
                                                                                    <td><?php echo $row['description']; ?>
                                                                                    </td>
                                                                                    <td><?php echo $row['quantity']; ?>
                                                                                    </td>
                                                                                    <td><?php echo $row['unit']; ?></td>
                                                                                    <td><?php echo $row['unit_cost']; ?>
                                                                                    </td>
                                                                                    <td><?php echo $row['amnt_cost']; ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <button type="button"
                                                                                            name="#editmaterials"
                                                                                            class="btn btn-success btn-sm editmaterials btn-flat"
                                                                                            data-card-widget="edit"
                                                                                            data-toggle="modal"
                                                                                            title="Edit"
                                                                                            data-id="<?php echo $row['id']; ?>"><i
                                                                                                class="fa fa-edit"></i>
                                                                                        </button>

                                                                                        <button type="button"
                                                                                            name="deleteprojectmater"
                                                                                            class='btn btn-danger btn-sm deleteprojectmater btn-flat'
                                                                                            data-card-widget='remove'
                                                                                            data-toggle='modal'
                                                                                            title='Remove'
                                                                                            data-id="<?php echo $row['id']; ?>"><i
                                                                                                class='fa fa-trash'></i></button>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </tbody>
                                                                            <!-- Total lahat ng materials dito... -->
                                                                            <tr>
                                                                                <td><b>Total Amount Cost</b></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <?php
                                                                                $sql = "SELECT SUM(amnt_cost) FROM project_materials WHERE proj_id = '$project_id'";
                                                                                $query = $conn->query($sql);
                                                                                while ($row = $query->fetch_assoc()) {
                                                                                    $sum = $row['SUM(amnt_cost)'];
                                                                                    echo "
                                                                                            <td>$sum</td>
                                                                                            <td></td>";
                                                                                }
                                                                                ?>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /. Default box -->
                                                    </section>
                                                    <!-- /.Main content for Project Emnployee-->
                                                </div><!-- /.box-body -->
                                            </div>
                                        </div>


                                        <!-- /.tab-pane MATERIAL LOGS-->
                                        <div class="tab-pane" id="tab_4">
                                            <div class="box box-solid box-success">
                                                <div class="box-header">
                                                    <h1 class="box-title">Project Materials Logs</h1>
                                                    <!-- employee button sa Gilid -->
                                                    <div class="pull-right">
                                                        <div class="btn-group-horizontal">
                                                            <a type="button" href="#addlogmaterials"
                                                                id="<?php echo $row['project_id']; ?>"
                                                                data-toggle="modal"
                                                                class="btn btn-primary btn-sm btn-flat"><i
                                                                    class="fa fa-plus"></i>Add Material Log</a>

                                                        </div>
                                                    </div>
                                                    <!-- /.employee button sa Gilid -->
                                                </div><!-- /.box-header -->
                                                <!-- The body of the box -->
                                                <div class="box-body">
                                                    <!-- Main content for Project Emnployee-->
                                                    <section class="content">
                                                        <!-- Default box - Ito ung laman ng box-->
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <div class="box">
                                                                    <div class="box-body">
                                                                        <table id="example3"
                                                                            class="table table-bordered">
                                                                            <thead>
                                                                                <th>Date</th>
                                                                                <th>Employee Name</th>
                                                                                <th>Material Name</th>
                                                                                <th>Time Borrow</th>
                                                                                <th>Status</th>
                                                                                <th>Quantity</th>
                                                                                <th>Condition</th>
                                                                                <th>Time Return</th>
                                                                                <th>Price</th>
                                                                                <th>Tools</th>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                // $sql = "SELECT * FROM project_materials_log WHERE proj_id = '$project_id' ";

                                                                                // $sql = "SELECT *, project_materials_log.id, employees.employee_id FROM project_materials_log LEFT JOIN employees ON employees.employee_id=project_materials_log.name WHERE proj_id = '$project_id'";

                                                                                $sql = "SELECT *, project_materials_log.id, employees.employee_id FROM project_materials_log LEFT JOIN employees ON employees.employee_id=project_materials_log.name LEFT JOIN materials_list ON materials_list.list_id=project_materials_log.material WHERE proj_id = '$project_id'";

                                                                                // $sql = "SELECT *, project_employee.id, employees.employee_id FROM project_employee LEFT JOIN employees ON employees.employee_id=project_employee.name WHERE projectid = '$project_id'";

                                                                                $query = $conn->query($sql);
                                                                                while ($row = $query->fetch_assoc()) {
                                                                                ?>
                                                                                <tr>
                                                                                    <td><?php echo $row['date']; ?></td>
                                                                                    <!--<td><?php echo $row['name']; ?></td>-->
                                                                                    <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?>
                                                                                    </td>
                                                                                    <td><?php echo $row['materials_name']; ?>
                                                                                    </td>
                                                                                    <td><?php echo $row['time_borrow']; ?>
                                                                                    </td>
                                                                                    <td><?php echo $row['status']; ?>
                                                                                    </td>
                                                                                    <td><?php echo $row['quantity1']; ?>
                                                                                    </td>
                                                                                    <td><?php echo $row['con_dition']; ?>
                                                                                    </td>
                                                                                    <td><?php echo $row['time_return']; ?>
                                                                                    </td>
                                                                                    <td><?php echo $row['price']; ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <button type="button"
                                                                                            name="#editmaterialslog"
                                                                                            class="btn btn-success btn-sm editmaterialslog btn-flat"
                                                                                            data-card-widget="edit"
                                                                                            data-toggle="modal"
                                                                                            title="Edit"
                                                                                            data-id="<?php echo $row['id']; ?>"><i
                                                                                                class="fa fa-edit"></i>
                                                                                        </button>

                                                                                        <!--<button type="button" name="#deleteprojectmaterlog" class='btn btn-danger btn-sm deleteprojectmaterlog btn-flat' data-card-widget='remove' data-toggle='modal' title='Remove' data-id="<?php echo $row['id']; ?>"><i class='fa fa-trash'></i></button>-->
                                                                                    </td>
                                                                                </tr>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /. Default box -->
                                                    </section>
                                                    <!-- /.Main content for Project Emnployee-->
                                                </div><!-- /.box-body -->
                                            </div>
                                        </div>
                                    </div> <!-- /.tab-pane -->
                                </div> <!-- /.tab-content -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include 'includes/project_employee_modal.php'; ?>
        <?php include 'includes/project_worker_modal.php'; ?>
        <?php include 'includes/project_materials_modal.php'; ?>
        <?php include 'includes/project_materials_log_modal.php'; ?>
        <?php include 'includes/footer.php'; ?>
    </div>
    <?php include 'includes/scripts.php'; ?>
    <script>
    //Project Materials
    $(function() {
        $(document).on('click', '.editmaterials', function() {
            // e.preventDefault();
            $('#editmaterials').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $(document).on('click', '.deleteprojectmater', function() {
            // e.preventDefault();
            $('#deleteprojectmater').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });
    });

    function getRow(id) {
        $.ajax({
            type: 'POST',
            url: 'project_materials_row.php',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                $('#projmaterid').val(response.id);
                $('#edit_description').val(response.description);
                $('#edit_quantity').val(response.quantity);
                $('#edit_unit').val(response.unit);
                $('#edit_unit_cost').val(response.unit_cost);
                $('#edit_amnt_cost').val(response.amnt_cost);

                $('#delprojmaterid').val(response.id);
                $('#del_description').html(response.description);
            }
        });
    } /*    */


    //Project Employees
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

    function getRow2(id) {
        $.ajax({
            type: 'POST',
            url: 'project_view_row.php',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                $('#projworkerid').val(response.id);
                // $('#edit_project_worker').val(response.name);
                $('#edit_position').val(response.position);
                $('#edit_project_date').val(response.timeline_sched);
                $('#edit_project_date_end').val(response.project_date_end);

                $('#delprojworkerid').val(response.id);
                $('#del_name').html(response.name);
            }
        });
    }

    //Project Material Logs
    $(function() {
        $(document).on('click', '.editmaterialslog', function() {
            // e.preventDefault();
            $('#editmaterialslog').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $(document).on('click', '.deleteprojectmaterlog', function() {
            // e.preventDefault();
            $('#deleteprojectmaterlog').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });
    });

    function getRow3(id) {
        $.ajax({
            type: 'POST',
            url: 'project_materials_log_row.php',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {

                $('#edit_date').val(response.date);
                $('#edit_name').val(response.name);
                // $('#edit_material').val(response.material);
                $('#edit_quantity1').val(response.quantity1);
                $('#edit_mat').val(response.material);
                $('#edit_time_borrow').val(response.time_borrow);
                $('#edit_status').val(response.status);
                $('#edit_time_return').val(response.time_return);
                $('#edit_price').val(response.price);
                $('#projmaterlogid').val(response.id);

                $('#delprojmaterlogid').val(response.id);
                $('#del_materlog').html(response.material);
                $('#del_materlog').val(response.material);
                $('#delmaterial').val(response.quantity1);
                // $('#delmaterial').val(response.quantity1);
            }
        });
    }
    </script>

</body>

</html>