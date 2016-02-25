@extends('layouts.app')
@section('style')
<style>
body {
background-color: #fff;
/*background-image: url(img/background-imager/Elegant_Background-7.jpg);*/
background-size: cover;
}
#company-name {
font-size: 64px;
}
h1.text-center,h3 {
color: #800000;
}
a.carousel-control .fa {
margin:100% 0 100% 0;
vertical-align: middle;
}
.item img {
width:100%;
height:100%;
}
.carousel {
margin-bottom:0px;
}
.main-top,
.main-bottom {
padding-top:140px;
padding-bottom:50px;
}
.main-top {
padding-bottom:150px;
}
#wrap {
background-color: #fff;
}
.main-button {
font-size:50px;
padding: 10px 50px 10px 50px;
}
input.form-control:focus {
box-shadow: none;
border:1px solid #66afe9;
padding:24px 15px 24px 15px;
}
input.form-control {
padding:24px 15px 24px 15px;
}
.btn-primary {
    background-color: #800000;
    border:0px;
}
.btn-primary:hover {
    background-color: #800000;
  -webkit-filter: brightness(110%);
  -webkit-transform: scale(1.03);
  transform: scale(1.03);


        /*border: 1px solid #800;*/
        -webkit-transform: scale(1.03);
        transform: scale(1.03);
        position: relative;
        z-index: 1;
}
</style>
@stop
@section('content')
<div class="container main-top">
    <form
        class  = "form-horizontal"
        role   = "form"
        method = "POST"
        action = "{{ url('/login') }}"
        id     = "login-form"
        novalidate
        >
        {!! csrf_field() !!}
        <div class="form-group{{ $errors->has('employee_id') ? ' has-error' : '' }}">
            <div class="col-md-offset-3 col-md-6">
                <input
                type        = "text"
                class       = "form-control"
                name        = "employee_id"
                id          = "employee_id"
                autocomplete = "off"
                placeholder = "Input Employee ID"
                value       = "{{ old('employee_id') }}"
                >
                @if ($errors->has('employee_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('employee_id') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group
            {{ $errors->has('password') ? ' has-error' : '' }}"
            >
            <div class="col-md-offset-3 col-md-6">
                <input
                type        = "password"
                class       = "form-control"
                name        = "password"
                id          = "password"
                placeholder = "Input Password"
                >
                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3 text-center">
                <button type="submit" class="btn btn-primary btn-lg">
                <i class="fa fa-btn fa-sign-in"></i> Login
                </button>
            </div>
        </div>
    </form>
</div>
<!-- ============= carousel ==================================== -->
<div id="carousel-id" class="carousel slide wow fadeIn" data-wow-offset="400" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target = "#carousel-id" data-slide-to="0" class="active"></li>
        <li data-target = "#carousel-id" data-slide-to="1" class=""></li>
        <li data-target = "#carousel-id" data-slide-to="2" class=""></li>
        <li data-target = "#carousel-id" data-slide-to="3" class=""></li>
        <li data-target = "#carousel-id" data-slide-to="4" class=""></li>
        <li data-target = "#carousel-id" data-slide-to="5" class=""></li>
    </ol>
    <div class="carousel-inner">
        <div class="item active">
            <img
            alt="First slide"
            src="http://www.telfordgp.com/images/banner/home-banner-1.jpg"
            >
        </div>
        <div class="item">
            <img
            alt = "Second slide"
            src = "http://www.telfordgp.com/images/banner/home-banner-2.jpg"
            >
        </div>
        <div class="item">
            <img
            alt = "Third slide"
            src = "http://www.telfordgp.com/images/banner/home-banner-3.jpg"
            >
        </div>
        <div class="item">
            <img
            alt = "Third slide"
            src = "http://www.telfordgp.com/images/banner/home-banner-6.jpg"
            >
        </div>
        <div class="item">
            <img
            alt = "Third slide"
            src = "http://www.telfordgp.com/images/banner/home-banner-5.jpg"
            >
        </div>
    </div>
</div>
<!-- ========================== telford ================================= -->
<div class="container main-bottom">
    <h1 class="text-center wow fadeInDown" id="company-name" data-wow-offset="250"><i class="fa fa-fort-awesome fa-2x"></i>
    Telford Svc. Phils., Inc.
    </h1>
    <h3 class="help-block text-center wow fadeIn" data-wow-offset="250">
    Telford Building, Linares St. Barangay Javalera Gen. Trias, Cavite Philippines, 4117
    </h3 class="help-block text-center">
    <br><br><br>
    <!-- ====================================== brief description of telford ====================================== -->
    <h3 class="help-block text-center wow fadeIn" data-wow-offset="250"><em>Telford Svc. Phils. Inc. was incorporated in 2000 to provide backend semiconductor manufacturing services such as taping, de-taping as well as inspection and other related activities such as IC programming to MNCs in South Philippines.
    It has established successful strong 'partnership programs' with renowned MNCs.</em></h3>
    <br><br><br>
    <h3 class="help-block text-right wow fadeIn" data-wow-offset="250">
    {{ Carbon::now('Asia/Manila')->format('m/d/Y h:i:s A') }}
    </h3>
</div>
@stop
@section('script')
<script>
$(function() {
new WOW().init();
$('#login-form').validate({
rules: {
employee_id: {
required: true
},
password: {
required: true
}
},
errorClass: "error",
errorElement: "span"
});
});
</script>
@stop