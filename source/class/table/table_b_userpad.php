<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_b_userpad extends discuz_table {

	private $_jointable;

	public function __construct () {
		$this->_table = 'b_userpad';
		$this->_jointable = 'ucenter_members';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function insert_pad($pad) {
		$this->insert( $pad);
	}

	public function get_latest_pad( $sum = 20) {
		return DB::fetch_all( 'select p.id,p.uid,p.padtext,p.createddate,u.username from '.DB::table( $this->_table).' as p left join '.DB::table( $this->_jointable).' as u on u.uid = p.uid where 1 order by id desc limit '.$sum);
	}

	public function delete_pad( $id , $uid) {
		return DB::query('delete from '.DB::table( $this->_table).' where id = '.$id.' and uid = '.$uid);
	}
}