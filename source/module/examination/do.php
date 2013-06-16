<?php
define( 'MODULENAME', 'do');

$id = intval( $_GET['id']);

$bucket_info = C::t('b_exam_bucket')->get_bucket_by_id( $id);

if( $bucket_info['id'])
	$question = C::t('b_exam')->get_questions_by_bucketid( $id);

if( isset( $_POST['post_paper'])) {



	foreach ($_POST as $key => $value) {
		//匹配多选答案
		if( preg_match('/^\d{1,2}_[A-Z]$/' , $key , $result)){
			if( $result[0]){
				unset( $_POST[$key]);
				$r = explode('_', $result[0]);
				$_POST[ $r[0]] = $_POST[ $r[0]].$r[1];
			}
		}
	}
	
	$bucket_id = intval( $_POST['target_exam']);

	unset($_POST['post_paper']);
	unset( $_POST['target_exam']);


	$bucket_content = C::t('b_exam')->get_answer_by_bucketid( $bucket_id);
	$goal = C::t('b_userexam')->goal_calculator( $_POST , $bucket_content);

	$result = C::t('b_userexam')->save_result( array(
		'uid' => $_G['uid'],
		'eid' => $id,
		'user_result' => json_encode( $_POST),
		'user_goal' => $goal,
		'generate_date' => time(),
		)
	);
	require template('examination/result');
	exit;
}

if( isset( $_GET['get_goal'])) {
	if( isset( $_GET['id'])){
		$id = intval( $_GET['id']);
		$result = C::t('b_userexam')->get_result_by_id( $id);
	}else if( isset( $_GET['eid'])) {
		$eid = intval( $_GET['eid']);
		$result = C::t('b_userexam')->get_result_by_eid( $eid , $_G['uid']);
	}


	require template('examination/result');
	exit;
}

require template('examination/do');