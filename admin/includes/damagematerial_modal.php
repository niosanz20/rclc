<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Add Damage Materials</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="damagematerial_add.php">
            	<div class="form-group">
                    <label for="date" class="col-sm-3 control-label">Date</label>

                    <div class="col-sm-9">
                      <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                </div>
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
                                  while($prow = $query->fetch_assoc()){
                                    echo "
                                      <option value='".$prow['firstname'].' '.$prow['lastname']."'>".$prow['firstname']." ".$prow['lastname']."</option>
                                    ";
                                  }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label">Description</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="description" name="description" >
                        </div>
                    </div>
                  	<div class="form-group">
                        <label for="price" class="col-sm-3 control-label">Price</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="price" name="price" >
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
            	<h4 class="modal-title"><b><span class="date"></span> - <span class="employee_name"></span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="damagematerial_edit.php">
            		<input type="hidden" id="ca_id" name="id">
                <div class="form-group">
                    <label for="edit_date" class="col-sm-3 control-label">Date</label>

                    <div class="col-sm-9">
                      <input type="date" class="form-control" id="edit_date" name="date" required>
                    </div>
                </div>
                <div class="form-group">
                  	<label for="edit_employee" class="col-sm-3 control-label">Employee</label>
                  	    <div class="col-sm-9">
                            <select class="form-control" name="employee" id="edit_employee" required>
                                <option value="" selected>- Select -</option>
                                <?php
                                  $sql = "SELECT * FROM employees";
                                  $query = $conn->query($sql);
                                  while($prow = $query->fetch_assoc()){
                                    echo "
                                      <option value='".$prow['firstname'].' '.$prow['lastname']."'>".$prow['firstname']." ".$prow['lastname']."</option>
                                    ";
                                  }
                                ?>
                            </select>
                        </div>
                </div>
                <div class="form-group">
                        <label for="edit_description" class="col-sm-3 control-label">Description</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_description" name="description" >
                        </div>
                </div>
                <div class="form-group">
                    <label for="edit_price" class="col-sm-3 control-label">Price</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="edit_price" name="price" >
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
            	<form class="form-horizontal" method="POST" action="damagematerial_delete.php">
            		<input type="hidden" id="ca_id" name="id">
            		<div class="text-center">
	                	<p>DELETE DAMAGE MATERIAL</p>
	                	<!--<h2 class="employee_name bold"></h2>-->
	                	<h4 class="modal-title"><b><span class="dm_description"></span> </b></h4>
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


     