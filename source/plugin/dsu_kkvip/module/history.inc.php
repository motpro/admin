<?php
!defined('IN_KKVIP') && exit('Access Denied');

//get history
$history = DB::fetch_all('select * from pre_a_record where uid = '.$_G['uid'].' order by id desc');

require template('dsu_kkvip:history');



