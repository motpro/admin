<?php
define('CURSCRIPT' , 'msearch');
require './source/class/class_core.php';
require DISCUZ_ROOT.'./source/function/cache/cache_lesson.php';
require './motlib/split.php';
$discuz = C::app();
$discuz->init();

loadcache('course_cache');
if( !isset( $_G['cache']['course_cache'])) {
	cache_keywords();
	loadcache('course_cache');

}

if( isset( $_GET['findout'])) {
	//print_r( $_G['cache']['course_cache']);
	$key = strtolower( trim( $_GET['keywords']));
	
	$ori = $key;
	if( strlen( $key) > 60 || strlen( $key) <= 3) {
		$pause = true;
		require template('portal/search_list');
		exit;
	}
	
	$key = spStr( $key);

	if( strlen( $key) < 12 && count( $key) > 1)
		$key [] = $ori;
	//ori是原始搜索关键句
	C::t('b_keyword')->save( $key , $ori);

	foreach ($key as $c_value) {
		foreach ($_G['cache']['course_cache']['course'] as $c) {
			//echo '<p>课程'.$c['fullname'].'不存在'.$c_value.'</p>';
			if( false !== stripos( $c['fullname'] , $c_value)) {
				if( !in_array( $c, $course_result))
					$course_result[] = $c;
			}
		}
	}

	foreach ($key as $p_value) {
		foreach ($_G['cache']['course_cache']['page'] as $p) {
			//echo '<p>页面'.$p['title'].'不存在'.$p_value.'</p>';
			if( false !== stripos( $p['title'] , $p_value)) {
				if( !in_array( $p, $page_result))
					$page_result[] = $p;
			}
		}
	}

	require template('portal/search_list');
}