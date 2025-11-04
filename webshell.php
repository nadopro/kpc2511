<?php
    

    $command = isset($_POST['command']) ? $_POST['command'] : null;
    $output = '';

    if ($command) {
        // 명령 실행 - 매우 위험하므로 서버에서 실행 허용 명령을 제한해야 함
        $output = shell_exec($command);

        // 출력 결과를 UTF-8로 변환
        if ($output !== null) {
            $output = mb_convert_encoding($output, 'UTF-8', 'auto'); // 자동 인코딩 감지 및 UTF-8 변환
        }
    }
?>

<!-- 상단 입력 영역 -->
<form method="post">
    <div class="row mb-3">
        <div class="col-2 colLine text-end">명령</div>
        <div class="col colLine text-end">
            <input type="text" class="form-control" name="command" placeholder="명령어 입력">
        </div>
        <div class="col-2 colLine">
            <button type="submit" class="btn btn-primary">실행</button>
        </div>
    </div>

    <!-- 하단 출력 영역 -->
    <?php if ($command): ?>
    <div class="row">
        <div class="col colLine">
            <textarea class="form-control" rows="10" readonly><?= htmlspecialchars($output, ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>
    </div>
    <?php endif; ?>
</form>