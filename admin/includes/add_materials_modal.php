<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Add Materials</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="materials_name" class="col-sm-3 control-label">* Material Name</label>

                        <div class="col-sm-9">
                            <select class="form-control" id="materials_name" name="materials_name" required>
                                <option value="" selected>- Select -</option>
                                    <?php
                                        $sql = "SELECT * FROM materials";
                                        $query = $conn->query($sql);
                                        while($prow = $query->fetch_assoc()){
                                        echo "
                                            <option value='".$prow['materials_id']."'>".$prow['name']."</option>
                                         ";
                                        }
                                        ?>
                            </select>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="materials_description" class="col-sm-3 control-label">Description</label>

                        <div class="col-sm-9" id="materials_description" name="materials_description">
                            <textarea class="form-control" readonly="readonly"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="project_budget" class="col-sm-3 control-label">Stock</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="project_budget" id="project_budget"></textarea>
                        </div>
                    </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Add</button>
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
                <h4 class="modal-title"><b>Update Materials</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="materials_list_edit.php">
                    <input type="hidden" id="materials_id" name="id">
                    <div class="form-group">
                        <label for="edit_material_name" class="col-sm-3 control-label">* Material Name</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_material_name" name="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_material_description" class="col-sm-3 control-label">Description</label>

                        <div class="col-sm-9">
                            <textarea class="form-control" name="description" id="edit_material_description"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_material_unit" class="col-sm-3 control-label">Unit</label>

                        <div class="col-sm-9">
                            <textarea class="form-control" name="unit" id="edit_material_unit"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_material_price" class="col-sm-3 control-label">Price</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="price" id="edit_material_price"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_material_pieces" class="col-sm-3 control-label">Stock</label>

                        <div class="col-sm-9">
                            <input type="text" readonly="readonly" class="form-control" name="stock" id="edit_material_pieces"></textarea>
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

<script text="type/javascript">
    $(document).ready(function(){
        $("#materials_name").change(function(){
            var aid = $("#materials_name").val();
            $.ajax({
                url: 'materials_details.php',
                method: 'POST',
                data: 'aid=' +aid
            }).done(function(materials_description){
                console.log(materials_description);
                materials_description = JSON.parse(materials_description);
                materials_description.forEach(function(material){
                    $('#materials_description').append('<textarea>' + material.description + '</textarea>')
                })
            })
        })
    })
  
    
</script>