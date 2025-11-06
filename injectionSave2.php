<?php
// injectionSave2.php
// 세션은 index.php에서 이미 시작됨
// DB 접속 정보는 $conn 으로 이미 설정됨

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

    if ($data) {
        $_SESSION['kpc_id']    = $data['id'];
        $_SESSION['kpc_name']  = $data['name'];
        $_SESSION['kpc_level'] = $data['level'];
        $ok = true;
    }

    if ($ok) {
        echo '<script>alert("로그인 성공"); location.href="/?cmd=init";</script>';
        return;
    } else {
        echo '<script>alert("아이디와 비밀번호를 확인하세요."); location.href="/?cmd=injectionSave2";</script>';
        return;
    }
}

// GET: 로그인 폼 출력
?>
<div class="row justify-content-center">
  <div class="col-12 col-md-6">
    <h3 class="mb-3">로그인</h3>
    <form id="loginForm" method="post" action="/?cmd=injectionSave2" autocomplete="off">
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
      * 비밀번호는 Base64로 인코딩되어 저장됩니다.
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

  // 페이지 로드 시 localStorage에서 복원
  document.addEventListener('DOMContentLoaded', function(){
    try {
      const savedId = localStorage.getItem(LS_KEY_ID);
      const savedPwEncoded = localStorage.getItem(LS_KEY_PW);

      if (savedId) {
        chkSaveId.checked = true;
        inpId.value = savedId;
      }

      if (savedPwEncoded) {
        chkSavePw.checked = true;
        // Base64 디코딩
        inpPw.value = atob(savedPwEncoded);
      }
    } catch (e) {
      console.error('localStorage 복원 오류', e);
    }
  });

  // 폼 제출 시 localStorage 저장/삭제
  form.addEventListener('submit', function(e){
    try {
      if (chkSaveId.checked) {
        localStorage.setItem(LS_KEY_ID, inpId.value);
      } else {
        localStorage.removeItem(LS_KEY_ID);
      }

      if (chkSavePw.checked) {
        // Base64 인코딩 후 저장
        localStorage.setItem(LS_KEY_PW, btoa(inpPw.value));
      } else {
        localStorage.removeItem(LS_KEY_PW);
      }
    } catch (err) {
      console.error('localStorage 저장 오류', err);
    }
  });
})();
</script>
