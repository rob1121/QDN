@extends('layouts.app')
@section('external-style')
<link rel="stylesheet" href="/vendor/css/select2.css">
<link rel="stylesheet" href="/vendor/css/select2-bootstrap.css">
@stop
@include('report.partials.style')
@section('content')
<div class="container">
    @include('report.partials.header', ['hidden' => 'hidden', 'disabled' => 'disabled'])
    <!-- START OF FORM -->
    <form
        method  = 'POST'
        action  = "{{ route('draft_link', ['slug' => $qdn->slug]) }}"
        enctype = "multipart/form-data"
        id      = "completion"
        novalidate
        >
        {!! csrf_field() !!}
        @include('report.partials.section', ['hidden' => 'hidden', 'disabled' => 'disabled'])
    </div>
    @if ($qdn->closure->status == 'incomplete')
    <div class="text-right container" id="btn-group">
        <button
        type    = 'submit'
        name    = 'draft_button'
        id      = 'draft_button'
        class   = "btn btn-default btn-lg"
        >
        Save as Draft
        <span class="fa fa-save"></span>
        </button>
        <button
        type    = 'submit'
        name    = 'aprroval_button'
        id      = 'aprroval_button'
        class   = "btn btn-default btn-lg btn-primary"
        >
        Submit for approvals
        <span class="fa fa-paper-plane"></span>
        </button>
    </div>
    @endif
</form>
@include('report.partials.modal')
@stop
@section('script')
    <script src="/vendor/js/bootstrap-datepicker.js"></script>
    <script src="/vendor/js/select2.min.js"></script>
    <script src="/js/reportCompletion.js"></script>
    <script src="/js/reportForm.js"></script>
    <script type="text/javascript">
$(function() {
$('#draft-button').on('click', function(e) {
    e.preventDefault();
    if (confirm('Are you sure you want to save as draft only?')) {
        $.ajax({
            url: '/',
            type: 'get',
            data: {},
            success: function() {
                $('.customer').text($('#customer').val().toUpperCase());
                $('.package_type').text($('#package_type').val().toUpperCase());

                    $.amaran({
        'theme'     :'awesome ok',
        'content'   :{
            title:'Draft Saved!',
            message:'',
            info:'Come back soon to verify the issue!',
            icon:'fa fa-save'
        },
        'position'  :'bottom right',
        'outEffect' :'fadeOut'
    });


            }

        });
        $('#edit').modal('hide');
    }

});
});
    </script>
@stop

