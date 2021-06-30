<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Add Project</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="project_add.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="project_name" class="col-sm-3 control-label">* Project Name</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="project_name" name="project_name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="datepicker_add" class="col-sm-3 control-label">* Date Started</label>

                        <div class="col-sm-9">
                            <div class="date">
                                <input type="text" class="form-control" id="datepicker_add" name="project_startdate"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="datepicker_add" class="col-sm-3 control-label">*Expected Date Finish</label>

                        <div class="col-sm-9">
                            <div class="date">
                                <input type="text" class="form-control" id="datepicker_add" name="project_enddate"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="project_description" class="col-sm-3 control-label">Description</label>

                        <div class="col-sm-9">
                            <textarea class="form-control" name="project_description"
                                id="project_description"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="project_Owner" class="col-sm-3 control-label">*Owner</label>

                        <div class="col-sm-9">
                            <input class="form-control" name="project_owner" id="project_owner" required></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="project_address" class="col-sm-3 control-label">Address</label>

                        <div class="col-sm-9">
                            <textarea class="form-control" name="project_address" id="project_address"
                                required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="project_budget" class="col-sm-3 control-label">Estimated Budget</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="project_budget" id="project_budget"
                                pattern="[0-9]+"></textarea>
                        </div>
                    </div>
                    <!--<div class="form-group">-->
                    <!--    <label for="project_status" class="col-sm-3 control-label">Status</label>-->

                    <!--    <div class="col-sm-9">-->
                    <!--        <select class="form-control" name="project_status" id="project_status" required>-->
                    <!--            <option value="" selected>- Select -</option>-->
                    <!--            <option value="Active">Active</option>-->
                    <!--            <option value="Pending">Pending</option>-->
                    <!--<option value="Finish">Finish</option>-->
                    <!--        </select>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="form-group">
                        <label for="photo" class="col-sm-3 control-label">Photo</label>

                        <div class="col-sm-9">
                            <input type="file" name="photo" id="photo">
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
                <h4 class="modal-title"><b>Update Project Details</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="project_edit.php">
                    <input type="hidden" id="project_id" name="id">
                    <div class="form-group">
                        <label for="edit_project_name" class="col-sm-3 control-label">* Project Name</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_project_name" name="project_name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="datepicker_edit" class="col-sm-3 control-label">* Date Started</label>

                        <div class="col-sm-9">
                            <div class="date">
                                <input type="text" class="form-control" id="datepicker_edit" name="project_startdate"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="datepicker_edit2" class="col-sm-3 control-label">*Expected Date Finish</label>

                        <div class="col-sm-9">
                            <div class="date">
                                <input type="text" class="form-control" id="datepicker_edit2" name="project_enddate"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_project_description" class="col-sm-3 control-label">Description</label>

                        <div class="col-sm-9">
                            <textarea class="form-control" name="project_description"
                                id="edit_project_description"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="project_Owner" class="col-sm-3 control-label">*Owner</label>

                        <div class="col-sm-9">
                            <input class="form-control" name="project_owner" id="edit_project_owner" required></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_project_address" class="col-sm-3 control-label">Address</label>

                        <div class="col-sm-9">
                            <textarea class="form-control" name="project_address" id="edit_project_address"
                                required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_project_budget" class="col-sm-3 control-label">Estimated Budget</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="project_budget" id="edit_project_budget"
                                pattern="[0-9]+"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_project_status" class="col-sm-3 control-label">Status</label>

                        <div class="col-sm-9">
                            <select class="form-control" name="project_status" id="edit_project_status" required>
                                <option selected id="status_val"></option>
                                <option value="Active">Active</option>
                                <option value="Pending">Pending</option>
                                <option value="Finished">Finished</option>
                            </select>
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
                <h4 class="modal-title"><b><span class="employee_id"></span></b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="project_delete.php">
                    <input type="hidden" id="project_id" name="id">
                    <div class="text-center">
                        <p>DELETE PROJECT</p>
                        <h2 class="bold del_project_name"></h2>
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

<!-- Update Photo -->
<div class="modal fade" id="edit_photo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b><span class="del_project_name"></span></b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="project_edit_photo.php"
                    enctype="multipart/form-data">
                    <input type="hidden" class="project_id" name="id">
                    <div class="form-group">
                        <label for="photo" class="col-sm-3 control-label">Photo</label>

                        <div class="col-sm-9">
                            <input type="file" id="photo" name="photo" required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-success btn-flat" name="upload"><i
                        class="fa fa-check-square-o"></i> Update</button>
                </form>
            </div>
        </div>
    </div>
</div>