<?php
include "db.php";

// 첨부파일 다운로드 기능
// DB에서 파일 정보를 조회하고 Content-Disposition 헤더로 원본 파일명을 전달한다.

$id = $_GET["id"];

$sql = "SELECT * FROM attachments WHERE id=$id";
$result = mysqli_query($conn, $sql);
$file = mysqli_fetch_assoc($result);

if (!$file || !file_exists($file["stored_path"])) {
    echo "파일이 존재하지 않습니다.";
    exit;
}

$path = $file["stored_path"];
$name = $file["original_name"];

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"" . $name . "\"");
header("Content-Length: " . filesize($path));

readfile($path);
exit;
?>
