<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_b_count extends discuz_table {

	public function __construct () {
		$this->_table = 'b_count';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function autoincrement_course( $itemid , $type) {
		$r = DB::fetch_first('select id from '.DB::table( $this->_table).' where itemid = '.$itemid.' and type=\''.$type.'\'');

		if( $r) {
			DB::query('update '.DB::table( $this->_table).' set click_count = click_count + 1 where itemid = '.$itemid.' and type = \''.$type.'\' ');
		}else {
			DB::query('insert into '.DB::table( $this->_table).'(itemid,click_count,type) values('.$itemid.',1,\''.$type.'\')');
		}
	}

	public function get_course_click( $course_id) {
		return DB::fetch_first('select click_count from '.DB::table( $this->_table).' where itemid = '.$course_id.' and type = \'c\'');
	}

	public function get_page_click( $page_id) {
		return DB::fetch_first('select click_count from '.DB::table( $this->_table).' where itemid = '.$course_id.' and type = \'p\'');
	}
}