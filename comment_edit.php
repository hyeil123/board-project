<?php
include "db.php";

// 댓글 수정 기능
// 댓글 작성자만 자신의 댓글을 수정할 수 있다.

login_check();

$id = $_GET["id"];
$post_id = $_GET["post_id"];

$comment_sql = "SELECT * FROM comments WHERE id=$id";
$comment_result = mysqli_query($conn, $comment_sql);
$comment = mysqli_fetch_assoc($comment_result);

if (!$comment || $_SESSION["user_id"] != $comment["user_id"]) {
    echo "<script>alert('댓글 수정 권한이 없습니다.'); location.href='view.php?id=$post_id';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST["content"];

    $sql = "UPDATE comments SET content='$content' WHERE id=$id";
    mysqli_query($conn, $sql);

    header("Location: view.php?id=$post_id");
    exit;
}
?>

<h2>댓글 수정</h2>

<form method="post">
    <textarea name="content" rows="5" cols="50" required><?php echo $comment["content"]; ?></textarea><br><br>
    <button type="submit">댓글 수정</button>
</form>

<a href="view.php?id=<?php echo $post_id; ?>">취소</a>
