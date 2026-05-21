<?php
include "db.php";

$sql = "SELECT * FROM posts ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<h2>게시판</h2>

<a href="write.php">글 작성</a>

<table border="1" cellpadding="10">
    <tr>
        <th>번호</th>
        <th>제목</th>
        <th>작성일</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row["id"]; ?></td>
        <td>
            <a href="view.php?id=<?php echo $row["id"]; ?>">
                <?php echo $row["title"]; ?>
            </a>
        </td>
        <td><?php echo $row["created_at"]; ?></td>
    </tr>
    <?php } ?>
</table>
