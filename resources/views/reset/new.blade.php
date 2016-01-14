@extends('layouts.app')
@section('content')
<div class="container">
    @include('errors.validationErrors');
    <form action="{{ route('password', ['id' => $user->user_id]) }}" method="POST" role="form">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <legend>New password</legend>

        <div class="form-group">
            <input
                type         = "password"
                autocomplete = "off"
                name         = "password"
                class        = "form-control"
                placeholder  = "Enter new password"
            >
        </div>
        <div class="form-group">
            <input
                type         = "password"
                autocomplete = "off"
                name         = "password_2"
                class        = "form-control"
                placeholder  = "Re - password"
            >
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@stop