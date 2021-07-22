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
            <form class="form-horizontal" method="POST" action="project_materials_add.php"
                    enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label material">Description</label>
                        <div class="col-sm-9">
                            <select class="form-control description" name="material_id" id="description" required>
                                <option value="" selected>- Select -</option>
                                <?php
                                $sql = "SELECT * FROM materials";
                                $query = $conn->query($sql);
                                while ($prow = $query->fetch_assoc()) {
                                    $name = $prow['name'];
                                    $value = $prow['materials_id'] . "-" . $prow['price'] . "-" . $prow['unit'];
                                    echo "
                                        <option value='$value'>" . $prow['name'] . ' | ' . $prow['description'] . "</option>
                                    ";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="quantity" class="col-sm-3 control-label">Quantity</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="number" id="quantity" min="1" name="quantity" pattern="[0-9]+" value="1" onchange="CalculateAmountCost(this.value)" required
                                ></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="unit" class="col-sm-3 control-label">Unit</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="unit" name="unit" required disabled></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="unit_cost" class="col-sm-3 control-label">Unit Cost</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="unit_cost" name="unit_cost" pattern="[0-9.]+"
                                required disabled></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="amnt_cost" class="col-sm-3 control-label">Amount Cost</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="total_amount" name="amnt_cost" pattern="[0-9.]+"
                                required disabled></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9">
                            <input type="hidden" value="<?php echo $project_id ?>" ; class="form-control"
                                name="projectid" id="projectid"></input>
                            <input type="hidden" value="" name="totalAmount" id="totalAmount">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                            class="fa fa-close"></i> Close</button>
                    <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i>
                        Save</button>
                </div>
            </form>
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
                <form class="form-horizontal" method="POST" action="project_material_edit.php"
                    enctype="multipart/form-data">
                    <input type="hidden" id="edit_projmaterid" name="id">
                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label material">Description</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="edit_description" name="description" disabled></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="quantity" class="col-sm-3 control-label">Quantity</label>
                        <div class="col-sm-9">
                        <input class="form-control" type="number" id="edit_quantity" min="1" name="quantity" pattern="[0-9]+" value="1" onchange="Edit_CalculateAmountCost(this.value)" required
                                ></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="unit" class="col-sm-3 control-label">Unit</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="edit_unit" name="unit" disabled></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="unit_cost" class="col-sm-3 control-label">Unit Cost</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="edit_unit_cost" name="unit_cost" pattern="[0-9.]+"
                            disabled></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="amnt_cost" class="col-sm-3 control-label">Amount Cost</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="edit_total_amount" name="amnt_cost" pattern="[0-9.]+"
                            disabled></input>
                        </div>
                    </div>
                     <div class="form-group">
                        <div class="col-sm-9">
                            <input type="hidden" value="<?php echo $project_id ?>" ; class="form-control"
                                name="projectid" id="projectid"></input>
                            <input type="hidden" value="" name="totalAmount" id="edit_totalAmount">
                            <input type="hidden" value="" name="materialId" id="edit_materialId">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-primary btn-flat" name="edit"><i class="fa fa-save"></i>
                    Update</button>
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
                <form class="form-horizontal" method="POST" action="project_material_delete.php"
                    enctype="multipart/form-data">
                    <input type="hidden" id="delprojmaterid" name="id">
                    <div class="text-center">
                        <h2 id="del_description" class="bold"></h2>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i>
                    Remove</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script>
    function GetMaterialPrice(){
        const element = document.getElementById('description');
        const options = element.options[element.selectedIndex].value;
        
        let materialId = options.split('-')[0];
        let price = options.split('-')[1];
        let unit = options.split('-')[2];
       
        if(options != "")
        {
            document.getElementById('unit_cost').value = price;
            document.getElementById('unit').value = unit;
        }
        else
        {
            document.getElementById('unit_cost').value = "Material Item is required!";
            document.getElementById('unit').value = "Material Item is required!";
            price = 0;
        }

        return price;
    }

    function CalculateAmountCost(quantity){
        let price = GetMaterialPrice();
        let value = price !== 0 ? quantity * price : "Material Item is required!";
        document.getElementById('total_amount').value = value;
        document.getElementById('totalAmount').value = value;
    }

    /*--
    Auto-calculation for adding new materials on project
    -----------------------------------*/
    $(document).on('change', '.description', function() {
        let quantity = $('#quantity').val();
        CalculateAmountCost(quantity);
    });

    function Edit_CalculateAmountCost(quantity){
        let price = $('#edit_unit_cost').val();
        let value = price !== 0 ? quantity * price : "Material Item is required!";
        document.getElementById('edit_total_amount').value = value;
        document.getElementById('edit_totalAmount').value = value;
    }

    /*--
    Auto-calculation for adding new materials on project
    -----------------------------------*/
    $(document).on('change', '.description', function() {
        let quantity = $('#edit_quantity').val();
        Edit_CalculateAmountCost(quantity);
    });
</script>