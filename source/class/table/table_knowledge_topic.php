<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_knowledge_topic extends discuz_table {

	public function __construct () {
		$this->_table = 'knowledge_topic';
		$this->_pk    = 'id';

		parent::__construct();
	}
	
	public function set( $topic){

		$t = DB::fetch_first('select id from '.DB::table( $this->_table).' where topic_words = \''.$topic['topic_words'].'\'');
		if( $t['id'])
			return $t['id'];
		$this->insert( $topic , true , true);
		
		return DB::fetch_first( 'select id,topic_words from '.DB::table( $this->_table).' where topic_words = \''.$topic['topic_words'].'\'');
	}

	public function get( $page = 1 , $sum = 1 , $pass = '1' , $order = 'id desc') {

		return DB::fetch_all('select id,topic_words,pass from '.DB::table( $this->_table).' where pass = '.$pass.' order by '.$order.' limit '.($page-1)*$sum.','.$sum);
	}

	public function get_by_id( $id) {
		return DB::fetch_first('select topic_words from '.DB::table( $this->_table).' where id = '.$id);
	}

	public function pass( $id) {

	}

	public function remove( $id) {
		
	}

}