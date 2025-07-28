<!--Add Data-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeaderTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="visa_countries_from" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="visa_countries_id" id="visa_countries_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group form-error">
                                <label>Name</label>
                                <input type="text" name="name" id="name"
                                       class="form-control form-control-lg form-control-admin" placeholder="Enter name">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-error">
                                <label>Flag</label>
                                <input type="file" name="flag_image" id="flag_image"
                                       class="form-control form-control-lg form-control-admin">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-error">
                                <label for="description">Documents Required</label>
                                <textarea name="documents_required" id="documents_required" class="form-control summernote required" placeholder="Type here...">                            
                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mw-100" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary mw-100" id="saveBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
