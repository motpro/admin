<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_b_keyword extends discuz_table {

	public function __construct () {
		$this->_table = 'b_keyword';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function save( $result) {

		foreach($result as $key) {
			if( strlen( $key) < 2)
				continue;
			$re = DB::fetch_first('select id,keywords from '.DB::table( $this->_table).' where keywords like \'%'.$key.'%\'');

			if( count( $re)) {
				//echo '<p>'.$re['keywords'].'已经存在</p>';
				if( $re['keywords'] == $key)
					DB::query('update '.DB::table( $this->_table).' set frequency = frequency + 1 where id = '.$re['id']);
			}else {
				//echo '<p>'.$re['keywords'].'不存在</p>';
				$this->insert( array('keywords' => $key , 'frequency' => 1) ,false, true);
			}
		}
	}

	public function get_hot_keyword( $num) { 
		return DB::fetch_all(' select keywords from '.DB::table( $this->_table).' where 1 order by frequency desc limit '.$num);
	}

}