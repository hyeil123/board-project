<?php
include "db.php";

// 게시글 작성 및 파일 업로드 기능
// 로그인한 사용자만 글을 작성할 수 있으며 게시판 번호와 작성자 번호를 함께 저장한다.

login_check();

$board_id = isset($_GET["board_id"]) ? $_GET["board_id"] : 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $board_id = $_POST["board_id"];
    $user_id = $_SESSION["user_id"];
    $title = $_POST["title"];
    $content = $_POST["content"];

    $sql = "INSERT INTO posts (board_id, user_id, title, content)
            VALUES ('$board_id', '$user_id', '$title', '$content')";
    mysqli_query($conn, $sql);

    $post_id = mysqli_insert_id($conn);

    // 첨부파일 업로드 처리
    // 실제 파일은 uploads 폴더에 저장하고 DB에는 원본 이름, 저장 경로, 크기만 기록한다.
    if (isset($_FILES["upload_file"]) && $_FILES["upload_file"]["error"] == 0) {
        $originalName = $_FILES["upload_file"]["name"];
        $tmpName = $_FILES["upload_file"]["tmp_name"];
        $fileSize = $_FILES["upload_file"]["size"];

        $ext = pathinfo($originalName, PATHINFO_EXTENSION);
        $storedName = uniqid() . "." . $ext;
        $storedPath = "uploads/" . $storedName;

        move_uploaded_file($tmpName, $storedPath);

        $file_sql = "INSERT INTO attachments (post_id, original_name, stored_path, file_size)
                     VALUES ('$post_id', '$originalName', '$storedPath', '$fileSize')";
        mysqli_query($conn, $file_sql);
    }

    header("Location: index.php?board_id=$board_id");
    exit;
}
?>

<h2>글 작성</h2>

<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="board_id" value="<?php echo $board_id; ?>">

    제목: <input type="text" name="title" required><br><br>

    내용:<br>
    <textarea name="content" rows="10" cols="50" required></textarea><br><br>

    파일: <input type="file" name="upload_file"><br><br>

    <button type="submit">작성</button>
</form>

<a href="index.php?board_id=<?php echo $board_id; ?>">목록</a>
