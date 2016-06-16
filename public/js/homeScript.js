function qdnData(givenDate, rowFile) {

    rowFile.empty();
    var loader = '<tr><td colspan="6"><div class="col-xs-12 text-center" id="loader"><i class="fa fa-spinner fa-pulse fa-2x"></i></div></td></tr>';
    rowFile.append(loader);
    $.ajax({
        url: link.qdn_data,
        type: 'GET',
        data: {
            setDate: givenDate
        },
        success: function (data) {
            rowFile.empty();
            if (data != '') {
                rowFile.append(data);
            } else {
                rowFile.append('<tr></tr>');
                $('<td></td>', {
                    colspan: "10",
                    class: "text-center",
                    text: "No data to show"
                }).appendTo(rowFile.children('tr'));
            }
        },
        error: function (givenDate, rowFile) {
            qdnData(givenDate, rowFile);
        },
        cache: false
    });
}
function status(status, rowFile) {
    rowFile.empty();
    var loader = '<tr><td colspan="6"><div class="col-xs-12 text-center" id="loader"><i class="fa fa-spinner fa-pulse fa-2x"></i></div></td></tr>';
    rowFile.append(loader);
    $.ajax({
        url: link.status,
        type: 'GET',
        data: {
            status: status
        },
        success: function (data) {
            rowFile.empty();

            if (data != '') {
                rowFile.append(data);
            } else {
                rowFile.append('<tr></tr>');
                $('<td></td>', {
                    colspan: "10",
                    class: "text-center",
                    text: "No data to show"
                }).appendTo(rowFile.children('tr'));
            }
        },
        error: function (status, rowFile) {
            status(status, rowFile);
        },
        cache: false
    });
}
//=============================================================================
$('#modalQdnMetrics').on('show.bs.modal', function () {
    var year = $('#year').val(),
        month = $('#month').val();
    $.ajax({
        url: link.ajax,
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
        },
        cache: false
    });
});

