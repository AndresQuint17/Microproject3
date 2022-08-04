// Time Data With Irregular Intervals
function loadTimeChart(idContainer, title, series, tipo) {

    series.forEach((element) => {
        element.data.map((UreaPCK, index) => {
            let fechaSplit = UreaPCK[0].split("-");
            UreaPCK[0] = Date.UTC(+fechaSplit[0], +fechaSplit[1] - 1, +fechaSplit[2]);
        });
    })

    Highcharts.chart(idContainer, {
        chart: {
            type: 'spline'
        },
        title: {
            text: title
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: { // don't display the dummy year
                month: '%e. %b',
                year: '%b'
            },
            title: {
                text: 'Date'
            }
        },
        yAxis: {
            title: {
                text: tipo
            },
            min: 0
        },
        tooltip: {
            headerFormat: '<b>{series.name}</b><br>',
            pointFormat: '{point.x:%e. %b}: {point.y:.2f} m'
        },

        plotOptions: {
            series: {
                marker: {
                    enabled: true
                }
            }
        },

        colors: ['#6CF', '#39F', '#06C', '#036', '#000'],

        // Define the data points. All series have a dummy year
        // of 1970/71 in order to be compared on the same x axis. Note
        // that in JavaScript, months start at 0 for January, 1 for February etc.
        series: series,

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    plotOptions: {
                        series: {
                            marker: {
                                radius: 2.5
                            }
                        }
                    }
                }
            }]
        }
    });
}



