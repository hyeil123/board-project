<?php
include "db.php";

// 로그아웃 기능
// 세션을 삭제하여 로그인 상태를 해제한다.

session_destroy();

header("Location: index.php");
exit;
?>
