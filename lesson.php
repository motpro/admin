<?php
define('APPTYPEID' , 0);
define('CURSCRIPT', 'lesson');
//discuz core
require './source/class/class_core.php';
//设备检测class
require './source/class/class_mobiledetect.php';

session_start();
$discuz = & discuz_core::instance();
$discuz->init();
$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
$contenttypefilter = $_G['siteurl'] . 'urlfilter.php?url=';

$lang = array('CH/' , 'TW/' , 'EN');

//@mot cache here
if( !isset( $_G['cache']['player'])) {
	//chmod( DISCUZ_ROOT.'player.config.php',0777);
	$p = require( DISCUZ_ROOT.'player.config.php');
	save_syscache('player' , $p);
	loadcache('player');
}
$p = $_G['cache']['player'];

//get vip data
if( $_G['uid']){
	$vip = C::t('b_vip')->get_vip_by_uid( intval( $_G['uid']));
}

//get bookmark and faviorte
if( $_G['uid']) {
	$favorite = C::t('b_favorite')->get_favorite_by_uid( $_G['uid']);
	$mark = C::t('b_mark')->get_mark_by_uid( $_G['uid']);
}

//get video json data by page_id
if( isset( $_GET['dataajax'])){

	$id = intval( $_POST['pageid']);

	$cinfo = C::t('b_course')->get_free_by_pageid( $id);

	if( $vip['uid'] || $cinfo['is_free']){
		$c = C::t('b_video')->get_video_by_pageid( $id);
		$c['label_a_file'] = $contenttypefilter . $p['subtitle'] . $c['v_path'] . $lang[$c['label_a']] . $c['label_a_file'];
		$c['label_b_file'] = $contenttypefilter . $p['subtitle'] . $c['v_path'] . $lang[$c['label_b']] . $c['label_b_file'];
		echo json_encode( $c);
		exit;
	}	
}

if( isset( $_GET['click_collection'])) {
	C::t('b_count')->autoincrement_course( intval( $_GET['id']), trim( $_GET['type']));
	echo 'ok';
}

/*
*@mobile device response
*
*/
if( 'phone1' === $deviceType){

	if( isset( $_GET['addmark'])){
		if( isset( $_G['uid'])){
			$id = intval( $_GET['addmark']);
			$m = C::t('b_mark')->get_mark_by_uid( $_G['uid']);
		if( $m){
			if( $m['id'] != $id)
				C::t('b_mark')->update( array('mark_id' => $id) , $_G['uid']);
			}else{
				C::t('b_mark')->insert( array('mark_id' => $id) , $_G['uid']);
			}
		}
		header('Location: lesson.php?enter_page='.$id);
	}


	if( isset( $_GET['favorite'])) {
		if( isset( $_GET['add'])){
			$id = intval( $_GET['add']);
			$exists = C::t('b_favorite')->get_favorite_by_id( $id , $_G['uid']);
			if( empty( $exists)){
				C::t('b_favorite')->insert( array('id' => $id) , $_G['uid']);
			}
		}else if( isset( $_GET['cancel'])) {
			$id = intval( $_GET['cancel']);
			C::t('b_favorite')->delete( array('id' => $id) , $_G['uid']);
		}
		require template('lesson/mobile/favorite');
		exit;
	}

	if( isset( $_GET['login'])) {
		if( !$_G['uid']) {
			require template('lesson/mobile/login');
			exit;
		}
	}

	if( isset( $_GET['enter_course'])) {
		$id = intval( $_GET['enter_course']);
		$pages = C::t('b_lesson_pages')->get_same_course_pages( $id);
		$course = C::t('b_course')->get_title_by_id( $id);
		require template('lesson/mobile/index');
		exit;
	}else if( isset( $_GET['enter_page'])){

		$id = intval( $_GET['enter_page']);
		$content = C::t('b_lesson_pages')->get_page_by_id( $id);
		//print_r( $page);

		require template('lesson/mobile/index');
		exit;
	}else if( isset( $_GET['play'])) {
		$filmid = intval( $_GET['play']);
		require template('lesson/mobile/play');
		exit;
	}

	$m_course = C::t('b_course')->get_all_course();
	require template('lesson/mobile/index');
	exit;
}

/*
*@mobile device response over
*
*/

//get all category here
$category = C::t('b_category')->get_all_category();

