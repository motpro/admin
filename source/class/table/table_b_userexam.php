<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *		字段说明
 *		@id 自增int PK
 *		@uid int userid
 *		@eid int exam_bucket_id( 试题id 参见b_exam_bucket的id )
 *		@user_result string json格式 考生做的答案
 * 		@user_goal int 考试分数 
 * 		@generate_date 考试成绩产生日期
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_b_userexam extends discuz_table {

	private $_jointable;
	private $_exam;
	private $_ucenter_members;

	public function __construct () {
		$this->_table = 'b_userexam';
		$this->_pk    = 'id';
		$this->_jointable = 'b_exam_bucket';
		$this->_exam = 'b_exam';
		$this->_ucenter_members = 'ucenter_members';

		parent::__construct();
	}

	public function goal_calculator( $users , $answer , $base = 120) {
		//按题目正确数量占总数的百分比算分
		//基础总分默认120
		$base_goal = count( $answer) * 2;
		$goal = 0;
		foreach ($answer as $key => $right) {
			//单选多选全对 满分 , 多选半对 半分
			if( $users[$key] == $right){
				$goal = $goal+2;
			}else if( FALSE !== strpos( $right, $users[$key])) {
				++$goal;
			}
		}
		return intval( $base * ($goal/$base_goal));
	}

	public function save_result( $result) {
		$test = DB::fetch_first('select * from '.DB::table( $this->_table).' where uid = '.$result['uid'].' and eid = '.$result['eid']);
		if( $test['id']) {
			return $test;
		}else{
			$this->insert( $result);
			return $result;
		}
			
	}

	public function get_result_by_id( $id){
		return DB::fetch_first( 'select u.*,b.title from '.DB::table( $this->_table).' as u left join '.DB::table( $this->_jointable).' as b on u.eid = b.id where u.id = '.$id);
	}

	public function get_result_by_eid( $eid , $uid){
		return DB::fetch_first( 'select * from '.DB::table( $this->_table).' as u left join '.DB::table( $this->_jointable).' as b on u.eid = b.id where u.uid = '.$uid.' and u.eid = '.$eid);
	}

	public function get_users_by_eid( $eid) {
		return DB::fetch_all( 'select e.id,e.uid,e.eid,e.user_goal,e.generate_date,p.username from '.DB::table( $this->_table).' as e left join '.DB::table( $this->_ucenter_members).' as p on p.uid = e.uid where e.eid = '.$eid.' order by user_goal desc');
	}

	public function get_detail_by_id( $id) {
		$users = DB::fetch_first('select * from '.DB::table( $this->_table).' where id = '.$id);
		$bucket = DB::fetch_first('select * from '.DB::table( $this->_jointable).' where id = '.$users['eid']);
		$question = DB::fetch_all('select * from '.DB::table( $this->_exam).' where bucket_id = '.$users['eid']);
		return array('users' => $users , 'bucket' => $bucket , 'question' => $question);
	}


}