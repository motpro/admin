<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_b_call extends discuz_table {

	public function __construct () {
		$this->_table = 'b_call';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function new_feed( $reply) {
		$this->insert( $reply);
	}

	public function get_noclose_message( $uid) {
		return DB::fetch_all('select * from '.DB::table( $this->_table).' where to_userid = '.$uid.' and close = 0');
	}

	public function get_close_message( $uid) {
		return DB::fetch_all('select * from '.DB::table( $this->_table).' where to_userid = '.$uid.' and close = 1');
	}

	public function count_newmessage( $uid) {
		return count( DB::fetch_all('select id from '.DB::table( $this->_table).' where to_userid = '.$uid.' and close = 0'));
	}

	public function close_message( $mid , $uid) {
		
	}

	public function close_some_message( $in , $uid) {
		DB::query( 'update '.DB::table( $this->_table).' set close = 1 where to_userid = '.$uid.' and id in '.$in);
	}

	public function delete_message( $mid , $uid) {
		DB::query( 'delete from '.DB::table( $this->_table).' where to_userid = '.$uid.' and id = '.$mid);
	}
}