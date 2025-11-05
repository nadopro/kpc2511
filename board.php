<?php
// board.php
// 전제: session_start(), $conn(mysqli) 준비됨
// 필수 GET: bid (게시판 구분: 1=공지, 2=자유)
// 선택 GET: mode (list | write | show | delete), page, idx

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo '<div class="alert alert-danger">DB 연결이 없습니다.</div>';
    return;
}

$bid  = isset($_GET['bid']) ? (int)$_GET['bid'] : 0;
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'list';
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$idx  = isset($_GET['idx']) ? (int)$_GET['idx'] : 0;

if ($bid <= 0) {
    echo '<div class="alert alert-warning">잘못된 접근입니다. (bid 누락)</div>';
    return;
}

// 공통 유틸
function h($s) { return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function ymd($dt) {
    $ts = strtotime($dt);
    return $ts ? date('Y-m-d', $ts) : h($dt);
}

// 글 목록(list)
if ($mode === 'list') {
    $perPage = 10;
    $offset  = ($page - 1) * $perPage;

    // 전체 개수
    $stmtCnt = mysqli_prepare($conn, "SELECT COUNT(*) FROM bbs WHERE bid = ?");
    mysqli_stmt_bind_param($stmtCnt, "i", $bid);
    mysqli_stmt_execute($stmtCnt);
    mysqli_stmt_bind_result($stmtCnt, $totalCount);
    mysqli_stmt_fetch($stmtCnt);
    mysqli_stmt_close($stmtCnt);

    // 목록
    $stmt = mysqli_prepare($conn,
        "SELECT idx, title, id, time
         FROM bbs
         WHERE bid = ?
         ORDER BY idx DESC
         LIMIT ? OFFSET ?");
    mysqli_stmt_bind_param($stmt, "iii", $bid, $perPage, $offset);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) $rows[] = $row;
    mysqli_free_result($res);
    mysqli_stmt_close($stmt);

    // 페이지 계산
    $totalPages = max(1, (int)ceil($totalCount / $perPage));
    $startNo = $totalCount - $offset;

    ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0"><?= h($bid === 1 ? '공지사항' : ($bid === 2 ? '자유게시판' : '게시판')) ?> 목록</h4>
      <div>
        <a class="btn btn-sm btn-primary" href="/?cmd=board&bid=<?= $bid ?>&mode=write">글쓰기</a>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th style="width:90px;">순서</th>
            <th>제목</th>
            <th style="width:160px;">작성일</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($rows)): ?>
            <tr><td colspan="3" class="text-center text-muted">등록된 글이 없습니다.</td></tr>
          <?php else: ?>
            <?php foreach ($rows as $r): ?>
              <tr>
                <td><?= (int)$startNo-- ?></td>
                <td>
                  <a href="/?cmd=board&bid=<?= $bid ?>&mode=show&idx=<?= (int)$r['idx'] ?>">
                    <?= h($r['title']) ?>
                  </a>
                </td>
                <td><?= ymd($r['time']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- 페이지네이션 -->
    <nav aria-label="page">
      <ul class="pagination pagination-sm justify-content-center">
        <?php
        // 간단 페이지 네비게이션
        $window = 5;
        $startP = max(1, $page - $window);
        $endP   = min($totalPages, $page + $window);

        $prev = max(1, $page - 1);
        $next = min($totalPages, $page + 1);
        ?>
        <li class="page-item<?= $page <= 1 ? ' disabled' : '' ?>">
          <a class="page-link" href="/?cmd=board&bid=<?= $bid ?>&mode=list&page=1">«</a>
        </li>
        <li class="page-item<?= $page <= 1 ? ' disabled' : '' ?>">
          <a class="page-link" href="/?cmd=board&bid=<?= $bid ?>&mode=list&page=<?= $prev ?>">‹</a>
        </li>
        <?php for ($p = $startP; $p <= $endP; $p++): ?>
          <li class="page-item<?= $p === $page ? ' active' : '' ?>">
            <a class="page-link" href="/?cmd=board&bid=<?= $bid ?>&mode=list&page=<?= $p ?>"><?= $p ?></a>
          </li>
        <?php endfor; ?>
        <li class="page-item<?= $page >= $totalPages ? ' disabled' : '' ?>">
          <a class="page-link" href="/?cmd=board&bid=<?= $bid ?>&mode=list&page=<?= $next ?>">›</a>
        </li>
        <li class="page-item<?= $page >= $totalPages ? ' disabled' : '' ?>">
          <a class="page-link" href="/?cmd=board&bid=<?= $bid ?>&mode=list&page=<?= $totalPages ?>">»</a>
        </li>
      </ul>
    </nav>
    <?php
    return;
}

// 글쓰기(write) + 등록 처리(POST)
if ($mode === 'write') {
    // 등록 처리
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = trim($_POST['title'] ?? '');
        $writerId = trim($_POST['writer'] ?? ''); // bbs.id 컬럼에 저장 (작성자 ID)
        $html  = trim($_POST['html'] ?? '');

        if ($title === '' || $writerId === '' || $html === '') {
            echo '<script>alert("제목, 작성자, 내용을 모두 입력해 주세요."); history.back();</script>';
            return;
        }

        $stmt = mysqli_prepare($conn,
            "INSERT INTO bbs (bid, title, html, id, file, time)
             VALUES (?, ?, ?, ?, NULL, NOW())");
        mysqli_stmt_bind_param($stmt, "isss", $bid, $title, $html, $writerId);
        $ok = mysqli_stmt_execute($stmt);
        if ($ok) {
            mysqli_stmt_close($stmt);
            echo '<script>alert("등록되었습니다."); location.href="/?cmd=board&bid=' . $bid . '&mode=list";</script>';
            return;
        } else {
            $err = h(mysqli_error($conn));
            mysqli_stmt_close($stmt);
            echo '<script>alert("등록 실패: ' . $err . '"); history.back();</script>';
            return;
        }
    }

    // 입력 폼
    ?>
    <h4 class="mb-3"><?= h($bid === 1 ? '공지사항' : ($bid === 2 ? '자유게시판' : '게시판')) ?> 글쓰기</h4>
    <form method="post" action="/?cmd=board&bid=<?= $bid ?>&mode=write">
      <div class="mb-3">
        <label class="form-label">제목</label>
        <input type="text" name="title" class="form-control" placeholder="제목을 입력하세요" required>
      </div>
      <div class="mb-3">
        <label class="form-label">작성자(ID)</label>
        <input type="text" name="writer" class="form-control" placeholder="작성자 ID를 입력하세요" value="<?= isset($_SESSION['kpc_id']) ? h($_SESSION['kpc_id']) : '' ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">내용</label>
        <textarea name="html" class="form-control" rows="8" placeholder="내용을 입력하세요" required></textarea>
      </div>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">글등록</button>
        <a class="btn btn-outline-secondary" href="/?cmd=board&bid=<?= $bid ?>&mode=list">목록보기</a>
      </div>
    </form>
    <?php
    return;
}

// 글 내용 보기(show) + 삭제(delete)
if ($mode === 'show') {
    if ($idx <= 0) {
        echo '<div class="alert alert-warning">잘못된 접근입니다. (idx 누락)</div>';
        return;
    }

    $stmt = mysqli_prepare($conn,
        "SELECT idx, bid, title, html, id, time
         FROM bbs
         WHERE idx = ? AND bid = ?
         LIMIT 1");
    mysqli_stmt_bind_param($stmt, "ii", $idx, $bid);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);
    mysqli_free_result($res);
    mysqli_stmt_close($stmt);

    if (!$row) {
        echo '<div class="alert alert-warning">존재하지 않는 글입니다.</div>';
        return;
    }

    $mineOrAdmin = (isset($_SESSION['kpc_level']) && (int)$_SESSION['kpc_level'] === 9)
                   || (isset($_SESSION['kpc_id']) && $_SESSION['kpc_id'] === $row['id']);

    ?>
    <div class="mb-2">
      <h4 class="mb-1"><?= h($row['title']) ?></h4>
      <div class="text-muted">
        작성자: <?= h($row['id']) ?> · 작성일: <?= ymd($row['time']) ?>
      </div>
    </div>

    <div class="border rounded p-3 mb-3" style="min-height:300px;">
      <?= nl2br(h($row['html'])) ?>
    </div>

    <div class="d-flex gap-2">
      <a class="btn btn-outline-secondary" href="/?cmd=board&bid=<?= $bid ?>&mode=list">목록</a>
      <?php if ($mineOrAdmin): ?>
        <a class="btn btn-outline-danger"
           href="/?cmd=board&bid=<?= $bid ?>&mode=delete&idx=<?= (int)$row['idx'] ?>"
           onclick="return confirm('정말 삭제하시겠습니까?');">삭제</a>
      <?php endif; ?>
    </div>
    <?php
    return;
}

if ($mode === 'delete') {
    if ($idx <= 0) {
        echo '<div class="alert alert-warning">잘못된 접근입니다. (idx 누락)</div>';
        return;
    }

    // 글 소유자 확인
    $stmt = mysqli_prepare($conn, "SELECT id FROM bbs WHERE idx = ? AND bid = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "ii", $idx, $bid);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);
    mysqli_free_result($res);
    mysqli_stmt_close($stmt);

    if (!$row) {
        echo '<div class="alert alert-warning">존재하지 않는 글입니다.</div>';
        return;
    }

    $mineOrAdmin = (isset($_SESSION['kpc_level']) && (int)$_SESSION['kpc_level'] === 9)
                   || (isset($_SESSION['kpc_id']) && $_SESSION['kpc_id'] === $row['id']);

    if (!$mineOrAdmin) {
        echo '<script>alert("삭제 권한이 없습니다."); location.href="/?cmd=board&bid=' . $bid . '&mode=show&idx=' . $idx . '";</script>';
        return;
    }

    $stmtD = mysqli_prepare($conn, "DELETE FROM bbs WHERE idx = ? AND bid = ? LIMIT 1");
    mysqli_stmt_bind_param($stmtD, "ii", $idx, $bid);
    $ok = mysqli_stmt_execute($stmtD);
    mysqli_stmt_close($stmtD);

    if ($ok) {
        echo '<script>alert("삭제되었습니다."); location.href="/?cmd=board&bid=' . $bid . '&mode=list";</script>';
        return;
    } else {
        $err = h(mysqli_error($conn));
        echo '<script>alert("삭제 실패: ' . $err . '"); location.href="/?cmd=board&bid=' . $bid . '&mode=show&idx=' . $idx . '";</script>';
        return;
    }
}

// 정의되지 않은 mode인 경우 list로
header('Location: /?cmd=board&bid=' . $bid . '&mode=list');
exit;