$('#pod').on('show.bs.modal', function () {
    var tbody = $("#tblQdnMetrics tbody#pareto-data"),
        year = $('#year').val(),
        month = $('#month').val(),
        loader = '<tr><td colspan="3"><div class="col-xs-12 text-center" id="loader"><i class="fa fa-spinner fa-pulse fa-2x"></i></div></td></tr>';
    tbody.empty();
    tbody.append(loader);

    $.ajax({
        url: link.ajax,
        method: 'GET',
        data: {
            month: month,
            year: year
        },
        success: function (point) {
            bars = point.pod.bars;
            category = point.pod.category;
            legend = point.pod.legends;
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
                    var preTD = "<td><a target='_blank' href='/pareto?month="
                        + month
                        + "&year="
                        + year
                        + "&discrepancy="
                        + category[i]
                        + "&category=pod'>";

                    tbody.append(
                        $("<tr></tr>")
                            .append(preTD + legend[i] + "</a></td>")
                            .append(preTD + category[i] + "</a></td>")
                            .append(preTD + bars[i] + "</a></td>")
                    );
                    count += 1;
                }
                var preTD = "<td colspan='2' class='h4 text-left'><a target='_blank' href='/pareto?month="
                    + month
                    + "&year="
                    + year
                    + "&category=total'>";

                tbody.append(
                    $("<tr class='warning'></tr>")
                        .append(preTD + "<strong>TOTAL : </strong></a></td>")
                        .append(preTD + total + "</a></td>")
                );
            }
        },
        cache: false
    });
});
$('#assemblyModal').on('show.bs.modal', function () {
    var tbody = $("#assemblyTable tbody#pareto-data"),
        year = $('#year').val(),
        month = $('#month').val(),
        loader = '<tr><td colspan="3"><div class="col-xs-12 text-center" id="loader"><i class="fa fa-spinner fa-pulse fa-2x"></i></div></td></tr>';
    tbody.empty();
    tbody.append(loader);
    $.ajax({
        url: link.ajax,
        method: 'GET',
        data: {
            month: month,
            year: year
        },
        success: function (point) {
            bars = point.assembly.bars;
            category = point.assembly.category;
            legend = point.assembly.legends;
            lines = point.assembly.lines;
            total = point.assembly.total;
            assemblyGraph.tooltip.options.formatter = function () {
                if (this.series.name == '% Pareto') {
                    var pcnt = Highcharts.numberFormat((this.y / total * 100), 0, '.'); //TOTAL
                    return pcnt + '%';
                }
                return this.y;
            };
            assemblyGraph.yAxis[1].update({
                tickInterval: total / 4, //TOTAL
                labels: {
                    formatter: function () {
                        var pcnt = Highcharts.numberFormat((this.value / total * 100), 0, '.'); //TOTAL
                        return pcnt + '%';
                    }
                }
            });
            assemblyGraph.xAxis[0].categories = legend;
            assemblyGraph.series[1].setData(lines);
            assemblyGraph.series[0].setData(bars);
            tbody.empty();
            if (total == 0) {
                tbody.append('<tr><td colspan="3" class="text-center">No data to show</td></tr>');
            } else {
                count = 1;
                for (i = 0; i < point.assembly.lines.length; i++) {
                    var preTD = "<td><a target='_blank' href='/pareto?month="
                        + month
                        + "&year="
                        + year
                        + "&discrepancy="
                        + category[i]
                        + "&category=failureMode'>";

                    tbody.append(
                        $("<tr></tr>")
                            .append(preTD + legend[i] + "</a></td>")
                            .append(preTD + category[i] + "</a></td>")
                            .append(preTD + bars[i] + "</a></td>")
                    );
                    count += 1;
                }
                var preTD = "<td colspan='2' class='h4 text-left'><a target='_blank' href='/pareto?month="
                    + month
                    + "&year="
                    + year
                    + "&discrepancy="
                    + category[0]
                    + "&category=failureMode'>";

                tbody.append(
                    $("<tr class='warning'></tr>")
                        .append(preTD + "<strong>TOTAL : </strong></a></td>")
                        .append(preTD + total + "</a></td>")
                );
            }
        },
        cache: false
    });
});
//=================================================================
$('#environmentModal').on('show.bs.modal', function () {
    var tbody = $("#environmentTable tbody#pareto-data"),
        year = $('#year').val(),
        month = $('#month').val(),
        loader = '<tr><td colspan="3"><div class="col-xs-12 text-center" id="loader"><i class="fa fa-spinner fa-pulse fa-2x"></i></div></td></tr>';
    tbody.empty();
    tbody.append(loader);
    $.ajax({
        url: link.ajax,
        method: 'GET',
        data: {
            month: month,
            year: year
        },
        success: function (point) {
            bars = point.environment.bars;
            category = point.environment.category;
            legend = point.environment.legends;
            lines = point.environment.lines;
            total = point.environment.total;
            environmentGraph.tooltip.options.formatter = function () {
                if (this.series.name == '% Pareto') {
                    var pcnt = Highcharts.numberFormat((this.y / total * 100), 0, '.'); //TOTAL
                    return pcnt + '%';
                }
                return this.y;
            };
            environmentGraph.yAxis[1].update({
                tickInterval: total / 4, //TOTAL
                labels: {
                    formatter: function () {
                        var pcnt = Highcharts.numberFormat((this.value / total * 100), 0, '.'); //TOTAL
                        return pcnt + '%';
                    }
                }
            });
            environmentGraph.xAxis[0].categories = legend;
            environmentGraph.series[1].setData(lines);
            environmentGraph.series[0].setData(bars);
            tbody.empty();
            if (total == 0) {
                tbody.append('<tr><td colspan="3" class="text-center">No data to show</td></tr>');
            } else {
                count = 1;
                for (i = 0; i < point.environment.lines.length; i++) {
                    var preTD = "<td><a target='_blank' href='/pareto?month="
                        + month
                        + "&year="
                        + year
                        + "&discrepancy="
                        + category[i]
                        + "&category=failureMode'>";

                    tbody.append(
                        $("<tr></tr>")
                            .append(preTD + legend[i] + "</a></td>")
                            .append(preTD + category[i] + "</a></td>")
                            .append(preTD + bars[i] + "</a></td>")
                    );
                    count += 1;
                }
                var preTD = "<td colspan='2' class='h4 text-left'><a target='_blank' href='/pareto?month="
                    + month
                    + "&year="
                    + year
                    + "&discrepancy="
                    + category[0]
                    + "&category=failureMode'>";

                tbody.append(
                    $("<tr class='warning'></tr>")
                        .append(preTD + "<strong>TOTAL : </strong></a></td>")
                        .append(preTD + total + "</a></td>")
                );
            }
        },
        cache: false
    });
});
//====================================================================
$('#failureModeModal').on('show.bs.modal', function () {
    var tbody = $("#failureModeTable tbody#pareto-data"),
        year = $('#year').val(),
        month = $('#month').val(),
        loader = '<tr><td colspan="3"><div class="col-xs-12 text-center" id="loader"><i class="fa fa-spinner fa-pulse fa-2x"></i></div></td></tr>';
    tbody.empty();
    tbody.append(loader);
    $.ajax({
        url: link.ajax,
        method: 'GET',
        data: {
            month: month,
            year: year
        },
        success: function (point) {
            bars = point.failureMode.bars;
            category = point.failureMode.category;
            legend = point.failureMode.legends;
            lines = point.failureMode.lines;
            total = point.failureMode.total;
            failureModeGraph.tooltip.options.formatter = function () {
                if (this.series.name == '% Pareto') {
                    var pcnt = Highcharts.numberFormat((this.y / total * 100), 0, '.'); //TOTAL
                    return pcnt + '%';
                }
                return this.y;
            };
            failureModeGraph.yAxis[1].update({
                tickInterval: total / 4, //TOTAL
                labels: {
                    formatter: function () {
                        var pcnt = Highcharts.numberFormat((this.value / total * 100), 0, '.'); //TOTAL
                        return pcnt + '%';
                    }
                }
            });
            failureModeGraph.xAxis[0].categories = legend;
            failureModeGraph.series[1].setData(lines);
            failureModeGraph.series[0].setData(bars);
            tbody.empty();
            if (total == 0) {
                tbody.append('<tr><td colspan="3" class="text-center">No data to show</td></tr>');
            } else {
                count = 1;
                for (i = 0; i < point.failureMode.lines.length; i++) {
                    var preTD = "<td><a target='_blank' href='/pareto?month="
                        + month
                        + "&year="
                        + year
                        + "&discrepancy="
                        + category[i]
                        + "&category=failureMode'>";

                    tbody.append(
                        $("<tr></tr>")
                            .append(preTD + legend[i] + "</a></td>")
                            .append(preTD + category[i] + "</a></td>")
                            .append(preTD + bars[i] + "</a></td>")
                    );
                    count += 1;
                }
                var preTD = "<td colspan='2' class='h4 text-left'><a target='_blank' href='/pareto?month="
                    + month
                    + "&year="
                    + year
                    + "&category=total'>";

                tbody.append(
                    $("<tr class='warning'></tr>")
                        .append(preTD + "<strong>TOTAL : </strong></a></td>")
                        .append(preTD + total + "</a></td>")
                );
            }
        },
        cache: false
    });
});
//====================================================================
$('#machineModal').on('show.bs.modal', function () {
    var tbody = $("#machineTable tbody#pareto-data"),
        year = $('#year').val(),
        month = $('#month').val(),
        loader = '<tr><td colspan="3"><div class="col-xs-12 text-center" id="loader"><i class="fa fa-spinner fa-pulse fa-2x"></i></div></td></tr>';
    tbody.empty();
    tbody.append(loader);
    $.ajax({
        url: link.ajax,
        method: 'GET',
        data: {
            month: month,
            year: year
        },
        success: function (point) {
            bars = point.machine.bars;
            category = point.machine.category;
            legend = point.machine.legends;
            lines = point.machine.lines;
            total = point.machine.total;
            machineGraph.tooltip.options.formatter = function () {
                if (this.series.name == '% Pareto') {
                    var pcnt = Highcharts.numberFormat((this.y / total * 100), 0, '.'); //TOTAL
                    return pcnt + '%';
                }
                return this.y;
            };
            machineGraph.yAxis[1].update({
                tickInterval: total / 4, //TOTAL
                labels: {
                    formatter: function () {
                        var pcnt = Highcharts.numberFormat((this.value / total * 100), 0, '.'); //TOTAL
                        return pcnt + '%';
                    }
                }
            });
            machineGraph.xAxis[0].categories = legend;
            machineGraph.series[1].setData(lines);
            machineGraph.series[0].setData(bars);
            tbody.empty();
            if (total == 0) {
                tbody.append('<tr><td colspan="3" class="text-center">No data to show</td></tr>');
            } else {
                count = 1;
                for (i = 0; i < point.machine.lines.length; i++) {
                    var preTD = "<td><a target='_blank' href='/pareto?month="
                        + month
                        + "&year="
                        + year
                        + "&discrepancy="
                        + category[i]
                        + "&category=failureMode'>";

                    tbody.append(
                        $("<tr></tr>")
                            .append(preTD + legend[i] + "</a></td>")
                            .append(preTD + category[i] + "</a></td>")
                            .append(preTD + bars[i] + "</a></td>")
                    );
                    count += 1;
                }
                var preTD = "<td colspan='2' class='h4 text-left'><a target='_blank' href='/pareto?month="
                    + month
                    + "&year="
                    + year
                    + "&discrepancy="
                    + category[0]
                    + "&category=failureMode'>";

                tbody.append(
                    $("<tr class='warning'></tr>")
                        .append(preTD + "<strong>TOTAL : </strong></a></td>")
                        .append(preTD + total + "</a></td>")
                );
            }
        },
        cache: false
    });
});
//====================================================================
$('#manModal').on('show.bs.modal', function () {
    var tbody = $("#manTable tbody#pareto-data"),
        year = $('#year').val(),
        month = $('#month').val(),
        loader = '<tr><td colspan="3"><div class="col-xs-12 text-center" id="loader"><i class="fa fa-spinner fa-pulse fa-2x"></i></div></td></tr>';
    tbody.empty();
    tbody.append(loader);
    $.ajax({
        url: link.ajax,
        method: 'GET',
        data: {
            month: month,
            year: year
        },
        success: function (point) {
            bars = point.man.bars;
            category = point.man.category;
            legend = point.man.legends;
            lines = point.man.lines;
            total = point.man.total;
            manGraph.tooltip.options.formatter = function () {
                if (this.series.name == '% Pareto') {
                    var pcnt = Highcharts.numberFormat((this.y / total * 100), 0, '.'); //TOTAL
                    return pcnt + '%';
                }
                return this.y;
            };
            manGraph.yAxis[1].update({
                tickInterval: total / 4, //TOTAL
                labels: {
                    formatter: function () {
                        var pcnt = Highcharts.numberFormat((this.value / total * 100), 0, '.'); //TOTAL
                        return pcnt + '%';
                    }
                }
            });
            manGraph.xAxis[0].categories = legend;
            manGraph.series[1].setData(lines);
            manGraph.series[0].setData(bars);
            tbody.empty();
            if (total == 0) {
                tbody.append('<tr><td colspan="3" class="text-center">No data to show</td></tr>');
            } else {
                count = 1;
                for (i = 0; i < point.man.lines.length; i++) {
                    var preTD = "<td><a target='_blank' href='/pareto?month="
                        + month
                        + "&year="
                        + year
                        + "&discrepancy="
                        + category[i]
                        + "&category=failureMode'>";

                    tbody.append(
                        $("<tr></tr>")
                            .append(preTD + legend[i] + "</a></td>")
                            .append(preTD + category[i] + "</a></td>")
                            .append(preTD + bars[i] + "</a></td>")
                    );
                    count += 1;
                }
                var preTD = "<td colspan='2' class='h4 text-left'><a target='_blank' href='/pareto?month="
                    + month
                    + "&year="
                    + year
                    + "&discrepancy="
                    + category[0]
                    + "&category=failureMode'>";

                tbody.append(
                    $("<tr class='warning'></tr>")
                        .append(preTD + "<strong>TOTAL : </strong></a></td>")
                        .append(preTD + total + "</a></td>")
                );
            }
        },
        cache: false
    });
});
//====================================================================
$('#materialModal').on('show.bs.modal', function () {
    var tbody = $("#materialTable tbody#pareto-data"),
        year = $('#year').val(),
        month = $('#month').val(),
        loader = '<tr><td colspan="3"><div class="col-xs-12 text-center" id="loader"><i class="fa fa-spinner fa-pulse fa-2x"></i></div></td></tr>';
    tbody.empty();
    tbody.append(loader);
    $.ajax({
        url: link.ajax,
        method: 'GET',
        data: {
            month: month,
            year: year
        },
        success: function (point) {
            bars = point.material.bars;
            category = point.material.category;
            legend = point.material.legends;
            lines = point.material.lines;
            total = point.material.total;
            materialGraph.tooltip.options.formatter = function () {
                if (this.series.name == '% Pareto') {
                    var pcnt = Highcharts.numberFormat((this.y / total * 100), 0, '.'); //TOTAL
                    return pcnt + '%';
                }
                return this.y;
            };
            materialGraph.yAxis[1].update({
                tickInterval: total / 4, //TOTAL
                labels: {
                    formatter: function () {
                        var pcnt = Highcharts.numberFormat((this.value / total * 100), 0, '.'); //TOTAL
                        return pcnt + '%';
                    }
                }
            });
            materialGraph.xAxis[0].categories = legend;
            materialGraph.series[1].setData(lines);
            materialGraph.series[0].setData(bars);
            tbody.empty();
            if (total == 0) {
                tbody.append('<tr><td colspan="3" class="text-center">No data to show</td></tr>');
            } else {
                count = 1;
                for (i = 0; i < point.material.lines.length; i++) {
                    var preTD = "<td><a target='_blank' href='/pareto?month="
                        + month
                        + "&year="
                        + year
                        + "&discrepancy="
                        + category[i]
                        + "&category=failureMode'>";

                    tbody.append(
                        $("<tr></tr>")
                            .append(preTD + legend[i] + "</a></td>")
                            .append(preTD + category[i] + "</a></td>")
                            .append(preTD + bars[i] + "</a></td>")
                    );
                    count += 1;
                }
                var preTD = "<td colspan='2' class='h4 text-left'><a target='_blank' href='/pareto?month="
                    + month
                    + "&year="
                    + year
                    + "&discrepancy="
                    + category[0]
                    + "&category=failureMode'>";

                tbody.append(
                    $("<tr class='warning'></tr>")
                        .append(preTD + "<strong>TOTAL : </strong></a></td>")
                        .append(preTD + total + "</a></td>")
                );
            }
        },
        cache: false
    });
});
//====================================================================
$('#processModal').on('show.bs.modal', function () {
    var tbody = $("#processTable tbody#pareto-data"),
        year = $('#year').val(),
        month = $('#month').val(),
        loader = '<tr><td colspan="3"><div class="col-xs-12 text-center" id="loader"><i class="fa fa-spinner fa-pulse fa-2x"></i></div></td></tr>';
    tbody.empty();
    tbody.append(loader);
    $.ajax({
        url: link.ajax,
        method: 'GET',
        data: {
            month: month,
            year: year
        },
        success: function (point) {
            bars = point.process.bars;
            category = point.process.category;
            legend = point.process.legends;
            lines = point.process.lines;
            total = point.process.total;
            processGraph.tooltip.options.formatter = function () {
                if (this.series.name == '% Pareto') {
                    var pcnt = Highcharts.numberFormat((this.y / total * 100), 0, '.'); //TOTAL
                    return pcnt + '%';
                }
                return this.y;
            };
            processGraph.yAxis[1].update({
                tickInterval: total / 4, //TOTAL
                labels: {
                    formatter: function () {
                        var pcnt = Highcharts.numberFormat((this.value / total * 100), 0, '.'); //TOTAL
                        return pcnt + '%';
                    }
                }
            });
            processGraph.xAxis[0].categories = legend;
            processGraph.series[1].setData(lines);
            processGraph.series[0].setData(bars);
            tbody.empty();
            if (total == 0) {
                tbody.append('<tr><td colspan="3" class="text-center">No data to show</td></tr>');
            } else {
                count = 1;
                for (i = 0; i < point.process.lines.length; i++) {
                    var preTD = "<td><a target='_blank' href='/pareto?month="
                        + month
                        + "&year="
                        + year
                        + "&discrepancy="
                        + category[i]
                        + "&category=failureMode'>";

                    tbody.append(
                        $("<tr></tr>")
                            .append(preTD + legend[i] + "</a></td>")
                            .append(preTD + category[i] + "</a></td>")
                            .append(preTD + bars[i] + "</a></td>")
                    );
                    count += 1;
                }
                var preTD = "<td colspan='2' class='h4 text-left'><a target='_blank' href='/pareto?month="
                    + month
                    + "&year="
                    + year
                    + "&discrepancy="
                    + category[0]
                    + "&category=failureMode'>";

                tbody.append(
                    $("<tr class='warning'></tr>")
                        .append(preTD + "<strong>TOTAL : </strong></a></td>")
                        .append(preTD + total + "</a></td>")
                );
            }
        },
        cache: false
    });
});
// ============================================================================
//start of pareto
var chartContent = {
    chart: {
        renderTo: 'podGraph',
        defaultSeriesType: 'column',
        borderColor: '#ccc',
        alignTicks: false,
        marginTop: 50,
        reflow: false
    },
    title: {
        text: 'Pareto of Discrepancy'
    },
    plotOptions: {
        series: {
            shadow: false,
        }
    },
    xAxis: {
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
            rotation: 270,
            margin: 35
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
        endOnTick: false,
        opposite: true,
        linkedTo: 0
    }],
    legend: {
        layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom',
        margin: 25,
        itemDistance: 50,
        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
    },
    series: [{
        // yAxis: 0,
        name: 'Count',
        color: '#800000'
    }, {
        type: 'line',
        name: '% Pareto',
        color: '#000000'
    }]
};
var qdnMetrics = new Highcharts.Chart({ //start of qdnMetrics
    chart: {
        renderTo: 'qdnMetrics',
        marginTop: 50,
        reflow: false
    },
    title: {
        text: "QDN January - December " + yearNow,
        margin: 35
    },
    subtitle: {
        text: 'Source: QDN System (Actual number in a week)'
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
        data: [5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5]
    }]
}); //end of qdnMetrics

