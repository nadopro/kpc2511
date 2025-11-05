<?php
    $temp = mt_rand(3000, 3100) / 100 ; 
    $hum = mt_rand(6000, 6100) / 100 ; 

    $sql = "insert into sensor (temp, hum, time) 
            values('$temp', '$hum', now())";
    mysqli_query($conn, $sql);

    echo "<p>온도 : $temp , 습도 : $hum<br>";
?>
    <script>
        setTimeout(function() {
            window.location.href = 'index.php?cmd=generator';
        }, 3000); // 3초 대기
    </script>
