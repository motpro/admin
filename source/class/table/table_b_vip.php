<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_b_vip extends discuz_table {

	public function __construct () {
		$this->_table = 'dsu_vip';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function get_vip_by_uid( $uid) {
		return DB::fetch_first('select uid,jointime,exptime from '.DB::table( $this->_table).' where uid = '.$uid. ' and exptime >'.time() );
	}
}