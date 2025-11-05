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
    

      $sql = "insert into log (ip, id, work, time) 
                values('$ip', '$userid', '$q', now() )";
      mysqli_query($conn, $sql);


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
