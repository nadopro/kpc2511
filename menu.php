<?php
// menu.php
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/?cmd=init">SITE</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div id="mainNav" class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- menu1 -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">취약점 찾기</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/?cmd=test">test</a></li>
            <li><a class="dropdown-item" href="/?cmd=injection">로그인(Injection)</a></li>
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
    </div>
  </div>
</nav>
