<div class="modal fade logoutModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered logout-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h2 class="h1 text-primary"><i class="fas fa-sign-out-alt"></i></h2>
                <h4>Logout</h4>
                <p>Are you sure you want to logout?</p>
                <div class="text-center">
                    <a href="javascript:;" class="btn btn-dark mw-100 mr-1" data-dismiss="modal">Cancel</a>
                    <a href="{{ route('admin.logout') }}" class="btn btn-primary mw-100 ml-1 btn-loader"
                       data-dismiss="modal">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>


<!--Block/UnBlock Users-->
<div class="modal fade" id="activeModal" tabindex="-1" role="dialog" aria-labelledby="activeModalTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title" id="activeModalHeading"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center" id="activeContent">
            </div>
            <input type="hidden" id="activeRowId">
            <input type="hidden" id="activeRowStatus">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mw-100" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary mw-100" id="activeBtn"></button>
            </div>
        </div>
    </div>
</div>

<!--Delete Users-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalHeading"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center" id="deleteContent">
            </div>
            <input type="hidden" id="deleteRowId">
            <input type="hidden" id="deleteUrl">
            <input type="hidden" id="deleteType">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mw-100" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary mw-100" id="deleteBtn"></button>
            </div>
        </div>
    </div>
</div>



<!--add tax -->
<div class="modal fade" id="addTaxModal" tabindex="-1" role="dialog" aria-labelledby="addTaxModalTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaxModalHeading"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="post" id="addTaxForm">
                    @csrf
            <div class="modal-body " id="addTaxContent">

                 <label class="text-dark">Title</label>
                 
                <input type="text" class="form-control" id="tax_title" name="tax_title" placeholder="Please enter title"/>
                <br>
                <label>Value</label>
             

                <input type="text" class="form-control" id="value" name="value" placeholder="Please enter value..."/>

            </div>

          
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mw-100" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary mw-100" id="addTaxBtn"></button>
            </div>
</form>
        </div>
    </div>
</div>
