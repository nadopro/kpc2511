<?php
// index.php
// DB 연결

session_save_path("./sess");
session_start();

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
  
    <!-- B0916 -->
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
