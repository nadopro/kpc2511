<?php
// menu.php
// index.php에서 세션을 이미 시작하므로 $_SESSION을 바로 사용 가능
$kpc_id    = $_SESSION['kpc_id'] ?? null;
$kpc_name  = $_SESSION['kpc_name'] ?? null;
$kpc_level = isset($_SESSION['kpc_level']) ? (int)$_SESSION['kpc_level'] : 0;
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/?cmd=init">KPC</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div id="mainNav" class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- 수정된 첫번째 메뉴 -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">취약점 찾기</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/?cmd=test">test</a></li>
            <li><a class="dropdown-item" href="/?cmd=login">로그인</a></li>
            <li><a class="dropdown-item" href="/?cmd=injection">로그인(Injection)</a></li>
            <li><a class="dropdown-item" href="/?cmd=secureLogin">로그인(Secure)</a></li>
            <li><a class="dropdown-item" href="/?cmd=menu1-3">menu1-3</a></li>
          </ul>
        </li>

        <!-- menu2 -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">menu2</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/?cmd=menu2-1">menu2-1</a></li>
            <li><a class="dropdown-item" href="/?cmd=menu2-2">menu2-2</a></li>
          </ul>
        </li>

        <!-- menu3 -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">menu3</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/?cmd=menu3-1">menu3-1</a></li>
            <li><a class="dropdown-item" href="/?cmd=menu3-2">menu3-2</a></li>
          </ul>
        </li>
      </ul>

      <!-- 우측: 로그인 상태 버튼 -->
      <div class="d-flex align-items-center">
        <?php if ($kpc_id): ?>
          <!-- 로그인된 상태: 이름 + 로그아웃 버튼 (injection.php?action=logout 처리) -->
          <span class="text-white me-3"><?= htmlspecialchars($kpc_name) ?>님</span>
          <form method="get" action="/?">
            <!-- 로그아웃은 GET 파라미터 action=logout 으로 처리 -->
            <input type="hidden" name="cmd" value="injection">
            <input type="hidden" name="action" value="logout">
            <button type="submit" class="btn btn-sm btn-outline-light">로그아웃</button>
          </form>
        <?php else: ?>
          <!-- 비로그인 상태: 로그인 버튼으로 injection 페이지로 이동 -->
          <a href="/?cmd=injection" class="btn btn-sm btn-outline-light">로그인</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
