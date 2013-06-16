<?php

define('CURSCRIPT' , 'examination');
require './source/class/class_core.php';

$discuz = C::app();
$discuz->init();

$module_list = array('admin' , 'enroll' , 'exam' , 'do' , 'schoolroll' , 'mytest' , 'library' , 'more');



$mod = $_GET['mod'] ? trim( $_GET['mod']) : 'schoolroll';

define('CURMODULE', $mod);
if( !in_array( $mod, $module_list)){
	require template('error/404');
	exit;
}


require DISCUZ_ROOT.'source/module/examination/'.$mod.'.php';
