<?php

error_reporting(E_ALL);
define('CURSCRIPT', 'admincp');
require './source/class/class_core.php';

$discuz = C::app();
$discuz->init();


if( 1 != $_G['adminid']) exit('Permission deny');


$ac = $_GET['ac'] ? $_GET['ac'] : 'default';


require_once libfile('admincp/'.$ac, 'module');