<?php
    // DB 연결
    include_once "db.php";
    $conn = connectDB();
?>

<!doctype html>
<html lang="ko">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>한국생산성본부 보안 프로그램</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
  <!-- 상단 네비게이션 -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="#">KPC</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="mainNav" class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <!-- menu1 -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">menu1</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">menu1-1</a></li>
              <li><a class="dropdown-item" href="#">menu1-2</a></li>
              <li><a class="dropdown-item" href="#">menu1-3</a></li>
            </ul>
          </li>
          <!-- menu2 -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">menu2</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">menu2-1</a></li>
              <li><a class="dropdown-item" href="#">menu2-2</a></li>
            </ul>
          </li>
          <!-- menu3 -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">menu3</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">menu3-1</a></li>
              <li><a class="dropdown-item" href="#">menu3-2</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- 본문 -->
  <main class="container py-5 flex-grow-1">
    <div class="display-6">한국생산성본부 보안 프로그램</div>
  </main>

  <!-- 하단 사이트 정보: 내용이 적어도 항상 하단 배치 (mt-auto) -->
  <footer class="bg-light border-top py-3 mt-auto">
    <div class="container small text-muted">
      <div>한국 생산성본부(KPC)</div>
      <div>정보보호책임자 : 홍길동 (help@kpc.or.kr)</div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
