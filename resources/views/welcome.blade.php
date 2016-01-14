@extends('layouts.app')
@section('style')
    <style>
        body {
            background-color: none;
            background-image: url(img/background-imager/Elegant_Background-7.jpg);
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
        }

        #company-name {
          font-size: 64px;
        }

        #content .container h1 {
          color: #800;
        }
    </style>
@stop
@section('content')
<div class="container">
    <h1 class="text-center"><i class="fa fa-fort-awesome fa-2x"></i></h1>
    <h1 class="text-center" id="company-name">
        Telford Svc. Phils., Inc.
    </h1>
    <h3 class="help-block text-center">
        Telford Building, Linares St. Barangay Javalera Gen. Trias, Cavite Philippines, 4117
    </h3 class="help-block text-center">
    <h3 class="help-block text-center">
        {{ Carbon::now('Asia/Manila')->format('m/d/Y h:i:s A') }}
    </h3>
</div>
@endsection
@section('script')
  <script src="js/form-validate.js"></script>
@stop




@if (! $currentUser)
{{-- LOGIN MODAL --}}
<div class="modal fade" id="login">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Login</h4>
            </div>
            <div class="modal-body">
                 <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}" id="login-form" novalidate>
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('employee_id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">User ID:</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="employee_id" value="{{ old('employee_id') }}" id="employee_id">

                                @if ($errors->has('employee_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('employee_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password" id="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Login
                                </button>

                                <a class="btn btn-link" href="{{ route('reset') }}">Forgot Your Password?</a>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endif