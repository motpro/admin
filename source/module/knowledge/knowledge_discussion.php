<?php
$id = intval( $_GET['id']);


if( $_GET['aid'] && $_GET['attitude']) {
	C::t('knowledge_answer_attitude')->add_attitude( intval( $_GET['aid']), $_G['uid'] , intval( $_GET['attitude']));
}

if( $_GET['id'] && $_GET['makedone']) {
	C::t('knowledge_question')->set_question_done( intval( $_GET['id']) , $_G['uid']);
}


if( isset( $_POST['reply'])) {
	$discuss = dhtmlspecialchars( trim( $_POST['discuss']));
	C::t('knowledge_answer')->reply( array( 'uid'		=> $_G['uid'],
											'content' 	=> $discuss,
											'date' 		=> time(),
											'qid'		=> $id,
											'agree'		=> 0,
											'disagree' 	=> 0,
											'rank'      => 0,	
	));

	$question_title = C::t('knowledge_question')->get_title_by_id( $id);

	if( isset( $_POST['callme'])) {
		C::t('b_call')->new_feed(array(	'to_userid' => $_POST['callme'],
										'call_userid'=> $_G['uid'] , 
										'url' => 'knowledge.php?mod=discussion&id='.$id , 
										'message' => '您的问题 <strong>'.$question_title['title'].'</strong> 有新的回答了!')
		);
	}

}

if( isset( $_GET['rm'])) {
	$id = intval( $_GET['rm']);
	C::t('knowledge_answer')->delete_answer_by_uid( $id , $_G['uid']);
	header('Location: knowledge.php?mod=discussion&id='.$_GET['id']);
}

$question = C::t('knowledge_question')->get_question_by_id( $id);

C::t('knowledge_question')->new_visitor( $id);

$father_reply = C::t('knowledge_answer')->get_answer_by_qid( $id);

require template('knowledge/discussion');