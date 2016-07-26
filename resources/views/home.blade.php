@extends('layouts.app')
@section('style')
<style>

</style>
@stop
@section('content')
{{-- STATUS =========================================================--}}
<div class="container">
    @include('errors.validationErrors')
    <!-- <legend class="h1">Status: </legend> -->
</div>

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