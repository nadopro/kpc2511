<?php

    $sql = "select *  from sensor";
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_num_rows($result);
    echo "$rows <br>";
    $start = $rows - 100;


    $sql = "select * from sensor order by idx asc limit $start, 200";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($result);
?>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['time', '온도', '습도'],
          <?php
            while($data)
            {
                echo "['$data[time]', $data[temp], $data[hum] ],";
                 $data = mysqli_fetch_array($result);
            }
          ?>

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

    <script>
        setTimeout(function() {
            window.location.href = 'index.php?cmd=monitor';
        }, 3000); // 3초 대기
    </script>