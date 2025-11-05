<?php
    $fail = true;
    if(!isset($_SESSION['kpc_id']))
    {
        $fail = true;
    }else
    {
        if($_SESSION['kpc_level'] != 9)
        {
            $fail = true;
        }else
        {
            $fail = false;
        }
    }
    // 2025-11-05 12:34:56
    $date = Date('Y-m-d');

    echo "date = $date    $date 00:00:00<br>";


    if(!isset($_SESSION['sess_sms']))
        $_SESSION['sess_sms'] = "";

    if($_SESSION['sess_sms'])
    {
        echo "SMS는 이미 발송했습니다.<br>";
    }else
    {
        $SendingMsg = "접속자가 갑자기 증가했습니다. 확인하세요.";
        include "auto_sms.php";
        $_SESSION['sess_sms'] = "sendOK";
    }


    if($fail == true)
    {
        echo "
        <script>
            alert('잘못된 접근입니다.');
            location.href='index.php';
        </script>
        ";
    }

?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['time', '접속자 수'],
          <?php

            for($i=0; $i<24; $i++)
            {
                $sql = "select count(*) as vis from log where time >='$date $i:00:00' and time <= '$date $i:59:59' ";
                $result = mysqli_query($conn, $sql);
                $data = mysqli_fetch_array($result);
                $visitor = $data['vis'];
                echo "['$i:00', $visitor ],";
            }

          ?>

        ]);

        var options = {
          title: '접속 로그',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>

    <div id="curve_chart" style="width: 900px; height: 500px"></div>

<?php
    $sql = "select * from log order by idx desc limit 50";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($result);

    ?>
    <table class='table table-borderd'>
        <tr>
            <td>순서</td>
            <td>ID</td>
            <td>WORK</td>
            <td>IP</td>
            <td>FLAG</td>
        </tr>
        <?php

        while($data)
        {
            echo "
            <tr>
                <td>$data[idx]</td>
                <td>$data[id]</td>
                <td>$data[work]</td>
                <td>$data[ip]</td>
                <td>FLAG</td>
            </tr>";
            $data = mysqli_fetch_array($result);
        }

        ?>
    </table>

    <?php

?>

    <script>
        setTimeout(function() {
            window.location.href = 'index.php?cmd=log';
        }, 5000); // 3초 대기
    </script>