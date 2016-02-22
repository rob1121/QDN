<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">EDIT: PRODUCT DESCRIPTION/ PROBLEM DETAILS</h4>
            </div>
            <form
                action = "{{ route('sectionOneSaveAsDraft',['slug' => $qdn->slug]) }}"
                method = "get"
                role   = "form"
                id     = "qdn-form"
                novalidate
                >
                @include('report.partials.sectionOne',['hidden'=>''])
                <div class="col-sm-12">
                    <div class="col-sm-12">
                    <label>QDN Validity</label>
                    <br>
                        <div class="btn-group" data-toggle="buttons" id="validate">
                            <label class="btn btn-default valid active">
                                <input type="radio" name="status" id="status" value="incomplete fill-up" checked> Valid
                            </label>
                            <label class="btn btn-default invalid">
                                <input type="radio" name="status" id="status" value="cancelled"> Invalid
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12">
                        <div class="btn-group">
                            <button
                            type  = "submit"
                            name  = "submit"
                            id    = "draft-button"
                            class = "btn btn-lg btn-default"
                            style = "margin:5px"
                            >
                            Save as Draft <i class="fa fa-save"></i><br>
                            <small>and come back soon</small>
                            </button>
                            <button
                            type  = "submit"
                            name  = "submit"
                            id    = "verification-btn"
                            class = "btn btn-lg btn-primary text-center"
                            style = "margin:5px"
                            >
                            Confirm Changes <i class="fa fa-paper-plane"></i><br>
                            <small>and send notification</small>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>