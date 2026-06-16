<?php
include "db.php";

// 게시판 목록, 게시글 검색, 정렬 기능
// board_id로 게시판을 구분하고, keyword로 게시글 제목/내용을 검색한다.

$board_id = isset($_GET["board_id"]) ? $_GET["board_id"] : 1;
$keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : "";
$order = isset($_GET["order"]) ? $_GET["order"] : "new";

$order_sql = ($order == "old") ? "ASC" : "DESC";

$board_sql = "SELECT * FROM boards";
$board_result = mysqli_query($conn, $board_sql);

$sql = "SELECT posts.*, users.username, boards.name AS board_name
        FROM posts
        JOIN users ON posts.user_id = users.id
        JOIN boards ON posts.board_id = boards.id
        WHERE posts.board_id = $board_id";

if ($keyword != "") {
    $sql .= " AND (posts.title LIKE '%$keyword%' OR posts.content LIKE '%$keyword%')";
}

$sql .= " ORDER BY posts.id $order_sql";

$result = mysqli_query($conn, $sql);
?>

<h2>게시판</h2>

<?php if (is_login()) { ?>
    <p>
        로그인 사용자: <?php echo $_SESSION["username"]; ?>
        <a href="logout.php">로그아웃</a>
    </p>
<?php } else { ?>
    <a href="login.php">로그인</a>
    <a href="register.php">회원가입</a>
<?php } ?>

<hr>

<h3>게시판 선택</h3>
<?php while ($board = mysqli_fetch_assoc($board_result)) { ?>
    <a href="index.php?board_id=<?php echo $board["id"]; ?>">
        <?php echo $board["name"]; ?>
    </a>
<?php } ?>

<hr>

<form method="get">
    <input type="hidden" name="board_id" value="<?php echo $board_id; ?>">
    검색어: <input type="text" name="keyword" value="<?php echo $keyword; ?>">
    정렬:
    <select name="order">
        <option value="new" <?php if ($order == "new") echo "selected"; ?>>최신순</option>
        <option value="old" <?php if ($order == "old") echo "selected"; ?>>오래된순</option>
    </select>
    <button type="submit">검색</button>
</form>

<br>

<a href="write.php?board_id=<?php echo $board_id; ?>">글 작성</a>
<a href="user_search.php">유저 검색</a>

<table border="1" cellpadding="10">
    <tr>
        <th>번호</th>
        <th>게시판</th>
        <th>제목</th>
        <th>작성자</th>
        <th>작성일</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row["id"]; ?></td>
        <td><?php echo $row["board_name"]; ?></td>
        <td>
            <a href="view.php?id=<?php echo $row["id"]; ?>">
                <?php echo $row["title"]; ?>
            </a>
        </td>
        <td><?php echo $row["username"]; ?></td>
        <td><?php echo $row["created_at"]; ?></td>
    </tr>
    <?php } ?>
</table>
