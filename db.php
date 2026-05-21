<?php
$conn = mysqli_connect("localhost", "boarduser", "1234", "board_db");

if (!$conn) {
    die("DB 연결 실패: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>
