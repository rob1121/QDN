@extends('layouts.app')
@section('external-style')
<link rel="stylesheet" href="/vendor/css/select2.css">
<link rel="stylesheet" href="/vendor/css/select2-bootstrap.css">
@stop
@include('report.partials.style')
@section('content')
<div class="container">
    @include('report.partials.header')
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
    @if ($qdn->closure->status == 'incomplete fill-up' && $show)
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
@push('scripts')
@include('report.partials.script')
    <script type="text/javascript">
$(function() {
$('#draft-button').on('click', function(e) {
    e.preventDefault();
    if (confirm('Are you sure you want to save as draft only?')) {
        $.ajax({
            url: '/report/' + qdn.slug + '/ajax',
            type: 'get',
            data: $('#qdn-form').serializeArray(),
            success: function(qdn) {
                //names of receiver
                var department = $.unique(qdn.department),
                names = $.map( qdn.receiver_name, function(n){
                       return n;
                    });

                //updating section one text fields
                $('.customer').text($('#customer').val().toUpperCase());
                $('.package_type').text($('#package_type').val().toUpperCase());
                $('.device_name').text($('#device_name').val().toUpperCase());
                $('.lot_id_number').text($('#lot_id_number').val().toUpperCase());
                $('.lot_quantity').text($('#lot_quantity').val().toUpperCase());
                $('.job_order_number').text($('#job_order_number').val().toUpperCase());
                $('.machine').text($('#machine').val().toUpperCase());
                $('.station').text($('#station').val().toUpperCase());
                $('.text-major').html($('#major:checked').val() == 'major' ? '[x]' : '[&nbsp;&nbsp;]');
                $('.text-minor').html($('#major:checked').val() == 'minor' ? '[x]' : '[&nbsp;&nbsp;]');
                $('.control_id').text($('#control_id').val());
                $('input.disposition[value="' + $('#dispositions input:checked').val() + '"]').prop('checked', true);
                // team res
             $('.team_responsible').html(department.join("<br>").toUpperCase());

                 $('.receiver_name').html(names.join("<br>"));
                $('.problem_description').text($('#problem_description').val());

                //display alert
                $.amaran({
                    'theme': 'awesome ok',
                    'content': {
                        title: 'Draft Saved!',
                        message: '',
                        info: 'Come back soon to verify the issue!',
                        icon: 'fa fa-save'
                    },
                    'position': 'bottom right',
                    'outEffect': 'fadeOut'
                });


            }

        });
        $('#edit').modal('hide');
    }

});
//======================= PE verification button ===================================
$('#verification-btn').on('click', function(e) {
    return confirm('Are you sure you want to confirm changes and proceed the form for completion?');
});
});
    </script>
@endpush

