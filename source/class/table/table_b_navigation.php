<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_b_navigation extends discuz_table {

	public function __construct () {
		$this->_table = 'b_navigation';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function fetch_all() {
		return DB::fetch_all('select * from %t where 1' , array($this->_table));
	}
}