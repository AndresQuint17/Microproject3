
// Horizontal Bar Chart
function loadHorizontalBarChart(idContainer, title, series, resolution) {
    Highcharts.chart(idContainer, {
        chart: {
            type: 'bar'
        },
        title: {
            text: title
        },
        xAxis: {
            title: {
                text: null
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.' + resolution + 'f}%</b> of total<br/>'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y:.' + resolution + 'f} %'
                },
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: series
    });
}