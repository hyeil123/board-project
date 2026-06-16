<?php
include "db.php";

// 로그인 기능
// 아이디와 비밀번호가 일치하면 세션에 사용자 정보를 저장한다.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('아이디 또는 비밀번호가 틀렸습니다.');</script>";
    }
}
?>

<h2>로그인</h2>

<form method="post">
    아이디: <input type="text" name="username" required><br><br>
    비밀번호: <input type="password" name="password" required><br><br>
    <button type="submit">로그인</button>
</form>

<a href="register.php">회원가입</a>
