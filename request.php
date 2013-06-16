<?php

define('CURSCRIPT', 'request');
require './source/class/class_core.php';
require './motlib/split.php';

$discuz = C::app();
$discuz->init();

if( !isset( $_G['uid'])) exit();


/**here ajax request **********************************************************************/
$ac = $_POST['action'] ? trim( $_POST['action']) : null;
$pa = $_POST['params'] ? $_POST['params'] : null;

if( 'setnote' === $ac) {
	//添加课堂笔记
	$pa['notetext']  = str_replace('<p>', '', $pa['notetext']);
	$pa['notetext']  = str_replace('</p>', '', $pa['notetext']);
	//截断过长的文本
	$pa['notetext'] = cutstr( $pa['notetext'] , 3000 , '');
	//入库
	$rt = C::t('b_usernote')->setnote( array(
				'uid' => $_G['uid'],
				'pageid' => $pa['pageid'],
				'notetext' => $pa['notetext'],
				'setdate' => time(),
	));
	//返回
	if( $rt == 0) { echo 0; exit;}
	echo json_encode( array( 'id' => $rt['id'], 'text' => cutstr( $rt['text'] , 36 , '')));
	exit;
}else if( 'getnote' === $ac) {
	//获得课堂笔记列表
	$note = C::t('b_usernote')->getnote( array('uid' => $pa['uid'] , 'sum' => 20 , 'pageid' => $pa['pageid']));
	foreach ($note as $key => $value) {
		$note[$key]['notetext'] = cutstr( $note[$key]['notetext'] , 36 , '') ;
	}
	echo json_encode( $note);
}

//编辑更新课堂笔记
if( 'update_note' === $ac) {

	$pa['notetext']  = str_replace('<p>', '', $pa['notetext']);
	$pa['notetext']  = str_replace('</p>', '', $pa['notetext']);

	echo C::t('b_usernote')->update_note_by_id( $pa['notetext'] , $pa['id'] , $pa['uid']);
}

if( 'calendar' === $ac) {

	//默认添加日程表记录
	$event = array( 'event' => cutstr( trim( $pa['Title']) , 48 , ''),
					'start' => cutstr( $pa['Start'] , 10 , ''),
					'end'   => cutstr( $pa['End']   , 10 , ''),
					'uid'   => $_G['uid'],
	);

	echo C::t('b_userevent')->new_event( $event);
	exit;
}

if( 'get_top_search' === $ac) {

	//更新搜索条目的缓存数据
	if( isset( $pa['update'])){
		$display = array();
		$course = C::t('b_course')->get_all_title();
		foreach ($course as $c) {
			$display[] = $c['fullname'];
		}
		$page = C::t('b_lesson_pages')->get_all_title();
		foreach ($page as $p) {
			$display[] = $p['title'];
		}
		
		savecache('top_search' , $display);
	}

	loadcache('top_search');

	if( !isset( $_G['cache']['top_search'])){
		$display = array();
		$course = C::t('b_course')->get_all_title();
		foreach ($course as $c) {
			$display[] = $c['fullname'];
		}
		$page = C::t('b_lesson_pages')->get_all_title();
		foreach ($page as $p) {
			$display[] = $p['title'];
		}
		
		savecache('top_search' , $display);
		loadcache('top_search');
	}

	echo json_encode( $_G['cache']['top_search']);
	exit;
}


/**here get request **********************************************************************/

if( isset( $_GET['user_page'])){

	if( $noteid = intval( $_GET['note_remove'])){
		C::t('b_usernote')->delete_note_by_id( $noteid , $_G['uid']);
		header('Location: user.php?ac=sub_note');
	}
	exit;
}
//取消日程
if( isset( $_GET['event_cancel'])){
	
	C::t('b_userevent')->cancel_event( array( 	'uid' => $_G['uid'] , 
												'id' => intval( $_GET['event_cancel'])
									));

	header('Location: user.php?ac=sub_schedule');
	exit;
}




