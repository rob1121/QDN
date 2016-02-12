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
