<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_b_userevent extends discuz_table {

	public function __construct () {
		$this->_table = 'b_userevent';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function new_event( $event , $related = 0) {
		return DB::query('insert into '.DB::table( $this->_table).'( uid , event , start , end , relatedpage) values( '.$event['uid'].' , \''.$event['event'].'\' , \''.$event['start'].'\' , \''.$event['end'].'\' , '.$related.')');
	}

	public function get_event_by_uid( $uid) {
		return DB::fetch_all('select * from '.DB::table( $this->_table).' where uid = '.$uid.' order by id desc');
	}

	public function cancel_event( $event) {
		return DB::query('delete from '.DB::table( $this->_table).' where uid = '.$event['uid'].' and id = '.$event['id']);
	}
}