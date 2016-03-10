@extends('layouts.app')
@section('style')
<style>
.col-md-2,
.col-md-10 {
margin:0px;
padding:0px;
}
</style>
@stop
@section('content')
<?php
function uniqueRand($min, $max, $quantity) {
	$numbers = range($min, $max);
	shuffle($numbers);
	return array_slice($numbers, 0, $quantity);
}
?>
{!! uniqueRand(1,30,10) !!}
<div class="col-md-12">
    <div class="col-md-2">
        <ul class="list-group ">
            <a href="#" class="list-group-item">
                Employees
                <i class="fa fa-users pull-right"></i>
            </a>
            <a href="#" class="list-group-item">
                Options
                <i class="fa fa-list pull-right"></i>
            </a>
                <a href="{{ route('MachineOptions') }}" class="list-group-item active">Machines</li>
                <a href="{{ route('FailureModeOptions') }}" class="list-group-item active">Failure Mode</li>
                <a href="{{ route('DiscrepancyCategoryOptions') }}" class="list-group-item active">Discrepancy Categories</li>
                <a href="{{ route('CustomerOptions') }}" class="list-group-item active">Customers</li>
            <a href="#" class="list-group-item">
                Logs
                <i class="fa fa-file pull-right"></i>
            </a>
        </ul>
    </div>
    <div class="col-md-10">
        <ul class="list-group">
            <li class="list-group-item"></li>
        </ul>
    </div>
</div>
</div>
@stop
@push('scripts')
{{-- expr --}}
@endpush