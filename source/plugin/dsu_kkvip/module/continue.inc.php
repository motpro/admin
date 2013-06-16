<?php
$service = DB::fetch_all('select * from pre_a_service where 1');
include template('dsu_kkvip:continue');