if( isset( $_GET['add_favorite'])){
	$courseid = intval( $_GET['add_favorite']);

	$exists = C::t('b_favorite')->get_favorite_by_id( $courseid , $_G['uid']);

	if( empty( $exists)){
		C::t('b_favorite')->insert( array('id' => $courseid) , $_G['uid']);
	}
	header('Location: lesson.php?pages_list='.$courseid);
	exit;
}else if( isset( $_GET['cancel_favorite'])){
	$courseid = intval( $_GET['cancel_favorite']);
	C::t('b_favorite')->delete( array('id' => $courseid) , $_G['uid']);
	header('Location: lesson.php?pages_list='.$courseid);
	exit;
}

if( !$_G['uid']&&$_GET['sign']) {

	if( 'signin' === trim( $_GET['sign'])) {
		require template('lesson/new_login');
	}elseif('signup' === trim( $_GET['sign'])) {
		require template('lesson/register');
	}
	exit;
}


if( isset( $_GET['pages_list'])){
	define('CURSCRIPT', 'pages_list');



	$id = intval( $_GET['pages_list']);
	$_SESSION['current_course'] = $id;

	//关联的考试
	$exam_bucket = C::t('b_exam_bucket')->get_bucket_by_course( $id);

	$lesson =  C::t('b_course')->get_course_by_id( $id);
	

	loadcache('c'.$id);
	if( !isset( $_G['cache']['c'.$id])){
		$pages = C::t('b_lesson_pages')->get_pages_info_by_id( $id);
		savecache('c'.$id , $pages);
		loadcache('c'.$id);
	}
	$pages = $_G['cache']['c'.$id];

	require template('lesson/new_pages_list');
	exit;
}

if( isset( $_GET['page_content'])){

	if( submitcheck('applysubmit')){
		DB::insert('fb_opinion', 
			array('name' => $_G['gp_name'], 
				  'username' => $_POST['name'], 
				  'email' => $_POST['email'], 
				  'phone' => $_POST['phone'], 
				  'uid' => $_G['uid'], 
				  'dateline' => time(), 
				  'updatetime' => time(), 
				  'status' => '0', 
				  'resideprovince' => $_G['gp_resideprovince'], 
				  'residecity' => $_G['gp_residecity'], 
				  'residedist' => $_G['gp_residedist'], 
				  'residecommunity' => $_G['gp_residecommunity'], 
				  'message' => $_G['gp_message']));
		$success = true;
	}

	$profile = DB::fetch_first('select realname,mobile from '.DB::table('common_member_profile').' where uid = '.$_G['uid']);

	$id = intval( $_GET['page_content']);

	$content = C::t('b_lesson_pages')->get_page_by_id( $id);

	$course_info = C::t('b_course')->get_course_by_id( $content['lessonid']);

	$next = C::t('b_lesson_pages')->get_title_by_id( $content['nextpageid']);
	$prev = C::t('b_lesson_pages')->get_title_by_id( $content['prevpageid']);

	$navigation = C::t('b_lesson_pages')->get_same_course_pages( $content['lessonid']);

	if( !$vip['uid']){
		if( empty( $_SESSION['current_course']))
			$_SESSION['current_course'] = 1;

		$free = C::t('b_course')->get_free_by_id( $content['lessonid']);

		if( $free['is_free'] && $_G['uid'])
			$vip['uid'] = 10086;
		else
			unset( $vip['uid']);
	}

	C::t('b_userlast')->set_last( $_G['uid'], $id);

	require template('lesson/new_content');
	exit;
}

if( isset( $_GET['mark'])){

	if( isset( $_G['uid'])){
		$id = intval( $_GET['mark']);
		$m = C::t('b_mark')->get_mark_by_uid( $_G['uid']);
		if( $m){
			if( $m['id'] != $id)
				C::t('b_mark')->update( array('mark_id' => $id) , $_G['uid']);
			}else{
				C::t('b_mark')->insert( array('mark_id' => $id) , $_G['uid']);
			}
	}
	header('Location: lesson.php?page_content='.$id);
	exit;
}





if( isset( $_GET['page']) && $_GET['page'] > 0) { $page = intval( $_GET['page']); }
else{ $page = 1; }

//get all course here
if( isset( $_GET['category'])){
	$c = C::t('b_course')->get_course_by_page( $page , 16 , intval( $_GET['category']));
}else{
	$c = C::t('b_course')->get_course_by_page( $page , 16);
}


$p = C::t('b_lesson_pages')->get_preview_pages(2);

foreach ($category as $value) {
	$cat[$value['id']] = $value['category'];
}

require template('lesson/user_interface');


