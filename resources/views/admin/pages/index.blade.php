@extends('admin.main')
@push('styles')
<style type="text/css">
.brighten {
background-color: #fff;
-webkit-filter: brightness(100%);
-webkit-transition: all .5s ease;
-moz-transition: all .5s ease;
-o-transition: all .5s ease;
-ms-transition: all .5s ease;
transition: all .5s ease;
}
.brighten:hover {
-webkit-filter: brightness(95%);
/*border: 1px solid #800;*/
/*-webkit-transform: scale(1.03);
transform: scale(1.03);*/
position: relative;
/*z-index: 1;*/
}
.panel-heading,
.panel-body {
border-radius: 1px;
}
select.input-lg {
border:0px;
}
.progress {
height: 3px;
}
</style>
@endpush
@section('content')
@foreach ($status as $panel)
<div class="col-md-3">
    <div class="row-fluid">
        <ul class="list-group"><li class="list-group-item">
            <div class="container-fluid text-center">
                {{ $panel[2] }}
                <hr class="danger">
                <h1 class="text-center">{{ $panel[0] }}</h1>
            </div>
        </li></ul>
    </div>
</div>
@endforeach
<div class="col-md-12">
    <ul class="list-group">
        <li class="list-group-item">
            <!-- LABEL -->
            <h4>Leading on
            <select name="month" id="month" class="input-lg">
                <option value="">All</option>
                @foreach ($months as $month)
                <option
                    value="{{ Carbon::parse($month)->format('m') }}"
                    @if (Carbon::parse($month)->format('m') == Carbon::now('Asia/Manila')->format('m'))
                    selected
                    @endif
                    >
                    {{ Str::title($month) }}
                </option>
                @endforeach
            </select>
            <!-- YEAR -->
            <select name="year" id="year" class="input-lg">
                @foreach ($years as $year)
                <option
                    value="{{ $year }}"
                    @if ($year == Carbon::now('Asia/Manila')->format('Y'))
                    selected
                    @endif
                    >
                    {{ Str::title($year) }}
                </option>
                @endforeach
            </select>
            </h4>
        </li>
    </ul>
</div>
<div class="col-md-8 " id="link">
    <ul class="list-group">
        <li class="list-group-item">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div id="qdnMetrics"></div>
                </div>
            </div>
        </li>
    </ul>

    <ul class="list-group">
        <li class="list-group-item">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div id="podGraph"></div>
                </div>
            </div>
        </li>
    </ul>
</div>
<div class="col-md-4">
    <ul class="list-group">
        <li class="list-group-item"><h4>Failure Mode</h4></li>
        @foreach ($ave as $name => $value)
        <li class="list-group-item">
            <strong>{{ $name }}</strong>
            <p id= "{{ str_slug($name,'-')."-count" }}"> {{ $count[$name] }}</p>
            <div class="progress">
                <div
                    id            = "{{ str_slug($name,'-') }}"
                    class         = " progress-bar progress-bar-danger"
                    role          = "progressbar"
                    aria-valuenow = "{{ $value }}"
                    aria-valuemin = "0"
                    aria-valuemax = "100"
                    style         = "width: {{ $value }}%;"
                    placeholder   = "{{ $value }}";
                    >
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>
<div class="col-md-4">
    <ul class="list-group">
        <li class="list-group-item"><h4>Recent Issued QDN</h4></li>
        @foreach ($qdn as $issue)
        <li class="list-group-item">
            <h5>{{ $issue->discrepancy_category }} <span class="label label-success pull-right">{{ $issue->closure->status }}</span></h5>
            <div class="row-fluid justify">
                {{ $issue->problem_description }}
            </div>
        </li>
        @endforeach
    </ul>
