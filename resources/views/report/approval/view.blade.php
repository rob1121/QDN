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
				@if (
				($currentUser->employee->department == 'production' && $qdn->closure->production == '')
				|| ($currentUser->employee->department == 'process' && $qdn->closure->process_engineering == '')
				|| ($currentUser->employee->department == 'quality assurance' && $qdn->closure->quality_assurance == '')
				|| ($currentUser->employee->department == 'other' && $qdn->closure->other_department == '')
				)
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
				@else
				<div class="col-md-3">
					<div class="col-md-11 text-center"><strong>{{ Str::title($qdn->closure->production)."&nbsp;" }}</strong></div>
					<div class="col-md-11 text-center underline-label">
						<strong>{{ Str::upper('production') }}</strong>
					</div>
				</div>
				<div class="col-md-3">
					<div class="col-md-11 text-center"><strong>{{ Str::title($qdn->closure->process_engineering)."&nbsp;" }}</strong></div>
					<div class="col-md-11 text-center underline-label">
						<strong>{{ Str::upper('process') }}</strong>
					</div>
				</div>
				<div class="col-md-3">
					<div class="col-md-11 text-center"><strong>{{ Str::title($qdn->closure->quality_assurance)."&nbsp;" }}</strong></div>
					<div class="col-md-11 text-center underline-label">
						<strong>{{ Str::upper('quality assurance') }}</strong>
					</div>
				</div>
				<div class="col-md-3">
					<div class="col-md-11 text-center"><strong>{{ Str::title($qdn->closure->other_department)."&nbsp;" }}</strong></div>
					<div class="col-md-11 text-center underline-label">
						<strong>{{ Str::upper('others') }}</strong>
					</div>
				</div>
				@endif
			</div>
		</div>
		<!-- ========================================== APPROVER MESSAGE MODAL ================================================ -->
		<div class="modal" id="approver-modal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="approver-msg">Add Comment (optional):</h4>
					</div>
					<div class="modal-body">
						<textarea
						rows        = "10"
						class       = "form-control"
						name        = "approverMessage"
						id          = "approver-message"
						placeholder = "Input Message. . ."
						></textarea>
					</div>
					<div class="modal-footer">
						<button
						type         = "button"
						id           = "confirm-btn"
						class        = "btn btn-success"
						data-dismiss = "modal"
						>
						Confirm Action
						<i class="fa fa-paper-plane"></i>
						</button>
						<button
						type         = "button"
						id           = "cancel-btn"
						class        = "btn btn-default"
						data-dismiss = "modal"
						>
						Cancel
						<i class="fa fa-edit"></i>
						</button>
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