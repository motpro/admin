<?php

/**
 *      本页面核心功能预计
 *		问题检索 提问 回答 相似问题 推荐到知识库
 *      
 */

define('CURSCRIPT', 'knowledge');
require './source/class/class_core.php';

$discuz = C::app();
$discuz->init();

//ajax添加话题标签
if( $_POST['action'] === 'new_topic'){
	$topic = C::t('knowledge_topic')->set( array( 'topic_words' => dhtmlspecialchars( trim( $_POST['params']['topic'])) , 'pass' => 0));
	echo json_encode( $topic);
	exit;
}

if( isset( $_POST['action'])) {

	if( 'get_attitude' === $_POST['action']) {
		
		$attitude = C::t('knowledge_answer_attitude')->get_attitude_by_aid( $_POST['params']['aid'] , $_POST['params']['uid']);

		echo $attitude['attitude'];

		exit;	
	}else if( 'get_topic' === $_POST['action']) {

	}
}

$message = C::t('b_call')->count_newmessage( $_G['uid']);

$mod = $_GET['mod'] ? trim( $_GET['mod']) : 'home';
define('CURMODULE', $mod);

require libfile('knowledge/'.$mod, 'module');