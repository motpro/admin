<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_knowledge_answer_attitude extends discuz_table {
	private $_table2;

	public function __construct () {
		$this->_table = 'knowledge_answer_attitude';
		$this->_table2 = 'knowledge_answer';
		$this->_pk    = 'id';

		parent::__construct();
	}

	//添加赞同或者反对 如果已经存在 会更新这个记录
	public function add_attitude( $aid , $uid , $attitude){
		if( $attitude === 1) $answer = 1;
		else if( $attitude === 2) $answer = 2;
		else return ;

		$exist = DB::fetch_first('select id,attitude from '.DB::table( $this->_table).' where aid = '.$aid.' and uid = '.$uid);
		if( $exist['id']){
			if( $exist['attitude'] === $attitude)
				return ;
			DB::query('update '.DB::table( $this->_table).' set attitude = '.$attitude.' where aid = '.$aid.' and uid = '.$uid);
			return ;
		}

		$this->insert( array('aid' => $aid , 'uid' => $uid , 'attitude' => $attitude));
	}

	public function get_good_attitude_by_aid( $aid) {
		return DB::fetch_all( 'select count(uid) from '.DB::table( $this->_table).' where aid = '.$aid.' and attitude = 1');
	}

	public function get_bad_attitude_by_qid( $qid) {
		return DB::fetch_all( 'select count(uid) from '.DB::table( $this->_table).' where aid = '.$aid.' and attitude = 2');
	}

	public function get_attitude_by_aid( $aid , $uid ){
		return DB::fetch_first('select attitude from '.DB::table( $this->_table).' where aid = '.$aid.' and uid = '.$uid);
	}

}
