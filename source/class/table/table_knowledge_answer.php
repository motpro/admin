<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_knowledge_answer extends discuz_table {

	private $_jointable;
	private $_jointable2;

	public function __construct () {
		$this->_table = 'knowledge_answer';
		$this->_jointable = 'ucenter_members';
		$this->_jointable2 = 'knowledge_question';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function reply( $answer) {
		DB::query( 'update '.DB::table( $this->_jointable2).' set reply = reply + 1 where id = '.$answer['qid']);
		return $this->insert( $answer , true);
	}

	public function get_answer_by_qid( $id){
		return DB::fetch_all('select a.id,a.uid,a.content,a.agree,a.disagree,a.rank,u.* from '.DB::table( $this->_table).' as a left join '.DB::table( $this->_jointable).' as u on a.uid = u.uid where a.qid = '.$id.' order by id desc');
	}

	public function get_answer_by_uid( $uid) {
		return DB::fetch_all( 'select id,uid,qid,content,date from '.DB::table( $this->_table).' where uid = '.$uid.' order by id desc');
	}

	public function delete_answer_by_uid( $id , $uid) {
		$ret = DB::fetch_first('select q.id from '.DB::table( $this->_jointable2).' as q left join '.DB::table( $this->_table).' as a on a.qid = q.id where a.id = '.$id.' and a.uid = '.$uid);

		DB::query( 'update '.DB::table( $this->_jointable2).' set reply = reply - 1 where id = '.$ret['id']);
		DB::query('delete from '.DB::table( $this->_table).' where id = '.$id.' and uid = '.$uid);
	}

	public function increase_agree( $id , $uid) {
		
	}
}