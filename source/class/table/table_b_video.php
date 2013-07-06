<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_b_video extends discuz_table {

	private $_jointable;

	public function __construct () {
		$this->_table = 'b_video';
		$this->_pk    = 'id';
		$this->_jointable = 'b_lesson_pages';

		parent::__construct();
	}

	public function get_video_by_pageid( $id) {
		return DB::fetch_first('select v.v_file,v.v_path from '.DB::table( $this->_table).' as v left join '.DB::table( $this->_jointable).' as p on p.film_id = v.id where p.id='.$id);
	}

	public function get_video_voice( $lessonid) {
		return DB::fetch_all('select v.v_voice from '.DB::table($this->_table).' as v left join '.DB::table($this->_jointable).' as p on v.id = p.film_id where lessonid = '.$lessonid);
	}

	public function insert_for_page( $data) {
		return DB::query('insert into '.DB::table($this->_table).'(v_file,v_path,label_a_file,label_b_file,image_file,label_a,label_b,v_voice) values('.$data['v_file'].','.$data['v_path'].','.$data['label_a_file'].','.$data['label_b_file'].','.$data['image_file'].',0,1,1)');
	}

	public function insert_new_film( $v_file) {
		return DB::query('insert into '.DB::table( $this->_table).'(v_file , label_a , label_b , v_voice) values('.$v_file.' , 0, 1, 1)');
	}

	public function update_video( $data) {
		DB::query('update '.DB::table( $this->_table).' set v_file = '.$data['v_file'].',v_path = '.$data['v_path'].',label_a = '.$data['label_a'].',label_a_file = '.$data['label_a_file'].',cn_intro = '.$data['cn_intro'].',en_intro = '.$data['en_intro'].',image_file = '.$data['image_file'].',updated_date = '.time().',label_b = '.$data['label_b'].',label_b_file = '.$data['label_b_file'].',v_time = '.$data['v_time'].',v_voice = '.$data['v_voice'].' where id = '.$data['film_id']);
	}

	public function delete_by_id( $id) {
		DB::query('delete from '.DB::table( $this->_table).' where id = '.$id);
	}

	public function get_video_info_by_id( $id) {
		return DB::fetch_first( 'select v.v_path,v.label_a,v.label_a_file,v.label_b,v.label_b_file,v.cn_intro,v.en_intro,v.image_file,v.v_time,v.v_voice,v.v_name from '.DB::table( $this->_table) .' as v left join '.DB::table( $this->_jointable).' as p on p.film_id = v.id where p.id = '.$id);
	}

}