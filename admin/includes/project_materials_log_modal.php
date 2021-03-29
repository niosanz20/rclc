<?php  
    $projectname = $_GET['projectname'];
    
?>

<!-- Add Project Materials Log-->
<div class="modal fade" id="addlogmaterials">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Add Project Materials Log of <?php echo $projectname ?></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="project_materials_log_add.php" enctype="multipart/form-data">
          		
          		      <div class="form-group">
                        <label for="date" class="col-sm-3 control-label">Date</label>
                        <div class="col-sm-9"> 
                            <div class="date">
                                <input type="date" class="form-control" id="date" name="date" value="<?php echo date('Y-m-d') ?>" required>
                            </div>
                        </div>
                    </div>   
                    <div class="form-group">
                        <label for="material" class="col-sm-3 control-label">Material</label>

                        <div class="col-sm-9">
                            <!--<input class="form-control" name="material" id="material" required></input>-->
                            <select class="form-control" name="material" id="material" required>
                                <option value="" selected>- Select -</option>
                                    <?php
                                        $sql = "SELECT * FROM materials_list";

                                        $query = $conn->query($sql);
                                        while($prow = $query->fetch_assoc()){
                                        echo "
                                            <option value='".$prow['list_id']."'>".$prow['materials_name']."</option>
                                            ";
                                        }
                                    ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="quantity" class="col-sm-3 control-label">Quantity</label>

                        <div class="col-sm-9">
                            <input type = "number" class="form-control" name="quantity" id="quantity"  required></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="position" class="col-sm-3 control-label">Employee</label>

                        <div class="col-sm-9">
                            <select class="form-control" name="name" id="name" required>
                                <option value="" selected>- Select -</option>
                                    <?php
                                        // $sql = "SELECT * FROM project_employee WHERE projectid = '$project_id'";
                                        
                                        // $sql = "SELECT *, project_materials_log.id, project_employee.id FROM project_materials_log LEFT JOIN project_employee ON project_employee.id=project_materials_log.name LEFT JOIN employees ON employees.employee_id = project_materials_log.name WHERE projectid = '$project_id'";
                                        
                                        $sql = "SELECT *, project_employee.id, employees.employee_id FROM project_employee LEFT JOIN employees ON employees.employee_id=project_employee.name WHERE projectid = '$project_id'";
                                        
                                        $query = $conn->query($sql);
                                        while($prow = $query->fetch_assoc()){
                                        echo "
                                            <option value='".$prow['employee_id']."'>".$prow['firstname']." ".$prow['lastname']."</option>
                                        ";
                                        }
                                        ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="time_borrow" class="col-sm-3 control-label">Time Borrow</label>

                  	    <div class="col-sm-9">
                  		    <div class="bootstrap-timepicker">
                    		    <input type="text" class="form-control timepicker" id="time_borrow" name="time_borrow" readonly>
                    	    </div>
                  	    </div>
                    </div> 
                    <!--<div class="form-group">-->
                    <!--    <label for="status" class="col-sm-3 control-label">Status</label>-->

                    <!--     <div class="col-sm-9"> -->
                    <!--        <select class="form-control" name="status" id="status" required>-->
                    <!--            <option selected id="status"></option>-->
                    <!--            <option value="Borrow">Borrow</option>-->
                    <!--            <option value="Return">Return</option>-->
                    <!--        </select>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <!--<div class="form-group">-->
                    <!--    <label for="status" class="col-sm-3 control-label">Status</label>-->

                    <!--     <div class="col-sm-9"> -->
                    <!--         <input class="form-control" name="status" id="status" value="Borrow" readonly></input>-->
                            <!--<select class="form-control" name="status" id="status" required>-->
                            <!--    <option selected id="status"></option>-->
                            <!--    <option value="Borrow">Borrow</option>-->
                            <!--    <option value="Return">Return</option>-->
                            <!--</select>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <!--<div class="form-group">-->
                    <!--    <label for="time_return" class="col-sm-3 control-label">Time Return</label>-->

                  	 <!--   <div class="col-sm-9">-->
                  		<!--    <div class="bootstrap-timepicker">-->
                    <!--		    <input type="text" class="form-control timepicker" id="time_return" name="time_return" required>-->
                    <!--	    </div>-->
                  	 <!--   </div>-->
                    <!--</div> -->
                    
                    
                    <div class="form-group">
                        <div class="col-sm-9">
                             <input type="hidden" value="<?php echo $project_id ?>"; class="form-control" name="projectid" id="projectid"></input>
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
<div class="modal fade" id="editmaterialslog">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b> Project Materials Log</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="project_materials_log_edit.php" enctype="multipart/form-data">
          		<input type="hidden" id="projmaterlogid" name="id">
          		<input type="hidden" id="edit_quantity1" name="quantity">
          		<input type="hidden" id="edit_mat" name="list_material">
          		<!--<input type="text" id="edit_name" name="name">-->
          		    <!--<div class="form-group">-->
                <!--        <label for="date" class="col-sm-3 control-label">Date</label>-->
                <!--        <div class="col-sm-9"> -->
                <!--            <input type="date" class="form-control" name="date" id="edit_date" required>-->
                <!--        </div>-->
                <!--    </div>   -->
                    <!--<div class="form-group">-->
                    <!--    <label for="name" class="col-sm-3 control-label">Employee</label>-->

                    <!--    <div class="col-sm-9">-->
                    <!--        <select class="form-control" name="name" id="edit_name" required>-->
                    <!--            <option selected id="name_val">- Select -</option>-->
                                    
                    <!--       </select>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="form-group">
                        <label for="material" class="col-sm-3 control-label">Condition</label>

                        <div class="col-sm-9">
                            <!--<input class="form-control" name="material" id="edit_material" required></input>-->
                            <input type="radio" id="edit_material" name="material" value="Returned Good" /> Returned Good<br />
                            <input type="radio" id="edit_material" name="material" value="Returned Bad" /> Returned Bad<br />
                            <input type="radio" id="edit_material" name="material" value="Missing" /> Missing<br />
                        </div>
                    </div>
                    <!--<div class="form-group">-->
                    <!--    <label for="time_borrow" class="col-sm-3 control-label">Time Borrow</label>-->

                  	 <!--   <div class="col-sm-9">-->
                  		<!--    <div class="bootstrap-timepicker">-->
                    <!--		    <input type="text" class="form-control timepicker" name="time_borrow" id="edit_time_borrow" >-->
                    <!--	    </div>-->
                  	 <!--   </div>-->
                    <!--</div> -->
                    <!-- <div class="form-group">-->
                    <!--    <label for="time_borrow" class="col-sm-3 control-label">Time Return</label>-->

                  	 <!--   <div class="col-sm-9">-->
                  		<!--    <div class="bootstrap-timepicker">-->
                    <!--		    <input type="text" class="form-control timepicker" name="time_borrow" id="edit_time_borrow" readonly>-->
                    <!--	    </div>-->
                  	 <!--   </div>-->
                    <!--</div> -->
                    <div class="form-group">
                        <label for="status" class="col-sm-3 control-label">Status</label>

                         <div class="col-sm-9"> 
                            <select class="form-control" name="status" id="edit_status" required>
                                <option selected ></option>
                                <option value="Settled">Settled</option>
                                <option value="Unsettled">Unsettled</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="time_return" class="col-sm-3 control-label">Time Return</label>

                  	    <div class="col-sm-9">
                  		    <div class="bootstrap-timepicker">
                    		    <input type="text" class="form-control timepicker" name="time_return" readonly value= "<?php (new \DateTime())->format('H:i:s'); ?>" >
                    	    </div>
                  	    </div>
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-sm-3 control-label">Price</label>
                        <div class="col-sm-9"> 
                            <input type="text" class="form-control" name="price" id="edit_price" required>
                        </div>
                    </div>   
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-primary btn-flat" name="edit"><i class="fa fa-save"></i>Save</button>
            	</form>
          	</div>
        </div>
    </div>
</div>



<!-- Delete -->
<div class="modal fade" id="deleteprojectmaterlog">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Remove Project Material Log</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="project_materials_log_delete.php" enctype="multipart/form-data">
            		<input type="hidden" id="delprojmaterlogid" name="id">
            		<input type="hidden" id="delmaterial" name="quantity">
            		<input type="hidden" id="del_materlog" name="mat_list">
            		<div class="text-center">
	                	<!--<h2 id="del_materlog" class="bold"></h2>-->
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