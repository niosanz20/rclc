<?php  
    $projectname = $_GET['projectname'];
    
?>

<!-- Add Project Materials-->
<div class="modal fade" id="addnewmaterials">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Add Project Materials of <?php echo $projectname ?></b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="project_materials_add.php" enctype="multipart/form-data">
                    <div class="form-group"> 
                        <label for="description" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-9">
                            <!--<input class="form-control" id="description" name="description"></input> -->
                            <select class="form-control" name="description" id="description" required>
                                <option value="" selected>- Select -</option>
                                <?php
                                    $sql = "SELECT * FROM materials";
                                    $query = $conn->query($sql);
                                    while ($prow = $query->fetch_assoc()) {
                                    echo "
                                        <option value='" . $prow['description'] . "'>" . $prow['description'] . "</option>
                                     ";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="quantity" class="col-sm-3 control-label">Quantity</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="quantity" name="quantity" pattern="[0-9]+" required></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="unit" class="col-sm-3 control-label">Unit</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="unit" name="unit" required></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="unit_cost" class="col-sm-3 control-label">Unit Cost</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="unit_cost" name="unit_cost" pattern="[0-9.]+" required></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="amnt_cost" class="col-sm-3 control-label">Amount Cost</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="amnt_cost" name="amnt_cost" pattern="[0-9.]+" required></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9">
                            <input type="hidden" value="<?php echo $project_id ?>" ; class="form-control" name="projectid" id="projectid"></input>
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
                        <div class="col-sm-9">
                            <input class="form-control" id="edit_description" name="description" required></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="quantity" class="col-sm-3 control-label">Quantity</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="edit_quantity" name="quantity" pattern="[0-9]+" required></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="unit" class="col-sm-3 control-label">Unit</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="edit_unit" name="unit" required></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="unit_cost" class="col-sm-3 control-label">Unit Cost</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="edit_unit_cost" name="unit_cost" pattern="[0-9.]+" required></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="amnt_cost" class="col-sm-3 control-label">Amount Cost</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="edit_amnt_cost" name="amnt_cost" pattern="[0-9.]+" required></input>
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
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="script/getData.js"></script>
<script src=".../js/jquery-3.2.1.min.js"></script>
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>-->
<script>
   
   
//     $('#description').change(function(){
//     // var value = $(this).val();
//     var value = $(this).data();
//     $.ajax({
//       type:'POST',
//       data:{value:value},
//       url:'response.php',
//       dataType: 'json',
//       success:function(response){
//           $('#unit').val(response.unit);
//       } 
    
//     });
// });    



// $(document).ready(function(){
//   $('#description').change(function(){
//       var value = $(this).val();
//       alert(value);
//       var data_string = 'value =' + value;
//       $.get('response.php',data_string, function(result){
          
//           $.each(result, function(){
//               $('#unit').val(this.unit);
//           })
//       })
//   }) 
// }) 
    

$(document).ready(function(){
  $("#description").change(function(){
      var value = $(this).find(":selected").val();
      var data_string = 'unit =' + value;
       $.ajax({
          url:'response.php',
          dataType: "json",
          cache: false,
          data: data_string,
          success: function(materialsData){
              if(materialsData){
                  $("#unit").text(materialsData.unit);
              }
              
          }
        })
  }) 
}) 
        
        
</script>