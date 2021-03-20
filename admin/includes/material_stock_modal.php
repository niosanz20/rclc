<!-- Add -->
<div class="modal fade" id="addstock">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Add Stock</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="material_stock_add.php" enctype="multipart/form-data">
                      <input type="hidden" id="materialsid" name="id">
                    <div class="form-group">
                        <label for="project_stock" class="col-sm-3 control-label">*Current Stock</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="stock" id="edit_stock" readonly></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="project_stock_add" class="col-sm-3 control-label">Stock</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="stock_add" id="stock_add" required pattern="[0-9]+"></textarea>
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


