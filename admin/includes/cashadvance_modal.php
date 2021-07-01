<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Add Cash Advance</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="cashadvance_add.php">
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
                        <label for="amount" class="col-sm-3 control-label">Amount</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="amount" name="amount" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="notes" class="col-sm-3 control-label">Notes</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="notes" name="notes" required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i>
                    Save</button>
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
                <h4 class="modal-title"><b><span class="date"></span> - <span class="employee_name"></span></b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="cashadvance_edit.php">
                    <input type="hidden" class="caid" name="id">
                    <div class="form-group">
                        <label for="edit_amount" class="col-sm-3 control-label">Amount</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_amount" name="amount" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_notes" class="col-sm-3 control-label">Notes</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_notes" name="notes" required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i>
                    Update</button>
                </form>
            </div>
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
                <h4 class="modal-title"><b><span class="date"></span></b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="cashadvance_delete.php">
                    <input type="hidden" class="caid" name="id">
                    <div class="text-center">
                        <p>DELETE CASH ADVANCE</p>
                        <h2 class="employee_name bold"></h2>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i>
                    Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>