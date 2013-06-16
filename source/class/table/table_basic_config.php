<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_common_admincp_cmenu.php 27806 2012-02-15 03:20:46Z svn_project_zhangjie $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_basic_config extends discuz_table {

	private $_jointable;

	public function __construct () {
		$this->_table = 'basic_config';
		$this->_jointable = 'b_course';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function get_director() {
		return DB::fetch_all('select id,c_key,c_value from '.DB::table( $this->_table).' where type = %s',array('director'));
	}

	public function get_bigphoto() {
		return DB::fetch_all('select id,config,c_key,c_value from '.DB::table( $this->_table).' where type = %s' , array('bigphoto'));
	}

	public function get_bigphoto_by_id( $id) {
		return DB::fetch_first('select id,c_key,c_value,config from '.DB::table( $this->_table).' where id = '.$id);
	}

	public function get_aboutus() {
		return DB::fetch_all('select * from '.DB::table( $this->_table).' where type = %s' , array('aboutus'));
	}

	public function insert_bigphoto( $photo) {
		return $this->insert( $photo, false , true);
	}

	public function get_hotcourse() {
		return DB::fetch_all('select s.id,s.config,c.fullname,c.logo from '.DB::table( $this->_table).' as s left join '.DB::table( $this->_jointable).' as c on s.config = c.id where s.type=\'hotcourse\' ');
	}

	public function add_hotcourse( $data) {
		$n = DB::fetch_all('select * from '.DB::table( $this->_table).' where config = '.$data['config']);
		if( !$n)
			$this->insert( $data , false , true);
	}

	public function rm_hotcourse( $id){
		return $this->delete( array('id' => $id));
	}



	public function delete_bigphoto( $id) {
		return $this->delete( $id);
	}

	public function update_director( $data) {
		return DB::query('update '.DB::table( $this->_table).' set c_key = \''.$data['c_key'].'\',c_value = \''.$data['c_value'].'\' where id = '.$data['id']);
	}

	public function update_bigphoto( $data) {
		return DB::query('update '.DB::table( $this->_table).' set config = \''.$data['config'].'\' , c_key = \''.$data['c_key'].'\' , c_value = \''.$data['c_value'].'\' where id = '.$data['id']);
	}
}