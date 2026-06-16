<?php
include "db.php";

// 댓글 작성 기능
// 로그인한 사용자만 댓글을 작성할 수 있으며 작성자 번호를 함께 저장한다.

login_check();

$post_id = $_POST["post_id"];
$user_id = $_SESSION["user_id"];
$content = $_POST["content"];

$sql = "INSERT INTO comments (post_id, user_id, content)
        VALUES ('$post_id', '$user_id', '$content')";
mysqli_query($conn, $sql);

header("Location: view.php?id=$post_id");
exit;
?>
