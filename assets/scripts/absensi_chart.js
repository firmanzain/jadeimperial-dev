/**
 * @author Batch Themes Ltd.
 */
(function() {
    'use strict';

    $(function() {

        var config = $.localStorage.get('config');
        $('body').attr('data-layout', config.layout);
        $('body').attr('data-palette', config.theme);

        var colors = config.colors;
        var palette = config.palette;

        Chart.defaults.global.responsive = true;
        Chart.defaults.global.scaleFontColor = palette.textColor;
        //bar-chart
        var barChartCtx = document.getElementById("bar-chart").getContext("2d");
        var barChartData = {
            labels: ["Statistik On / Off Karyawan"],
            datasets: [{
                label: "Hadir",
                fillColor: colors.success,
                strokeColor: colors.success,
                highlightFill: colors.success,
                highlightStroke: colors.success,
                data: [masuk]
            }, {
                label: "Cuti",
                fillColor: colors.info,
                strokeColor: colors.info,
                highlightFill: colors.info,
                highlightStroke: colors.info,
                data: [cuti]
            }, {
                label: "Izin",
                fillColor: colors.warning,
                strokeColor: colors.warning,
                highlightFill: colors.warning,
                highlightStroke: colors.warning,
                data: [izin]
            }, {
                label: "Absen",
                fillColor: colors.danger,
                strokeColor: colors.danger,
                highlightFill: colors.danger,
                highlightStroke: colors.danger,
                data: [absen]
            }]
        };
        var barChartOptions = {
            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
            scaleBeginAtZero: true,

            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: true,

            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",

            //Number - Width of the grid lines
            scaleGridLineWidth: 1,

            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,

            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,

            //Boolean - If there is a stroke on each bar
            barShowStroke: true,

            //Number - Pixel width of the bar stroke
            barStrokeWidth: 1,

            //Number - Spacing between each of the X value sets
            barValueSpacing: 0,

            //Number - Spacing between data sets within X values
            barDatasetSpacing: 0,

            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

        };
        var absensi = new Chart(barChartCtx).Bar(barChartData, barChartOptions);
        document.getElementById('legend-bar').innerHTML = absensi.generateLegend();
    });

})();