</div>
<div class="clearfix"></div>
@include('home.modals')
@stop
@push('scripts')
<script src="/vendor/js/highcharts.js"></script>
<script src="/vendor/js/exporting.js"></script>
<script src="/js/homeScript.js"></script>
<script>
$(function() {
    //highcharts =======================================================
var month = $('#month').val(),
year = $('#year').val(),
slug = function(str) {
var $slug = '';
var trimmed = $.trim(str);
$slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
replace(/-+/g, '-').
replace(/^-|-$/g, '');
return $slug.toLowerCase();
},
updateLead = function(month, year){
$.ajax({
url: '{{ route('UpdateLead') }}',
type: 'GET',
data: {
month: month,
year: year
},
success: function (data) {
if (data['ave'] == '') {
var pBarInit = $('.progress div.progress-bar');
pBarInit.parent('div.progress').siblings('p').text('0');
pBarInit.css({width: 0 + '%'});
pBarInit.attr('aria-valuenow', 0);
pBarInit.attr('title', '0%');
} else {
$.each(data['ave'], function( index, value ) {
var pBar = $('.progress div.progress-bar#' + slug(index));
pBar.parent('div.progress').siblings('p#' + slug(index) + '-count').text(data['count'][index]);
pBar.css({width: value + '%'});
pBar.attr('aria-valuenow',value);
pBar.attr('title', value + '%');
});
}
},
error: function() {
alert('error');
}
});
AjaxParetoOfDiscrepancy();
},
AjaxQdnMetrics = function() {
        var year = $('#year').val(),
            month = $('#month').val();
        $.ajax({
            url: '/ajax',
            method: 'GET',
            data: {
                month: month,
                year: year
            },
            success: function(point) {
                count = 1;
                for (i = 0; i < point.qdn.length; i++) {
                    $('#tblQdnMetrics')
                        .find("td:nth-of-type(" + count + ")")
                        .text(point.qdn[i]);
                    count += 1;
                }
                qdnMetrics.series[0].setData(point.qdn);
                // refresh DOM every 5sec
                setInterval(AjaxQdnMetrics(), 5000);
            },
            error: function() {
                AjaxQdnMetrics();
            },
            cache: false
        });
    },
    AjaxParetoOfDiscrepancy = function() {
        var tbody = $("#tblQdnMetrics tbody#pareto-data"),
            year = $('#year').val(),
            month = $('#month').val(),
            loader = '<tr><td colspan="3"><div class="col-xs-12 text-center" id="loader"><i class="fa fa-spinner fa-pulse fa-2x"></i></div></td></tr>';
        tbody.empty();
        tbody.append(loader);

        $.ajax({
            url: '/ajax',
            method: 'GET',
            data: {
                month: month,
                year: year
            },
            success: function(point) {
                bars = point.pod.bars;
                category = point.pod.category;
                legend = point.pod.legends;
                lines = point.pod.lines;
                total = point.pod.total;
                podGraph.tooltip.options.formatter = function() {
                    if (this.series.name == '% Pareto') {
                        var pcnt = Highcharts.numberFormat((this.y / total * 100), 0, '.'); //TOTAL
                        return pcnt + '%';
                    }
                    return this.y;
                };
                podGraph.yAxis[1].update({
                    tickInterval: total / 4, //TOTAL
                    labels: {
                        formatter: function() {
                            var pcnt = Highcharts.numberFormat((this.value / total * 100), 0, '.'); //TOTAL
                            return pcnt + '%';
                        }
                    }
                });
                podGraph.xAxis[0].categories = legend;
                podGraph.series[1].setData(lines);
                podGraph.series[0].setData(bars);
                tbody.empty();
                if (total == 0) {
                    tbody.append('<tr><td colspan="3" class="text-center">No data to show</td></tr>');
                } else {
                    count = 1;
                    for (i = 0; i < point.pod.lines.length; i++) {
                        tbody.append(
                            $("<tr></tr>")
                                .append("<td><a target='_blank' href='" + window.location.href + "pareto?month=" + month + "&year=" + year + "&discrepancy=" + category[i] + "&category=pod'>" + legend[i] + "</a></td>")
                                .append("<td><a target='_blank' href='" + window.location.href + "pareto?month=" + month + "&year=" + year + "&discrepancy=" + category[i] + "&category=pod'>" + category[i] + "</a></td>")
                                .append("<td><a target='_blank' href='" + window.location.href + "pareto?month=" + month + "&year=" + year + "&discrepancy=" + category[i] + "&category=pod'>" + bars[i] + "</a></td>")
                        );
                        count += 1;
                    }
                    tbody.append(
                        $("<tr class='warning'></tr>")
                            .append("<td colspan='2' class='h4 text-left'><a target='_blank' href='" + window.location.href + "pareto?month=" + month + "&year=" + year + "&category=total'><strong>TOTAL : </strong></a></td>")
                            .append("<td colspan='2' class='h4 text-left'><a target='_blank' href='" + window.location.href + "pareto?month=" + month + "&year=" + year + "&category=total'>" + total + "</a></td>")
                    );
                }
            },
            cache: false
        });
    };
    // VARIABLES ENDING ==============================================================================
AjaxParetoOfDiscrepancy();
AjaxQdnMetrics();
//GET MONTH
$('#month').on('change', function(event) {
event.preventDefault();
/* Act on the event */
var self = $(this);
month = self.val();
updateLead(month, year);
});
//GET YEAR
$('#year').on('change', function(event) {
event.preventDefault();
/* Act on the event */
var self = $(this);
year = self.val();
updateLead(month, year);

});
});
</script>
@endpush