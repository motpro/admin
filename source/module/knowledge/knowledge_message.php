<?php

if( isset( $_GET['rm'])) {
	$id = dintval( $_GET['rm']);

	C::t('b_call')->delete_message( $id, $_G['uid']);
	header('Location: knowledge.php?mod=message');

}else if( isset( $_POST['close'])) {
	unset( $_POST['close']);
	foreach ($_POST as $key => $value) {
		$id[] = $key;
	}
	$in = implode( $id, ',');
	$in = '('.$in.')';
	C::t('b_call')->close_some_message( $in , $_G['uid']);
}	



$noclose = C::t('b_call')->get_noclose_message( $_G['uid']);
$close = C::t('b_call')->get_close_message( $_G['uid']);

require template('knowledge/message');