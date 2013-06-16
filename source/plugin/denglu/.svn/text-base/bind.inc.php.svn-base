<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once  DISCUZ_ROOT.'./source/plugin/denglu/lib/api.class.php';
$denglu_data  = denglu_data();

if(($mid = getgpc('mid')) && $_G['uid']){
	loadcache("plugin");
	dsetcookie('denglu_olbind','1');
	dheader("location:http://open.denglu.cc/transfer/".$mid."?appid=".$_G['cache']['plugin']['denglu']['appid']."&uid=".$_G['uid']);
}

global $_G;

if($_GET['option']){////////////在线登录+注册+绑定
	include template('denglu:oldenglu');
	exit();
}

$api = new denglu_api;

if(submitcheck('unbind')){///////////表单 中加入formhash
	$mediaUserID = $_POST['mediaUserID'];
	
	$api->post_unbind($mediaUserID);
	denglu_unbind($mediaUserID);
}
$renren_key = $api->post_get_renren();
if(submitcheck('doshare')){
	dsetcookie($_G['uid'].'temp_medias');
	dsetcookie($_G['uid'].'medias');
	
	denglu_userset($_G['uid']);
}

$bind_users = get_bind_users($_G['uid']);
if($_G['gp_tag']=='photo'){///////////////模板变量
	$myphoto = myphoto($bind_users,$denglu_data);
}
if(submitcheck('photoset') && $_G['gp_muid']){//////////////上传头像
	require_once './config/config_ucenter.php';
	$p = $_G['siteurl'].'source/plugin/denglu/avatar/'.$_G['gp_muid'];
	$url = UC_API.'/photo.php?uid='.$_G['uid'].'&muid='.$p.'&salt='.md5($_G['uid'].$p);
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	echo "<div style='display:none'><iframe src='".$url."'></iframe></div>";
	showmessage("denglu:photo_set_success",'home.php?mod=spacecp&ac=plugin&id=denglu:bind&tag=photo');	
}

foreach($bind_users as $buser){
	if($denglu_data[$buser['mediaID']]['shareFlag']){
		continue;
	}
	$bindusers[] = $buser;
}

if(count($bind_users)==1 && $bind_users[0]['tag']==0){
	dsetcookie('mediaUserID',$bind_users[0]['mediaUserID'],$_G['gp_cookietime']);
	$check_media = array();
	$bindusers = array();
}elseif(count($bind_users)==0){
	$check_media = check_media($bind_users,$denglu_data);
}
else{
	$check_media = check_media($bind_users,$denglu_data);
}


function myphoto($bind_users,$denglu_data){
	$myphoto = array();
	if(count($bind_users)==1 && $bind_users[0]['tag']==0){
		return $myphoto;
	}
	$photo_path = dirname(__FILE__).'/avatar/';
	foreach($bind_users as $v){

		if(file_exists($photo_path.$v['mediaUserID'].'_big.jpg')){
			$myphoto[] = $v;
		}
	}
	return $myphoto;
}

?>
