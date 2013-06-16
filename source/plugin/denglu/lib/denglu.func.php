<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/* common_function*/
function dl_a($v='a'){
	echo '<script>alert("'.$v.'")</script>';
}

if(!function_exists('mb_convert_encoding')){
	function mb_convert_encoding($string,$to,$from)
	{
		if ($from == "UTF-8")
		$iso_string = utf8_decode($string);
		else
		if ($from == "UTF7-IMAP")
		$iso_string = imap_utf7_decode($string);
		else
		$iso_string = $string;

		if ($to == "UTF-8")
		return(utf8_encode($iso_string));
		else
		if ($to == "UTF7-IMAP")
		return(imap_utf7_encode($iso_string));
		else
		return($iso_string);
	}
}

if ( !function_exists('json_decode') ){
	function json_decode($json)
	{
		$comment = false;
		$out = '$x=';
	 
		for ($i=0; $i<strlen($json); $i++)
		{
			if (!$comment)
			{
				if (($json[$i] == '{') || ($json[$i] == '['))       $out .= ' array(';
				else if (($json[$i] == '}') || ($json[$i] == ']'))   $out .= ')';
				else if ($json[$i] == ':')    $out .= '=>';
				else                         $out .= $json[$i];         
			}
			else $out .= $json[$i];
			if ($json[$i] == '"' && $json[($i-1)]!="\\")    $comment = !$comment;
		}
		eval($out . ';');
		return $x;
	}
}

function get_bind_users($uid){
	$array = array();
	$query = DB::query("select * from ".DB::table('denglu_bind_info')." where uid=$uid");
	while($result = DB::fetch($query)){
		$array[] = $result;
	}

	return $array;
}

function dl_conv($str,$to,$from){
	if(is_array($str)){
		foreach($str as $k => $v){
			$k = dl_conv($k,$to,$from);
			$v = dl_conv($v,$to,$from);
			$str[$k] = $v;
		}
	}else{
		return  mb_convert_encoding($str,$to,$from);
	}
	return $str;
}

function check_media($bind_users,$denglu_data){////////检查用户还有哪些媒体可以绑定
	$bind_users = (array)$bind_users;
	$result = array();
	
	foreach($bind_users as $v){
		$arr[] = $v['mediaID'];
	}
	
	foreach($denglu_data as $key => $value){
		if(in_array($value['mediaID'],$arr)){
			continue;
		}
		$result[] = $value;
		
	}
	return $result;
}

function denglu_data(){
	$denglu_data  = include_once(dirname(__FILE__).'/denglu.data.php');
	
	foreach($denglu_data as $data){
		$arr[$data['mediaID']] = $data;
	}
	return $arr;
}

function make_media_avatar($img,$muid){
	require_once dirname(__FILE__).'/thumb.class.php';
	
	$thumb = new thumb;
	$type = $thumb->getImagesInfo($img);
	$tempimg = DISCUZ_ROOT.'source/plugin/denglu/avatar/'.substr(md5($muid),0,10).$type;
	$tempimg = str_replace('\\','/',$tempimg);
	
	@$thumb->upload_image($img,$tempimg);
	$big = $thumb->image_path($muid,'big');
	$middle = $thumb->image_path($muid,'middle');
	$small = $thumb->image_path($muid,'small');

	$thumb->make_thumb($tempimg,200,200,$big);
	$thumb->make_thumb($tempimg,120,120,$middle);
	$thumb->make_thumb($tempimg,48,48,$small);

	unlink($tempimg);
}
/*denglu_discuz x1.5 functions */

