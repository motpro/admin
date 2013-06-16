<?php
chdir('../');
define('SUB_DIR', '/aboutus/');
define('CURSCRIPT', 'aboutus');
$_GET['mod'] = 'list';
$_GET['catid'] = '9';
require_once './portal.php';
?>