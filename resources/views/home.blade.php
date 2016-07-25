@extends('layouts.app')
@section('style')
<style>
.brighten {
background-color: #fff;
-webkit-filter: brightness(100%);
-webkit-transition: all .1s ease;
-moz-transition: all .1s ease;
-o-transition: all .1s ease;
-ms-transition: all .1s ease;
transition: all .1s ease;
}
.brighten:hover {
-webkit-filter: brightness(95%);
/*border: 1px solid #800;*/
-webkit-transform: scale(1.03);
transform: scale(1.03);
position: relative;
z-index: 1;
}
#link {
margin-bottom: 32px;
}
#link div .row {
margin-top : 5px;
margin-left : 5px;
margin-row : 5px;
}
#link div {
margin: 0px;
padding: 0px;
}
.modal-body  {
padding-top: 0px;
padding-bottom: 0px;
}
.table {
background-color: #fff;
margin-bottom: 0px;
padding-top: 0px;
padding-bottom: 0px;
}
.panel {
border: 0px;
}
.panel-primary>.panel-heading {
background-color: #800;
}
.panel.panel-primary,
.panel .panel-body,
.panel .panel-heading,
.panel .panel-footer,
.collapse {
border-radius: 0px;
border: 0px;
}
.well {
background-color: #fff;
border: 1px solid #e3e3e3;
border-radius: 0px;
-webkit-box-shadow: 0px;
box-shadow: 0px;
}
select.form-control:focus {
box-shadow: none;
}
</style>
@stop
@section('content')
{{-- STATUS =========================================================--}}
<div class="container">
    @include('errors.validationErrors')
    <!-- <legend class="h1">Status: </legend> -->
</div>
{{-- container for collapse data filtered by status----================================= --}}
<div class="container">
    <qdn-collapse :list.sync="qdn"></qdn-collapse>
</div>
@include('home.modals')
@endsection
@section('script')
<script src="/js/vue-home.js"></script>
<script src="/js/homeScript.js"></script>
<script>
$(function() {
var interval = 5000; // 1000 = 1 second, 3000 = 3 seconds
function doAjax() {
    $.ajax({
        type: 'get',
        url: '/count',
        success: function(count) {
            $('#text-today').text(count.today);
            $('#text-week').text(count.week);
            $('#text-month').text(count.month);
            $('#text-year').text(count.year);
            $('#text-peVerification').text(count.PeVerification);
            $('#text-incomplete').text(count.Incomplete);
            $('#text-approval').text(count.Approval);
            $('#text-qaVerification').text(count.QaVerification);
        },
        complete: function() {
            // Schedule the next
            setTimeout(doAjax, interval);
        }
    });
}
setTimeout(doAjax, interval);
});
</script>
@stop