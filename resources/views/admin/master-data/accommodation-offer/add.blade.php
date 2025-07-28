<!--Add Data-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeaderTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="accommodation_offer_from">
                @csrf
                <input type="hidden" name="accommodation_offer_id" id="accommodation_offer_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group form-error">
                                <label>Name</label>
                                <input type="text" name="name" id="name"
                                       class="form-control form-control-lg form-control-admin" placeholder="Enter name">
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
