@extends('layouts.app')
@section('external-style')
    <link rel = "stylesheet" href="/vendor/css/select2.css">
    <link rel = "stylesheet" href="/vendor/css/select2-bootstrap.css">
    <link rel = "stylesheet" href="/vendor/css/bootstrap-datepicker.css">
@stop
@section('style')
<style>

.col-xs-5 p {
border-bottom: 1px solid grey;
}

.panel {
margin-top:0px;
margin-bottom:-1px;
border-radius: 0px;
}

.bold {
font-weight: bold;
text-align:right;
}
panel-body {
padding:0px;
}

#what {
width: 100%;
padding:15px;
resize: none;
}

.panel .panel-heading {
border-radius: 0px;
background-color:#800000;
color:#fff;
}

button[type="submit"] {
margin: 25px 0px 50px 0px;
}

.form-control[disabled],
.form-control[readonly],
fieldset[disabled] .form-control {
    background-color: #fff;
}

input.form-control:focus {
    box-shadow: none;
}

input[type="file"]{
    display: none;
}

.error,
.error .select2-choice.select2-default,
.error .select2-choices {
    box-shadow: none;
}

.edit {
    float:right;
}
</style>
@stop
@section('content')
@include('errors.validationErrors')
<!-- HEADING -->
<center><H1 style='color:#800000'>QUALITY DEVIATION NOTICE</H1></center>
<!-- START -->
<div class="container" style='font-size:12px;padding:0px'>
<a 
    href="{{ route('pdf', ['slug'=> $qdn->slug]) }}" 
    class="btn btn-default"
>Print <i class="fa fa-print"></i>

</a>
    <!-- PRODUCT DESCRIPTION/ PROBLEM DETAILS -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
            PRODUCT DESCRIPTION/ PROBLEM DETAILS
            @if ($currentUser->Employee->department == 'pe'
                || $currentUser->access_level == 'Admin')
            <a
                class='edit'
                href="/edit"
            >edit <i class="fa fa-pencil"></i> </a>
            @endif
            </h3>
        </div>
        <div class="panel-body">
            <!-- FIRST COLUMN -->
            <div class="col-lg-4 col-md-3 col-sm-6 text-left">
                <!-- CUSTOMER -->
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">Customer:</div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                        <p> {{ $qdn->customer }} </p>
                    </div>
                </div>
                <!-- PACKAGE TYPE -->
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">
                        Package Type:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                        <p>{{ $qdn->package_type }}</p>
                    </div>
                </div>
                <!-- DEVICE NAME -->
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">
                        Device Name:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                        <p>{{ $qdn->device_name }}</p>
                    </div>
                </div>
                <!-- LOT ID NUMBER -->
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">
                        Lot ID No.:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                        <p>{{ $qdn->lot_id_number }}</p>
                    </div>
                </div>
                <!-- LOT QUANTITY -->
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">
                        Lot Quantity:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                        <p>{{ $qdn->lot_quantity }}</p>
                    </div>
                </div>
            </div>
            <!-- SECOND COLUMN -->
            <div class="col-lg-4 col-md-3 col-sm-6 text-left">
                <!-- JOB ORDER NUMBER -->
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">
                        Job Order No.:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                        <p>{{ $qdn->job_order_number }}</p>
                    </div>
                </div>
                <!-- MACHINE -->
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">
                        Machine:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                        <p>{{ $qdn->machine }}</p>
                    </div>
                </div>
                <!-- STATION -->
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">
                        Station:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                        <p>{{ $qdn->station }}</p>
                    </div>
                </div>
                <!-- MAJOR -->
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">Major:</div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 text-left">
                        <?=$qdn->major == "major" ? '[x]' : '[&nbsp;&nbsp;]';?>
                    </div>
                </div>
                <!-- MINOR -->
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">Minor:</div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 text-left">
                        <?=$qdn->major != "major" ? '[x]' : '[&nbsp;&nbsp;]';?>
                    </div>
                </div>
            </div>
            <!-- THIRD COLUMN -->
            <div class="col-lg-4 col-md-6 col-sm-6 text-left">
                <!-- QDN NO -->
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">QDN No.:</div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                        <p style='color:Red;font-weight:bold'>
                            {{ $qdn->control_id }}
                        </p>
                    </div>
                </div>
                <!-- TEAM RESPONSIBLE -->
                <div class="row">
                    <div class ="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">
                        Team Responsible:
                    </div>
                    <div class ="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                        <p>
                            {!! implode("<br>",$department) !!}
                        </p>
                    </div>
                </div>
                <!-- ISSUED BY -->
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">Issued By:</div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                        <p>
                            {{ $qdn->involvePerson()->first()->originator_name }}
                        </p>
                    </div>
                </div>
                <!-- ISSUED TO -->
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">Issued To:</div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                        <p>
                            {!!
                                implode("<br>",array_flatten(
                                $qdn->involvePerson()
                                    ->select('receiver_name')
                                    ->get()
                                    ->toArray())
                                )
                            !!}
                        </p>
                    </div>
                </div>
                <!-- DATE AND TIME -->
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">
                        Date and Time:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                        <p>
                            {{ Carbon::parse($qdn->created_at) }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="container text-center col-lg-12 col-sm-12">
                <br/><br/>
                <?=
                $qdn->problem_description == ""
                    ? "<br/><br/>"
                    : $qdn->problem_description . "<br/><br/>";
                ?>
            </div>
        </div>
    </div>
    <!-- CONTAINEMENT ACTION WHO -->
    <!-- START OF FORM -->
    <form
        method  = 'POST'
        action  = "{{ route('draft_link', ['slug' => $qdn->slug]) }}"
        enctype = "multipart/form-data"
        id      = "completion"
         novalidate
     >
    {!! csrf_field() !!}
        @include('report.partials._section1')
        <div class="text-right container">
            <button
                type    = 'submit'
                name    = 'draft_button'
                id      = 'draft_button'
                class   = "btn btn-default btn-lg"
            >Save as Draft
            <span class="fa fa-save"></span>
            </button>
            <button
                type    = 'submit'
                name    = 'aprroval_button'
                id      = 'aprroval_button'
                class   = "btn btn-default btn-lg btn-primary"
            >Submit for approvals
                <span class="fa fa-paper-plane"></span>
            </button>
        </div>
    </form>
</div>
@endsection
@section('script')
    <script src="/vendor/js/bootstrap-datepicker.js"></script>
    <script src="/vendor/js/select2.min.js"></script>
    <script src="/js/reportCompletion.js"></script>
@stop