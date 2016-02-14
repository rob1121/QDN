@extends('layouts.app')
@section('substyle')
	<style>
		#approval-body>div>.underline-label {
			border-top:1px solid black;
		}
	</style>
@stop
@include('report.partials.style')
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
					<div class="col-md-12 text-center"><div class="form-group"><label><input type="radio" name="approve" id="approve"> <i class="fa fa-check"></i>Approve</label></div></div>

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
@stop
@include('report.partials.script')
