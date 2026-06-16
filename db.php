<?php
// 데이터베이스 연결 및 로그인 세션 관리 기능
// 모든 PHP 파일에서 include하여 DB 연결과 로그인 상태를 사용한다.

session_start();

$conn = mysqli_connect("localhost", "boarduser", "1234", "board_db");

if (!$conn) {
    die("DB 연결 실패: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

// 로그인 여부 확인 함수
function is_login() {
    return isset($_SESSION["user_id"]);
}

// 로그인이 필요한 페이지에서 사용하는 함수
function login_check() {
    if (!is_login()) {
        echo "<script>alert('로그인이 필요합니다.'); location.href='login.php';</script>";
        exit;
    }
}
?>
