@extends('layouts.app')
@section('style')
<style type="text/css">
.list-group-item i.fa {
float: right;
}
.list-group-item:first-child,
.list-group-item:last-child {
border-radius: 0px;
}
.list-group-item.active,
.list-group-item.active:hover,
.list-group-item.active:active,
.list-group-item.active:focus {
background-color:#f5f5f5;
color: #222;
border-color:#ddd;
font-weight:bold;
}
.form-control,
.form-control:hover,
.form-control:active,
.form-control.active,
.form-control:focus {
box-shadow: none;
}
</style>
@endsection
@section('content')
<div class="container">
    <div class="col-md-4">
        <ul class="list-group">
            <a href="#" class="list-group-item">Account <i class="fa fa-angle-double-right"></i></a>
            <a href="#" class="list-group-item">Settings <i class="fa fa-angle-double-right"></i></a>
            <a href="#" class="list-group-item">Email <i class="fa fa-angle-double-right"></i></a>
        </ul>
    </div>
    <div class="col-md-8">
        <ul class="list-group">
            <li class="list-group-item">
                <h1>Account</h1>
            </li>
            <li class="list-group-item">
                <!-- NAME -->
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" class="form-control input-lg" value="{{ $user->employee->name }}">
                </div>

                <!-- DEPARTMENT -->
                <div class="form-group">
                    <label for="department">Department:</label>
                    <input type="text" name="department" id="department" class="form-control input-lg" value="{{ $user->employee->department }}">
                </div>

                <!-- PASSWORD -->
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" class="form-control input-lg">
                </div>

                <!-- PASSWORD CONFIRMATION -->
                <div class="form-group">
                    <label for="password_confirmation">Password Confirmation:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-lg">
                </div>

                <!-- SUBMIT -->
                <div class="form-group">
                    <button type="submit" class="btn btn-info  btn-lg">SUBMIT</button>
                </div>
            </form>
        </li>
    </ul>
</div>
</div>
@endsection