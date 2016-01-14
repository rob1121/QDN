@extends('layouts.app')
@section('content')
<div class="container">
    @include('errors.validationErrors')
    <form action="{{ route('reset') }}" method="POST" role="form">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <legend>Account Reset</legend>

        <div class="form-group">
            <input
                type         ="text"
                class        ="form-control"
                autocomplete = "off"
                id           ="employee_id"
                name         ="employee_id"
                placeholder  ="Employee ID"
                value        ="{{ old('employee_id') }}"
            >
        </div>



        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@stop