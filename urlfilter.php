<?php
$_req = trim($_GET['url']);

header("Content-Type: text/plain;charset=utf-8");
echo iconv('UTF-16', 'UTF-8', file_get_contents( $_req));
?>