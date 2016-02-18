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
.item {
height: 600px;
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
padding-bottom:280px;
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
                value       = "{{ old('employee_id') }}"
                id          = "employee_id"
                placeholder = "Input Employee ID"
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
<div id="carousel-id" class="carousel slide" data-ride="carousel">
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
            src="http://www.stigp.com/images/banner/home-banner-1.jpg"
            >
        </div>
        <div class="item">
            <img
            alt = "Second slide"
            src = "http://www.stigp.com/images/banner/home-banner-2.jpg"
            >
        </div>
        <div class="item">
            <img
            alt = "Third slide"
            src = "http://www.stigp.com/images/banner/home-banner-3.jpg"
            >
        </div>
        <div class="item">
            <img
            alt = "Third slide"
            src = "http://www.stigp.com/images/banner/home-banner-6.jpg"
            >
        </div>
        <div class="item">
            <img
            alt = "Third slide"
            src = "http://www.stigp.com/images/banner/home-banner-5.jpg"
            >
        </div>
    </div>
    <a class="left carousel-control" href="#carousel-id" data-slide="prev"><span class="fa fa-chevron-left fa-5x"></span></a>
    <a class="right carousel-control" href="#carousel-id" data-slide="next"><span class="fa fa-chevron-right fa-5x"></span></a>
</div>
<!-- ========================== telford ================================= -->
<div class="container main-bottom wow fadeInLeft" data-wow-offset="450">
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