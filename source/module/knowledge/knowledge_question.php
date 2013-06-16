<?php
if( isset( $_POST['publish'])) {
	$question = array(
		'uid' => $_G['uid'],
		'title' => $_POST['title'],
		'level' => 0,
		'view' => 1,
		'content' => dhtmlspecialchars( cutstr( $_POST['content'] , 1500)),
		'createddate' => time(),
		'callme' => $_POST['callme']=='on' ? 1 : 0,
		'topicid' => intval( $_POST['topicid']),
		'status' => 0,
	);
	
	$id = C::t('knowledge_question')->new_question( $question);
	header('Location: knowledge.php?mod=discussion&id='.$id);
}

//列出问题标签
$topic = C::t('knowledge_topic')->get( 1, 20, 0 ,'id desc');

require template('knowledge/problem');