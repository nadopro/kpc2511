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