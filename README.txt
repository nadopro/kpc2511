download xampp
download visual code

http://localhost:8080
http://localhost:8080/phpmyadmin


새로운(왼쪽) --> 사용자 계정(탭) --> 사용자 추가

id : secure
pass : 1111
v 동명의 ..
v Grant ..
v 전체적 권한

자료의 다운로드
https://github.com/nadopro

여기에 접속해 kpc2511 폴더 클릭
https://github.com/nadopro/kpc2511

정규식

    [abc] 
    ls *.[ch] 
    [abc]{2}
        aa cb ac dc
    [abc]{2, 4}
    [abcdef....xyz]{4, 10}
    [a-z]{4, 10}
    [0-9]{4, 10} == \d{4, 10}
    ^[a-zA-Z0-9]{4, 10}$  \w

    92test34

    ^01[017]-[0-9]{4}-[0-9]{4}$

    \uAC00

    00 : 가
    01 : 각
    02 : 갂
    03 : 갃

    ...
    LAST : 힣

    됬다 ---> 됐다
    뷃

    ^[가-힣]{2, 4}$

https://w3schools.com
https://w3schools.com/bootstrap5

Q1. 데이터베이스

다음 조건을 만족하는 mysql 스키마를 만들어줘.
table name : first
각 필드는 다음과 같아.
id varchar(20)
name varchar(30)
pass varchar(30)

이렇게 만들어진 테이블에 데이터를 추가까지지 해줘.
name은 조선시대 역사책에 나오는 인물로 10명을 무작위로 넣어줘.
id : 이름을 기반으로 임의로 정해
모든 비밀번호는 암호화 없이 1111 로 정해.

github.com/nadopro/kpc2511


DROP TABLE IF EXISTS first;

