@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="{{ route('password', ['id' => $user->user_id]) }}" method="POST" role="form" id="new_password" novalidate>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <h1>New password</h1>
                    <hr>
                    @include('errors.validationErrors')
                    <div class="form-group">
                        <input
                        type         = "password"
                        autocomplete = "off"
                        name         = "password"
                        id           = "password"
                        class        = "form-control input-lg"
                        placeholder  = "Enter new password"
                        >
                    </div>
                    <div class="form-group">
                        <input
                        type         = "password"
                        autocomplete = "off"
                        name         = "password_2"
                        id           = "password_2"
                        class        = "form-control input-lg"
                        placeholder  = "Re - password"
                        >
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Save <i class="fa fa-save"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script type="text/javascript">
$(function() {
$('#new_password').validate({
rules: {
    password: {
        required: true,
    minlength: 6
    },
    password_2: {
        required: true,
    equalTo: "#password",
    minlength: 6
    }
},
errorClass: "error",
errorElement: "span"
});
});
</script>
@stop
