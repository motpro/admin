<?php
!defined('IN_KKVIP') && exit('Access Denied');

//showmessage('dsu_kkvip:buy_nomoney','home.php?mod=spacecp&ac=credit&op=buy');

$service = DB::fetch_all('select * from pre_a_service where 1');
require template('dsu_kkvip:active');