<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: cache_admingroups.php 24830 2011-10-12 08:23:34Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function cache_course_info() { 
	$course = C::t('b_course')->get_latest_course( 8);
	savecache( 'latest_course' , $course);
}

function cache_keywords() {
	$course = C::t('b_course')->get_course_title();
	$page = C::t('b_lesson_pages')->get_page_title();
	savecache('course_cache' , array( 'course' => $course , 'page' => $page));
}

function cache_free_pages( $number) {
	$freep = C::t('b_lesson_pages')-> get_free_course_pages( $number);
	savecache( 'freep' , $freep);
}

function get_hot_keyword() { 
	$result = C::t('b_keyword')->get_hot_keyword( 20);
	savecache('hot_keyword' , $result);
}

function cache_hot_course() {
	$c_vip = C::t('b_course')->get_vip_course();
	savecache('hot_course' , $c_vip);
}