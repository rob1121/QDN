@extends('layouts.app')
@section('style')
<style>
body {
background-color: #fff;
/*background-image: url(img/background-imager/Elegant_Background-7.jpg);*/
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
</div><div id="carousel-id" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carousel-id" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-id" data-slide-to="1" class=""></li>
    <li data-target="#carousel-id" data-slide-to="2" class=""></li>
    <li data-target="#carousel-id" data-slide-to="3" class=""></li>
    <li data-target="#carousel-id" data-slide-to="4" class=""></li>
    <li data-target="#carousel-id" data-slide-to="5" class=""></li>
  </ol>
  <div class="carousel-inner">
    <div class="item active">
      <img data-src="holder.js/900x500/auto/#777:#7a7a7a/text:First slide" alt="First slide" src="http://www.stigp.com/images/banner/home-banner-1.jpg">
    </div>
    <div class="item">
      <img data-src="holder.js/900x500/auto/#666:#6a6a6a/text:Second slide" alt="Second slide" src="http://www.stigp.com/images/banner/home-banner-2.jpg">
    </div>
    <div class="item">
      <img data-src="holder.js/900x500/auto/#555:#5a5a5a/text:Third slide" alt="Third slide" src="http://www.stigp.com/images/banner/home-banner-3.jpg">
    </div>
    <div class="item">
      <img data-src="holder.js/900x500/auto/#555:#5a5a5a/text:Third slide" alt="Third slide" src="http://www.stigp.com/images/banner/home-banner-6.jpg">
    </div>
    <div class="item">
      <img data-src="holder.js/900x500/auto/#555:#5a5a5a/text:Third slide" alt="Third slide" src="http://www.stigp.com/images/banner/home-banner-5.jpg">
    </div>
  </div>
  <a class="left carousel-control" href="#carousel-id" data-slide="prev"><span class="fa fa-chevron-left fa-5x"></span></a>
  <a class="right carousel-control" href="#carousel-id" data-slide="next"><span class="fa fa-chevron-right fa-5x"></span></a>
</div>
@endsection