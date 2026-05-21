<?php
include "db.php";

$id = $_GET["id"];
$post_id = $_GET["post_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST["content"];

    $sql = "UPDATE comments SET content='$content' WHERE id=$id";
    mysqli_query($conn, $sql);

    header("Location: view.php?id=$post_id");
    exit;
}

$sql = "SELECT * FROM comments WHERE id=$id";
$result = mysqli_query($conn, $sql);
$comment = mysqli_fetch_assoc($result);
?>

<h2>댓글 수정</h2>

<form method="post">
    <textarea name="content" rows="5" cols="50"><?php echo $comment["content"]; ?></textarea><br><br>
    <button type="submit">댓글 수정</button>
</form>

<a href="view.php?id=<?php echo $post_id; ?>">취소</a>
