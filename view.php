<?php
include "db.php";

// 게시글 상세 조회 기능
// 게시글 내용, 작성자, 첨부파일, 댓글을 함께 출력한다.

$id = $_GET["id"];

$post_sql = "SELECT posts.*, users.username, boards.name AS board_name
             FROM posts
             JOIN users ON posts.user_id = users.id
             JOIN boards ON posts.board_id = boards.id
             WHERE posts.id = $id";
$post_result = mysqli_query($conn, $post_sql);
$post = mysqli_fetch_assoc($post_result);

$file_sql = "SELECT * FROM attachments WHERE post_id = $id";
$file_result = mysqli_query($conn, $file_sql);

$comment_sql = "SELECT comments.*, users.username
                FROM comments
                JOIN users ON comments.user_id = users.id
                WHERE comments.post_id = $id
                ORDER BY comments.id DESC";
$comment_result = mysqli_query($conn, $comment_sql);
?>

<h2><?php echo $post["title"]; ?></h2>

<p>게시판: <?php echo $post["board_name"]; ?></p>
<p>작성자: <?php echo $post["username"]; ?></p>
<p>작성일: <?php echo $post["created_at"]; ?></p>

<hr>

<p><?php echo nl2br($post["content"]); ?></p>

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

<?php if (is_login() && $_SESSION["user_id"] == $post["user_id"]) { ?>
    <a href="edit.php?id=<?php echo $id; ?>">수정</a>
    <a href="delete.php?id=<?php echo $id; ?>" onclick="return confirm('삭제하시겠습니까?');">삭제</a>
<?php } ?>

<a href="index.php?board_id=<?php echo $post["board_id"]; ?>">목록</a>

<hr>

<h3>댓글</h3>

<?php if (is_login()) { ?>
<form action="comment_add.php" method="post">
    <input type="hidden" name="post_id" value="<?php echo $id; ?>">
    <textarea name="content" rows="3" cols="50" required></textarea><br>
    <button type="submit">댓글 작성</button>
</form>
<?php } else { ?>
<p>댓글을 작성하려면 로그인하세요.</p>
<?php } ?>

<?php while ($comment = mysqli_fetch_assoc($comment_result)) { ?>
    <p>
        <b><?php echo $comment["username"]; ?></b><br>
        <?php echo nl2br($comment["content"]); ?><br>
        <small><?php echo $comment["created_at"]; ?></small><br>

        <?php if (is_login() && $_SESSION["user_id"] == $comment["user_id"]) { ?>
            <a href="comment_edit.php?id=<?php echo $comment["id"]; ?>&post_id=<?php echo $id; ?>">댓글 수정</a>
            <a href="comment_delete.php?id=<?php echo $comment["id"]; ?>&post_id=<?php echo $id; ?>">댓글 삭제</a>
        <?php } ?>
    </p>
    <hr>
<?php } ?>
