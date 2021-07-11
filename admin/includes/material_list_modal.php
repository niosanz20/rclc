<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Add New Materials</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="materials_list_add.php"
                    enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="materials_name" class="col-sm-3 control-label">* Material Name</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="materials_name" name="materials_name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="quantity" class="col-sm-3 control-label">* Quantity</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="quantity" id="quantity" pattern="[0-9]+"
                                required></textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i>
                    Add</button>
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
                <h4 class="modal-title"><b>Update Material Name</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="list_materials_edit.php">
                    <input type="hidden" id="list_id" name="id">
                    <div class="form-group">
                        <label for="edit_material_name" class="col-sm-3 control-label">* Material Name</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_material_name" name="name" required>
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
                <h4 class="modal-title"><b><span class="list_id"></span></b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="list_materials_delete.php">
                    <input type="hidden" class="list_id" name="id">
                    <div class="text-center">
                        <p>DELETE MATERIALS</p>
                        <h2 class="bold del_materials_name"></h2>
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

<!-- Equipment Log -->
<div class="modal fade" id="equipmentLog-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><strong>Equipment's borrowers</strong></h4>
            </div>
            <div class="modal-body">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h1 class="box-title">Project Equipments Logs</h1>
                    </div>
                    <div class="box-body">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box" id="equipmentLog-details">
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>