<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 제목/내용 저장
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO posts(title, content)
            VALUES('$title', '$content')";

    mysqli_query($conn, $sql);

    // 마지막 글 번호
    $post_id = mysqli_insert_id($conn);

    // 파일 업로드
    if ($_FILES['upload_file']['name']) {

        $originalName = $_FILES['upload_file']['name'];
        $tmpName = $_FILES['upload_file']['tmp_name'];
        $fileSize = $_FILES['upload_file']['size'];

        $ext = pathinfo($originalName, PATHINFO_EXTENSION);

        $uuidName = uniqid() . "." . $ext;

        $uploadPath = "uploads/" . $uuidName;

        move_uploaded_file($tmpName, $uploadPath);

        $sql = "INSERT INTO attachments
        (post_id, original_name, stored_path, file_size)
        VALUES
        ('$post_id', '$originalName', '$uploadPath', '$fileSize')";

        mysqli_query($conn, $sql);
    }

    header("Location: index.php");
}
?>

<form method="post" enctype="multipart/form-data">

제목:
<input type="text" name="title"><br><br>

내용:
<textarea name="content"></textarea><br><br>

파일:
<input type="file" name="upload_file"><br><br>

<button type="submit">작성</button>

</form>
