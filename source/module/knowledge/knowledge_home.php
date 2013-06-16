<?php
	if( isset( $_GET['get_more_question'] )) {
		//header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		//header("Cache-Control: no-cache, must-revalidate");
		//header("Pragma: no-cache");
		if( isset( $_GET['type']))
			$more = C::t('knowledge_question')->get_new_question_by_page( $_GET['get_more_question'] , 10 , $_GET['type']);
		else
			$more = C::t('knowledge_question')->get_new_question_by_page( $_GET['get_more_question'] , 10 );

		foreach ($more as $question) {
			$question['avatar'] = avatar( $question['uid'] , 'small');
			$list [] = $question;
		}
		echo json_encode( $list);
		exit;
	}
//话题类别id
$type = isset( $_GET['type']) ? intval( $_GET['type']) : null ;
//话题类别 keywords
$type_name =  (null === $type) ? '' : C::t('knowledge_topic')->get_by_id( $type) ;

$new = C::t('knowledge_question')->get_new_question_by_page(1 , 10 , $type);

require template('knowledge/home');