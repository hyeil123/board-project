<?php
// MariaDB(board_db)와 연결
// 다른 PHP 파일에서 include하여 사용
$conn = mysqli_connect("localhost", "boarduser", "1234", "board_db");

if (!$conn) {
    die("DB 연결 실패: " . mysqli_connect_error());
}
// 한글 깨짐 방지
mysqli_set_charset($conn, "utf8mb4");
?>
