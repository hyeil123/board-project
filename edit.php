<?php
include "db.php";

$id = $_GET["id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];

    $sql = "UPDATE posts SET title='$title', content='$content' WHERE id=$id";
    mysqli_query($conn, $sql);

    header("Location: view.php?id=$id");
    exit;
}

$sql = "SELECT * FROM posts WHERE id=$id";
$result = mysqli_query($conn, $sql);
$post = mysqli_fetch_assoc($result);
?>

<h2>글 수정</h2>

<form method="post">
    제목: <input type="text" name="title" value="<?php echo $post["title"]; ?>"><br><br>
    내용:<br>
    <textarea name="content" rows="10" cols="50"><?php echo $post["content"]; ?></textarea><br><br>
    <button type="submit">수정</button>
</form>

<a href="view.php?id=<?php echo $id; ?>">취소</a>
