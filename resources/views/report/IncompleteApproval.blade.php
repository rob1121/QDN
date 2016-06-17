@extends('layouts.app')
@include('report.partials.style')
@push('style')
<style>
#approval-body {
	padding:32px 0px 32px 0px;
}
	#approval-body>div>.underline-label {
		border-top:1px solid black;
	}
	.btn-lg {
		margin: 5px;
	}
	#section7-approve.active {
		color: #fff;
		background-color: #5cb85c;
		border-color: #4cae4c;
	}
	#section7-reject.active {
	color: #fff;
	background-color: #c9302c;
	border-color: #ac2925;
	}
</style>
@endpush
@section('content')
<div class="container">
	@include('report.partials.header', ['hidden' => 'hidden', 'disabled' => 'disabled'])
	@include('report.partials.section', ['hidden' => 'hidden', 'disabled' => 'disabled'])
	<!-- //======================================= Start of APPROVALS SECTION ========================================= -->
	<form action="{{ route('UpdateForApprroval', ['slug' => $qdn->slug]) }}" method="post" id="approver-form">
		{!! csrf_field() !!}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">APPROVALS:</h3>
			</div>
			<div class="panel-body" id="approval-body">
				@if (isApprover($qdn))
				<div class="col-md-12 text-center">
					<div class="btn-group" data-toggle="buttons" id="approval-btn-group">
						<label class="btn btn-default btn-lg" id="section7-approve">
							<input type="radio" name="approver_radio" id="option1" autocomplete="off" value="approve">
							Approve <i class="fa fa-check"></i>
						</label>
						<label class="btn btn-default btn-lg" id="section7-reject">
							<input type="radio" name="approver_radio" id="option2" autocomplete="off" value="reject">
							Reject <i class="fa fa-times"></i>
						</label>
					</div>
				</div>
                    <div class="clearfix"></div>
				@endif
				@include('report.partials.sectionSeven',['view' => isApprover($qdn), 'valid' => userClosure($qdn->closure)])
			</div>
		</div>
	</form>
</div>
@include('report.partials.modal')
@stop
@push('scripts')
@include('report.partials.script')
<script>
$(function() {
$('#approval-btn-group .btn').on('click', function() {
    $('#approver-modal').modal('show');
});
$('#confirm-btn').on('click', function() {
    if (confirm('Have you review all action stated on the page? If yes click ok to proceed')) {
        $('form#approver-form').submit();
    }
});
});
</script>
@endpush