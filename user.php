<?php
define('CURSCRIPT', 'user');
require './source/class/class_core.php';

$discuz = C::app();
$discuz->init();

if( !$_G['uid']){
	require template('user/guest');
	exit;
}

include_once libfile('class/vip');

//$app_list = array( 'home' , 'learn' , 'note' , 'favorite' , 'question' , 'kit' , 'account');

$ac = $_GET['ac'] ? trim( $_GET['ac']) : 'home' ; 

//sub_vip
if( 'sub_vip' === $ac) {

	$vip_time = C::t('b_vip')->get_vip_by_uid( $_G['uid']);
	$vip = $vip ? $vip : new vip();
	if(!$vip->on) showmessage('undefined_action');
	$is_vip = $vip->is_vip();
	$vip_credit_name=$_G['setting']['extcredits'][$vip->vars['creditid']]['title'];
	$vip_credit='extcredits'.$vip->vars['creditid'];
	$query=DB::fetch($vip->query("SELECT {$vip_credit} FROM pre_common_member_count WHERE uid='{$_G[uid]}'"));
	$my_credit=$query[$vip_credit];
}

if( 'sub_newsfeed' === $ac) {
	if( isset( $_GET['pad_delete'])){
		$id = intval( $_GET['pad_delete']);
		C::t('b_userpad')->delete_pad( $id , $_G['uid']);
		header('Location: user.php?ac=sub_newsfeed');
	}
	$news = C::t('b_userpad')->get_latest_pad();
}

//sub_plan
if( 'sub_plan' === $ac) {
	$list = array();

	$my_course = C::t('b_favorite')->get_favorite_by_uid( $_G['uid']);
	foreach ($my_course as $c) {
		$c['pages'] = C::t('b_lesson_pages')->get_same_course_pages( $c['courseid']);
		$list[] = $c; 
	}
}

//sub_note
if( 'sub_note' === $ac) {
	if( $id = intval( $_GET['edit'])) {
		$edit = C::t('b_usernote')->get_user_note_by_id( $id , $_G['uid']);
	}
	$notes = C::t('b_usernote')->get_notes_by_uid( $_G['uid']);
}

if( 'sub_repository' === $ac) {
	$dict_list = C::t('knowledge_repository')->get_dict_by_uid( $_G['uid']);
}

if( 'sub_schedule' === $ac) {
	$event = C::t('b_userevent')->get_event_by_uid( $_G['uid']);

	$future = array();
	$today = array();
	$outofdate = array();

	foreach ($event as $_event) {

		if( time() - $_event['start'] > 86400)
			$outofdate[] = $_event;
		else if( date('Y/m/d' , $_event['start']) === date('Y/m/d'))
			$today[] = $_event;
		else 
			$future[] = $_event; 
 	}
}

if( 'home' === $ac){
	$event = C::t('b_userevent')->get_event_by_uid( $_G['uid']);
	$last = C::t('b_userlast')->get_last( $_G['uid']);

	if( isset( $_POST['add_pad'])) {
		C::t('b_userpad')->insert_pad( array(	'uid' => $_G['uid'],
												'padtext' => dhtmlspecialchars( $_POST['text']),
												'createddate' => time(),
		));

		$successed = TRUE;
	}
}

$message = C::t('b_call')->count_newmessage( $_G['uid']);

require template('user/'.$ac);