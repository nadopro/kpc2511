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
