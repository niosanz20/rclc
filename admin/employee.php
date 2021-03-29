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
          Employee List
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li>Employees</li>
          <li class="active">Employee List</li>
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
        } else if (isset($_SESSION['success'])) {
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4><i class='icon fa fa-check'></i> Success!</h4>
                  " . $_SESSION['success'] . "
                <hr>
            </div>";
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
                    <!--<th>Employee ID</th>-->
                    <th>Photo</th>
                    <th>QR</th>
                    <th>Name</th>
                    <!--<th>Position</th>-->
                    <th>Schedule</th>
                    <th>Position</th>
                    <th>Tools</th>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT *, employees.id AS empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id";
                    $query = $conn->query($sql);
                    while ($row = $query->fetch_assoc()) {
                    ?>
                      <tr>
                        <!--<td><?php echo $row['employee_id']; ?></td>-->
                        <td>
                          <!-- Photo Display -->
                          <img src="<?php echo (!empty($row['photo'])) ? '../images/' . $row['photo'] : '../images/profile.jpg'; ?>" width="30px" height="30px" class="img-circle img-fluid "> <a href="#edit_photo" data-toggle="modal" class="pull-right photo" data-id="<?php echo $row['empid']; ?>"><span class="fa fa-edit"></span></a>
                        </td>
                        <td>
                          <!-- QR Display -->
                          <img src="<?php echo (!empty($row['qrimage'])) ? '../images/' . $row['qrimage'] : '../images/profile.jpg'; ?>" width="30px" height="30px">
                        </td>
                        <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                        <!--<td><?php echo $row['description']; ?></td>-->
                        <td><?php echo date('h:i A', strtotime($row['time_in'])) . ' - ' . date('h:i A', strtotime($row['time_out'])); ?></td>
                        <!-- <td><?php echo date('M d, Y', strtotime($row['created_on'])) ?></td> -->
                        <td><?php echo $row['description']; ?></td>
                        <td>
                          <button class="viewEmployee btn btn-info btn-sm btn-flat" data-card-widget="view" data-toggle="tooltip" title="View" id="<?php echo $row['empid']; ?>"><i class="glyphicon glyphicon-eye-open"></i> View</button>
                          <button class="btn btn-success btn-sm edit btn-flat" data-card-widget="edit" data-toggle="tooltip" title="Edit" data-id="<?php echo $row['empid']; ?>"><i class="fa fa-edit"></i> Edit</button>
                          <button class="btn btn-danger btn-sm delete btn-flat" data-card-widget="delete" data-toggle="tooltip" title="Delete" data-id="<?php echo $row['empid']; ?>"><i class="fa fa-trash"></i> Delete</button>
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
    <?php include 'includes/employee_modal.php'; ?>

    <div id="viewEmployee" class="modal fade">
      <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="">
          <!-- <div class="modal-header">

            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><span class="glyphicon glyphicon-file"></span>Worker's Information<strong id="employee_name"></strong></h4>
          </div> -->
          <div class="modal-body" id="modal-view-employee">

          </div>
        </div>
      </div>
    </div>

  </div>

  <?php include 'includes/scripts.php'; ?>
  <script>
    $(function() {
      $(document).on('click', '.view', function() {
        // e.preventDefault();
        $('#view').modal('show');
        var id = $(this).data('id');
        getRow(id);
      });

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

      $(document).on('click', '.photo', function() {
        // e.preventDefault();
        var id = $(this).data('id');
        getRow(id);
      });

    });

    /*--
     Display Modal of Info for Employee
     -----------------------------------*/
    $(document).on('click', '.viewEmployee', function() {
      var empID = $(this).attr("id");
      $.ajax({
        url: "includes/viewinfo_employee.php",
        method: "POST",
        data: {
          empID: empID
        },
        dataType: 'json',
        success: function(data) {
          //  content of payroll summary
          $('#modal-view-employee').html(data.employee_modal);
          // $('#employee_name').text(data.empName);
          //  content of breakdown of specific payroll (printable)
          // $('#printout').html(data.payroll_details);
          $('#viewEmployee').modal('show');
        },
        error: function(data) {
          console.log(data);
        }
      });
    });

    function getRow(id) {
      $.ajax({
        type: 'POST',
        url: 'employee_row.php',
        data: {
          id: id
        },
        dataType: 'json',
        success: function(response) {
          $('.empid').val(response.empid);
          $('.employee_id').html(response.employee_id);
          $('.del_employee_name').html(response.firstname + ' ' + response.lastname);
          $('#employee_name').html(response.firstname + ' ' + response.lastname);
          $('#view_firstname').val(response.firstname);
          $('#edit_firstname').val(response.firstname);
          $('#edit_lastname').val(response.lastname);
          $('#edit_address').val(response.address);
          $('#datepicker_edit').val(response.birthdate);
          $('#edit_contact').val(response.contact_info);
          $('#gender_val').val(response.gender).html(response.gender);
          $('#position_val').val(response.position_id).html(response.description);
          $('#schedule_val').val(response.schedule_id).html(response.time_in + ' - ' + response.time_out);
        }
      });
    }
  </script>
</body>

</html>