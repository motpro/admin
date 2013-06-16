<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_b_category extends discuz_table {

	public function __construct () {
		$this->_table = 'b_category';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function get_all_category() {
		return DB::fetch_all('select * from '.DB::table( $this->_table).' where 1');
	}

	public function insert( $category) {
		DB::query('insert into '.DB::table($this->_table).'(category) values('.$category.')');
	}

	public function exist( $category) {
		return DB::result_first('select count(id) from '.DB::table( $this->_table).' where category = '.$category);
	}

	public function delete( $id) {
		DB::query('delete from '.DB::table( $this->_table).' where id = '.$id);
	}

	public function update( $data) {
		return DB::query('update '.DB::table( $this->_table).' set category = '.$data['category'].' where id = '.$data['id']);
	}
}