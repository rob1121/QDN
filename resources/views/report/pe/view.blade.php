@extends('layouts.app')
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
		    <div class="panel-body">
	        </div>
	    </div>

	</div>
@stop
@include('report.partials.script')
