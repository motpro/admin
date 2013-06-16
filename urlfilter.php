<?php
$_req = trim($_GET['url']);

header('Content-Type: text/plain');
echo file_get_contents( $_req);
?>