<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">EDIT: PRODUCT DESCRIPTION/ PROBLEM DETAILS</h4>
            </div>
            <form
                action = "/"
                method = "POST"
                role   = "form"
                id     = "qdn-form"
                novalidate
                >
                @include('report.partials.sectionOne',['hidden'=>''])
                <div class="modal-footer">
                    <div class="btn-group">
                        <button
                        type  = "submit"
                        name  = "submit"
                        id    = "submit"
                        class = "btn btn-lg btn-default"
                        >
                        Save as Draft <i class="fa fa-save"></i><br>
                        <small>and come back soon</small>
                        </button>
                        <button
                        type  = "submit"
                        name  = "submit"
                        id    = "submit"
                        class = "btn btn-lg btn-success text-center"
                        >
                        Send Confirmation <i class="fa fa-paper-plane"></i><br>
                        <small>and proceed for completion</small>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>