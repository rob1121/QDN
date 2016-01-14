@extends('errors.app')
@section('style')
    <style>
        body {
            background-color: none;
            background-image: url(/img/404.jpg);
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
        }
        .h1 {
            font-family: Coustard;
            font-size:54px;
        }
    </style>
@stop
@section('content')
    <div class="container text-center">
        <p class="h1">QDN</p>
        <p class="h3">Sorry, the page you were looking for doesn’t exist.</p>
        <p class="h5">Go back to <a href="/">Home page</a> or <a href="mailto:robinsonlegaspi@astigp.com">contact us</a> about a problem.</p>
    </div>
@stop