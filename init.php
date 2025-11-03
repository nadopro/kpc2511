<?php
// init.php : 캐러셀 슬라이드
?>
<div id="homeCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner rounded-3 overflow-hidden">
    <div class="carousel-item active">
      <img src="img/ny.jpg" class="d-block w-100" alt="New York">
    </div>
    <div class="carousel-item">
      <img src="img/la.jpg" class="d-block w-100" alt="Los Angeles">
    </div>
    <div class="carousel-item">
      <img src="img/chicago.jpg" class="d-block w-100" alt="Chicago">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<div class="text-muted">메인 초기 화면입니다.</div>