function denglu_register($userinfo){
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
	
	$groupinfo = array();
	if($_G['setting']['regverify']) {
		$groupinfo['groupid'] = 8;
	} else {
		$groupinfo['groupid'] = $_G['setting']['newusergroupid'];
	}
	
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

	if($uid <= 0 ) {
		$userinfo['screenName'] = $_G['gp_username'];
		
		$reg_error = $userinfo['tag'] ? 'reg' : 'quick';
		$dl_lang = lang('plugin/denglu');
		if($uid == -1) {
			$u_error = $dl_lang['profile_username_illegal'];
		} elseif($uid == -2) {
			$u_error = $dl_lang['profile_username_protect'];
		} elseif($uid == -3) {
			$u_error = $dl_lang['profile_username_duplicate'];
		} elseif($uid == -4) {
			$e_error = $dl_lang['profile_email_illegal']; 
		} elseif($uid == -5) {
			$e_error = $dl_lang['profile_email_domain_illegal'];
		} elseif($uid == -6) {
			$e_error = $dl_lang['profile_email_duplicate'];
		} else {
			showmessage('undefined_action', NULL, 'HALTED');
		}
	include template('denglu:denglu');
	exit();
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
	
	$param = array('bbname' => $_G['setting']['bbname'], 'username' => $_G['username'], 'uid' => $_G['uid']);

	
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
	//sendpm
	return $uid;
}
function get_bind_info($mediaUserID){
	$query = DB::fetch_first("select m.*  from ".DB::table('denglu_bind_info')." d left join ".DB::table('common_member')." m on m.uid=d.uid where d.mediaUserID='$mediaUserID'");
	return $query ? $query : false;
}

function denglu_login_set($member){
	global $_G;

	$_G['member'] = $member;
	include_once libfile('function/member');
	include_once libfile('function/stat');
	
	setloginstatus($member, $_G['gp_cookietime'] ? 2592000 : 0);
	DB::query("UPDATE ".DB::table('common_member_status')." SET lastip='".$_G['clientip']."', lastvisit='".time()."' WHERE uid='$_G[uid]'");

	updatestat('login', 1);
	updatecreditbyaction('daylogin', $_G['uid']);
	checkusergroup($_G['uid']);
}

function is_bind($userinfo){///////绑定要多加判断,
	global $_G;
	$return = 0;
	
	$query = DB::fetch_first("select uid,is_first from ".DB::table('denglu_bind_info')." where  mediaUserID={$userinfo['mediaUserID']}");
	if($query){////已绑定
		if($query['uid']==$_G['uid']){
			$return = 1;//////与本登录帐号绑定
		}else{
			$return = 2;/////与其他帐号绑定
		}
	}
	return $return;
}

function denglu_bind($userinfo){
	global $_G;
	
	$multi = DB::fetch_first("select mediaUserID from ".DB::table('denglu_bind_info')." where uid={$_G['uid']} and mediaID={$userinfo['mediaID']}");
	$multi && showmessage("denglu:binded_with_this_media",'home.php?mod=spacecp&ac=plugin&id=denglu:bind');
	
	DB::query("DELETE from ".DB::table('denglu_bind_info')." where mediaUserID={$userinfo['mediaUserID']}");
	$r = DB::result_first("select count(*) from ".DB::table('denglu_bind_info')." where uid={$_G['uid']}");
	
	$data = array(
		'uid' => $_G['uid'],
		'mediaUserID' => $userinfo['mediaUserID'],
      	'mediaID' => $userinfo['mediaID'],
		'screenName' => $userinfo['screenName'],
		'createtime' => time(),
		'is_first' => !$r ? 1 : 0,
		'thread_syn' => $userinfo['shareFlag'] ? 0 : 1,
		'log_syn' => $userinfo['shareFlag'] ? 0 : 1,
		'tag' => $userinfo['tag']
	);
	DB::insert('denglu_bind_info',$data);
	//showmessage("denglu_bind_success",'home.php?mod=spacecp&ac=plugin&id=denglu:bind');
}
function denglu_unbind($mediaUserID){
	global $_G;
	$r = DB::query("delete from ".DB::table('denglu_bind_info')." where mediaUserID=$mediaUserID and uid={$_G['uid']}");
	showmessage("denglu:denglu_unbind_success",dreferer());
}
function denglu_userset($uid){////////hidden an array for mediaUserID
	if(!$uid){
		showmessage('undefined action',dreferer());
	}
	$mediaUserID = $_POST['mediaUserID'];

	foreach($mediaUserID as $v){
		$condition = "uid={$uid} and mediaUserID={$v}";
		$data = array(
			'thread_syn'=>!empty($_POST['thread_syn_'.$v]) ? 1 : 0 ,
			'log_syn' => !empty($_POST['log_syn_'.$v]) ? 1 : 0,
			//'arc_syn' => $arc_syn[$i]
		);
		DB::update("denglu_bind_info",$data,$condition);
	}
	showmessage('denglu:setting_success',dreferer());
}

function get_media_info($mediaUserID){
	return DB::fetch_first("select * from ".DB::table('denglu_bind_info')." where mediaUserID=$mediaUserID");
}
?>
