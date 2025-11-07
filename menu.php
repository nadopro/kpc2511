<?php
// menu.php
// index.php에서 세션을 이미 시작하므로 $_SESSION을 바로 사용 가능
$kpc_id    = $_SESSION['kpc_id'] ?? null;
$kpc_name  = $_SESSION['kpc_name'] ?? null;
$kpc_level = isset($_SESSION['kpc_level']) ? (int)$_SESSION['kpc_level'] : 0;
?>
<nav class="navbar navbar-expand-lg navbar-light bg-secondary">
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
            <li><a class="dropdown-item" href="/?cmd=injectionSave">로그인(Save)</a></li>
            <li><a class="dropdown-item" href="/?cmd=injectionSave2">로그인(암호화저장)</a></li>
            <li><a class="dropdown-item" href="/?cmd=injectionSave3">로그인(암호화전송)</a></li>
            <li><a class="dropdown-item" href="/?cmd=secureLogin">로그인(Secure)</a></li>
            <li><a class="dropdown-item" href="/?cmd=brute">Brute Force</a></li>
            <li><a class="dropdown-item" href="/?cmd=brute2">Brute Force2</a></li>
            <li><a class="dropdown-item" href="/?cmd=brute3">Brute Force3</a></li>
            <li><a class="dropdown-item" href="/?cmd=webshell">Web Shell</a></li>
            <li><a class="dropdown-item" href="/?cmd=board&bid=1">공지사항</a></li>
            <li><a class="dropdown-item" href="/?cmd=board&bid=2">자유게시판</a></li>
            <li><a class="dropdown-item" href="/?cmd=editor">에디터</a></li>
          </ul>
        </li>

        <!-- menu2 -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">보안 예제</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/?cmd=chart">구글차트</a></li>
            <li><a class="dropdown-item" href="/?cmd=generator">데이터생성기</a></li>
            <li><a class="dropdown-item" href="/?cmd=monitor">모니터링</a></li>
            <li><a class="dropdown-item" href="/?cmd=crawling">크롤링</a></li>
            <li><a class="dropdown-item" href="/?cmd=network">인물관계</a></li>
            <li><a class="dropdown-item" href="/?cmd=join">회원가입(ajax)</a></li>
            <li><a class="dropdown-item" href="/?cmd=monitor2">모니터링(AJAX)</a></li>
            <li><a class="dropdown-item" href="/?cmd=fake">Fake Data</a></li>
            <li><a class="dropdown-item" href="/?cmd=gps">IP Map</a></li>
            <li><a class="dropdown-item" href="/?cmd=webftp">탐색기</a></li>
          </ul>
        </li>

        <?php
        if(isset($_SESSION['kpc_id']))
        {
          if(isset($_SESSION['kpc_level']) and $_SESSION['kpc_level'] ==9)
          {

        ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">관리자전용</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/?cmd=log">로그관리</a></li>
            <li><a class="dropdown-item" href="/?cmd=menu3-2">menu3-2</a></li>
          </ul>
        </li>
      </ul>

      <?php
          }
        }
      ?>

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
