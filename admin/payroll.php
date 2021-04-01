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
          Payroll
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Payroll</li>
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
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Employee List</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Employee filtered by date</a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                      <center>
                        <h3>Payroll Report (Pay Date)</h3>
                      </center>
                      <table id="example5" class="table table-bordered">
                        <thead>
                          <th>Name</th>
                          <th>Position</th>
                          <th>Contact Info</th>
                          <th>Action</th>
                        </thead>
                        <tbody>
                          <?php
                          $sql = "SELECT *, employees.id AS empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id";
                          $query = $conn->query($sql);
                          while ($row = $query->fetch_assoc()) {
                          ?>
                            <tr>
                              <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                              <td><?php echo $row['description']; ?></td>
                              <td><?php echo $row['contact_info']; ?></td>
                              <td>
                                <button class="viewPayroll btn btn-success btn-sm edit btn-flat" data-toggle="tooltip" title="View" id="<?php echo $row['employee_id']; ?>"><i class="fa fa-eye"></i> View </button>
                              </td>
                            </tr>
                          <?php
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                    <!-- /.tab-pane -->
                     <div class="tab-pane" id="tab_2">
                      <div class="row">
                        <div class="col-lg-6" style="text-align: right;">
                          <h3>Payroll Report (Pay Date) | </h3>
                        </div>
                        <div class="col-lg-6" style="margin-top: 15px; max-width: 300px;">
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
                      </div>
                        <div class="panel" id="attendanceRecord_table">
						
					    </div> 
                      
                    </div>
                    <!-- /.tab-pane -->
                  </div>
                  <!-- /.tab-content -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <?php include 'includes/footer.php'; ?>
    <!-- Vertically Centered Modal Start -->
    <div id="viewPayroll" class="modal fade">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><span class="glyphicon glyphicon-file"></span>Payroll Summary for <strong id="employee_name"></strong></h4>
          </div>
          <div class="modal-body" id="modal-view-payroll">

          </div>
        </div>
      </div>
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

  </div>
  <?php include 'includes/scripts.php'; ?>
  <script>
    $(document).ready(function() {
        
    loadAttendanceRecord(0);
	insertEmployeePayslip();
	
	/*--
      Insert Data OnLoad of page for Payslip of every Employee
      -----------------------------------*/
	function insertEmployeePayslip(){
		 var dateNow = Date.now();
		$.ajax({
			url: "php/insertEmployeePayslip.php",
			method: "POST",
			data:{dateNow:dateNow},
			success: function(data){
				//alert(data);
			},
			error: function(){
				console.log('There is something wrong!');
			}
			
		});
	}
        

      /*--
      Display Modal of Payroll for Employee
      -----------------------------------*/
      $(document).on('click', '.viewPayroll', function() {
        var empID = $(this).attr("id");
        $.ajax({
          url: "php/view_payroll.php",
          method: "POST",
          data: {
            empID: empID
          },
          dataType: 'json',
          success: function(data) {
            //  content of payroll summary
            $('#modal-view-payroll').html(data.payroll_table);
            $('#employee_name').text(data.empName);
            //  content of breakdown of specific payroll (printable)
            $('#printout').html(data.payroll_details);
            $('#viewPayroll').modal('show');
          },
          error: function(data) {
            console.log(data);
          }
        });
      });

      /*--
      Display Modal of Payroll Details for Employee
      -----------------------------------*/
      $(document).on('click', '.viewPayrollDetails', function() {
        var empID2 = $(this).attr("id");
        var cutoffID = $(this).attr("refid");
        $.ajax({
          url: "php/view_payroll.php",
          method: "POST",
          data: {
            empID2: empID2,
            cutoffID: cutoffID
          },
          dataType: 'json',
          success: function(data) {
            //  content of breakdown of specific payroll (printable)
            $('#printout').html(data.payroll_details);
            window.addEventListener('load', window.print());
          },
          error: function(data) {
            console.log(data);
          }
        });
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
      
      /*--
    Display Modal of Payroll for CutOff
    -----------------------------------*/
      $(document).on('click', '.cutoffdate', function() {
        var cutoff_id = $('#cuttoffdate_value').val();
		
		if(cutoff_id != ""){
		  loadAttendanceRecord(cutoff_id);
		}
		
       
      });
	  
	  function loadAttendanceRecord(cutoff_id){
		 $.ajax({
          url: "php/load_attendancerecord.php",
          method: "POST",
		  data: {
            cutoff_id: cutoff_id
          },
          dataType: "json",
          success: function(data) {
			  
			$('#attendanceRecord_table').html(data.attendanceRecord);
			
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