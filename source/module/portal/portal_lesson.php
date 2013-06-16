<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if( 1 != $_G['adminid']){
	header('Location: portal.php');
	exit;
}

$contenttypefilter = $_G['siteurl'] . 'urlfilter.php?url=';

$lang = array('CH/' , 'TW/' , 'EN');

$action_list = array('admin' , 
					 'course_info',
					 'add_category',
					 'edit_category',
					 'pages_list',
					 'edit_page',
					 'add_course',
					 'delete_page',
					 'course_delete',
					 'view_logo'
);

$modsession->islogin = true;
$ac = $_GET['ac'] ? $_GET['ac'] : '';
if( 'lesson' === $ac || '' === $ac){

	//default page of lesson manage
	$list = C::t('b_course')->get_all_course_orderby_sortid();

	$category = C::t('b_category')->get_all_category();

	foreach ($list as $key => $lesson) {


		//$v_num = count( DB::fetch_all('select id from pre_b_lesson_pages where film_id > 0 and lessonid = '.$lesson['id']));
		$v_num = C::t('b_lesson_pages')->count_film_number( $lesson['id']);

		//$p_num = count( DB::fetch_all('select id from pre_b_lesson_pages where lessonid = '.$lesson['id']));
		$p_num = C::t('b_lesson_pages')->count_pages_number( $lesson['id']);

		$course_video = C::t('b_video')->get_video_voice( $lesson['id']);
		$list[$key]['video_num'] = $v_num;
		$list[$key]['page_num']	= $p_num;

		$list[$key]['en'] = mot_filter( $course_video , 1);
		$list[$key]['cn'] = mot_filter( $course_video , 0);
	}


	foreach ($category as $key => $value) {
		$category_list[$value['id']] = $value['category'];
	}	
	require template('portal/lesson/admin');
	exit;
}else if( 'course_info' === $ac){
	// edit course information
	if( isset( $_POST['add_new_page'])){
		$pageid = C::t('b_lesson_pages')->insert_new_page( array(
			'lessonid' 	=> $_POST['lessonid'],
			'title'		=>	quote_m($_POST['title']),
		));

		if( isset( $_FILES['image_file'])){
			$file_type = array_pop( explode('.', $_FILES['image_file']['name']));
			//chmod( DISCUZ_ROOT . 'uploads/' , 0777);
			move_uploaded_file(  $_FILES['image_file']['tmp_name'], DISCUZ_ROOT . 'uploads/'.$pageid.'.'.$file_type);
			$image_file = $pageid.'.'.$file_type;
		}else{
			$image_file = '199999.png';
		}
		$film_id = C::t('b_video')->insert_for_page( array(
			'v_file'	=> quote_m($_POST['v_file']),
			'v_path'	=> quote_m($_POST['v_path']),
			'label_a_file'	=> quote_m($_POST['label_a_file']),
			'label_b_file'	=> quote_m($_POST['label_b_file']),
			'image_file'	=> quote_m($image_file),
		));

		C::t('b_lesson_pages')->update_page(array('film_id' => $film_id , 'pageid' => $pageid));
	}

	if( isset( $_POST['save_courseinfo'])){
		$data = array(
			'fullname' 		=>	quote_m($_POST['fullname']),
			'sortid'		=>  intval( $_POST['sortid']),
			'category_id'	=> 	intval( $_POST['category_id']),
			'is_free'		=>  intval( $_POST['is_free']),
			'is_hidden'		=>  intval( $_POST['is_hidden']),
			'summary'		=>  quote_m($_POST['summary']),
			'logo'			=>  quote_m($_POST['logo']),
			'id'			=>  $_POST['id'],
		);
		C::t('b_course')->update_course( $data);
	}
	
	$id = intval( $_GET['id']);
	$course_info = C::t('b_course')->get_course_by_id( $id);
	$category = C::t('b_category')->get_all_category();
	$pages = C::t('b_lesson_pages')->get_pages_by_lessonid( $id);
	require template('portal/lesson/course_info');
	exit;
}else if( 'add_category' === $ac){

	if( isset( $_POST['add_category_name'])){
		$c = $_POST['category'];
		$exist = C::t('b_category')->exist( quote_m($c));		
		if( !$exist)
			C::t('b_category')->insert( quote_m($c));
	}
	$c = C::t('b_category')->get_all_category();
	require template('portal/lesson/add_category');
	exit;
}else if( 'delete_category' === $ac){

	$id = intval( $_GET['id']);
	C::t('b_category')->delete( $id);
	header('Location: portal.php?mod=lesson&ac=add_category');
}else if( 'edit_category' === $ac){
	if( isset( $_POST['s'])){
		$ok = C::t('b_category')->update( array(
			'id' => intval( $_POST['id']), 
			'category' => quote_m($_POST['category']))
		);
	}
	$category = C::t('b_category')->get_all_category();
	require template('portal/lesson/edit_category');
	exit;
}else if( 'edit_page' === $ac){

	if( isset( $_POST['save_page'])){

		//video
		if( ( $_FILES['images']['tmp_name']) && $_FILES['images']['error'] == 0 ){
			$file_type = array_pop( explode('.', $_FILES['images']['name']));
			chmod( DISCUZ_ROOT . 'uploads/' , 0777);
			move_uploaded_file(  $_FILES['images']['tmp_name'], DISCUZ_ROOT . 'uploads/'.$_POST['id'].'.'.$file_type);
			$image_file = $_POST['id'].'.'.$file_type;
		}
		if( !isset( $image_file))
			$image_file = $_POST['image_file'];

		C::t('b_lesson_pages')->update_pageedit( array(
			'film_id'		=> $_POST['film_id'],
			'prevpageid'	=> $_POST['prevpageid'],
			'nextpageid'	=> $_POST['nextpageid'],
			'title'			=> quote_m( $_POST['title']),
			'content'		=> quote_m( $_POST['contents']),
			'id'			=> $_POST['id'],
		));

		C::t('b_video')->update_video( array(
			'v_file'		=> quote_m($_POST['v_file']),
			'v_path'		=> quote_m($_POST['v_path']),
			'label_a'		=> quote_m($_POST['label_a']),
			'label_a_file'	=> quote_m($_POST['label_a_file']),
			'label_b'		=> quote_m($_POST['label_b']),
			'label_b_file'	=> quote_m($_POST['label_b_file']),
			'cn_intro'		=> quote_m($_POST['cn_intro']),
			'en_intro'		=> quote_m($_POST['en_intro']),
			'image_file'	=> quote_m($image_file),
			'v_time'		=> quote_m($_POST['v_time']),
			'v_voice'		=> quote_m($_POST['v_voice']),
			'film_id'		=> $_POST['film_id'],
		));
	}
	$id = intval( $_GET['id']);
	//user lesson page content
	chmod( DISCUZ_ROOT.'player.config.php',0777);
	//播放器配置
	$p = require( DISCUZ_ROOT.'player.config.php');
	$page = C::t('b_lesson_pages')->get_pageedit_info( $id);

	$page['label_a_file'] = $contenttypefilter . $p['subtitle'] . $page['v_path'] . $lang[$page['label_a']] . $page['label_a_file'];
	$page['label_b_file'] = $contenttypefilter . $p['subtitle'] . $page['v_path'] . $lang[$page['label_b']] . $page['label_b_file'];

	$course = C::t('b_course')->get_course_by_id( $page['lessonid']);
	$allpages = C::t('b_lesson_pages')->get_same_course_pages($page['lessonid']);
	//print_r( $page);
	require template('portal/lesson/edit_page');
	exit;
}else if( 'add_course' === $ac){
	//创建course记录
	$id = C::t('b_course')->insert_empty_course();
	//转到course管理页面
	header('Location: portal.php?mod=lesson&ac=course_info&id='.$id);
	exit;
}else if( 'delete_page' === $ac){
	$id = intval( $_GET['id']);
	$cid = intval( $_GET['cid']);
	$p = C::t('b_lesson_pages')->get_page_by_id( $id);
	C::t('b_video')->delete_by_id($p['film_id']);
	C::t('b_lesson_pages')->delete_by_id( $p['id']);
	header('Location: portal.php?mod=lesson&ac=course_info&id='.$cid);
}else if( 'course_delete' === $ac){
	$course_id = intval( $_GET['id']);

	if( isset( $_GET['confirm'])){
		$pages = C::t('b_lesson_pages')->get_same_course_pages($course_id);
		foreach ($pages as $p) {
			C::t('b_video')->delete_by_id($p['film_id']);
		}
		C::t('b_lesson_pages')->delete_by_courseid( $course_id);
		C::t('b_course')->delete_by_id( $course_id);
		header('Location: portal.php?mod=lesson&ac=lesson');
	}
	//echo $course_id;
	$course = C::t('b_course')->get_course_by_id($course_id);
	require template('portal/lesson/confirm_delete');
}else if( 'view_logo' === $ac){
	@chmod( DISCUZ_ROOT.'uploads/', 0777);
	$dir = opendir(DISCUZ_ROOT.'uploads/lesson/');
	$list = array();
	while($file = readdir( $dir)){
		if( '.' != $file && '..' != $file){
			$list[] = $file;
		}
	}
	require template('portal/lesson/view_logo');
}else if( 'generate' == $ac){
	set_time_limit(0);
	@chmod( DISCUZ_ROOT.'uploads/', 0777);
	$dir = opendir(DISCUZ_ROOT.'uploads/');
	$list = array();
	while($file = readdir( $dir)){
		if( '.' != $file && '..' != $file && strpos($file,'.')){
			//$list[] = $file;
			img_create_small(DISCUZ_ROOT.'/uploads/'.$file , 256,144,DISCUZ_ROOT.'/uploads/small/'.$file);
		}
	}
	header('Location: portal.php?mod=lesson');
}

function quote_m( $str){ return '\''.trim($str).'\'';}


function mot_filter( $array , $dest){
	$flag = 0;
	foreach ($array as $a) { if( $a['v_voice'] == $dest) ++$flag;}
	return $flag;
}

function img_create_small($big_img,$width,$height,$small_img){
    //print_r( $imgage = getimagesize($big_img));
    
    switch ($imgage[2]){
    	case 1: $im=imagecreatefromgif($big_img);break;
    	case 2: $im=imagecreatefromjpeg($big_img);break;
    	case 3: $im=imagecreatefrompng($big_img);break;
    }

    $src_W=imagesx($im);
    $src_H=imagesy($im);
    $tn=imagecreatetruecolor($width,$height);
    imagecopyresized($tn,$im,0,0,0,0,$width,$height,$src_W,$src_H);
    echo imagejpeg($tn,$small_img);
}