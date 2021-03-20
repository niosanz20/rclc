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
                    Material List
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li>Project</li>
                    <li class="active">Materials List</li>
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
                                <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
                            </div>
                            <div class="box-body">
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <th>Material ID</th>
                                        <th>Material Name</th>
                                        <th>Description</th>
                                        <th>Unit</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Tools</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM materials";
                                        $query = $conn->query($sql);
                                        while ($row = $query->fetch_assoc()) {
                                        echo "
                                            <tr>
                                              <td>" . $row['materials_id'] . "</td>
                                              <td>" . $row['name'] . "</td>
                                              <td>" . $row['description']. "</td>
                                              <td>" . $row['unit']. "</td>
                                              <td>" . $row['price']. "</td>
                                              <td>" . $row['stock']. "</td>
                                              <td>
                                                <button class='btn btn-success btn-sm edit btn-flat' data-id='" . $row['materials_id'] . "'><i class='fa fa-edit'></i> Edit</button>
                                              </td>
                                            </tr> ";
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
        <?php include 'includes/add_materials_modal.php'; ?>
    </div>
    <?php include 'includes/scripts.php'; ?>
    <script>
        $(function() {
            $('.edit').click(function(e) {
                e.preventDefault();
                $('#edit').modal('show');
                var materials_id = $(this).data('id');
                getRow(materials_id);
            });

            $('.delete').click(function(e) {
                e.preventDefault();
                $('#delete').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });

            $('.photo').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                getRow(id);
            });

        });

        function getRow(materials_id) {
            $.ajax({
                type: 'POST',
                url: 'materials_list_row.php',
                data: {
                   materials_id: materials_id
                },
                dataType: 'json',
                success: function(response) {
                    $('.materials_id').val(response.materials_id);
                    $('#materials_id').val(response.materials_id);
                    $('.del_materials_name').html(response.name);
                    $('#edit_material_name').val(response.name);
                    $('#edit_material_description').val(response.description);
                    $('#edit_material_unit').val(response.unit);
                    $('#edit_material_price').val(response.price);
                    $('#edit_material_pieces').val(response.stock);
                }
            });
        }
    </script>
</body>

</html>