$('#modalQdnMetrics').on('show.bs.modal', function () {
    $('#qdnMetrics').css('visibility', 'hidden');
});

$('#modalQdnMetrics').on('shown.bs.modal', function () {
    $('#qdnMetrics').css('visibility', 'initial');
    qdnMetrics.reflow();
});
//======================================================
var podGraph = new Highcharts.Chart(chartContent); //end of pareto
$('#pod').on('show.bs.modal', function () {
    $('#podGraph').css('visibility', 'hidden');
});
$('#pod').on('shown.bs.modal', function () {
    $('#podGraph').css('visibility', 'initial');
    podGraph.reflow();
});
//======================================================
chartContent.chart.renderTo = 'assemblyGraph';
chartContent.title.text = 'Pareto of Discrepancy - Assembly';
var assemblyGraph = new Highcharts.Chart(chartContent); //end of pareto
$('#assemblyModal').on('show.bs.modal', function () {
    $('#assemblyGraph').css('visibility', 'hidden');
});
$('#assemblyModal').on('shown.bs.modal', function () {
    $('#assemblyGraph').css('visibility', 'initial');
    assemblyGraph.reflow();
});
//======================================================
chartContent.chart.renderTo = 'environmentGraph';
chartContent.title.text = 'Pareto of Discrepancy - Environment';
var environmentGraph = new Highcharts.Chart(chartContent); //end of pareto
$('#environmentModal').on('show.bs.modal', function () {
    $('#environmentGraph').css('visibility', 'hidden');
});
$('#environmentModal').on('shown.bs.modal', function () {
    $('#environmentGraph').css('visibility', 'initial');
    environmentGraph.reflow();
});
//======================================================
chartContent.chart.renderTo = 'failureModeGraph';
chartContent.title.text = 'Pareto of Discrepancy - Failure Mode';
var failureModeGraph = new Highcharts.Chart(chartContent); //end of pareto
$('#failureModeModal').on('show.bs.modal', function () {
    $('#failureModeGraph').css('visibility', 'hidden');
});
$('#failureModeModal').on('shown.bs.modal', function () {
    $('#failureModeGraph').css('visibility', 'initial');
    failureModeGraph.reflow();
});
//======================================================
chartContent.chart.renderTo = 'machineGraph';
chartContent.title.text = 'Pareto of Discrepancy - Machine';
var machineGraph = new Highcharts.Chart(chartContent); //end of pareto
$('#machineModal').on('show.bs.modal', function () {
    $('#machineGraph').css('visibility', 'hidden');
});
$('#machineModal').on('shown.bs.modal', function () {
    $('#machineGraph').css('visibility', 'initial');
    machineGraph.reflow();
});
//======================================================
chartContent.chart.renderTo = 'manGraph';
chartContent.title.text = 'Pareto of Discrepancy - Man';
var manGraph = new Highcharts.Chart(chartContent); //end of pareto
$('#manModal').on('show.bs.modal', function () {
    $('#manGraph').css('visibility', 'hidden');
});
$('#manModal').on('shown.bs.modal', function () {
    $('#manGraph').css('visibility', 'initial');
    manGraph.reflow();
});
//======================================================
chartContent.chart.renderTo = 'materialGraph';
chartContent.title.text = 'Pareto of Discrepancy - Material';
var materialGraph = new Highcharts.Chart(chartContent); //end of pareto
$('#materialModal').on('show.bs.modal', function () {
    $('#materialGraph').css('visibility', 'hidden');
});
$('#materialModal').on('shown.bs.modal', function () {
    $('#materialGraph').css('visibility', 'initial');
    materialGraph.reflow();
});
//======================================================
chartContent.chart.renderTo = 'processGraph';
chartContent.title.text = 'Pareto of Discrepancy - Method / Process';
var processGraph = new Highcharts.Chart(chartContent); //end of pareto
$('#processModal').on('show.bs.modal', function () {
    $('#processGraph').css('visibility', 'hidden');
});
$('#processModal').on('shown.bs.modal', function () {
    $('#processGraph').css('visibility', 'initial');
    processGraph.reflow();
});

//=============================================================
$('#peVerification').on('show.bs.collapse', function () {
    var rowFile = $(this).find("tbody");
    status('p.e. verification', rowFile);
    $('.collapse').collapse('hide');
});

$('#incomplete').on('show.bs.collapse', function () {
    var rowFile = $(this).find("tbody");
    status('incomplete fill-up', rowFile);
    $('.collapse').collapse('hide');
});

$('#approval').on('show.bs.collapse', function () {
    var rowFile = $(this).find("tbody");
    status('incomplete approval', rowFile);
    $('.collapse').collapse('hide');
});

$('#qaVerification').on('show.bs.collapse', function () {
    var rowFile = $(this).find("tbody");
    status('q.a. verification', rowFile);
    $('.collapse').collapse('hide');
});
$.ajaxSetup({
    headers: {
        'X-CSRF-Token': $('meta[name=_token]').attr('content')
    }
});
