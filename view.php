<?php
include "db.php";

$id = $_GET["id"];

$post_sql = "SELECT * FROM posts WHERE id = $id";
$post_result = mysqli_query($conn, $post_sql);
$post = mysqli_fetch_assoc($post_result);

$file_sql = "SELECT * FROM attachments WHERE post_id = $id";
$file_result = mysqli_query($conn, $file_sql);

$comment_sql = "SELECT * FROM comments WHERE post_id = $id ORDER BY id DESC";
$comment_result = mysqli_query($conn, $comment_sql);
?>

<h2><?php echo $post["title"]; ?></h2>
<p><?php echo nl2br($post["content"]); ?></p>
<p>작성일: <?php echo $post["created_at"]; ?></p>

<a href="edit.php?id=<?php echo $id; ?>">수정</a>
<a href="delete.php?id=<?php echo $id; ?>">삭제</a>
<a href="index.php">목록</a>

<hr>

<h3>첨부파일</h3>
<?php while ($file = mysqli_fetch_assoc($file_result)) { ?>
    <p>
        <a href="download.php?id=<?php echo $file["id"]; ?>">
            <?php echo $file["original_name"]; ?>
        </a>
    </p>
<?php } ?>

<hr>

<h3>댓글</h3>

<form action="comment_add.php" method="post">
    <input type="hidden" name="post_id" value="<?php echo $id; ?>">
    <textarea name="content" rows="3" cols="50"></textarea><br>
    <button type="submit">댓글 작성</button>
</form>

<?php while ($comment = mysqli_fetch_assoc($comment_result)) { ?>
    <p>
        <?php echo nl2br($comment["content"]); ?>
        <br>
        <small><?php echo $comment["created_at"]; ?></small>
        <br>
        <a href="comment_edit.php?id=<?php echo $comment["id"]; ?>&post_id=<?php echo $id; ?>">댓글 수정</a>
        <a href="comment_delete.php?id=<?php echo $comment["id"]; ?>&post_id=<?php echo $id; ?>">댓글 삭제</a>
    </p>
    <hr>
<?php } ?>
