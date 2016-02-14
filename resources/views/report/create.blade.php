@extends('layouts.app')
@section('external-style')
<link rel="stylesheet" href="/vendor/css/select2.css">
<link rel="stylesheet" href="/vendor/css/select2-bootstrap.css">
@stop
@section('style')
<style>
select {
visibility: hidden;
}
.form-control:focus,
#s2id_receiver_name .select2-choices,
.select2-dropdown-open .select2-choice,
.select2-container-active .select2-default {
box-shadow: none;
}
</style>
@stop
@section('content')
<div class="container">
    @include('errors.validationErrors')
    <form
        action = "{{ route('issue_qdn') }}"
        method = "POST"
        role   = "form"
        id     = "qdn-form"
        novalidate
        >
        @include('report.partials.sectionOne',
            [
            'btn'=>'<!-- SUBMIT BUTTON -->
            <div class="form-group col-xs-12">
                <button
                type  = "submit"
                name  = "submit"
                class = "btn btn-lg btn-primary"
                >
                <i class="fa fa-save"></i> Submit
                </button>
            </div>',
            'hidden'=>'hidden'
            ]
        )
    </form>
</div>
@stop
@section('script')
<script src="/vendor/js/select2.min.js"></script>
<script src="/js/reportForm.js"></script>
@stop