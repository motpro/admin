<?php
chdir('../');
define('SUB_DIR', '/aboutus/');
define('CURMODULE', 'aboutus');
$_GET['mod'] = 'list';
$_GET['catid'] = '9';
require_once './portal.php';
?>