<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_b_exam_bucket extends discuz_table {

	private $_jointable;
	private $_jointable2;

	public function __construct () {
		$this->_table = 'b_exam_bucket';
		$this->_jointable = 'b_course';
		$this->_jointable2 = 'b_exam';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function create_bucket( $bucket){
		$r = DB::fetch_first('select id from '.DB::table( $this->_table).' where title = \''.$bucket['title'].'\' and bind_course = \''.$bucket['bind_course'].'\'');
		if( !$r['id'])
			return $this->insert( $bucket , true);
		else
			return 0;
	}

	public function get_bucket_list() {
		return DB::fetch_all('select b.*,c.fullname,c.logo from '.DB::table( $this->_table).' as b left join '.DB::table( $this->_jointable).' as c on b.bind_course = c.id where 1');
	}

	public function read_bucket_info( $bucket_id) {
		$bucket = array();
		$bucket['question'] = DB::fetch_all( 'select id,title from '.DB::table( $this->_jointable2).' where bucket_id = '.$bucket_id);
		$bucket['info'] = DB::fetch_first('select title from '.DB::table( $this->_table).' where id = '.$bucket_id);
		return $bucket;
	}

	public function get_bucket_by_id( $bucket_id) {
		return DB::fetch_first('select b.*,c.fullname from '.DB::table( $this->_table).' as b left join '.DB::table( $this->_jointable).' as c on b.bind_course = c.id where b.id = '.$bucket_id);
	}

	public function get_bucket_by_course( $id) {
		return DB::fetch_first('select * from ' .DB::table( $this->_table). ' where bind_course = '.$id.' and status = 1');
	}

	public function update_bucket_info( $info) {
		return $this->update( $info['id'], $info);
	}

	public function set_status( $id , $status) {
		$this->update( $id, array('status' => $status));
	}

	public function delete_bucket_by_id( $bucket_id) {
		DB::query('delete from '.DB::table( $this->_jointable2).' where bucket_id = '.$bucket_id);
		return DB::query('delete from '.DB::table( $this->_table).' where id = '.$bucket_id);
	}
}