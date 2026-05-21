<?php
include "db.php";

$post_id = $_POST["post_id"];
$content = $_POST["content"];

$sql = "INSERT INTO comments (post_id, content) VALUES ('$post_id', '$content')";
mysqli_query($conn, $sql);

header("Location: view.php?id=$post_id");
exit;
?>
