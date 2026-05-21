<?php
include "db.php";

$id = $_GET["id"];
$post_id = $_GET["post_id"];

$sql = "DELETE FROM comments WHERE id=$id";
mysqli_query($conn, $sql);

header("Location: view.php?id=$post_id");
exit;
?>
