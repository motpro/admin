<?php
define('CURSCRIPT', 'known');

require './source/class/class_core.php';
$discuz = C::app();
$discuz->init();

require template('known/home');