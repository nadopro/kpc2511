<?php
// secureLogin.php
// 전제: index.php에서 session_start()와 $conn(mysqli) 연결을 이미 수행함.

// 로그아웃 처리 (optional)
$action = $_GET['action'] ?? '';
if ($action === 'logout') {
    unset($_SESSION['kpc_id'], $_SESSION['kpc_name'], $_SESSION['kpc_level']);
    echo '<script>alert("로그아웃 되었습니다."); location.href="/?cmd=init";</script>';
    return;
}

// 서버측 입력 검사용 정규식: 공백, ', ", - 문자를 허용하지 않음, 길이 4 이상
// ^           : 시작
// [^ \'"-]    : 공백, 작은따옴표, 큰따옴표, 하이픈을 제외한 문자
// {4,}        : 최소 4자 이상
// $           : 끝
$validate_regex = '/^[^ \'"-]{4,}$/u';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $pw = $_POST['pw'] ?? '';

    // 서버측 검증 (클라이언트 검증은 우회될 수 있으므로 필수)
    if (!preg_match($validate_regex, $id) || !preg_match($validate_regex, $pw)) {
        echo '<script>alert("ID와 PW는 공백, 따옴표(\' \"), 하이픈(-)을 포함할 수 없으며 최소 4자 이상이어야 합니다."); location.href="/?cmd=secureLogin";</script>';
        exit;
    }

    // DB 연결 확인
    if (!isset($conn) || !($conn instanceof mysqli)) {
        echo '<script>alert("DB 연결이 되어있지 않습니다. 관리자에게 문의하세요."); location.href="/?cmd=secureLogin";</script>';
        exit;
    }

    // Prepared statement 사용 (SQL Injection 방지)
    $sql = "SELECT idx, name, id, `level` FROM users WHERE id = ? AND pass = PASSWORD(?) LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        // prepare 실패시 (디버그용 메시지)
        echo '<script>alert("데이터베이스 오류가 발생했습니다. (prepare 실패)"); location.href="/?cmd=secureLogin";</script>';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "ss", $id, $pw);
    mysqli_stmt_execute($stmt);

    // 결과 가져오기
    $res = mysqli_stmt_get_result($stmt);
    if ($res && mysqli_num_rows($res) === 1) {
        // mysqli_fetch_array 사용하여 결과 읽기
        $row = mysqli_fetch_array($res);

        // 세션에 저장
        $_SESSION['kpc_id']    = $row['id'];
        $_SESSION['kpc_name']  = $row['name'];
        $_SESSION['kpc_level'] = (int)$row['level'];

        mysqli_free_result($res);
        mysqli_stmt_close($stmt);

        echo '<script>alert("로그인 성공"); location.href="/?cmd=init";</script>';
        exit;
    } else {
        if ($res) mysqli_free_result($res);
        mysqli_stmt_close($stmt);
        echo '<script>alert("아이디와 비밀번호를 확인하세요."); location.href="/?cmd=secureLogin";</script>';
        exit;
    }
}
?>

<!-- HTML: 로그인 폼 (클라이언트측 검증 포함) -->
<div class="row justify-content-center">
  <div class="col-12 col-md-6">
    <h3 class="mb-3">안전한 로그인 (SQL Injection 방지 연습)</h3>

    <form id="loginForm" method="post" action="/?cmd=secureLogin" novalidate>
      <div class="mb-3">
        <label class="form-label">ID</label>
        <input type="text" name="id" id="id" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">PW</label>
        <input type="password" name="pw" id="pw" class="form-control" required>
      </div>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">로그인</button>
        <a href="/?cmd=init" class="btn btn-outline-secondary">취소</a>
      </div>
    </form>

    <hr>
    <div class="text-muted small mt-2">
      * 입력 규칙: 공백, 따옴표(' or "), 하이픈(-) 금지, ID/PW 모두 최소 4자 이상<br>
      * 테스트 계정: admin / abcd (레벨 9), test / abcd (레벨 1)
    </div>
  </div>
</div>

<script>
// 클라이언트측 검증: 서버와 동일한 규칙 적용
document.getElementById('loginForm').addEventListener('submit', function(e) {
    var id = document.getElementById('id').value.trim();
    var pw = document.getElementById('pw').value.trim();

    // 정규식: 공백, ', " , - 금지, 최소 4자
    var re = /^[^ \'"-]{4,}$/;

    if (!re.test(id) || !re.test(pw)) {
        alert("ID와 PW는 공백, 따옴표(' \") 및 하이픈(-)을 포함할 수 없으며, 최소 4자 이상이어야 합니다.");
        e.preventDefault();
        return false;
    }
    return true;
});
</script>
