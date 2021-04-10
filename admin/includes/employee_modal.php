<!-- require_once('employee_add.php'); -->

<!-- Add -->
<div class="modal fade" id="addnew">
  <div class="modal-dialog modal-lg">
    <form role="form" method="POST" action="employee_add.php" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><b>Add Employee</b></h4>
        </div>
        <div class="modal-body">

          <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title"><b>EMPLOYEE INFORMATION</b></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->

                <div class="card-body">
                  <div class="form-group">
                    <label for="firstname" class="col-sm-3 control-label">First Name</label>
                    <input type="text" class="form-control" placeholder="Enter firstname" id="firstname" name="firstname" pattern="[A-Za-z\s]+" title="Only alphabets and white space allowed." required>
                  </div>
                  <div class="form-group">
                    <label for="lastname" class="col-sm-3 control-label">Last Name</label>
                    <input type="text" class="form-control" placeholder="Enter lastname" id="lastname" name="lastname" pattern="[A-Za-z\s]+" title="Only alphabets and white space allowed." required>
                  </div>
                  <div class="form-group">
                    <label for="address" class="col-sm-3 control-label">Address</label>
                    <textarea class="form-control" name="address" id="address" placeholder="Enter Address"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="datepicker_add" class="col-sm-3 control-label">Birthdate</label>
                    <input type="text" class="form-control" id="datepicker_add" name="birthdate" placeholder="Enter birthdate">
                  </div>
                  <div class="form-group">
                    <label for="contact" class="col-sm-6 control-label">Contact Info</label>
                    <input type="text" class="form-control" id="contact" name="contact" pattern="[0-9]{11}" title="11-digit number only and starts with 09." placeholder="Enter contact number">
                  </div>
                  <div class="form-group">
                    <label for="gender" class="col-sm-6 control-label">Gender</label>
                    <select class="form-control" name="gender" id="gender" required>
                      <option value="" selected>- Select -</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="photo">Photo</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <!-- <label class="custom-file-label">Choose file</label> -->
                        <input type="file" class="form-control" name="photo" id="photo">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <!-- </form> -->
              </div>
              <!-- /.card -->
            </div>

            <div class="col-md-6">
              <!-- general form elements -->
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title"><b>WORK INFORMATIONS</b></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <!-- <form role="form"> -->
                <div class="card-body">
                  <div class="form-group">
                    <label for="position" class="col-sm-3 control-label">Position</label>
                    <select class="form-control" name="position" id="position" required>
                      <option value="" selected>- Select -</option>
                      <?php
                      $sql = "SELECT * FROM position";
                      $query = $conn->query($sql);
                      while ($prow = $query->fetch_assoc()) {
                        echo " <option value='" . $prow['id'] . "'>" . $prow['description'] . "</option> ";
                      } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="schedule" class="col-sm-3 control-label">Schedule</label>
                    <select class="form-control" id="schedule" name="schedule" required>
                      <option value="" selected>- Select -</option>
                      <?php
                      $sql = "SELECT * FROM schedules";
                      $query = $conn->query($sql);
                      while ($srow = $query->fetch_assoc()) {
                        echo " <option value='" . $srow['id'] . "'>" . $srow['time_in'] . ' - ' . $srow['time_out'] . "</option> ";
                      } ?>
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->
                <!-- </form> -->
              </div>
              <!-- /.card -->
              <div class="card card-warning">
                <div class="card-header">
                  <h3 class="card-title"><b>GOVERNMENT INFORMATION</b></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="sss" class="col-sm-3 control-label">SSS</label>
                      <input type="text" class="form-control" placeholder="Enter 10-digits SSS number" id="sss" name="sss" pattern="[0-9]{10}" title="SSS number consists of 10 digits">
                    </div>
                    <div class="form-group">
                      <label for="pagibig" class="col-sm-3 control-label">Pag-ibig</label>
                      <input type="text" class="form-control" placeholder="Enter 12-digits Pag-ibig number" id="pagibig" name="pagibig" pattern="[0-9]{12}" title="Pag-ibig number consists of 12 digits">
                    </div>
                    <div class="form-group">
                      <label for="philhealth" class="col-sm-3 control-label">Philhealth</label>
                      <input type="text" class="form-control" placeholder="Enter 12-digits Philhealth number" id="philhealth" name="philhealth" pattern="[0-9]{12}" title="Philhealth number consists of 12 digits">
                    </div>
                    <div class="form-group">
                      <label for="tin" class="col-sm-3 control-label">Tin</label>
                      <input type="text" class="form-control" placeholder="Enter 9-digits Tin number" id="tin" name="tin" pattern="[0-9]{9}" title="Tin number consists of 9 digits">
                    </div>
                  </div>
                  <!-- /.card-body -->


              </div>
            </div>

          </div>
          <!-- </form> -->

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
          <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Save</button>
    </form>
  </div>
</div>
</div>
</div>


