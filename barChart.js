// Bar Chart
function loadBarChart(idContainer, title, series, resolution) {

    Highcharts.chart(idContainer, {
        chart: {
            type: 'column'
        },
        title: {
            align: 'left',
            text: title
        },
        subtitle: {
            align: 'left',
            text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total percent'
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.' + resolution + 'f}%'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.' + resolution + 'f}%</b> of total<br/>'
        },

        series: [{
            name: "Resumen",
            colorByPoint: true,
            data: series
        }],
        drilldown: {
            breadcrumbs: {
                position: {
                    align: 'right'
                }
            },
            series: []
        }
    });
};
