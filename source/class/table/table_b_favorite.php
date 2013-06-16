<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_b_favorite extends discuz_table {

	private $_jointable = 'b_course';

	public function __construct () {
		$this->_table = 'b_favorite';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function get_favorite_by_uid( $uid) {
		return DB::fetch_all('select f.courseid,c.fullname from '.DB::table($this->_table).' as f left join '.DB::table($this->_jointable).' as c on f.courseid = c.id where uid = '.$uid);
	}

	public function get_favorite_by_id( $id , $uid) {
		return DB::fetch_first('select id from '.DB::table( $this->_table).' where uid = '.$uid.' and courseid = '.$id);
	}

	public function insert( $data , $uid) { 
		return DB::query('insert into '.DB::table( $this->_table).'(uid , courseid) values( '.$uid.' , '.$data['id'].')');
	}

	public function delete( $data , $uid) {
		DB::query('delete from '.DB::table( $this->_table).' where uid = '.$uid.' and courseid = '.$data['id']);
	}
}