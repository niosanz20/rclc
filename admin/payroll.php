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
          <!-- Tophe ehhehe -->
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
                <div class="row">
                  <div class="col-lg-2">
                     <span><strong>Filter by: </strong></span>
                      <select class="form-control" id="tableSelection">
                        <option>Employee</option>
                        <option>Cutoff Date</option>
                      </select>
                    </div>
                    <div class="col-lg-2" id="filter-date-section" style="display: none">
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
                </div>
                <div class="row col-lg-12">
                  <div class="panel" id="tableSection">
                    
                  </div>
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
        
  loadEmployeeList();
	insertEmployeePayslip();

  $(document).on('change', '#tableSelection', function() {
    //get selected value in dropdown selection
    var index = $("select[id='tableSelection'] option:selected").index();

    switch(index){
      case 0:
        document.getElementById('filter-date-section').style.display = "none";
        // document.getElementById('tableSection').innerHTML = "";
        loadEmployeeList();
      break;
      case 1:
        document.getElementById('filter-date-section').style.display = "block";
        // document.getElementById('tableSection').innerHTML = "";
        var cutoff_id = $('#cuttoffdate_value').val();
        loadAttendanceRecord(cutoff_id);
      break;
    }
  });

  /*--
  Load Attendance Record by CutOff Date
  -----------------------------------*/
    $(document).on('click', '.cutoffdate', function() {
      var cutoff_id = $('#cuttoffdate_value').val();
  
      if(cutoff_id != ""){
        loadAttendanceRecord(cutoff_id);
      }
    });

  /*--
  Display Table: Employee List
  -----------------------------------*/
  function loadEmployeeList(){
     $.ajax({
          url: "php/load_employeeList.php",
          method: "POST",
          data: {},
          dataType: "json",
          success: function(data) {
          
           $('#tableSection').html(data.employeeList);
      
          },
          error: function(data) {
            console.log(data);
          }
        });  
  }
  /*--
  Display Table: Employee List Filtered by Cutoofdate
  -----------------------------------*/
  function loadAttendanceRecord(cutoff_id){
     $.ajax({
          url: "php/load_attendancerecord.php",
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
  Insert Data OnLoad of page for Payslip of every Employee
  -----------------------------------*/
	function insertEmployeePayslip(){
		 var dateNow = Date.now();
		$.ajax({
			url: "php/insertEmployeePayslip.php",
			method: "POST",
			data:{dateNow:dateNow},
			success: function(data){
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
    Generate Payroll of all employees
    -----------------------------------*/
      $(document).on('click', '.generate-all-payroll', function() {
        var cutoff_id = $(this).attr("id");
		
		if(cutoff_id != ""){
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
		  complete: function(data){
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