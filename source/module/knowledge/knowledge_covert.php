<?php

if( isset( $_POST['publish'])) {
	$id = C::t('knowledge_repository')->add_dict( array(	'uid'=>$_G['uid'] , 
													'title' => trim( $_POST['title']),
													'keyword' => trim( $_POST['keyword']),
													'content' => htmlspecialchars( $_POST['content']),
													'categoryid' => 0,
													'createddate' => time(),
													'lastfixeddate' => time(),
	));

	header('Location: knowledge.php?mod=repository');
}

$id = intval( $_GET['id']);
$question = C::t('knowledge_question')->get_question_by_id( $id);

$topic = C::t('knowledge_topic')->get_by_id( $question['topicid']);

$answer = C::t('knowledge_answer')->get_answer_by_qid( $id);

require template('knowledge/covert');