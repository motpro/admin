<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_b_lesson_pages extends discuz_table {

	private $_jointable;
	private $_jointable2;

	public function __construct () {
		$this->_table = 'b_lesson_pages';
		$this->_pk    = 'id';
		$this->_jointable = 'b_video';
		$this->_jointable2 = 'b_course';

		parent::__construct();
	}

	public function get_pages_info_by_id( $id) {
		return DB::fetch_all('select p.id,p.film_id,p.title,v.image_file from '.DB::table( $this->_table).' as p left join '.DB::table( $this->_jointable ).' as v on p.film_id = v.id  where lessonid = '.$id);
	}

	public function get_preview_pages( $per) {
		$p =  DB::fetch_all('select p.id,p.lessonid,p.title,v.image_file from '.DB::table( $this->_table).' as p left join '.DB::table( $this->_jointable).' as v on p.film_id = v.id where 1');
		$tmp = array();

		foreach ($p as $page) {
			$tmp[$page['lessonid']][] = $page;
		}

		foreach ($tmp as $key => $value) {
			$tmp[$key] = array_slice( $value, 0 , $per , true);
		}

		return $tmp;

	}

	public function get_pages_by_lessonid( $id) {
		return DB::fetch_all('select p.*,v.v_file,v.v_path,v.label_a_file,v.label_b_file,v.image_file from '.DB::table( $this->_table).' as p left join '.DB::table( $this->_jointable).' as v on p.film_id = v.id where lessonid = '.$id);
	}

	public function get_page_by_id( $id) {
		return DB::fetch_first('select * from '.DB::table( $this->_table).' where id = '.$id);
	}

	public function get_title_by_id( $id) {
		return DB::fetch_first('select id,title from '.DB::table( $this->_table).' where id = '.$id);
	}

	public function get_page_title() {
		return DB::fetch_all('select id,title from '.DB::table( $this->_table).' where 1');
	}

	public function get_same_course_pages( $courseid) {
		return DB::fetch_all('select id,title,film_id from '.DB::table( $this->_table).' where lessonid = '.$courseid);
	}

	public function get_completed_page( $id) {
		return DB::fetch_all('select p.id,p.title,v.v_file,v.v_path,v.label_a_file,v.label_b_file,v.image_file from '.DB::table($this->_table).' as p left join '.DB::table( $this->_jointable).' as v on p.film_id = v.id where lessonid = '.$id);
	}

	public function get_pageedit_info( $id) {
		return DB::fetch_first('select p.*,v.v_file,v.v_path,v.label_a_file,v.label_a,v.label_b_file,v.label_b,v.cn_intro,v.en_intro,v.image_file,v.v_time,v.v_voice from '.DB::table( $this->_table).' as p left join '.DB::table( $this->_jointable).' as v on p.film_id = v.id where p.id = '.$id);
	}

	public function get_free_course_pages( $number) {
		return DB::fetch_all( 'select p.id,p.title,p.contents,v.image_file from ' .DB::table( $this->_jointable2). ' as c left join '.DB::table( $this->_table).' as p on c.id = p.lessonid inner join '.DB::table( $this->_jointable).' as v on p.film_id = v.id where c.is_free = 1 and c.is_hidden = 0 order by id desc limit '.$number);
	}

	public function get_all_title() {
		return DB::fetch_all('select title from '.DB::table( $this->_table).' where 1');
	}

	public function insert_new_page( $data) {
		return DB::query('insert into '.DB::table($this->_table).'(lessonid,timecreated,title) values('.$data['lessonid'].','.time().','.$data['title'].' )');
	}

	public function update_page( $data) {
		return DB::query('update '.DB::table( $this->_table).' set film_id = '.$data['film_id'].' where id = '.$data['pageid']);
	}

	public function update_pageedit( $data) {
		DB::query('update '.DB::table( $this->_table).' set film_id='.$data['film_id'].',prevpageid = '.$data['prevpageid'].',nextpageid = '.$data['nextpageid'].',title = '.$data['title'].',contents = '.$data['content'].' where id = '.$data['id']);
	}

	public function count_film_number( $courseid) {
		return DB::result_first('select count(id) from '.DB::table($this->_table).' where film_id > 0 and lessonid = '.$courseid);
	}

	public function count_pages_number( $lessonid) {
		return DB::result_first('select count(id) from '.DB::table($this->_table).' where lessonid = '.$lessonid);
	}

	public function delete_by_id( $id) {
		DB::query('delete from '.DB::table( $this->_table).' where id = '.$id);
	}

	public function delete_by_courseid( $courseid) {
		DB::query('delete from '.DB::table( $this->_table).' where lessonid = '.$courseid);
	}
}