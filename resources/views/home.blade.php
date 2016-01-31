@extends('layouts.app')
@section('style')
<style>

    .brighten {
        background-color: #fff;
        -webkit-filter: brightness(100%);
        -webkit-transition: all .1s ease;
        -moz-transition: all .1s ease;
        -o-transition: all .1s ease;
        -ms-transition: all .1s ease;
        transition: all .1s ease;
    }

    .brighten:hover {
        -webkit-filter: brightness(95%);
        /*border: 1px solid #800;*/
        -webkit-transform: scale(1.03);
        transform: scale(1.03);
        position: relative;
        z-index: 99999;
    }

    #link {
        margin-bottom: 32px;
    }

    #link div .row {
        margin-top : 5px;
        margin-left : 5px;
        margin-row : 5px;
    }

    #link div {
        margin: 0px;
        padding: 0px;
    }



    .modal-body  {
        padding-top: 0px;
        padding-bottom: 0px;
    }


    .table {
        background-color: #fff;
        margin-bottom: 0px;
        padding-top: 0px;
        padding-bottom: 0px;
    }
    .panel {
        border: 0px;
    }

    .panel-primary>.panel-heading {
        background-color: #800;
    }

    .panel.panel-primary,
    .panel .panel-body,
    .panel .panel-heading,
    .panel .panel-footer,
    .collapse {
        border-radius: 0px;
        border: 0px;
    }

    .well {
        background-color: #fff;
        border: 1px solid #e3e3e3;
         border-radius: 0px;
         -webkit-box-shadow: 0px;
         box-shadow: 0px;
    }
</style>
@stop
@section('content')


<!-- Count content=================================================== -->
<div class="container">
<legend class="h1">Counts: </legend>
@foreach ($counts as $panel)
<div class="col-xs-3 h2">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $panel[2] }}</h3>
        </div>
        <div class="panel-body">
            {{ $panel[0] }}
        </div>
        <a class="h5" href="#">
            <div
                class         = "panel-footer"
                data-toggle   = "collapse"
                href          = "#{{ $panel[1] }}"
                aria-expanded = "false"
                aria-controls = "{{ $panel[1] }}"
            >
                <span class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>
@endforeach
</div>
<div class="container">

@foreach ($counts as $panel)
    <div class="collapse" id="{{ $panel[1] }}">
      <div class="well">
      <legend>{{ $panel[2] }}</legend>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Problem Desciption</th>
                    <th>Trap Location</th>
                    <th>Customer</th>
                    <th>Receiver Name</th>
                    <th>Issued Date / Time</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    </div>
@endforeach
</div>

{{-- MODAL LINKS ==========================================================--}}
<div class="container" id="link">
@include('errors.validationErrors')
<legend class="h1">Graphs: </legend>
@foreach ($charts as $chart)
    <a
        data-toggle = "modal"
        href        = "#{{ $chart['id'] }}"
    >
            <div class="col-xs-4" style="color: #800">
                <div class="row text-center table-bordered brighten ">
                    <i class="fa fa-bar-chart fa-5x"></i>
                    <br><strong class="text-muted">{!! $chart['heading'] !!}</strong>
                </div>
            </div>
    </a>
@endforeach
</div>

{{-- STATUS =========================================================--}}

<div class="container">
<legend class="h1">Status: </legend>
@foreach ($status as $panel)
<div class="col-xs-3 h2">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $panel[2] }}</h3>
        </div>
        <div class="panel-body">
            {{ $panel[0] }}
        </div>
        <a class="h5" href="#">
            <div
                class         = "panel-footer"
                data-toggle   = "collapse"
                href          = "#{{ $panel[1] }}"
                aria-expanded = "false"
                aria-controls = "{{ $panel[1] }}"
            >
                <span class="pull-left">View Details</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>
@endforeach
</div>

{{-- container for collapse data filtered by status----================================= --}}
<div class="container" id="">

@foreach ($status as $panel)
    <div class="collapse" id="{{ $panel[1] }}">
      <div class="well">
      <legend>{{ $panel[2] }}</legend>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Problem Desciption</th>
                    <th>Trap Location</th>
                    <th>Customer</th>
                    <th>Receiver Name</th>
                    <th>Issued Date / Time</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    </div>
@endforeach
</div>
@include('home.modals')
@endsection

@section('script')
    <script src="/vendor/js/highcharts.js"></script>
    <script src="/vendor/js/exporting.js"></script>
    <script src="/js/homeScript.js"></script>
@stop