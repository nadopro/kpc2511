
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', '온도', '습도', '접속자'],
          ['2004',  1000,      400, 77],
          ['2005',  1170,      460, 120],
          ['2006',  660,       1120, 550],
          ['2007',  1030,      540, 420]
        ]);

        var options = {
          title: '구글차트 테스트',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>

    <div id="curve_chart" style="width: 900px; height: 500px"></div>

