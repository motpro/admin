<?php
define('CURSCRIPT' , '404');
require './source/class/class_core.php';
error_reporting( E_ALL);
$discuz = C::app();
$discuz->init();

require template('error/404');