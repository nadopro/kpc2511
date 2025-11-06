<?php
// ajaxCheckId.php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/db.php';
$conn = connectDB();
if (!($conn instanceof mysqli)) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'code' => 'dberr', 'message' => 'DB 연결 실패']);
    exit;
}

// 요청 JSON 파싱
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

$id = isset($data['id']) ? trim($data['id']) : '';

// 길이 체크
if (mb_strlen($id, 'UTF-8') < 4) {
    echo json_encode(['ok' => false, 'code' => 'short', 'message' => '4글자 이상만 가능합니다.']);
    exit;
}

// 아이디 중복 체크 (Prepared Statement 권장)
$stmt = mysqli_prepare($conn, "SELECT 1 FROM users WHERE id = ? LIMIT 1");
if (!$stmt) {
    echo json_encode(['ok' => false, 'code' => 'stmt', 'message' => '쿼리 준비 오류']);
    exit;
}
mysqli_stmt_bind_param($stmt, 's', $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
$exists = mysqli_stmt_num_rows($stmt) > 0;
mysqli_stmt_close($stmt);

if ($exists) {
    echo json_encode(['ok' => false, 'code' => 'taken', 'message' => '사용중인 아이디입니다.']);
} else {
    echo json_encode(['ok' => true, 'code' => 'ok', 'message' => '사용가능한 아이디입니다.']);
}
