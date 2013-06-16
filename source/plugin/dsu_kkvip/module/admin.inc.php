<?php

if( isset( $_POST['create_seervice'])){
	unset( $_POST['create_seervice']);
	DB::insert('a_service' , $_POST);
}

if( isset( $_GET['rm'])){
	$id = intval( $_GET['rm']);
	DB::query('delete from pre_a_service where id = '.$id);
}

$service = DB::fetch_all('select * from pre_a_service where 1');

if( intval( $_G['adminid'])===1)
	include template('dsu_kkvip:admin');
else
	header('vip.php');
