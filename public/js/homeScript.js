
function qdnData(givenDate, rowFile) {
    $.ajax({
        url: '/qdn-data',
        type: 'GET',
        data: {
            setDate: givenDate
        },
        success: function(data) {
            if (data != '') {
                rowFile.append(data);
            } else {
                rowFile.empty();
                rowFile.append('<tr></tr>');
                $('<td></td>', {
                    colspan: "10",
                    class: "text-center",
                    text: "No data to show"
                }).appendTo(rowFile.children('tr'));
            }
        },
        cache: false
    });
}


function requestData() {
    $.ajax({
        url: '/ajax',
        success: function(point) {
            if (datus != point.qdn) {
                datus = point.qdn;
                count = 1;

                for (i = 0; i < point.qdn.length; i++) {

                    $('#tblQdnMetrics')
                        .find("td:nth-of-type(" + count + ")")
                        .text(datus[i]);

                    qdnMetrics.series[0].data[i].update(datus[i]);
                    count += 1;

                }

            }
            setTimeout(requestData, 1000);
        },
        cache: false
    });
}
//======================================================================================
$('#pod').on('show.bs.modal', function() {
    $.ajax({
        url: '/ajax',
        success: function(point) {
            bars = point.pod.bars;
            category = point.pod.category;
            legend = point.pod.legends;
            lines = point.pod.lines;
            total = point.pod.total;

            podGraph.series[1].update(
                {
                    tooltip: {
                        formatter: function() {
                            if (podGraph.series.name == '% Pareto') {
                                var pcnt = Highcharts.numberFormat((this.y / total * 100), 0, '.'); //TOTAL
                                return pcnt + '%';
                            }
                            return this.y;
                        }
                    }
                });
            podGraph.yAxis[1].update({
                tickInterval: total / 4, //TOTAL
                labels: {
                    formatter: function() {
                        var pcnt = Highcharts.numberFormat((this.value / total * 100), 0, '.'); //TOTAL
                        return pcnt + '%';
                    }
                }

            });


            var tbody = $("tbody#pareto-data");
            tbody.empty();
            for (i = 0; i < point.pod.lines.length; i++) {
                tbody.append(
                    $("<tr></tr>")
                        .append("<td>" + legend[i] + "</td>")
                        .append("<td>" + category[i] + "</td>")
                        .append("<td>" + bars[i] + "</td>")
                );
                podGraph.series[1].data[i].update(lines[i]);
                podGraph.series[0].data[i].update(bars[i]);
                count += 1;

            }
            $("tbody#pareto-data").append(
                $("<tr></tr>")
                    .append("<td colspan='2' class='h4 text-left'><strong>TOTAL : </strong></td>")
                    .append("<td>" + total + "</td>")
            );

        },
        cache: false
    });
});
$('#today').on('show.bs.collapse', function() {
    var rowFile = $(this).find("tbody");
    qdnData('today', rowFile)

    $('#week').collapse('hide');
    $('#month').collapse('hide');
    $('#year').collapse('hide');
});

$('#week').on('show.bs.collapse', function() {
    var rowFile = $(this).find("tbody");
    qdnData('week', rowFile)

    $('#today').collapse('hide');
    $('#month').collapse('hide');
    $('#year').collapse('hide');
});

$('#month').on('show.bs.collapse', function() {
    var rowFile = $(this).find("tbody");
    qdnData('month', rowFile)

    $('#today').collapse('hide');
    $('#week').collapse('hide');
    $('#year').collapse('hide');
});

$('#year').on('show.bs.collapse', function() {
    var rowFile = $(this).find("tbody");
    qdnData('year', rowFile)

    $('#week').collapse('hide');
    $('#month').collapse('hide');
    $('#today').collapse('hide');
});

var qdnMetrics;

/**
 * Request data from the server, add it to the graph and set a timeout
 * to request again
 */

qdnMetrics = new Highcharts.Chart({ //start of qdnMetrics
    chart: {
        renderTo: 'qdnMetrics',
        zoomType: 'xy',
        events: {
            load: requestData
        }
    },
    title: {
        text: "QDN January - December " + yearNow
    },
    subtitle: {
        text: 'Source: QDN System'
    },
    xAxis: [{
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        crosshair: true
    }],
    yAxis: [{
        min: 0,
        endOnTick: false,
        lineColor: '#999',
        lineWidth: 1,
        tickColor: '#666',
        tickWidth: 1,
        tickLength: 3,
        gridLineColor: '#ddd',
        title: {
            text: 'Counts',
            rotation: 270
        }
    }],
    tooltip: {
        shared: true
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        x: 0,
        verticalAlign: 'top',
        y: 0,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
    },
    series: [{
        name: 'Actual',
        type: 'column',
        color: '#800000',
        data: datus

    }, {
        name: 'Target',
        type: 'line',
        color: '#000000',
        data: [5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5]
    }]
}); //end of qdnMetrics



$('#modalQdnMetrics').on('show.bs.modal', function() {
    $('#qdnMetrics').css('visibility', 'hidden');
});
$('#modalQdnMetrics').on('shown.bs.modal', function() {
    $('#qdnMetrics').css('visibility', 'initial');
    qdnMetrics.reflow();
});
// ===========================================================================================
//start of pareto
var podGraph = new Highcharts.Chart({
    chart: {
        renderTo: 'podGraph',
        defaultSeriesType: 'column',
        borderColor: '#ccc',
        alignTicks: false
    //backgroundColor:'#eee',
    //plotBackgroundColor:'#fff',
    },
    title: {
        text: 'Pareto of Discrepancy'
    },
    tooltip: {
        formatter: function() {
            if (this.series.name == '% Pareto') {
                var pcnt = Highcharts.numberFormat((this.y / total * 100), 0, '.'); //TOTAL
                return pcnt + '%';
            }
            return this.y;
        }
    },
    plotOptions: {
        series: {
            shadow: false,
        }
    },
    xAxis: {
        categories: legends, //TITLE
        lineColor: '#999',
        lineWidth: 1,
        tickColor: '#666',
        tickLength: 3
    },

    yAxis: [{
        min: 0,
        endOnTick: false,
        lineColor: '#999',
        lineWidth: 1,
        tickColor: '#666',
        tickWidth: 1,
        tickLength: 3,
        gridLineColor: '#ddd',
        title: {
            text: 'Counts',
            rotation: 270
        }
    }, {
        title: {
            text: '% Pareto',
            rotation: 270
        },
        alignTicks: false,
        gridLineWidth: 0,
        lineColor: '#999',
        lineWidth: 1,
        tickColor: '#666',
        tickWidth: 1,
        tickLength: 3,
        tickInterval: total / 4, //TOTAL
        endOnTick: false,
        opposite: true,
        linkedTo: 0,
        labels: {
            formatter: function() {
                var pcnt = Highcharts.numberFormat((this.value / total * 100), 0, '.'); //TOTAL
                return pcnt + '%';
            }
        }
    }],
    series: [{
        //yAxis:0,
        name: 'Count',
        color: '#800000',
        data: bars
    }, {
        type: 'line',
        name: '% Pareto',
        color: '#000000',
        //yAxis:0,
        data: lines
    }]
}); //end of pareto

$('#pod').on('show.bs.modal', function() {
    $('#podGraph').css('visibility', 'hidden');
});
$('#pod').on('shown.bs.modal', function() {
    $('#podGraph').css('visibility', 'initial');
    podGraph.reflow();
});

$.ajaxSetup({
    headers: {
        'X-CSRF-Token': $('meta[name=_token]').attr('content')
    }
});