<?php
// 필수 파라미터 확인
$cmd = $_GET['cmd'] ?? null;
$bid = $_GET['bid'] ?? null;

// 게시판 종류 정의
$boardNames = [
    1 => '자유게시판',
    2 => 'QnA게시판'
];
$boardName = $boardNames[$bid] ?? null;
if (!$boardName) {
    die('존재하지 않는 게시판입니다.');
}

// mode 결정
$mode = $_GET['mode'] ?? 'list';
$idx = $_GET['idx'] ?? null;
$bid = $_GET['bid'];

// index.php?cmd=board&bid=1
// index.php?cmd=board&bid=1+where &idx=2

if(is_numeric($bid)  )
{

}else
{
    echo "
    <script>
        location.href='http://warning.or.kr';
    </script>
    ";
    exit();
}

// 글 목록 보기
if ($mode === 'list') {
    $page = $_GET['page'] ?? 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $query = "SELECT idx, title, id, time FROM bbs WHERE bid = $bid ORDER BY idx DESC LIMIT $offset, $limit";
    $result = mysqli_query($conn, $query);
    
    echo "<h2>$boardName</h2>";
    echo "
    <div class='row'>
        <table class='table table-bordered'>
            <tr>
                <th class='col'>번호</th>
                <th class='col-7'>제목</th>
                <th class='col'>작성자</th>
                <th class='col'>작성일</th>
            </tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td class='col'>{$row['idx']}</td>
                        <td class='col-7'><a href='index.php?cmd=board&bid=$bid&mode=show&idx={$row['idx']}'>{$row['title']}</a></td>
                        <td class='col'>{$row['id']}</td>
                        <td class='col'>{$row['time']}</td>
                    </tr>";
    }
    echo "</table>
    </div>
    ";

    // 글쓰기 버튼
    echo "<a href='index.php?cmd=board&bid=$bid&mode=write'><button class='btn btn-primary'>글쓰기</button></a>";
    exit;
}

// 게시글 보기
if ($mode === 'show' && $idx) {
    $query = "SELECT * FROM bbs WHERE bid = $bid AND idx = $idx";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    if (!$row) die('글을 찾을 수 없습니다.');

    $row['html'] = nl2br($row['html']);

    echo "
    <div class='row'>
        <div class='col-2 colLine'>제목</div>
        <div class='col colLine'>{$row['title']}</div>
    </div>
    <div class='row'>
        <div class='col-2 colLine'>작성자</div>
        <div class='col colLine'>{$row['id']}</div>
    </div>
    <div class='row'>
        <div class='col-2 colLine'>작성일</div>
        <div class='col colLine'>{$row['time']}</div>
    </div>
    <div class='row'>
        <div class='col colLine' style='height:300px; min-height:300px;'>{$row['html']}</div>
    </div>
    <div class='row'>
        <div class='col-2 colLine'>첨부</div>
        <div class='col colLine'>";  
        if ($row['file']) {
            echo "<p>첨부파일: <a href='uploads/{$row['file']}' download>{$row['file']}</a></p>";
        }
        echo "</div>
    </div>
    <div class='row'>
        <div class='col colLine text-center'>
            <a href='index.php?cmd=board&bid=$bid&mode=list'><button class='btn btn-primary'>목록보기</button></a> 
            <a href='index.php?cmd=board&bid=$bid&mode=write&idx=$idx'><button  class='btn btn-primary'>수정하기</button></a>
            <a href='index.php?cmd=board&bid=$bid&mode=delete&idx=$idx'><button  class='btn btn-primary'>삭제하기</button></a>
        </div>
    </div>
    ";

 
    exit;
}

// 글쓰기/수정 화면
if ($mode === 'write') {
    $title = $html = $file = '';
    if ($idx) { // 수정일 경우
        $query = "SELECT * FROM bbs WHERE bid = $bid AND idx = $idx";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        if (!$row) die('글을 찾을 수 없습니다.');
        $title = $row['title'];
        $html = $row['html'];
        $file = $row['file'];
    }

    
    echo "<h2>" . ($idx ? "글 수정" : "글 쓰기") . "</h2>";
    echo "<form method='post' action='index.php?cmd=board&bid=$bid&mode=dbwrite' enctype='multipart/form-data'>";
    
    // 게시글 번호 (수정용)
    if ($idx) {
        echo "<input type='hidden' name='idx' value='$idx'>";
    }
    
    // 제목 입력
    echo "<div class='row mb-3'>";
    echo "  <div class='col-2 colLine text-end'>제목</div>";
    echo "  <div class='col colLine'>";
    echo "      <input type='text' name='title' value='$title' class='form-control'>";
    echo "  </div>";
    echo "</div>";
    
    // 작성자 (읽기 전용)
    echo "<div class='row mb-3'>";
    echo "  <div class='col-2 colLine text-end'>작성자</div>";
    echo "  <div class='col colLine'>";
    echo "      <input type='text' name='id' value='{$_SESSION['kpcid']}' class='form-control' readonly>";
    echo "  </div>";
    echo "</div>";
    
    // 내용 입력
    echo "<div class='row mb-3'>";
    echo "  <div class='col-2 colLine text-end'>내용</div>";
    echo "  <div class='col colLine'>";
    echo "      <textarea name='html' rows='10' class='form-control'>$html</textarea>";
    echo "  </div>";
    echo "</div>";
    
    // 파일 첨부
    echo "<div class='row mb-3'>";
    echo "  <div class='col-2 colLine text-end'>파일</div>";
    echo "  <div class='col colLine'>";
    echo "      <input type='file' name='file' class='form-control'>";
    echo "  </div>";
    echo "</div>";
    
    // 버튼
    echo "<div class='row'>";
    echo "  <div class='col-2'></div>"; // 왼쪽 여백
    echo "  <div class='col'>";
    echo "      <a href='index.php?cmd=board&bid=$bid&mode=list' class='btn btn-secondary'>목록보기</a>";
    echo "      <button type='submit' class='btn btn-primary'>글등록</button>";
    echo "  </div>";
    echo "</div>";
    
    echo "</form>";
  
    
    exit;
}

// 글 등록(DB 저장)
if ($mode === 'dbwrite' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $html = $_POST['html'];
    $id = $_POST['id'];
    $file = $_FILES['file']['name'] ?? null;

    /*
    $title = str_replace("<", "&lt;", $title);
    $title = str_replace(">", "&gt;", $title);

    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $html = htmlspecialchars($html, ENT_QUOTES, 'UTF-8');;

    $html = str_replace("<", "&lt;", $html);
    $html = str_replace(">", "&gt;", $html);
    */
    
    // 파일 업로드 처리
    if ($file) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES['file']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], $targetFile);
    }

    if (isset($_POST['idx'])) { // 수정
        $idx = $_POST['idx'];
        $query = "UPDATE bbs SET title='$title', html='$html', file='$file' WHERE idx=$idx";
    } else { // 새 글
        $query = "INSERT INTO bbs (bid, title, html, id, file)
                     VALUES ($bid, '$title', '$html', '$id', '$file')";
    }
    $result = mysqli_query($conn, $query);
    echo "
    
    <script>
        location.href='index.php?cmd=board&bid=$bid&mode=list';
    </script>
    ";

    exit;
}

// 글 삭제
if ($mode === 'delete' && $idx) {
    $query = "DELETE FROM bbs WHERE idx = $idx AND bid = $bid";
    mysqli_query($conn, $query);
    header("Location: index.php?cmd=board&bid=$bid&mode=list");
    exit;
}
?>