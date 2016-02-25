<?php
function dispositionCondition($qdn, $disposition) {
	if ('' == $qdn) {
		return 'use as is' == $disposition;
	}
	return $qdn == $disposition;
}
?>
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">EDIT: PRODUCT DESCRIPTION/ PROBLEM DETAILS</h4>
            </div>
            <form
                action = "{{ route('SectionOneSaveAndProceed',['slug' => $qdn->slug]) }}"
                method = "get"
                role   = "form"
                id     = "qdn-form"
                novalidate
                >
                @include('report.partials.sectionOne',['hidden'=>''])
                <div class="col-sm-12">
                    <div class="col-sm-12">
                        <label>QDN Validity:</label>
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
            </form>
        </div>
    </div>
</div>