@extends('layouts.app')
@section('external-style')
<link rel="stylesheet" href="/vendor/css/select2.css">
<link rel="stylesheet" href="/vendor/css/select2-bootstrap.css">
@stop
@push('style')
<style>
.form-control:focus,
#s2id_receiver_name .select2-choices,
.select2-dropdown-open .select2-choice,
.select2-container-active .select2-default {
box-shadow: none;
}
button[name="submit"] {
margin-left:15px;
}
.major.active,
.major.active:hover,
.major.active.focus {
color: #fff;
background-color: #c9302c;
border-color: #ac2925;
}
.minor.active,
.minor.active:hover,
.minor.active.focus {
color: #fff;
background-color: #ec971f;
border-color: #d58512;
}
</style>
@endpush
@section('content')
<div class="container">
    @include('errors.validationErrors')
    <!-- ==================================== form start======================================== =======================-->
    <form
        action = "{{ route('issue_qdn') }}"
        method = "POST"
        role   = "form"
        id     = "qdn-form"
        novalidate
        >
        {{ csrf_field() }}
        @include('report.partials.sectionOne',['hidden'=>'hidden'])
        <!-- SUBMIT BUTTON -->
        <div class="form-group col-xs-12">
            <button
            type  = "button"
            name  = "submit"
            class = "btn btn-lg btn-primary"
            >
            <i class="fa fa-save"></i> Submit
            </button>
        </div>
        <!-- //========================== modal for confirmation message =============================== -->
        <div class="modal" id="confirm-submit">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Confirm Submission</h4>
                    </div>
                    <div class="modal-body">
                        <em>Are you certain with all your inputs? If yes click</em>
                        <strong class="label label-primary">Confirm Submission</strong>
                        <br><br>
                        <em>to edit click </em>
                        <strong class="label label-default">Cancel</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                        <span class="fa fa-times-circle"></span>
                        Cancel
                        </button>
                        <button type="submit" id="btn-confirm" class="btn btn-primary">
                        <span class="fa fa-check-circle"></span>
                        Confirm Submission
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
        <!-- ================================================= form end =================================== -->
</div>
@stop
<!-- ============================================ script ==============================================================  -->
@section('script')
<script src="/vendor/js/select2.min.js"></script>
<script src="/js/reportForm.js"></script>
@stop
@push('scripts')
<script type="text/javascript">
$(function() {
$('button[name="submit"]').on('click', function () {
$('#confirm-submit').modal('show');
});
});
</script>
@endpush