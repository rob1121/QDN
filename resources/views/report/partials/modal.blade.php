<?php
function dispositionCondition($qdn, $disposition) {
	if ('' == $qdn) {
		return 'use as is' == $disposition;
	}
	return $qdn == $disposition;
}
?>
<form
    action = "{{ route('SectionOneSaveAndProceed',['slug' => $qdn->slug]) }}"
    method = "get"
    role   = "form"
    id     = "qdn-form"
    novalidate
    >
    <div class="modal" id="edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">EDIT: PRODUCT DESCRIPTION/ PROBLEM DETAILS</h4>
                </div>
                @include('report.partials.sectionOne',['hidden'=>''])
                <div class="col-sm-12">
                    <div class="col-sm-12">
                        <label>QDN Validity:</label>
                        <br>
                        <div class="btn-group" data-toggle="buttons" id="validate">
                            <label class="btn btn-default valid {{ $qdn->closure->status !== 'cancelled' ? 'active':'' }}">
                                <input type="radio" name="status" id="status" value="incomplete fill-up"  {{ $qdn->closure->status !== 'cancelled' ? 'checked':'' }}> Valid
                            </label>
                            <label class="btn btn-default invalid {{ $qdn->closure->status =='cancelled' ? 'active':''}}">
                                <input type="radio" name="status" id="status" value="cancelled" {{ $qdn->closure->status =='cancelled' ? 'checked':''}}> Invalid
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                    <br>
                        <a data-toggle="modal" href='#validation-modal'>Input Validation Report <i class="fa fa-edit"></i></a>
                    </div>
                </div>
                <br>
                <div class="col-sm-12">
                    <div class="col-sm-12">
                        <br>
                        <label>Disposition:</label>
                        <br>
                        <div class="btn-group" data-toggle="buttons" id="dispositions">
                            @foreach ($disposition_check as $disposition)
                            <label class="btn btn-default
                                {{  dispositionCondition($qdn->disposition, $disposition) ? 'active' : '' }}
                                ">
                                <input
                                type  = 'radio'
                                name  = 'disposition'
                                value = '{{ $disposition }}'
                                {{ dispositionCondition($qdn->disposition, $disposition) ? 'checked' : '' }}
                                >
                                {{ Str::upper($disposition) }}
                            </label>
                            @endforeach
                        </div>
                        <hr>
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
                            @if ($currentUser->employee->department == 'process')
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ========================================== VALIDATION MESSAGE MODAL ================================================ -->
    <div class="modal" id="validation-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="validation-msg">Write Validation Output:</h4>
                </div>
                <div class="modal-body">
                    <textarea
                    rows        = "10"
                    class       = "form-control"
                    name        = "ValidationMessage"
                    id          = "validation-message"
                    placeholder = "Input Message. . ."
                    ></textarea>
                </div>
                <div class="modal-footer">
                    <button
                    type         = "button"
                    id           = "submit-btn"
                    class        = "btn btn-default"
                    data-dismiss = "modal"
                    >
                    Done
                    <i class="fa fa-check"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>