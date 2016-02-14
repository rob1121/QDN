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
                    <button
                    type  = "submit"
                    name  = "submit"
                    id    = "submit"
                    class = "btn btn-lg btn-primary"
                    style = "margin-left:32px"
                    >
                    <i class="fa fa-save"></i> Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>