<!-- Edit -->
<div class="modal fade" id="edit">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" action="employee_edit.php">
        <input type="hidden" class="empid" name="id">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><b>Edit Employee</b> |
            <span class="employee_id"></span>
          </h4>
        </div>
        <div class="modal-body">

          <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title"><b>EMPLOYEE INFORMATION</b></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <div class="card-body">
                  <div class="form-group">
                    <label for="edit_firstname" class="col-sm-3 control-label">First Name</label>
                    <input type="text" class="form-control" placeholder="Enter firstname" id="edit_firstname" name="firstname" pattern="[A-Za-z\s]+" title="Only alphabets and white space allowed." required>
                  </div>
                  <div class="form-group">
                    <label for="edit_lastname" class="col-sm-3 control-label">Last Name</label>
                    <input type="text" class="form-control" placeholder="Enter lastname" id="edit_lastname" name="lastname" pattern="[A-Za-z\s]+" title="Only alphabets and white space allowed." required>
                  </div>
                  <div class="form-group">
                    <label for="edit_address" class="col-sm-3 control-label">Address</label>
                    <textarea class="form-control" name="address" id="edit_address" placeholder="Enter Address"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="datepicker_edit" class="col-sm-3 control-label">Birthdate</label>
                    <input type="text" class="form-control" id="datepicker_edit" name="birthdate" placeholder="Enter birthdate">
                  </div>
                  <div class="form-group">
                    <label for="edit_contact" class="col-sm-6 control-label">Contact Info</label>
                    <input type="text" class="form-control" id="edit_contact" name="contact" pattern="[0-9]{11}" title="11-digit number only and starts with 09." placeholder="Enter contact number">
                  </div>
                  <div class="form-group">
                    <label for="edit_gender" class="col-sm-6 control-label">Gender</label>
                    <select class="form-control" name="gender" id="edit_gender" required>
                      <option selected id="gender_val"></option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->
                <!-- </form> -->
              </div>
              <!-- /.card -->
            </div>

            <div class="col-md-6">
              <!-- general form elements -->
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title"><b>WORK INFORMATIONS</b></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <!-- <form role="form"> -->
                <div class="card-body">
                  <div class="form-group">
                    <label for="edit_position" class="col-sm-3 control-label">Position</label>
                    <select class="form-control" name="position" id="edit_position" required>
                      <option selected id="position_val"></option>
                      <?php
                      $sql = "SELECT * FROM position";
                      $query = $conn->query($sql);
                      while ($prow = $query->fetch_assoc()) {
                        echo " <option value='" . $prow['id'] . "'>" . $prow['description'] . "</option> ";
                      } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="edit_schedule" class="col-sm-3 control-label">Schedule</label>
                    <select class="form-control" id="edit_schedule" name="schedule" required>
                      <option selected id="schedule_val"></option>
                      <?php
                      $sql = "SELECT * FROM schedules";
                      $query = $conn->query($sql);
                      while ($srow = $query->fetch_assoc()) {
                        echo " <option value='" . $srow['id'] . "'>" . $srow['time_in'] . ' - ' . $srow['time_out'] . "</option> ";
                      } ?>
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->
                <!-- </form> -->
              </div>
              <!-- /.card -->
              <div class="card card-warning">
                <div class="card-header">
                  <h3 class="card-title"><b>GOVERNMENT INFORMATION</b></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="edit_sss" class="col-sm-3 control-label">SSS</label>
                      <input type="text" class="form-control" placeholder="Enter 10-digits SSS number" id="edit_sss" name="sss" pattern="[0-9]{10}" title="SSS number consists of 10 digits">
                    </div>
                    <div class="form-group">
                      <label for="edit_pagibig" class="col-sm-3 control-label">Pag-ibig</label>
                      <input type="text" class="form-control" placeholder="Enter 12-digits Pag-ibig number" id="edit_pagibig" name="pagibig" pattern="[0-9]{12}" title="Pag-ibig number consists of 12 digits">
                    </div>
                    <div class="form-group">
                      <label for="edit_philhealth" class="col-sm-3 control-label">Philhealth</label>
                      <input type="text" class="form-control" placeholder="Enter 12-digits Philhealth number" id="edit_philhealth" name="philhealth" pattern="[0-9]{12}" title="Philhealth number consists of 12 digits">
                    </div>
                    <div class="form-group">
                      <label for="edit_tin" class="col-sm-3 control-label">Tin</label>
                      <input type="text" class="form-control" placeholder="Enter 9-digits Tin number" id="edit_tin" name="tin" pattern="[0-9]{9}" title="Tin number consists of 9 digits">
                    </div>
                  </div>
                  <!-- /.card-body -->
              </div>
            </div>
          </div>
          <!-- </form> -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
          <button type="submit" class="btn btn-primary btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
        </div>
      </form>
    </div>
  </div>
</div>



<!-- Delete -->
<div class="modal fade" id="delete">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b><span class="employee_id"></span></b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="employee_delete.php">
          <input type="hidden" class="empid" name="id">
          <div class="text-center">
            <p>DELETE EMPLOYEE</p>
            <h2 class="bold del_employee_name"></h2>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Update Photo -->
<div class="modal fade" id="edit_photo">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b><span class="del_employee_name"></span></b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="employee_edit_photo.php" enctype="multipart/form-data">
          <input type="hidden" class="empid" name="id">
          <div class="form-group">
            <label for="photo" class="col-sm-3 control-label">Photo</label>

            <div class="col-sm-9">
              <input type="file" id="photo" name="photo" required>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-success btn-flat" name="upload"><i class="fa fa-check-square-o"></i> Update</button>
        </form>
      </div>
    </div>
  </div>
</div>