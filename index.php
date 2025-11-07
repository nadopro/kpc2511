<?php
// index.php
// DB 연결

session_save_path("./sess");
session_start();

date_default_timezone_set("Asia/Seoul");

include_once __DIR__ . "/config.php";
include_once __DIR__ . "/db.php";
$conn = connectDB();

// 라우팅용 cmd (기본값: init)
$cmd = isset($_GET['cmd']) ? $_GET['cmd'] : 'init';

    // 비정상적인 잦은 접속인가?
  $q = $_SERVER["QUERY_STRING"];
      //echo "q = $q<br>";
      $ip = $_SERVER["REMOTE_ADDR"];
      $ip1 = rand(1,254);
      $ip2 = rand(1,254);
      $ip3 = rand(1,254);
      $ip4 = rand(1,254);
      
      $ip ="$ip1.$ip2.$ip3.$ip4";

      //echo "ip = $ip<br>";

      if(isset($_SESSION["kpc_id"]))
        $userid = $_SESSION["kpc_id"];
      else
        $userid = "";
    
    // 비정상적인 트래픽인가?
    //$BLOCK_BY_NETWORK = false;
    //$BLOCK_COUNT = 10;

    // 다음 줄은 테스트 후 삭제
    $ip = "2.3.4.15";
    if($BLOCK_BY_NETWORK == true)
    {
      $splitIP = explode(".", $ip);
      $networks = "$splitIP[0].$splitIP[1].$splitIP[2].";

      $sql = "select * from log 
            where ip like '$networks%' and time >= (now() - interval 5 second) ";
    }else
    {
      $sql = "select * from log 
            where ip='$ip' and time >= (now() - interval 5 second) ";
    }
    
    $result = mysqli_query($conn, $sql);
    $connectCount = mysqli_num_rows($result);
    echo "$connectCount<br>";
    if($connectCount >= $BLOCK_COUNT)
    {
      $sql = "select * from black where ip='$ip' ";
      $result = mysqli_query($conn, $sql);
      $data = mysqli_fetch_array($result);

      if($data)
      {
        $sql = "update black set reject = reject + 1 where ip='$ip'";
        $result = mysqli_query($conn, $sql);

        echo "Reject Count ++<br>";
      }else
      {
        $sql = "insert into black (ip, reason, reject, time) 
              values ('$ip', '비정상적인 과도한 접속', '1', now())";
        $result = mysqli_query($conn, $sql);
        echo "Add to Black list<br>";
      }     

      echo"
      <script>
        location.href='https://warning.or.kr';
      </script>
      ";
    }


      $sql = "insert into log (ip, id, work, time) 
                values('$ip', '$userid', '$q', now() )";
      mysqli_query($conn, $sql);

?>
<!doctype html>
<html lang="ko">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>사이트</title>
    <link href="asset/bootstrap.min.css" rel="stylesheet">
    <script src="asset/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body class="d-flex flex-column min-vh-100">

  <!-- 상단 메뉴 -->
  <?php include __DIR__ . "/menu.php"; ?>

  <!-- 본문 -->
  <main class="container py-4 flex-grow-1">
    <?php
      // 요청하신 형태 그대로: include "$cmd.php"
      // (필요시 보안을 위해 화이트리스트/패턴체크 추가 권장)

      // index.php?cmd=test

      


      include "$cmd.php";
    ?>
  </main>

  <footer class="bg-light border-top py-3 mt-auto">
    <div class="container small text-muted">
      Copyright © Your Site
    </div>
  </footer>

  
</body>
</html>
