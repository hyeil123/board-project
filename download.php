<?php
include "db.php";

$id = $_GET["id"];

$sql = "SELECT * FROM attachments WHERE id=$id";
$result = mysqli_query($conn, $sql);
$file = mysqli_fetch_assoc($result);

$path = $file["stored_path"];
$name = $file["original_name"];

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"" . $name . "\"");
header("Content-Length: " . filesize($path));

readfile($path);
exit;
?>
