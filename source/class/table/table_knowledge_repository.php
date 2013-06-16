<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_knowledge_repository extends discuz_table {

	private $_jointable;

	public function __construct () {
		$this->_table = 'knowledge_repository';
		$this->_jointable = 'ucenter_members';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function add_dict( $dict) {
		return $this->insert( $dict);
	}

	public function get_dict_list() {
		return DB::fetch_all('select d.id,d.uid,d.title,d.keyword,d.createddate,u.username from '.DB::table( $this->_table).' as d left join '.DB::table( $this->_jointable).' as u on d.uid = u.uid where 1 order by id desc');
	}

	public function get_dict_by_id( $id) {
		return DB::fetch_first('select d.*,u.username from '.DB::table( $this->_table).' as d left join '.DB::table( $this->_jointable).' as u on d.uid = u.uid where id = '.$id);
	}

	public function get_dict_by_uid( $uid) {
		return DB::fetch_all('select id,title,keyword,createddate from '.DB::table( $this->_table).' where uid = '.$uid);
	}
}