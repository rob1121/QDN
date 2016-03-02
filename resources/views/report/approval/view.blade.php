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
						<input type="radio" name="options" id="option1" autocomplete="off" value="approve">
						Approve <i class="fa fa-check"></i>
					</label>
					<label class="btn btn-default btn-lg" id="section7-reject">
						<input type="radio" name="options" id="option2" autocomplete="off" value="reject">
						Reject <i class="fa fa-times"></i>
					</label>
				</div>
			</div>
			@else
			<div class="col-md-3">
				<div class="col-md-11 text-center"><strong>{{ Str::title($qdn->closure->production) }}</strong></div>
				<div class="col-md-11 text-center underline-label">
					<strong>{{ Str::upper('production') }}</strong>
				</div>
			</div>
			<div class="col-md-3">
				<div class="col-md-11 text-center"><strong>{{ Str::title($qdn->closure->process_engineering) }}</strong></div>
				<div class="col-md-11 text-center underline-label">
					<strong>{{ Str::upper('process') }}</strong>
				</div>
			</div>
			<div class="col-md-3">
				<div class="col-md-11 text-center"><strong>{{ Str::title($qdn->closure->quality_assurance) }}</strong></div>
				<div class="col-md-11 text-center underline-label">
					<strong>{{ Str::upper('quality assurance') }}</strong>
				</div>
			</div>
			<div class="col-md-3">
				<div class="col-md-11 text-center"><strong>{{ Str::title($qdn->closure->other_department) }}</strong></div>
				<div class="col-md-11 text-center underline-label">
					<strong>{{ Str::upper('others') }}</strong>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>
@include('report.partials.modal')
@stop
@push('scripts')
@include('report.partials.script')
<script>
	$(function() {
		$('#approval-btn-group .btn').on('click', function () {
			$('#validation-modal h4#validation-msg').text('Add Comment (optional):');
			$('#validation-modal').modal('show');
		});
	});
</script>
@endpush