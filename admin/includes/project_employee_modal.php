
<!-- Add Project Leader-->
<div class="modal fade" id="addnewleader">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Assign Project Leader</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="project_worker_add.php" enctype="multipart/form-data">
          		  <div class="form-group">
                  	<label for="position_leader" class="col-sm-3 control-label">Project Leader</label>

                  	 <div class="col-sm-9" >
                      <select class="form-control" name="worker" id="worker" required>
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
                     <div class="form-group">
                        <div class="col-sm-9">
                            <input type="hidden" value="<?php echo $project_id ?>"; class="form-control" name="projectid" id="projectid"></input>
                        
                        </div>
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


