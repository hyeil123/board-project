<?php
include "db.php";

// 댓글 삭제 기능
// 댓글 작성자만 자신의 댓글을 삭제할 수 있다.

login_check();

$id = $_GET["id"];
$post_id = $_GET["post_id"];

$comment_sql = "SELECT * FROM comments WHERE id=$id";
$comment_result = mysqli_query($conn, $comment_sql);
$comment = mysqli_fetch_assoc($comment_result);

if (!$comment || $_SESSION["user_id"] != $comment["user_id"]) {
    echo "<script>alert('댓글 삭제 권한이 없습니다.'); location.href='view.php?id=$post_id';</script>";
    exit;
}

mysqli_query($conn, "DELETE FROM comments WHERE id=$id");

header("Location: view.php?id=$post_id");
exit;
?>
