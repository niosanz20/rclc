<?php
$end_date = $_GET['end_date'];
$start_date = $_GET['start_date'];
$projectname = $_GET['projectname'];

?>

<!-- Add Project Worker-->
<div class="modal fade" id="addnewworker">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Assign Project Worker of <?php echo $projectname ?></b></h4>

            </div>
            <form class="form-horizontal" method="POST" action="project_worker_add.php" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="worker" class="col-sm-3 control-label">Project Worker</label>

                        <div class="col-sm-9">
                            <select class="form-control" name="worker" id="worker" required>
                                <option value="" selected>- Select -</option>
                                <?php
                                $sql = "SELECT * FROM employees LEFT JOIN project_employee ON employees.employee_id=project_employee.name WHERE project_employee.status = 'Vacant'";
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
                        <label for="worker" class="col-sm-3 control-label">Position</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="position" id="position" required>
                                <option value="" selected>- Select -</option>
                                <?php
                                $sql = "SELECT * FROM position";
                                $query = $conn->query($sql);
                                while ($prow = $query->fetch_assoc()) {
                                    echo "
                                  <option value='" . $prow['description'] . "'>" . $prow['description'] . " </option>
                                ";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="datepicker_edit" class="col-sm-3 control-label">Project Worker Start</label>

                        <div class="col-sm-9">
                            <div>
                                <input type="date" class="form-control" id="project_date" name="project_date" min="<?php echo $start_date ?>" max="<?php echo $end_date ?>">
                            </div>
                        </div>
                    </div>



                    <!--<div class="form-group">-->
                    <!--    <label for="datepicker_add" class="col-sm-3 control-label">* Date Started</label>-->

                    <!--    <div class="col-sm-9">-->
                    <!--        <div class="date">-->
                    <!--            <input type="text" class="form-control" id="datepicker_add" name="project_startdate" required>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->


                    <div class="form-group">
                        <label for="datepicker_edit" class="col-sm-3 control-label">Project Worker End</label>

                        <div class="col-sm-9">
                            <div class="">
                                <input type="date" class="form-control" id="project_date_end" name="project_date_end" min="<?php echo $start_date ?>" max="<?php echo $end_date ?>">

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-9">
                            <input type="hidden" value="<?php echo $project_id ?>" ; class="form-control" name="projectid" id="projectid"></input>
                            <!--<input type="text" value="<?php echo $project_address ?>"; class="form-control" name="project_address" id="project_address"></input>-->
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                    <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Save</button>

                </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit Project Worker -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Edit Project Worker</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="project_worker_edit.php" enctype="multipart/form-data">
                    <input type="hidden" id="projworkerid" name="id">
                    <!--<div class="form-group">-->
                    <!--  <label for="position_leader" class="col-sm-3 control-label">Project Worker</label>-->

                    <!--    	 <div class="col-sm-9" >-->
                    <!--        <select class="form-control" name="name" id="edit_project_worker" required>-->
                    <!--          <option value="" selected>- Select -</option>-->
                    <?php
                    //   $sql = "SELECT * FROM employees";
                    //   $query = $conn->query($sql);
                    //   while($prow = $query->fetch_assoc()){
                    //     echo "
                    //       <option value='".$prow['firstname'].' '.$prow['lastname']."'>".$prow['firstname']." ".$prow['lastname']."</option>
                    //     ";
                    //   }
                    ?>
                    <!--      </select>-->
                    <!--    </div>-->
                    <!--</div>-->

                    <div class="form-group">
                        <label for="edit_position" class="col-sm-3 control-label">Position</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="position" id="edit_position" required>
                                <option value="" selected>- Select -</option>
                                <?php
                                $sql = "SELECT * FROM position";
                                $query = $conn->query($sql);
                                while ($prow = $query->fetch_assoc()) {
                                    echo "
                                  <option value='" . $prow['description'] . "'>" . $prow['description'] . " </option>
                                ";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="datepicker_edit" class="col-sm-3 control-label">Project Worker Start</label>

                        <div class="col-sm-9">
                            <div>
                                <input type="date" class="form-control" id="edit_project_date" name="project_date" min="<?php echo $start_date ?>" max="<?php echo $end_date ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="datepicker_edit" class="col-sm-3 control-label">Project Worker End</label>

                        <div class="col-sm-9">
                            <div class="">
                                <input type="date" class="form-control" id="edit_project_date_end" name="project_date_end" min="<?php echo $start_date ?>" max="<?php echo $end_date ?>">

                            </div>
                        </div>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-primary btn-flat" name="edit"><i class="fa fa-save"></i> Update</button>
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
                <h4 class="modal-title"><b>Remove Project Worker</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="project_worker_delete.php" enctype="multipart/form-data">
                    <input type="hidden" id="delprojworkerid" name="id">
                    <div class="text-center">
                        <h2 id="del_name" class="bold"></h2>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Remove</button>
                </form>
            </div>
        </div>
    </div>
</div>


























<!-- Edit Materials 
<div class="modal fade" id="editmaterials">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Edit Project Material</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="project_material_edit.php" enctype="multipart/form-data">
            	 <input type="hidden" id="projmaterid" name="id">
          		   <div class="form-group">
                        <label for="description" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-9" >
                            <input class="form-control" id="edit_description" name="description"></input>
                        </div>
                    </div>   
                    <div class="form-group">
                        <label for="quantity" class="col-sm-3 control-label">Quantity</label>
                        <div class="col-sm-9" >
                            <input class="form-control" id="edit_quantity" name="quantity"></input>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="unit" class="col-sm-3 control-label">Unit</label>
                        <div class="col-sm-9" >
                            <input class="form-control" id="edit_unit" name="unit"></input>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="unit_cost" class="col-sm-3 control-label">Unit Cost</label>
                        <div class="col-sm-9" >
                            <input class="form-control" id="edit_unit_cost" name="unit_cost"></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="amnt_cost" class="col-sm-3 control-label">Amount Cost</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="edit_amnt_cost" name="amnt_cost"></input>
                        </div>
                    </div>    
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-primary btn-flat" name="edit"><i class="fa fa-save"></i> Update</button>
            	</form>
          	</div>
        </div>
    </div>
</div>  -->



<!-- Delete Materials 
<div class="modal fade" id="deleteprojectmater">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Remove Project Material</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="project_material_delete.php" enctype="multipart/form-data">
            		<input type="hidden" id="delprojmaterid" name="id">
            		<div class="text-center">
	                	<h2 id="del_description" class="bold"></h2>
	            	</div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Remove</button>
            	</form>
          	</div>
        </div>
    </div>
</div> -->