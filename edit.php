<?php
include "db.php";

// 게시글 수정 기능
// 작성자만 게시글 제목/내용/첨부파일을 수정할 수 있다.

login_check();

$id = $_GET["id"];

$post_sql = "SELECT * FROM posts WHERE id=$id";
$post_result = mysqli_query($conn, $post_sql);
$post = mysqli_fetch_assoc($post_result);

if (!$post || $_SESSION["user_id"] != $post["user_id"]) {
    echo "<script>alert('수정 권한이 없습니다.'); location.href='index.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];

    $sql = "UPDATE posts SET title='$title', content='$content' WHERE id=$id";
    mysqli_query($conn, $sql);

    if (isset($_FILES["upload_file"]) && $_FILES["upload_file"]["error"] == 0) {
        $old_file_sql = "SELECT * FROM attachments WHERE post_id=$id";
        $old_file_result = mysqli_query($conn, $old_file_sql);

        while ($old_file = mysqli_fetch_assoc($old_file_result)) {
            if (file_exists($old_file["stored_path"])) {
                unlink($old_file["stored_path"]);
            }
        }

        mysqli_query($conn, "DELETE FROM attachments WHERE post_id=$id");

        $originalName = $_FILES["upload_file"]["name"];
        $tmpName = $_FILES["upload_file"]["tmp_name"];
        $fileSize = $_FILES["upload_file"]["size"];

        $ext = pathinfo($originalName, PATHINFO_EXTENSION);
        $storedName = uniqid() . "." . $ext;
        $storedPath = "uploads/" . $storedName;

        move_uploaded_file($tmpName, $storedPath);

        $file_sql = "INSERT INTO attachments (post_id, original_name, stored_path, file_size)
                     VALUES ('$id', '$originalName', '$storedPath', '$fileSize')";
        mysqli_query($conn, $file_sql);
    }

    header("Location: view.php?id=$id");
    exit;
}
?>

<h2>글 수정</h2>

<form method="post" enctype="multipart/form-data">
    제목: <input type="text" name="title" value="<?php echo $post["title"]; ?>" required><br><br>

    내용:<br>
    <textarea name="content" rows="10" cols="50" required><?php echo $post["content"]; ?></textarea><br><br>

    새 파일 선택: <input type="file" name="upload_file"><br>
    <small>새 파일을 선택하면 기존 첨부파일이 교체됩니다.</small><br><br>

    <button type="submit">수정</button>
</form>

<a href="view.php?id=<?php echo $id; ?>">취소</a>
