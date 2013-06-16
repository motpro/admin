<?php
if( 'question' === $_GET['ac']){
	$title = '我的问题';
	$my_question = C::t('knowledge_question')->get_question_by_uid( $_G['uid']);
}else if( 'answer' === $_GET['ac']) {
	$title = '我的回答';
	$my_answer = C::t('knowledge_answer')->get_answer_by_uid( $_G['uid']);
}else {
	header('Location: knowledge.php');
}

require template('knowledge/user');