<?php
if( isset( $_POST['finish'])){

	$way = array(
		0 => '开通',
		1 => '续费',
	);
	//generate trade_no
	$trade_no = strtoupper( date('Ymdhis') . substr( md5( mt_rand(1000,9999)) , 0 , 18));

	//get user data
	$u = DB::fetch_first('select company,occupation,qq,gender from '.DB::table('common_member_profile').' where uid = '.$_G['uid']);

	$order = array(

		'trade_no'		=> $trade_no,
		'blind_uid'		=> $_G['uid'],
		'sign_date'		=> time(),
		'status'		=> 1,
		'realname'		=> trim( $_POST['realname']),
		'company'		=> $u['company'],
		'paymethod'		=> 0,
		'position'      => $u['occupation'],
		'qq'			=> $u['qq'],
		'gender'		=> $u['gender'],
		'pre_productid'	=> intval( $_POST['type']),
		'productid'		=> intval( $_POST['type']),
		'pre_productnum'=> 1,
		'productnum'	=> 1,
		'pre_total'		=> $_POST['cost'],
		'total'			=> $_POST['cost'],
		'allowance'		=> 1.0,
		'ordertype'		=> 2,
		'usertype'		=> 0,
	);

	DB::insert('uclient_desire' , $order);
	require template('dsu_kkvip:offline_ok');
	exit;
}

$uid = $_G['uid'];
$user = DB::fetch_first('select mobile,realname from '.DB::table('common_member_profile').' where uid = '.$uid);

require template('dsu_kkvip:offline');
