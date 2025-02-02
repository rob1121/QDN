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

    select.input-lg {
        border: 0px;
    }

    .progress {
        height: 3px;
    }

    #link {
        margin-bottom: 32px;
    }

    #link div .row {
        margin-top: 5px;
        margin-left: 5px;
        margin-row: 5px;
    }

    #link div {
        margin: 0px;
        padding: 0px;
    }

    .modal-body {
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

    .panel-primary > .panel-heading {
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

    .recent__date {
        font-weight: lighter;
        transition: .3s;
    }

    .recent {
        background-color: #f9f9f9;
        cursor: default;
        transition: .3s;
    }

    .recent:hover {
        transform:scale(1.05,1);
        background-color: #fff;
    }

    .recent:hover .recent__date {
        font-weight: normal;
    }
</style>
@endpush
@section('content')
    @foreach ($counts as $panel)
        <div class="col-xs-3 h2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $panel[2] }}</h3>
                </div>
                <div class="panel-body" id="{{ $panel[4] }}">
                    {{ $panel[0] }}
                </div>
                <a class="h5" target="_blank" href="/pareto?category={{ $panel[3] }}">
                    <div
                            class="panel-footer"
                    >
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
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
        <div id="qdnMetrics"></div>
        <br>
        <br>
        <div id="podGraph"></div>
        <table class="pod__table">
            <tr class="pod__row">
                <td class="pod__legend">None</td>
                <td class="pod__category">None</td>
            </tr>
        </table>
        <br>
        <br>
        <div id="cycleTimeGraph"></div>
        <br>
        <br>
        <div id="pie"></div>
    </div>
    <div class="col-md-4">
        <ul class="list-group">
            <li class="list-group-item"><a data-toggle="modal" href="#{{ $charts[$id = 2]['id'] }}"><h4>Failure
                        Mode</h4></a></li>
            @foreach ($ave as $name => $value)
                <li class="list-group-item">
                    <a data-toggle="modal" href="#{{ $charts[++$id]['id'] }}"><strong>{{ $name }}</strong></a>
                    <p id="{{ str_slug($name,'-')."-count" }}"> {{ $count[$name] }}</p>
                    <div class="progress">
                        <div
                                id="{{ str_slug($name,'-') }}"
                                class=" progress-bar progress-bar-danger"
                                role="progressbar"
                                aria-valuenow="{{ $value }}"
                                aria-valuemin="0"
                                aria-valuemax="100"
                                style="width: {{ $value }}%;"
                                placeholder="{{ $value }}" ;
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
                <li class="list-group-item recent">
                    <h5>
                        <strong>{{ $issue->discrepancy_category }}</strong>
                        <span class="recent__date">{{ diffForHumans($issue->created_at) }}</span>
                        @if($issue->closure->status != 'Closed')
                            <span class="label  label-primary pull-right"></span>
                        @else
                            <span class="label  label-success pull-right"></span>
                        @endif
                    </h5>
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
    $(function () {


        var cycleTimeGraph = new Highcharts.Chart({ //start of cycleTimeGraph
            chart: {
                renderTo: 'cycleTimeGraph',
                marginTop: 50,
                reflow: false
            },
            title: {
                text: "QDN Cycle Time January - December " + yearNow,
                margin: 35
            },
            subtitle: {
                text: 'Source: QDN System'
            },
            xAxis: [{
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ],
                crosshair: true
            }],
            yAxis: chartContent.yAxis[0],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                margin: 25,
                itemDistance: 50,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            series: [{
                name: 'Actual',
                type: 'column',
                color: '#800000'
            }, {
                name: 'Target',
                type: 'line',
                color: '#000000',
                data: [24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24]
            }]
        }); //end of cycleTimeGraph
//highcharts =======================================================
        var month = $('#month').val(),
                year = $('#year').val(),
                slug = function (str) {
                    var $slug = '';
                    var trimmed = $.trim(str);
                    $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
                    return $slug.toLowerCase();
                },
                updateLead = function (month, year) {
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
                                $.each(data['ave'], function (index, value) {
                                    var pBar = $('.progress div.progress-bar#' + slug(index));
                                    pBar.parent('div.progress').siblings('p#' + slug(index) + '-count').text(data['count'][index]);
                                    pBar.css({width: value + '%'});
                                    pBar.attr('aria-valuenow', value);
                                    pBar.attr('title', value + '%');
                                });
                            }
                        },
                        error: function () {
                            alert('error');
                        }
                    });
                    AjaxParetoOfDiscrepancy();
                },
                AjaxQdnMetrics = function () {
                    var year = $('#year').val(),
                            month = $('#month').val();
                    $.ajax({
                        url: '/ajax',
                        method: 'GET',
                        data: {
                            month: month,
                            year: year
                        },
                        success: function (point) {
                            count = 1;
                            for (i = 0; i < point.qdn.length; i++) {
                                $('#tblQdnMetrics')
                                        .find("td:nth-of-type(" + count + ")")
                                        .text(point.qdn[i]);
                                count += 1;
                            }
                            qdnMetrics.series[0].setData(point.qdn);
// refresh DOM every 5sec
                            setTimeout(AjaxQdnMetrics, 60000);
                        },
                        error: function () {
                            AjaxQdnMetrics();
                        },
                        cache: false
                    });
                },
                AjaxParetoOfDiscrepancy = function () {
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
                        success: function (point) {
                            console.log(point.pod.category);

                            bars = point.pod.bars;
                            category = point.pod.category;
                            legend = point.pod.category;
//                            legend = point.pod.legends;
                            lines = point.pod.lines;
                            total = point.pod.total;

                            podGraph.tooltip.options.formatter = function () {
                                if (this.series.name == '% Pareto') {
                                    var pcnt = Highcharts.numberFormat((this.y / total * 100), 0, '.'); //TOTAL
                                    return pcnt + '%';
                                }
                                return this.y;
                            };
                            podGraph.yAxis[1].update({
                                tickInterval: total / 4, //TOTAL
                                labels: {
                                    formatter: function () {
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
                                                    .append("<td><a target='_blank' href='/pareto?month=" + month + "&year=" + year + "&discrepancy=" + category[i] + "&category=pod'>" + legend[i] + "</a></td>")
                                                    .append("<td><a target='_blank' href='/pareto?month=" + month + "&year=" + year + "&discrepancy=" + category[i] + "&category=pod'>" + category[i] + "</a></td>")
                                                    .append("<td><a target='_blank' href='/pareto?month=" + month + "&year=" + year + "&discrepancy=" + category[i] + "&category=pod'>" + bars[i] + "</a></td>")
                                    );
                                    count += 1;
                                }
                                tbody.append(
                                        $("<tr class='warning'></tr>")
                                                .append("<td colspan='2' class='h4 text-left'><a target='_blank' href='/pareto?month=" + month + "&year=" + year + "&category=total'><strong>TOTAL : </strong></a></td>")
                                                .append("<td colspan='2' class='h4 text-left'><a target='_blank' href='/pareto?month=" + month + "&year=" + year + "&category=total'>" + total + "</a></td>")
                                );
                            }
                        },
                        cache: false
                    });
                },
                AjaxCycleTime = function () {
                    var year = $('#year').val(),
                            month = $('#month').val();
                    $.ajax({
                        url: '/api/cycle-time-pareto',
                        success: function (point) {
                            count = 1;
                            for (i = 0; i < point.length; i++) {
                                $('#tblQdnMetrics')
                                        .find("td:nth-of-type(" + count + ")")
                                        .text(point[i]);
                                count += 1;
                            }
                            cycleTimeGraph.series[0].setData(point);
// refresh DOM every 5sec
                            setTimeout(AjaxCycleTime, 60000);
                        },
                        error: function () {
                            AjaxCycleTime();
                        },
                        cache: false
                    });
                };
// VARIABLES ENDING ==============================================================================
        AjaxParetoOfDiscrepancy();
        AjaxCycleTime();
        AjaxQdnMetrics();
//GET MONTH
        $('#month').on('change', function (event) {
            event.preventDefault();
            /* Act on the event */
            var self = $(this);
            month = self.val();
            updateLead(month, year);
        });
//GET YEAR
        $('#year').on('change', function (event) {
            event.preventDefault();
            /* Act on the event */
            var self = $(this);
            year = self.val();
            updateLead(month, year);
        });
        $.ajax({
            url: "/api/station-pie-data",
            success: function(pieDataForStation) {

                // Build the chart
                $('#pie').highcharts({
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: 'Pie chart of stations with highest contributor (as of {{ Carbon::now("Asia/Manila")->format("M Y") }} )'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        name: '%',
                        colorByPoint: true,
                        data: pieDataForStation
                    }]
                });
            }
        });

    });
</script>
@endpush