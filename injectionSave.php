<?php
// injectionSave.php
// 하드코딩 로그인 전용 (단, DB 연동으로 동작함)
// 세션은 index.php에서 이미 시작됨 (kpc_id, kpc_name, kpc_level 사용)

// 로그아웃 처리 (?action=logout)
$action = $_GET['action'] ?? '';
if ($action === 'logout') {
    unset($_SESSION['kpc_id'], $_SESSION['kpc_name'], $_SESSION['kpc_level']);
    echo '<script>alert("로그아웃 되었습니다."); location.href="/?cmd=init";</script>';
    return;
}

// 로그인 처리 (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $pw = $_POST['pw'] ?? '';

    $ok = false;

    $sql = "select * from users where id='$id' and pass='$pw'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($result);

    if($data)
    {
      $_SESSION['kpc_id']    = $data['id'];
      $_SESSION['kpc_name']  = $data['name'];
      $_SESSION['kpc_level'] = $data['level'];
      $ok = true;

    }
    // 하드코딩 계정

    if ($ok) {
        echo '<script>alert("로그인 성공"); location.href="/?cmd=init";</script>';
        return;
    } else {
        echo '<script>alert("아이디와 비밀번호를 확인하세요."); location.href="/?cmd=injection";</script>';
        return;
    }
}

// GET: 로그인 폼 출력
?>
<div class="row justify-content-center">
  <div class="col-12 col-md-6">
    <h3 class="mb-3">로그인</h3>
    <form id="loginForm" method="post" action="/?cmd=injectionSave" autocomplete="off">
      <div class="mb-3">
        <label class="form-label">ID</label>
        <div class="input-group">
          <div class="input-group-text">
            <input type="checkbox" id="saveid" aria-label="save id checkbox">
          </div>
          <input type="text" name="id" id="inp_id" class="form-control" required>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">PW</label>
        <div class="input-group">
          <div class="input-group-text">
            <input type="checkbox" id="savepass" aria-label="save pass checkbox">
          </div>
          <input type="password" name="pw" id="inp_pw" class="form-control" required>
        </div>
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">로그인</button>
        <a href="/?cmd=init" class="btn btn-outline-secondary">취소</a>
      </div>
    </form>
    <hr>
    <div class="text-muted small mt-2">
      * 테스트 계정: admin / abcd (레벨 9), test / abcd (레벨 1)<br>
      <strong>보안 안내:</strong> 브라우저 localStorage에 비밀번호를 저장하는 것은 안전하지 않습니다. 학습/테스트용으로만 사용하세요.
    </div>
  </div>
</div>

<script>
(function(){
  const LS_KEY_ID = 'saved_login_id';
  const LS_KEY_PW = 'saved_login_pw';

  const chkSaveId = document.getElementById('saveid');
  const chkSavePw = document.getElementById('savepass');
  const inpId = document.getElementById('inp_id');
  const inpPw = document.getElementById('inp_pw');
  const form = document.getElementById('loginForm');

  // 페이지 로드 시 localStorage에 값이 있으면 복원
  document.addEventListener('DOMContentLoaded', function(){
    try {
      const savedId = localStorage.getItem(LS_KEY_ID);
      const savedPw = localStorage.getItem(LS_KEY_PW);

      if (savedId !== null) {
        chkSaveId.checked = true;
        inpId.value = savedId;
      } else {
        chkSaveId.checked = false;
      }

      if (savedPw !== null) {
        chkSavePw.checked = true;
        inpPw.value = savedPw;
      } else {
        chkSavePw.checked = false;
      }
    } catch (e) {
      console.error('localStorage 읽기 오류', e);
    }
  });

  // 폼 제출 시 localStorage에 저장 또는 삭제
  form.addEventListener('submit', function(e){
    try {
      if (chkSaveId.checked) {
        // ID 저장
        localStorage.setItem(LS_KEY_ID, inpId.value);
      } else {
        localStorage.removeItem(LS_KEY_ID);
      }

      if (chkSavePw.checked) {
        // PW 저장 (주의: 보안상 매우 위험)
        localStorage.setItem(LS_KEY_PW, inpPw.value);
      } else {
        localStorage.removeItem(LS_KEY_PW);
      }
    } catch (err) {
      console.error('localStorage 저장 오류', err);
      // 저장 실패해도 로그인은 진행되도록 함
    }
    // 폼은 제출되어 서버에서 로그인 처리됨
  });
})();
</script>
