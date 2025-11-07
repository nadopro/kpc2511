<?php
// db.php
// MySQL 접속 정보
function connectDB() {
    $host = "localhost";   // XAMPP 기본
    $user = "secure";
    $pass = "1111";
    $db   = "secure";

    // MySQLi 연결
    $conn = new mysqli($host, $user, $pass, $db);

    // 연결 확인
    if ($conn->connect_error) {
        die("Database Connection Failed: " . $conn->connect_error);
    }

    // UTF-8 설정
    $conn->set_charset("utf8mb4");

    return $conn;
}

?>
