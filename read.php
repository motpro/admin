<?php
define('CURSCRIPT', 'read');
require './source/class/class_core.php';

$discuz = C::app();
$discuz->init();

$title = trim( $_GET['title']);
require template('common/header');
include('pages/'.$title.'.html');
require template('common/footer');