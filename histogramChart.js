
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
    var data = google.visualization.arrayToDataTable(edadesJugadores);

    var options = {
        title: 'Histograma - Edades de los Jugadores',
        legend: { position: 'none' },
    };

    var chart = new google.visualization.Histogram(document.getElementById('chart_div'));
    chart.draw(data, options);
}