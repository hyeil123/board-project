<?php
include "db.php";

// 유저 검색 기능
// username을 기준으로 회원을 검색한다.

$keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : "";

$sql = "SELECT id, username, created_at FROM users";

if ($keyword != "") {
    $sql .= " WHERE username LIKE '%$keyword%'";
}

$sql .= " ORDER BY id DESC";

$result = mysqli_query($conn, $sql);
?>

<h2>유저 검색</h2>

<form method="get">
    아이디 검색: <input type="text" name="keyword" value="<?php echo $keyword; ?>">
    <button type="submit">검색</button>
</form>

<table border="1" cellpadding="10">
    <tr>
        <th>회원번호</th>
        <th>아이디</th>
        <th>가입일</th>
    </tr>

    <?php while ($user = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $user["id"]; ?></td>
        <td><?php echo $user["username"]; ?></td>
        <td><?php echo $user["created_at"]; ?></td>
    </tr>
    <?php } ?>
</table>

<a href="index.php">게시판으로</a>
