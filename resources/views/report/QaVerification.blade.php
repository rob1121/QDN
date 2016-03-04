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
	.btn-group>.btn-default {
		margin: 5px;
	}
	#radio-approve.active {
		color: #fff;
		background-color: #5cb85c;
		border-color: #4cae4c;
	}
	#radio-reject.active {
	color: #fff;
	background-color: #c9302c;
	border-color: #ac2925;
	}
	.section8-question {
		padding-top:10px;
	}
	.signature-title {
		margin-top:32px;
	}
</style>
@endpush
@section('content')
<div class="container">
	@include('report.partials.header', ['hidden' => 'hidden', 'disabled' => 'disabled'])
	@include('report.partials.section', ['hidden' => 'hidden', 'disabled' => 'disabled'])
	<!-- //======================================= Start of APPROVALS SECTION ========================================= -->
	<form action="{{ route('QaVerificationUpdate', ['slug' => $qdn->slug]) }}" method="post" id="approver-form">
		{!! csrf_field() !!}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">APPROVALS:</h3>
			</div>
			<div class="panel-body" id="approval-body">
				@include('report.partials.sectionSeven')
			</div>
		</div>
		<!-- ============================================= section 8 qa verification ====================== -->
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">VERIFIED BY:</h3>
			</div>
			<div class="panel-body" id="approval-body">
				<div class="col-md-offset-1 col-md-5 section8-question">CONTAINMENT ACTION TAKEN?</div>
				<div class="col-md-6">
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-default" id="radio-approve">
							<input
							type  = "radio"
							name  = "containment_action_taken"
							value = "yes"
							>
							Yes <i class="fa fa-check"></i>
						</label>
						<label class="btn btn-default active" id="radio-reject">
							<input
							type  = "radio"
							name  = "containment_action_taken"
							value = "no"
							checked
							>
							No <i class="fa fa-times"></i>
						</label>
					</div>
				</div>
				<div class="col-md-offset-1 col-md-5 section8-question">CORRECTIVE ACTION TAKEN?</div>
				<div class="col-md-6">
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-default" id="radio-approve">
							<input
							type  = "radio"
							name  = "corrective_action_taken"
							value = "yes"
							>
							Yes <i class="fa fa-check"></i>
						</label>
						<label class="btn btn-default active" id="radio-reject">
							<input
							type   = "radio"
							name  = "corrective_action_taken"
							value = "no"
							checked
							>
							No <i class="fa fa-times"></i>
						</label>
					</div>
				</div>
				<!-- ==================================== QA SIGNATURE ============================== -->
				<div class="col-md-12 text-center">
					<legend class="signature-title">VERIFY ACTION</legend>
					<div class="btn-group" data-toggle="buttons" id="approval-btn-group">
						<label class="btn btn-default btn-lg" id="radio-approve">
							<input
							type  = "radio"
							name  = "containment_action_taken"
							value = "approve"
							>
							Approve <i class="fa fa-check"></i>
						</label>
						<label class="btn btn-default btn-lg" id="radio-reject">
							<input
							type  = "radio"
							name  = "containment_action_taken"
							value = "reject"
							>
							Reject <i class="fa fa-times"></i>
						</label>
					</div>
				</div>
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