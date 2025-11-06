<?php
// injectionSave3.php
// 클라이언트에서 pw를 base64로 인코딩해서 전송하고,
// 서버에서 base64_decode한 후 DB와 비교하는 테스트용 스크립트.
// 주의: Base64는 보안적 암호화가 아님. HTTPS + 서버측 해시 사용 권장.

// 전제: index.php에서 session_start() 및 $conn (mysqli)가 준비되어 있음.
// 헤더(UTF-8)
header('Content-Type: text/html; charset=utf-8');

// 로그아웃 처리 (?action=logout)
$action = $_GET['action'] ?? '';
if ($action === 'logout') {
    unset($_SESSION['kpc_id'], $_SESSION['kpc_name'], $_SESSION['kpc_level']);
    echo '<script>alert("로그아웃 되었습니다."); location.href="/?cmd=init";</script>';
    return;
}

// 로그인 처리 (POST) - 여기서 pw는 Base64 인코딩된 값으로 도착함
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $pw_encoded = $_POST['pw'] ?? '';

    // 기본 유효성
    if ($id === '' || $pw_encoded === '') {
        echo '<script>alert("ID 또는 PW가 비어 있습니다."); history.back();</script>';
        return;
    }

    // base64 디코딩 (복호화)
    $pw = base64_decode($pw_encoded, true); // 실패 시 false 반환
    if ($pw === false) {
        echo '<script>alert("비밀번호 디코딩에 실패했습니다."); history.back();</script>';
        return;
    }

    // DB와 비교 — Prepared Statement 사용 (평문 비교을 전제로 함: 교육/테스트 목적)
    // 실제 운영에서는 pass 컬럼에 password_hash() 결과를 저장하고 password_verify() 사용 권장.
    if (!isset($conn) || !($conn instanceof mysqli)) {
        echo '<script>alert("DB 연결 정보가 없습니다."); history.back();</script>';
        return;
    }

    $stmt = mysqli_prepare($conn, "SELECT id, name, `level` FROM users WHERE id = ? AND pass = ? LIMIT 1");
    if (!$stmt) {
        $err = mysqli_error($conn);
        echo '<script>alert("DB 준비 오류: ' . htmlspecialchars($err) . '"); history.back();</script>';
        return;
    }

    mysqli_stmt_bind_param($stmt, 'ss', $id, $pw);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($res);
    mysqli_free_result($res);
    mysqli_stmt_close($stmt);

    if ($data) {
        // 로그인 성공
        $_SESSION['kpc_id']    = $data['id'];
        $_SESSION['kpc_name']  = $data['name'];
        $_SESSION['kpc_level'] = $data['level'];

        echo '<script>alert("로그인 성공"); location.href="/?cmd=init";</script>';
        return;
    } else {
        echo '<script>alert("아이디와 비밀번호를 확인하세요."); location.href="/?cmd=injectionSave3";</script>';
        return;
    }
}

// GET: 로그인 폼 출력
?>
<div class="row justify-content-center">
  <div class="col-12 col-md-6">
    <h3 class="mb-3">로그인 (Base64 인코딩 전송 테스트)</h3>
    <form id="loginForm" method="post" action="/?cmd=injectionSave3" autocomplete="off">
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
      * 테스트 계정 예: admin / abcd (레벨 9), test / abcd (레벨 1)<br>
      * 이 페이지는 클라이언트에서 비밀번호를 Base64 인코딩하여 전송하고, 서버에서 복호화 후 비교합니다.<br>
      <strong>주의:</strong> Base64는 암호화가 아니며, 공격자가 중간에서 가로채면 쉽게 디코딩할 수 있습니다. 운영 환경에서는 반드시 HTTPS, 서버측 해시(예: password_hash/verify)를 사용하세요.
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

  // 페이지 로드 시 localStorage에서 복원 (localStorage에는 Base64로 저장되어 있음)
  document.addEventListener('DOMContentLoaded', function(){
    try {
      const savedId = localStorage.getItem(LS_KEY_ID);
      const savedPwEncoded = localStorage.getItem(LS_KEY_PW);

      if (savedId) {
        chkSaveId.checked = true;
        inpId.value = savedId;
      } else {
        chkSaveId.checked = false;
      }

      if (savedPwEncoded) {
        chkSavePw.checked = true;
        // Base64 디코딩하여 평문을 input에 채움
        try {
          inpPw.value = atob(savedPwEncoded);
        } catch(e) {
          // 디코딩 오류 시 저장값 제거
          console.error('saved pw decode error', e);
          localStorage.removeItem(LS_KEY_PW);
          chkSavePw.checked = false;
        }
      } else {
        chkSavePw.checked = false;
      }
    } catch (e) {
      console.error('localStorage 읽기 오류', e);
    }
  });

  // 폼 제출 시: localStorage 저장/삭제 처리, 그리고 전송할 pw 값을 Base64로 인코딩해서 대체
  form.addEventListener('submit', function(e){
    try {
      // localStorage save/remove
      if (chkSaveId.checked) {
        localStorage.setItem(LS_KEY_ID, inpId.value);
      } else {
        localStorage.removeItem(LS_KEY_ID);
      }

      if (chkSavePw.checked) {
        localStorage.setItem(LS_KEY_PW, btoa(inpPw.value)); // Base64 인코딩해서 저장
      } else {
        localStorage.removeItem(LS_KEY_PW);
      }

      // --- 핵심: 서버로 전송하기 전에 pw 값을 Base64로 인코딩 ---
      // 현재 inp_pw에는 평문 비밀번호가 들어있음. 전송할 값으로 치환.
      var plain = inpPw.value;
      var encoded = btoa(plain); // Base64 인코딩
      inpPw.value = encoded;

      // 폼은 제출되어 서버에 전송됨.
      // 서버는 base64_decode($_POST['pw']) 해서 원래 평문을 얻음.
    } catch (err) {
      console.error('submit handler error', err);
      // 오류가 나도 폼 제출은 계속 시도(필요시 방지)
    }
  });
})();
</script>
