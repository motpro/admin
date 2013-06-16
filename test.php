<?php
error_reporting(E_ALL);
//$(window).scrollTop()>=$(document).height()-$(window).height()
/*
include './config/config_ucenter.php';
include './uc_client/client.php';

$result = uc_user_login('mot','wjy123' , false , false);

print_r( $result);

$name = uc_get_user('seekmas');

print_r( $name);

echo uc_user_synlogin(2);
*/
require './source/class/class_core.php';

$discuz = C::app();
$discuz->init();

