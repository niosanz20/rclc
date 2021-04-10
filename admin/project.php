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
                    Project List
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li>Project</li>
                    <li class="active">Project List</li>
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
                            <div class="box-header with-border">
                                <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> New</a>
                            </div>
                            <div class="box-body">
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <!--<th>Project ID</th>-->
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Owner</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM project";
                                        $query = $conn->query($sql);
                                        while ($row = $query->fetch_assoc()) {

                                        ?>
                                            <tr>
                                                <!--<td><?php echo $row['project_id']; ?></td>-->
                                                <td><img src="<?php echo (!empty($row['photo'])) ? '../images/projectimg/' . $row['photo'] : '../images/projectimg/profile.jpg'; ?>" width="30px" height="30px" class="img-circle img-fluid img-margin"> <a href="#edit_photo" data-toggle="modal" class="pull-right photo" data-id="<?php echo $row['project_id']; ?>"><span class="fa fa-edit"></span></a></td>
                                                <td><?php echo $row['project_name']; ?></td>
                                                <td><?php echo $row['project_address']; ?></td>
                                                <td><?php echo $row['project_owner']; ?></td>
                                                <?php
                                                if ($row['project_status'] == "Active") {
                                                    echo ' <td class="project-state "><span class="badge badge-active rclc-center"> ' . $row['project_status'] . ' </span></td> ';
                                                } else if ($row['project_status'] == "Pending") {
                                                    echo ' <td class="project-state "><span class="badge badge-pending rclc-center"> ' . $row['project_status'] . ' </span></td> ';
                                                } else if ($row['project_status'] == "Finish") {
                                                    echo ' <td class="project-state "><span class="badge badge-finish rclc-center"> ' . $row['project_status'] . ' </span></td> ';
                                                }
                                                ?>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
                                                            <span class="fa fa-caret-down"></span></button>
                                                        <ul class="dropdown-menu" role="menu">

                                                            <li><a href="project_view.php?project_id=<?php echo $row['project_id'] ?>&start_date=<?php echo $row['project_startdate'] ?>&end_date=<?php echo $row['project_enddate'] ?>&projectname=<?php echo $row['project_name'] ?>">View</a></li>

                                                            <!--<li><a href="project_view.php?project_id=<?php echo $row['project_id'] ?>">View</a></li>-->

                                                            <li><a class="edit" data-id="<?php echo $row['project_id']; ?>">Edit</a></li>
                                                            <!--<li><a href="#">Assign Employee</a></li>
                                                            <li><a href="#">Assign Materials </a></li> -->
                                                            <!-- <li class="divider"></li>
                                                            <li><a class="delete" data-id="<?php echo $row['project_id']; ?>">Delete</a></li> -->
                                                        </ul>
                                                    </div>

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
            </section>
        </div>

        <?php include 'includes/footer.php'; ?>
        <?php include 'includes/project_modal.php'; ?>
    </div>
    <?php include 'includes/scripts.php'; ?>
    <script>
        $(function() {
            $(document).on('click', '.edit', function() {
                // e.preventDefault();
                $('#edit').modal('show');
                var project_id = $(this).data('id');
                getRow(project_id);
            });

            $(document).on('click', '.delete', function() {
                // e.preventDefault();
                $('#delete').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });

            $(document).on('click', '.photo', function() {
                // e.preventDefault();
                var project_id = $(this).data('id');
                getRow(project_id);
            });

        });

        function getRow(project_id) {
            $.ajax({
                type: 'POST',
                url: 'project_row.php',
                data: {
                    project_id: project_id
                },
                dataType: 'json',
                success: function(response) {
                    $('.project_id').val(response.project_id);
                    $('#project_id').val(response.project_id);
                    $('.del_project_name').html(response.project_name);
                    $('#project_name').val(response.project_name);
                    $('#edit_project_name').val(response.project_name);
                    $('#datepicker_edit').val(response.project_startdate);
                    $('#datepicker_edit2').val(response.project_enddate);
                    $('#edit_project_description').val(response.project_description);
                    $('#edit_project_owner').val(response.project_owner);
                    $('#edit_project_address').val(response.project_address);
                    $('#edit_project_budget').val(response.project_budget);
                    $('#status_val').val(response.project_status).html(response.project_status);
                }
            });
        }
    </script>
</body>

</html>