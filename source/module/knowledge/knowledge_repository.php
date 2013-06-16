<?php
$dict_list = C::t('knowledge_repository')->get_dict_list();

if( isset( $_GET['view'])) {
	$id = intval( $_GET['view']);
	$dict = C::t('knowledge_repository')->get_dict_by_id( $id);
	require template('knowledge/dictionary');
	exit;
}
require template('knowledge/repository');