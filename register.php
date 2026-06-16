<?php
include "db.php";

// 회원가입 기능
// 사용자가 입력한 아이디와 비밀번호를 users 테이블에 저장한다.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('회원가입 완료'); location.href='login.php';</script>";
    } else {
        echo "<script>alert('이미 존재하는 아이디입니다.');</script>";
    }
}
?>

<h2>회원가입</h2>

<form method="post">
    아이디: <input type="text" name="username" required><br><br>
    비밀번호: <input type="password" name="password" required><br><br>
    <button type="submit">회원가입</button>
</form>

<a href="login.php">로그인</a>
