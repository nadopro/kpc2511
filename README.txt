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
