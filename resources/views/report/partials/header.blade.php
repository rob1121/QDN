@include('errors.validationErrors')
<!-- HEADING -->
<center><H1 style='color:#800000'>QUALITY DEVIATION NOTICE</H1></center>
<!-- START -->
<!-- PRODUCT DESCRIPTION/ PROBLEM DETAILS -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
        PRODUCT DESCRIPTION/ PROBLEM DETAILS
        @if ($show)
        <a
            target         = "_blank"
            href           = "{{ route('pdf', ['slug'=> $qdn->slug]) }}"
            class          = "edit link"
            >
            print
            <i class="fa fa-print"></i>
        </a>
        @if ($currentUser->access_level == 'Admin' || strpos(Request::url(), 'report/'.$qdn->slug) != 0)
        <a
            class       = 'edit link'
            data-toggle = 'modal'
            href        = '#edit'
            >
            {{ $qdn->closure->status == 'p.e. verification' && $currentUser->employee->department == 'process' ? 'verify' : 'edit' }}
            <i class="fa fa-edit"></i>
        </a>
        @endif
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
                    <p class="customer">{{ Str::upper($qdn->customer) }}</p>
                </div>
            </div>
            <!-- PACKAGE TYPE -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">
                    Package Type:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                    <p class="package_type">{{ Str::upper($qdn->package_type) }}</p>
                </div>
            </div>
            <!-- DEVICE NAME -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">
                    Device Name:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                    <p class="device_name">{{ Str::upper($qdn->device_name) }}</p>
                </div>
            </div>
            <!-- LOT ID NUMBER -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">
                    Lot ID No.:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                    <p class="lot_id_number">{{ Str::upper($qdn->lot_id_number) }}</p>
                </div>
            </div>
            <!-- LOT QUANTITY -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">
                    Lot Quantity:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                    <p class="lot_quantity">{{ $qdn->lot_quantity }}</p>
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
                    <p class="job_order_number">{{ $qdn->job_order_number }}</p>
                </div>
            </div>
            <!-- MACHINE -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">
                    Machine:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                    <p class="machine">{{ Str::upper($qdn->machine) }}</p>
                </div>
            </div>
            <!-- STATION -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">
                    Station:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                    <p class="station">{{ Str::upper($qdn->station) }}</p>
                </div>
            </div>
            <!-- MAJOR -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">Major:</div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 text-left text-major">
                    {{ $qdn->major == "major" ? '[x]' : '[&nbsp;&nbsp;]' }}
                </div>
            </div>
            <!-- MINOR -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">Minor:</div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 text-left text-minor">
                    {{ $qdn->major != "major" ? '[x]' : '[&nbsp;&nbsp;]' }}
                </div>
            </div>
        </div>
        <!-- THIRD COLUMN -->
        <div class="col-lg-4 col-md-6 col-sm-6 text-left">
            <!-- QDN NO -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">QDN No.:</div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                    <p class="control_id">
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
                    <p class="team_responsible">
                        {!! Str::upper(implode("<br>",$department)) !!}
                    </p>
                </div>
            </div>
            <!-- ISSUED BY -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">Issued By:</div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                    <p class="originator_name">
                        {{ Str::title($qdn->involvePerson()->select('originator_name')->first()->originator_name) }}
                    </p>
                </div>
            </div>
            <!-- ISSUED TO -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 bold">Issued To:</div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                    <p class="receiver_name">
                        {!!
                        Str::title(implode("<br>",array_flatten(
                        $qdn->involvePerson()
                        ->select('receiver_name')
                        ->get()
                        ->toArray()))
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
        <div class="container text-center col-lg-12 col-sm-12 problem_description">
            <br/><br/>
            {{
            $qdn->problem_description == ""
            ? "<br/><br/>"
            : $qdn->problem_description
            }}
        </div>
    </div>
</div>