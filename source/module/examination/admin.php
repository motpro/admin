<?php
if( 1 != $_G['adminid']) {
	echo 'permission denied';
	exit;
}
//解释bucket跟question, 很多很多的question试题都放在不同的bucket试题桶里面，用于管理。这就是它们的关系。

//ajax
$action = trim( $_POST['action']);
$params = $_POST['params'];
//添加试题右边的ajax从这里获取数据
if( 'read_bucket_info' === $action){
	$id = intval( $params['bucket_id']);
	$result = C::t('b_exam_bucket')->read_bucket_info( $id);

	echo json_encode( $result);
	exit;
}
//ajax

$ac = $_GET['ac'] ? trim( $_GET['ac']) : 'home';

$op = $_GET['op'] ? trim( $_GET['op']) : 'list';

//设置试题对用户是否可见
if( 'push' === $ac) {
	$id = intval( $_GET['bucket_id']);
	C::t('b_exam_bucket')->set_status( $id , 1);
}else if( 'pop' === $ac) {
	$id = intval( $_GET['bucket_id']);
	C::t('b_exam_bucket')->set_status( $id , 0);
}


if( 'edit' === $_GET['op']) {

	//更新试题
	if( isset( $_POST['update_type'])) {

		if( 's' === $_POST['update_type']) {

			C::t('b_exam')->update_question( array(	'id' => $_POST['id'],
													'sid' => $_POST['sid'],
													'title' => trim( $_POST['title']),
													'question' => json_encode( array('A'=>$_POST['a'],'B'=>$_POST['b'],'C'=>$_POST['c'],'D'=>$_POST['d'])),
													'answer' => $_POST['answer'],
													'tips' => trim( $_POST['tips']),
			));

		}else if( 'm' === $_POST['update_type']){

			C::t('b_exam')->update_question( array(	'id' => $_POST['id'],
													'sid' => $_POST['sid'],
													'title' => trim( $_POST['title']),
													'question' => json_encode( array('A'=>$_POST['a'],'B'=>$_POST['b'],'C'=>$_POST['c'],'D'=>$_POST['d'])),
													'answer' => $_POST['A'].$_POST['B'].$_POST['C'].$_POST['D'],
													'tips' => trim( $_POST['tips']),
			));

		}else if( 'd' === $_POST['update_type']){

			C::t('b_exam')->update_question( array(	'id' => $_POST['id'],
													'sid' => $_POST['sid'],
													'title' => trim( $_POST['title']),
													'question' => trim( $_POST['question']),
													'tips' => trim( $_POST['tips']),
			));
		}

	}

	$id = intval( $_GET['eid']);
	
	//更新试题bucket的信息
	if( isset( $_POST['save_bucket_info'])) {

		C::t('b_exam_bucket')->update_bucket_info( array(
			'id' => intval( $_POST['id']),
			'title' => trim( $_POST['title']),
			'info' => trim( $_POST['info']),
			'bind_course' => intval( $_POST['bind_course']),
		));
	}

	$bucket_info = C::t('b_exam_bucket')->get_bucket_by_id( $id);

	$question_list = C::t('b_exam')->get_questions_by_bucketid( $id);

	$c = C::t('b_course')->get_course_title();

	require template('examination/admin_edit');
	exit;
}

if( 'remove' === $_GET['op']) {


	$id = intval( $_GET['eid']);
	//删除bucket
	$bucket_info = C::t('b_exam_bucket')->get_bucket_by_id( $id);

	if( isset( $_GET['submit'])){
		if( 1 === intval( $_GET['submit'])) {
			C::t('b_exam_bucket')->delete_bucket_by_id( $id);
			header('Location: examination.php?mod=admin');
		}else {
			header('Location: examination.php?mod=admin');
		}
	}


	require template('examination/admin_remove');

	exit;
}

if( 'rm_question' === $_GET['op']) {
	$id = intval( $_GET['qid']);
	$eid = intval( $_GET['eid']);
	C::t('b_exam')->remove_question_by_id( $id);
	header('Location: examination.php?mod=admin&ac=home&op=edit&eid='.$eid);
}

if( 'bucket' === $_GET['op']) {

	$c = C::t('b_course')->get_course_title();

	if( isset( $_POST['add_bucket'])){

		$status = C::t('b_exam_bucket')->create_bucket( array(	'title' => trim( $_POST['title']),
																'info'  => trim( $_POST['info']),
																'bind_course' => intval( $_POST['bind_course']),
		));
	}

	require template('examination/admin_bucket');
	exit;
}

if( 'create' === $_GET['op']){

	$bucket_list = C::t('b_exam_bucket')->get_bucket_list();

	if( isset( $_POST['single_info'])){

		$question = array(
			'A' => trim( $_POST['optiona']),
			'B' => trim( $_POST['optionb']),
			'C' => trim( $_POST['optionc']),
			'D' => trim( $_POST['optiond']),
		);

		$status = C::t('b_exam')->add_question( array(
			'sid' => intval( $_POST['sid']),
			'title' => trim( $_POST['title']),
			'type' => 's',
			'question' => json_encode( $question),
			'answer' => trim( $_POST['answer']),
			'tips' => trim( $_POST['single_info']),
			'bucket_id' => intval( $_POST['bucket_id']),
		));

		header('Location: examination.php?mod=admin&ac=library&op=create&status=ok&bucket_id='.$_POST['bucket_id']);
		exit;

	}else if ( isset( $_POST['multi_info'])) {

		$question = array(
			'A' => trim( $_POST['optiona']),
			'B' => trim( $_POST['optionb']),
			'C' => trim( $_POST['optionc']),
			'D' => trim( $_POST['optiond']),
		);

		C::t('b_exam')->add_question( array(
			'sid' => intval( $_POST['sid']),
			'title' => trim( $_POST['title']),
			'type' => 'm',
			'question'=>json_encode( $question),
			'answer' => $_POST['a'].$_POST['b'].$_POST['c'].$_POST['d'],
			'tips' => trim( $_POST['info']),
			'bucket_id' =>  intval( $_POST['bucket_id']),
		));

		header('Location: examination.php?mod=admin&ac=library&op=create&status=ok&bucket_id='.$_POST['bucket_id']);

		exit;	

	}else if ( isset( $_POST['descript_info'])) {

		C::t('b_exam')->add_question( array(
			'sid' => intval( $_POST['sid']),
			'title' => trim( $_POST['title']),
			'type' => 'd',
			'question'=> trim( $_POST['question']),
			'answer' => '',
			'tips' => trim( $_POST['info']),
			'bucket_id' =>  intval( $_POST['bucket_id']),
		));

		header('Location: examination.php?mod=admin&ac=library&op=create&status=ok&bucket_id='.$_POST['bucket_id']);
		exit;

	}
	require template('examination/admin_create');
	exit;
}

if( 'group' === $_GET['op']) {

	$eid = intval( $_GET['eid']);

	$list = C::t('b_userexam')->get_users_by_eid( $eid);
	$bucket_info = C::t('b_exam_bucket')->get_bucket_by_id( $eid);

	require template('examination/admin_group');

	exit;
}

if( 'detail' === $_GET['op']){
	$id = intval( $_GET['id']);

	$detail = C::t('b_userexam')->get_detail_by_id( $id);


	print_r( $detail);
	require template('examination/detail');
	exit;
}

$list = C::t('b_exam_bucket')->get_bucket_list();


require template('examination/admin');