<?php

 $letters = "abcdefghij";
$size = strlen($letters);
$min_len = 4;
$MAX_LEN = 8; // 안전 제한. 필요시 늘리세요 (주의: 큰 값은 매우 느립니다).

// HTML 폼
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ?>
    <!doctype html>
    <html>
      <head><meta charset="utf-8"><title>비밀번호 길이 검사</title></head>
      <body>
        <form method="post">
          검사할 최대 길이 (len): <input type="number" name="len" min="<?php echo $min_len; ?>" max="<?php echo $MAX_LEN; ?>" value="<?php echo $min_len; ?>">
          <button type="submit">실행</button>
        </form>
        <p>설명: 4글자부터 입력한 len까지 순서대로 검사합니다. (최대 <?php echo $MAX_LEN; ?>로 제한)</p>
      </body>
    </html>
    <?php
    exit;
}

// POST 처리
$len = intval($_POST['len'] ?? 0);
if ($len < $min_len) {
    echo "len은 최소 {$min_len} 이상이어야 합니다.";
    exit;
}
if ($len > $MAX_LEN) {
    echo "요청하신 len값 {$len} 이(가) 서버 안전 제한({$MAX_LEN})을 초과합니다. {$MAX_LEN}로 실행합니다.<br>";
    $len = $MAX_LEN;
}

echo "<meta charset='utf-8'>";
echo "letters = $letters, size = $size<br>";
echo "검사할 길이 범위: {$min_len} ~ {$len}<br><hr>";

$cnt = 0;

// 준비된문(statement) - 재사용
$stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE pass = ?");
if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt, "s", $pass);

// 외부 루프: 각 길이에 대해 처리
for ($current_len = $min_len; $current_len <= $len; $current_len++) {
    echo "=== 길이 {$current_len} 검사 시작 ===<br>";
    // 초기 인덱스 배열 (모두 0)
    $indices = array_fill(0, $current_len, 0);

    while (true) {
        // 현재 인덱 조합으로 문자열 생성
        $pass_chars = [];
        for ($p = 0; $p < $current_len; $p++) {
            $pass_chars[] = $letters[$indices[$p]];
        }
        $pass = implode('', $pass_chars);
        $cnt++;

        // DB 조회 (prepared)
        mysqli_stmt_execute($stmt);
        // bind param 값 넣기 (mysqli requires setting param before execute, we already bound variable $pass so update it)
        // but ensure $pass variable is in scope (we used bind_param earlier)
        // execute already called; we need to set param before execute; reorder:
        // (To avoid confusion, re-bind current $pass via mysqli_stmt_bind_param before execute)
        mysqli_stmt_bind_param($stmt, "s", $pass);
        mysqli_stmt_execute($stmt);

        $res = mysqli_stmt_get_result($stmt);
        if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $id = htmlspecialchars($row['id']);
                echo "찾음: id = {$id}, pass = {$pass}<br>";
            }
            mysqli_free_result($res);
            // 필요하면 여기에 exit() 또는 다른 동작 추가
        }

        // 진행 출력 및 flush (많은 출력이 느리게 만들 수 있음)
        if ($cnt % 1000 == 0) {
            echo "진행: {$cnt} 조합 검사됨...<br>";
            // 출력 버퍼 플러시
            @ob_flush();
            @flush();
        }

        // 원래 코드의 임의 종료(예: 테스트 목적)처럼 카운트 제한을 둘 수 있음.
        // if ($cnt > 100000) { echo "테스트용 카운트 제한 도달. 종료합니다.<br>"; exit(); }

        // 인덱스 증가 (마지막 자리부터 carry)
        $pos = $current_len - 1;
        while ($pos >= 0) {
            $indices[$pos]++;
            if ($indices[$pos] < $size) {
                break; // carry 끝
            }
            // carry
            $indices[$pos] = 0;
            $pos--;
        }
        if ($pos < 0) {
            // 모든 조합을 다 돌았음
            break;
        }
    } // while combinations

    echo "=== 길이 {$current_len} 검사 종료 (현재까지 총 검사수: {$cnt}) ===<br><br>";
    // flush
    @ob_flush();
    @flush();
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

echo "<hr>완료! 총 검사 조합 수: {$cnt}<br>";
?>