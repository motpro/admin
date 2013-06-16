<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require 'source/plugin/denglu/lib/denglu.func.php';

global $_G;

if($_G['uid']){
	$tempMedias = getcookie($_G['uid'].'temp_medias');
	if(!$tempMedias){
		$medias = unserialize(htmlspecialchars_decode(getcookie($_G['uid'].'medias')));
	}else{
		$medias = unserialize(htmlspecialchars_decode($tempMedias));
	}
	if($medias){
		$module = isset($_GET['module']) ? strtolower(trim($_GET['module'])) : '';
		$mediaParam =  isset($_GET['media']) ? $_GET['media'] : 0;
		list($prefix,$mediaid) = explode('_',$mediaParam);
		$mediaid = intval($mediaid);
		if($mediaid  && $module){
			$image = '';
			$field = $module == 'forum' ? 'thread_syn' : 'log_syn';
			foreach ($medias as $key =>$media){
				if($media['mediaID'] == $mediaid){
					$medias[$key][$field] = $medias[$key][$field] ? 0 : 1;
					dsetcookie($_G['uid'].'temp_medias',htmlspecialchars(serialize($medias),ENT_QUOTES));
					break;
				}
			}
			foreach ($medias as $media){
				if($media[$field]){
					$image .= "<img onclick='dl_syc(this.id);' src='./source/plugin/denglu/template/images/denglu_second_icon_{$media['mediaID']}.png' id='media_{$media['mediaID']}'/>";
				}else{
					$image .= "<img onclick='dl_syc(this.id);' src='./source/plugin/denglu/template/images/denglu_second_icon_no_{$media['mediaID']}.png' id='media_{$media['mediaID']}'/>";
				}
			}
			include template('denglu:icon_ajax');
		}
	}
}
?>