<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_knowledge_question extends discuz_table {

	private $_jointable;

	public function __construct () {
		$this->_table = 'knowledge_question';
		$this->_jointable = 'knowledge_topic';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function new_question( $question) {
		return $this->insert( $question , true);
	}

	public function get_new_question_by_page( $page = 1 , $number = 10 , $type = null) {
		$type = (($type === null) ? '1' :'topicid = '.$type );
		
		return DB::fetch_all( 'select q.id,q.title,q.uid,q.view,q.reply,q.createddate,q.status,q.topicid,t.topic_words from '.DB::table( $this->_table).' as q left join '.DB::table( $this->_jointable).' as t on q.topicid = t.id where '.$type.' order by id desc limit '.($page-1)*$number.','.$number);
	}

	public function get_title_by_id( $id) {
		return DB::fetch_first( 'select title from '.DB::table( $this->_table).' where id = '.$id);
	}

	public function get_question_by_id( $id) {
		return $this->fetch($id , true);
	}

	public function new_visitor( $id) {
		return DB::query( 'update '.DB::table( $this->_table).' set view = view + 1 where id = '.$id);
	}

	public function get_question_by_uid( $uid) {
		return DB::fetch_all( 'select * from '.DB::table( $this->_table).' where uid = '.$uid.' order by id desc');
	}

	public function set_question_done( $id , $uid) {
		return DB::query('update '.DB::table( $this->_table).' set status = 1 where id = '.$id.' and uid = '.$uid);
	}
}