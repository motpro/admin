<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_b_exam extends discuz_table {

	public function __construct () {
		$this->_table = 'b_exam';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function add_question( $question){
		return $this->insert( $question , true ,true);
	}

	public function get_questions_by_bucketid( $bucket_id) {
		return DB::fetch_all('select * from '.DB::table( $this->_table).' where bucket_id = '. $bucket_id .' order by sid');
	}

	public function update_question( $question) {
		return $this->update($question['id'] , $question);
	}

	public function remove_question_by_id( $id) {
		return DB::query('delete from '.DB::table( $this->_table).' where id = '.$id);
	}

	public function get_answer_by_bucketid( $bucket_id) {
		$answer = DB::fetch_all('select sid,answer from '.DB::table( $this->_table).' where bucket_id = '.$bucket_id.' and type in (\'s\',\'m\') ');
		$return = array();
		foreach ($answer as $value) {
			$return[$value['sid']] = $value['answer'];
		}
		return $return;
	}

}