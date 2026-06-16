<?php
include "db.php";

// 게시글 삭제 기능
// 작성자만 게시글을 삭제할 수 있다.

login_check();

$id = $_GET["id"];

$post_sql = "SELECT * FROM posts WHERE id=$id";
$post_result = mysqli_query($conn, $post_sql);
$post = mysqli_fetch_assoc($post_result);

if (!$post || $_SESSION["user_id"] != $post["user_id"]) {
    echo "<script>alert('삭제 권한이 없습니다.'); location.href='index.php';</script>";
    exit;
}

$file_sql = "SELECT * FROM attachments WHERE post_id=$id";
$file_result = mysqli_query($conn, $file_sql);

while ($file = mysqli_fetch_assoc($file_result)) {
    if (file_exists($file["stored_path"])) {
        unlink($file["stored_path"]);
    }
}

$board_id = $post["board_id"];

mysqli_query($conn, "DELETE FROM posts WHERE id=$id");

header("Location: index.php?board_id=$board_id");
exit;
?>
