<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_b_course extends discuz_table {

	private $_jointable;
	private $_clickcount;

	public function __construct () {
		$this->_table = 'b_course';
		$this->_pk    = 'id';
		$this->_jointable = 'b_lesson_pages';
		$this->_clickcount = 'b_count';

		parent::__construct();
	}

	public function get_all_course() {
		return DB::fetch_all('select id,fullname,category_id,summary,logo from '.DB::table($this->_table).' where is_hidden = %d' , array(0));
	}

	public function get_top_course() {
		return DB::fetch_all('select * from '.DB::table( $this->_table).' where is_free =  1 and is_hidden = 0 order by id desc limit 2');
	}

	public function get_vip_course() {
		return DB::fetch_all('select * from '.DB::table( $this->_table).' where is_free = 0 and is_hidden = 0 order by id desc');
	}

	public function get_hidden_course() {
		return DB::fetch_all('select * from '.DB::table($this->_table).' where is_hidden = 1');
	}

	public function get_latest_course( $num) {
		return DB::fetch_all('select id,fullname,summary,logo from '.DB::table($this->_table).' where is_hidden = %d and is_free = %d order by id desc limit %d' , array( 0,1,$num));
	}

	public function get_course_by_id( $id) {
		return DB::fetch_first('select * from '.DB::table($this->_table).' where id = '.$id);
	}

	public function get_course_title() {
		return DB::fetch_all('select id,fullname from '.DB::table( $this->_table).' where 1');
	}
	//*******display on lesson page*******
	public function get_course_by_page( $page , $num , $category_id = 0) {

		if( $category_id != 0) 
			$category = 'and category_id = '.$category_id;
		else
			$category = '';
		
		return DB::fetch_all('select id,fullname,logo,summary,category_id from '.DB::table( $this->_table).' where is_hidden = %d '.$category.' limit '.($page-1)*$num.','.$num , array(0));
	}

	public function get_free_course_by_page($page,$num) {
		return DB::fetch_all('select id,fullname,logo,summary from '.DB::table( $this->_table).' where is_hidden = %d and is_free = %d limit '.($page-1)*$num.','.$num , array(0,1));
	}

	public function get_hot_course_by_page($page,$num) {
		return DB::fetch_all('select c.id,c.fullname,c.logo,c.summary,t.click_count from '.DB::table( $this->_table).' as c left join '.DB::table( $this->_clickcount).' as t on c.id = t.itemid  where is_hidden = %d limit '.($page-1)*$num.','.$num , array(0));
	}
	//*******display on lesson page*******
	public function get_free_by_id( $id) {
		return DB::fetch_first('select is_free from '.DB::table( $this->_table).' where id = '.$id);
	}

	public function get_free_by_pageid( $id) {
		return DB::fetch_first('select c.is_free from '.DB::table( $this->_table).' as c left join '.DB::table( $this->_jointable).' as p on p.lessonid = c.id where p.id = '.$id);
	}

	public function get_title_by_id( $id) {
		 return DB::fetch_first('select id,fullname from '.DB::table($this->_table).' where id = '.$id);
	}

	public function get_all_course_orderby_sortid() {
		return DB::fetch_all('select id,sortid,category_id,fullname,is_hidden,is_free from '.DB::table( $this->_table).' order by sortid');
	}

	public function get_all_title() {
		return DB::fetch_all('select fullname from '.DB::table( $this->_table).' where 1');
	}

	public function insert_empty_course() {
		return DB::query('insert into '.DB::table($this->_table).'(sortid,category_id,fullname,is_hidden,is_free) values(9999,0,'.quote_m('新的课程').',1,0)');
	}

	public function update_course( $data) {
		DB::query('update '.DB::table($this->_table).' set fullname='.$data['fullname'].',sortid='.$data['sortid'].',category_id='.$data['category_id'].',is_free='.$data['is_free'].',is_hidden='.$data['is_hidden'].',summary='.$data['summary'].',logo='.$data['logo'].' where id = '.$data['id']);
	}

	public function delete_by_id( $id) {
		DB::query('delete from '.DB::table( $this->_table).' where id = '.$id);
	}
}