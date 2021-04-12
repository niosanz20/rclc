<!-- Add -->
<div class="modal fade" id="addnew">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b>Add Overtime</b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="overtime_add.php">
          <div class="form-group">
            <label for="employee" class="col-sm-3 control-label">Employee</label>

            <!--<div class="col-sm-9">-->
            <!-- 	<input type="text" class="form-control" id="employee" name="employee" required>-->
            <!--</div>-->
            <div class="col-sm-9">
              <select class="form-control" name="employee" id="employee" required>
                <option value="" selected>- Select -</option>
                <?php
                $sql = "SELECT * FROM employees";
                $query = $conn->query($sql);
                while ($prow = $query->fetch_assoc()) {
                  echo "
                                      <option value='" . $prow['employee_id'] . "'>" . $prow['firstname'] . " " . $prow['lastname'] . "</option>
                                    ";
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="datepicker_add" class="col-sm-3 control-label">Date</label>

            <div class="col-sm-9">
              <div class="date">
                <input type="text" class="form-control" id="datepicker_add" name="date" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="hours" class="col-sm-3 control-label">No. of Hours</label>

            <div class="col-sm-9">
              <input type="text" class="form-control" id="hours" name="hours">
            </div>
          </div>
          <div class="form-group">
            <label for="mins" class="col-sm-3 control-label">No. of Mins</label>

            <div class="col-sm-9">
              <input type="text" class="form-control" id="mins" name="mins">
            </div>
          </div>
          <div class="form-group">
            <label for="rate" class="col-sm-3 control-label">Rate</label>

            <div class="col-sm-9">
              <input type="text" class="form-control" id="rate" name="rate" required>
            </div>
          </div>
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
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b><span id="overtime_date"></span></b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="overtime_edit.php">
          <input type="hidden" class="otid" name="id">
          <div class="text-center">
            <p>Are you sure you want to approve this overtime?</p>
            <h2 class="employee_name bold"></h2>
            <h4 class="othour"></h4>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="glyphicon glyphicon-ok-circle"></i> Yes</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- <div class="modal fade" id="edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b><span class="employee_name"></span></b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="overtime_edit.php">
          <input type="hidden" class="otid" name="id">
          <div class="form-group">
            <label for="datepicker_edit" class="col-sm-3 control-label">Date</label>

            <div class="col-sm-9">
              <div class="date">
                <input type="text" class="form-control" id="datepicker_edit" name="date" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="hours_edit" class="col-sm-3 control-label">No. of Hours</label>

            <div class="col-sm-9">
              <input type="text" class="form-control" id="hours_edit" name="hours">
            </div>
          </div>
          <div class="form-group">
            <label for="mins_edit" class="col-sm-3 control-label">No. of Mins</label>

            <div class="col-sm-9">
              <input type="text" class="form-control" id="mins_edit" name="mins">
            </div>
          </div>
          <div class="form-group">
            <label for="rate_edit" class="col-sm-3 control-label">Rate</label>

            <div class="col-sm-9">
              <input type="text" class="form-control" id="rate_edit" name="rate" required>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
        </form>
      </div>
    </div>
  </div>
</div> -->

<!-- Delete -->
<div class="modal fade" id="delete">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b><span id="overtime_dated"></span></b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="overtime_delete.php">
          <input type="hidden" class="otid" name="id">
          <div class="text-center">
            <p>Are you sure you want to decline this overtime?</p>
            <h2 class="employee_name bold"></h2>
            <h4 class="othour"></h4>
            <div class="form-group">
                <input type="radio" name="Late OT" value="">Reason 1
                <input type="radio" name="Late OT" value="">Reason 2
            </div>
            <div class="form-group">
              <label for="others">Others: </label>
              <input type="text" name="others">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="glyphicon glyphicon-ban-circle"></i> Yes</button>
        </form>
      </div>
    </div>
  </div>
</div>