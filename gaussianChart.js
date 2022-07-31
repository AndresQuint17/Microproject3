// Gaussian Chart
function loadGaussianChart(idContainer, title, series, titleData, titleBellCurve) {

    Highcharts.chart(idContainer, {

        title: {
            text: title
        },

        xAxis: [{
            title: {
                text: titleData
            },
            alignTicks: false
        }, {
            title: {
                text: titleBellCurve
            },
            alignTicks: false,
            opposite: true
        }],

        yAxis: [{
            title: { text: titleData }
        }, {
            title: { text: titleBellCurve },
            opposite: true
        }],

        series: [{
            name: titleBellCurve,
            type: 'bellcurve',
            xAxis: 1,
            yAxis: 1,
            baseSeries: 1,
            zIndex: -1
        }, {
            name: titleData,
            type: 'scatter',
            data: series,
            accessibility: {
                exposeAsGroupOnly: true
            },
            marker: {
                radius: 1.5
            }
        }]
    });
}