-- 스키마 생성
CREATE TABLE first (
    id   VARCHAR(20)  NOT NULL,
    name VARCHAR(30)  NOT NULL,
    pass VARCHAR(30)  NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 데이터 삽입 (조선시대 인물 10명, 비밀번호는 모두 '1111')
INSERT INTO first (id, name, pass) VALUES
('yi_sunsin',       '이순신',     '1111'),
('sejong',          '세종',       '1111'),
('jeong_yakyong',   '정약용',     '1111'),
('shin_saimdang',   '신사임당',   '1111'),
('jang_youngsil',   '장영실',     '1111'),
('heo_jun',         '허준',       '1111'),
('ryu_seongryong',  '유성룡',     '1111'),
('kim_simin',       '김시민',     '1111'),
('kim_jeongho',     '김정호',     '1111'),
('jeong_cheol',     '정철',       '1111');

Q2.

다음 조건을 만족하는 index.php을 만들어 줘.
HTML5, Bootstrap5를 이용해서 반응형 홈페이지를 만들거야.
상단에는 Navbar를 이용해서 메뉴를 구성할거야.
메뉴에는 menu1, menu2, menu3이 있어.
각각의 메뉴는 dropdown으로 구성하는데,
menu1에는 menu1-1, menu1-2, menu1-3,
menu2에는 menu2-1, menu2-2
menu3에는 menu3-1, menu3-2

내용에는
"한국생산성본부 보안 프로그램" 만 써줘.
하단에는 사이트 정보가 있는데,
"한국 생산성본부(KPC)
정보보호책임자 : 홍길동 (help@kpc.or.kr)" 이렇게 적어줘.

만약에 본문의 내용이 너무 적은 경우에는 사이트정보를 화면의
맨 아래에 배치해 줘.

Q3.

이 코드에 데이터베이스를 연결할거야.
코드의 맨앞에 db.php라는 파일을 include 할 거야.

db.php에는 다음을 추가해 줘.
db name : secure
db user : secure
db pass : 1111
인데, connectDB()를 만들건데,
이 함수는 DB연결후, 접속정보인 conn 를 반환해

index.php에서는 db.php를 인클루드 후에
$conn = connectDB();

이렇게 구성해서 자동으로 DB연결이 되도록 할거야.

Q4.

index.php?cmd=login

이 코드를 다음과 같이 구조를 바꾸고 싶어.
navbar로 된 메뉴는 통채로 menu.php로 옮기고 싶어.
이 파일을 include로 처리해 줘.

index.php?cmd=test 와 같이 GET방식으로 cmd값을 차자.
만약에 cmd가 없으면 init를 default로 해 줘.
만약에 $cmd = $_GET['cmd'] 로 한 후, 디스플레이 하는 곳에
include "$cmd.php" 이렇게 처리하고 싶어.
init파일은 carousel로 이미지를 슬라이딩하고 싶어.
이미지는 img 폴더에 있고, ny.jpg, la.jpg, chicago.jpg가 있어.

즉 menu.php, init.php, index.php를 만들어 줘.


https://www.security.org/how-secure-is-my-password/

폴더만들기 : sess

Q5.

메뉴 아래에 로그인 여부를 버튼으로 표시하고 싶어.
로그인을 위해 세션으로 처리하는데,
세션 정보는 "sess"폴더에서 수행할거야.

우리가 현재 작업하는 구조는 모두 index.php를 통과하도록 되어있어.
맨 위에 세션이 저장되는 위치와 세션 시작을 표시해줘.

메뉴의 첫번째는 다음과 같이 수정했어.

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">취약점 찾기</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/?cmd=test">test</a></li>
            <li><a class="dropdown-item" href="/?cmd=injection">로그인(Injection)</a></li>
            <li><a class="dropdown-item" href="/?cmd=menu1-3">menu1-3</a></li>
          </ul>
        </li>

세션의 이름은 "kpc_id" : 사용자 아이디
"kpc_name" : 사용자 이름을 저장
"kpc_level" " 사용자의 등급(1: 사용자, 9: 관리자)

injection.php에는 로그인하는 코드를 만들어 줘.
만약에 로그인 된 경우에는 메뉴 밑에 오른쪽에 버튼 "홍길동님 로그아웃"
버튼을 만들고
로그인이 안된경우에는 "로그인" 버튼을 만들고 클릭하면 index.php?cmd=injection 
로 이동해 줘.

    즉 injection.php 파일을 만들고, menu밑에 로그인여부 버튼을 만들고,
    index.php 을 수정해 줘.


Q6.

로그인은 하드코딩하거랴.
id : admin, pass : 1111 ==> 관리자로 로그인 , 레벨 9
id : test, pass : 1111 ==> "테스트"로 로그인 , 레벨 1
나머지는 "아이디와 비밀번호를 확인하세요" alert()해 줘.
injection.php 파일을 수정해 줘.


주소창에 입력

javascript:alert(document.cookie);

download burp suite

=====================================================
                    Day 2
=====================================================

netstat -ano | findstr ":80"
netsh http show urlacl

sc query W3SVC
sc query WAS
sc query MsDepSvc

net stop W3SVC
net stop WAS
net stop MsDepSvc

sc config W3SVC start= disabled
sc config WAS start= disabled
sc config MsDepSvc start= disabled


0001 0010 0011 0100 : 1.2.3.4
0001 0010 0011 0111 : 1.2.3.7
1111 1111 1111 0000 :255.255.255.0
0001 0010 0011 0000 : 1.2.3.0

175.114.70.15


0000 0000
0111 1111 : 0 - 127 : A class
  50.*.*.* : 1600만개
  10.*.*.* : private ip
  127.*.*.* : loop back address
1000 0000
1011 1111  : 128 - 191  : B class
  175.114.*.* : 65K
  172.*. :private address
1100 0000
1101 1111 : 192 - 221 : class
  200.12.10-15.*
  192.168.*.*

  Q7.

  회원가입한 사용자 정보를 모아놓은 데이터베이스 테이블을 
  다음과 같이 만들거야.

  table name : users
  idx : int, auto_increment, primary KEY
  name : varchar(30)
  id : varchar(30), unique
  pass : varchar(50),
  level : 회원 등급(1:일반회원, 9: 관리자)


CREATE TABLE users (
  idx INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(30) NOT NULL,
  id VARCHAR(30) NOT NULL UNIQUE,
  pass VARCHAR(50) NOT NULL,
  level TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

insert into users (name, id, pass, level)
  values('테스트', 'test', 'abcd', '1');
insert into users (name, id, pass, level)
  values('관리자', 'admin', 'abcd', '9'); 
insert into users (name, id, pass, level)
  values('홍길동', 'kdhong', 'bcde', '1'); 
insert into users (name, id, pass, level)
  values('이순신', 'sslee', 'defg', '1');

Q8.
다음과 같이 하드코딩된 로그인하는 코드가 있어.
이것을 조금 전에 만든 users 테이블과 연동하는 코드로 바꾸고 싶어.
mysqli_fetch_array()를 이용해서 작성해 줘.

<?php
// injection.php
// 하드코딩 로그인 전용
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

    // 하드코딩 계정
    if ($id === 'admin' && $pw === '1111') {
        $_SESSION['kpc_id']    = 'admin';
        $_SESSION['kpc_name']  = '관리자';
        $_SESSION['kpc_level'] = 9;
        $ok = true;
    } elseif ($id === 'test' && $pw === '1111') {
        $_SESSION['kpc_id']    = 'test';
        $_SESSION['kpc_name']  = '테스트';
        $_SESSION['kpc_level'] = 1;
        $ok = true;
    }

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
    <form method="post" action="/?cmd=injection">
      <div class="mb-3">
        <label class="form-label">ID</label>
        <input type="text" name="id" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">PW</label>
        <input type="password" name="pw" class="form-control" required>
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">로그인</button>
        <a href="/?cmd=init" class="btn btn-outline-secondary">취소</a>
      </div>
    </form>
    <hr>
    <div class="text-muted small mt-2">
      * 테스트 계정: admin / 1111 (레벨 9), test / 1111 (레벨 1)
    </div>
  </div>
</div>

$id = "test";
$pass = "1111";

select * from users where id='$id' and pass='$pass' ;
                            aaaa' or 2>1 -- 
select * from users where id='aaaa' or 2>1 -- ' and pass='$pass' ;


TCP/IP

naming rule

secureLogin

myFamilyCount, my_family_count


Q9.

<?php
// injection.php
// 하드코딩 로그인 전용
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

현재 sql injection 테스트를 위한 로그인 파일(secureLogin.php)이
다음처럼 만들어져있어.
첫번째, 사용자 로그인 버튼을 눌렀을때, 입력값 검사를 수행하고 싶어.
1. 아이디와 비밀번호에는 공백(space), 따옴표(' 또는 "), 빼기표시(-)
가 안들어가도록 정규식으로 검사하고, 아이디와 비번 모두 4글자 이상이어야 해.

2. 이를 수신한 서버에서는 아이디와 비번에 특수 문자 등이 안들어가서
sql injection을 방지하도록 아래 코드를 수정해 줘.

<div class="row justify-content-center">
  <div class="col-12 col-md-6">
    <h3 class="mb-3">로그인</h3>
    <form method="post"  action="/?cmd=secureLogin">
      <div class="mb-3">
        <label class="form-label">ID</label>
        <input type="text" name="id"  class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">PW</label>
        <input type="password" name="pw" class="form-control" required>
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">로그인</button>
        <a href="/?cmd=init" class="btn btn-outline-secondary">취소</a>
      </div>
    </form>
    <hr>
    <div class="text-muted small mt-2">
      * 테스트 계정: admin / abcd (레벨 9), test / abcd (레벨 1)
    </div>
  </div>
</div>


for(i=1; i<=1000000; i++)
{
  connect();
  insert();
  close();
}

connect();
for(i=1; i<=1000000; i++)
{
  insert...();
}
close();


https://www.zaproxy.org/

Q10.

index.php?cmd=brute와 같이 접속할거야.
index.php에는 이미 include "db.php"를 수행해서
연결을 마친상태야.(연결 정보 : $conn)

get으로 넘어온 cmd값인 brute를 인클루드하는 
즉, include "brute.php"하는 이 파일을 만들고 싶어.

영문으로 된 텍스트를 찾는 원리를 코드로 만들고 싶어.
예를 들어, aaaa, aaab, aaac.... zzzz까지 검사하는 코드야.
users 테이블의 비밀번호와 이 텍스트가 같은지 비교하는 코드를 작성할 거야.
만약 하나라도 찾으면,
동일한 비밀번호를 같는 아이디를 모두 출력하고 프로그램을 종료해 줘.

===========================

다음과 같은 코드를 응용해서 다른 코드를 만들고 싶어.

<?php

    $letters = "abcdefghij";
    $size = strlen($letters);
    echo "size = $size<br>";

    $cnt = 0;

    for($i = 0; $i < $size; $i++)
    {
        for($j = 0; $j < $size; $j++)
        {
            for($k = 0; $k < $size; $k++)
            {
                for($l = 0; $l < $size; $l++)
                {
                    $cnt ++;

                    $pass = $letters[$i] . $letters[$j] . $letters[$k] . $letters[$l];
                    $sql = "select * from users where pass='$pass' ";
                    $result = mysqli_query($conn, $sql);
                    $data = mysqli_fetch_array($result);
                    if($data)
                    { // find
                        while($data)
                        {
                            $id = $data["id"];
                            echo "id = $id, pass = $pass <br>";
                            $data = mysqli_fetch_array($result);
                        }

                        // exit();
                    }
                    if($cnt > 100000)
                        exit();
                }
            }
        }
    
    }

?>


이 코드를 수정해서 사용자 입력으로 len를 입력받은 후, 실행 버튼을 클릭하면
프로그램이 실행돼.
만약에 5인 경우라면
4글자를 모두 검사한 후, 5글자를 검사해
만약 6인 경우라면
4글자 모두 검사 --> 5글자 모두 검사 --> 6글자 검사
하도록 프로그램을 수정해 줘.



main()
{
  a(); // A 
  b(); // B 
  c(); // C 
  fflush(); fd.flush();
  d(); // D 
  e(); // E 
}

A 
B 


Q12.

다음 코드를 응용해서 코드를 변경해 줘.

<?php

    $letters = "abcdefghij";
    $size = strlen($letters);
    echo "size = $size<br>";

    $cnt = 0;

    for($i = 0; $i < $size; $i++)
    {
        for($j = 0; $j < $size; $j++)
        {
            for($k = 0; $k < $size; $k++)
            {
                for($l = 0; $l < $size; $l++)
                {
                    $cnt ++;

                    $pass = $letters[$i] . $letters[$j] . $letters[$k] . $letters[$l];
                    $sql = "select * from users where pass='$pass' ";
                    $result = mysqli_query($conn, $sql);
                    $data = mysqli_fetch_array($result);
                    if($data)
                    { // find
                        while($data)
                        {
                            $id = $data["id"];
                            echo "id = $id, pass = $pass <br>";
                            $data = mysqli_fetch_array($result);
                        }

                        exit();
                    }
                    if($cnt > 100000)
                        exit();
                }
            }
        }
    
    }

?>


이때, $cnt 가 없으면 0이고
0 일때는 aaaa 라는 문자를 만들고,
1 일때는 aaab 라는 문자를 만들고,
2 일때는 aaac 라는 문자를 만들어.

이렇게 cnt값에 따라 조합 가능한 모든 문자열을 순차적으로 증가하는데,
index.php?cmd=brute3&cnt=1
이렇게 GET 방식으로 cnt가 결정되면 해당하는 문자인 (예: aaaa)를 찾아
데이터베이스를 검사해.

cnt값을 증가시켜서 다음 링크로 이동해.
setTimeout을 이용해 1초마다 한번씩 호출하도록 변경해 줘.


Q13.

webshell.php 파일을 하나 만들고 싶어.

상단에 다음과 같이 구성되어 있어.

<div class="row">
  <div class="col-2 text-end">명령</div>
  <div class="col text-end">
    <input type="text" name="command" class="form-control" placeholder="명령을 입력하세요">
  </div>
  <div class="col-2 text-end">
    <button type="btn btn-primary">실행</button>
  </div>
</div>

실행을 누른 경우, 하단에 명령을 수행하도록 해 줘.
한글 깨짐이 없도록 주의해서 만들어 줘.

Q14.

다음과 같은 Mysql 스키마를 하나 정의해 줘.
table name : log
필드 정보 :
  idx: integer, auto_increment, primary key 
  ip: IP Address 예: 1.2.3.4
  id : 사용자 아이디 (최대 30자)
  work : varchar(255)
  time : datetime -- 2025-11-04 12:34:56


CREATE TABLE `log` (
  `idx` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip` VARCHAR(20)    NOT NULL,
  `id` VARCHAR(30)    NOT NULL ,
  `work` VARCHAR(255) NOT NULL,
  `time` DATETIME      NOT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


=====================================================
                    Day 3
=====================================================

void print(char *ptr)
{
	char buf[100];
	bzero(buf, sizeof(buf));
	strcpy(buf, ptr);
}

// ./test Hello
// ./test "hello world"

int main(int argc, char **argv)
{
	print(argv[1]);
	return 0;
}

게시판 ..

Q15.
게시판을 위해서 Mysql 스키마를 만들려고 해.

table name : bbs
idx : 게시글의 키값, 자동 증가
bid : 게시판의 종류, 예: 1(공지사항), 2(자유게시판)
title : 게시글의 제목
html : 게시글의 내용, mediumtext
id : 사용자 아이디
file : 파일의 이름
time : datetime


CREATE TABLE bbs (
  idx   INT UNSIGNED NOT NULL AUTO_INCREMENT primary key,
  bid   TINYINT UNSIGNED NOT NULL COMMENT '1=공지, 2=자유',
  title VARCHAR(200) NOT NULL,
  html  MEDIUMTEXT NOT NULL,
  id    VARCHAR(30) NOT NULL COMMENT '작성자 아이디',
  file  VARCHAR(255) DEFAULT NULL COMMENT '첨부 파일명',
  time  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO bbs (bid, title, html, id, file, time) VALUES
(1, '공지사항 게시판 글쓰기 1', '공지사항 게시판 글쓰기 1번째 테스트', 'admin', NULL, NOW()),
(1, '공지사항 게시판 글쓰기 2', '공지사항 게시판 글쓰기 2번째 테스트', 'admin', NULL, NOW()),
(2, '자유게시판 글쓰기 1', '자유게시판 글쓰기 1번째 테스트', 'admin', NULL, NOW()),
(2, '자유게시판 글쓰기 2', '자유게시판 글쓰기 2번째 테스트', 'admin', NULL, NOW());

Q16.

index.php?cmd=board&bid=1
index.php?cmd=board&bid=2

이런 형태로 게시판을 요청할거야.
모든 파일은 index.php를 거쳐서 가고 데이터베이스 설정은 이미 끝나서
$conn에 모든 접속정보를 포함하기 때문에,
board.php는 순수한 게시판 동작만 있으면 돼.

GET방식으로 $mode를 확인해서
$mode가 없으면 $mode = "list", 즉 목록 보기

$mode == "write" : 글 쓰기
$mode == "show" : 글 내용보기

이때 각각의 기능은 다음과 같아.

글 목록 보기($mode = "list")
  bbs 테이블에서 목록 10개씩 보여줘.
  순서, 제목, 작성일
  제목을 클릭하면 글 내용보기($mode = "show")로 이동
  화면 하단에는 "글쓰기"버튼, 페이지별로 보기 가 배치돼
  글쓰기를 누르면, "mode=write"로 이동해

글쓰기(mode = write)
제목, 작성자, 내용입력(textarea)
화면 하단에는 글등록, 목록보기 버튼이 있어.
글등록버튼을 누르면 bbs테이블에 삽입후, 목록으로 해.

글 내용 보기($mode = "show")
제목, 작성자, 작성일, 글 내용보기
글 내용보기에서 줄바꿈이 있는 경우에는 <br>처리를 해줘.
만약 글 내용이 아무리 적어도 글 내용의 공간을 높이 300px을 최소한 자리를 잡아줘.
하단에는 삭제와 목록 버튼이 있고,
삭제는 글쓴 사람(세션 : kpc_id, kpc_level)이거나 관리자(kpc_level == 9)은
삭제가 가능해


board.php 파일을 만들어 줘.

Q17.
지금 만든 코드를 보안 공부를 하기 위해서
mysqli_query("insert into ..");
이런 형태의 단순한 쿼리로 바꿔줘.
데이터를 가져올때는 mysqli_fetch_array($conn, $result);
형태로 바꿔줘.
코드를 잘못 만들면 XSS와 같은 공격을 당할 수 있다는 것을 학습하려고해.


<script>
  for(var i = 1; i <= 3; i++)
  {
    location.href=''
  }
</script>

스크립트 테스트입니다.
<script>for(var i=1; i<=3; i++) alert(i); </script>

XSS : Cross Site Scripting

X : Ex 
XP : Expert
XML : 
X : Xmit : trans

WYSIWIG : What You See Is What You Get

Q18.

WYSIWYG 게시판에서 글쓰기 하는 부분을 예제로 만들고 싶어.
index.php?cmd=editor

editor.php 파일을 만들어줘.

상단에는 제목, 버튼 입력부, 글쓰기 부, 글등록 버튼
버튼입력부에는 Bold, Underline, Italic 버튼을 만들거야.
이 버튼은 material-icons를 이용할건데,
이를 위해 index.php에 이미
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
이렇게 등록해 놨어.
이런 예제를 하나 만들어 줘. 글쓰기 부분만 있으면 돼


d3js.org

Q19.

다음과 같은 MySQL 스키마를 만들어 줘.

table name : sensor
필드 정보는 다음과 같아.

idx : 키값, 자동 증가
temp : 온도 저장, float
hum : 습도 저장 , float
time : datetime

CREATE TABLE sensor (
  idx  INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  temp FLOAT NOT NULL ,
  hum  FLOAT NOT NULL ,
  time DATETIME 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

insert into sensor (temp, hum, time) 
  values('27.5', '60.1', now());
