<?php
if(!defined('IN_ADMINCP')) exit('Access Denied');
require_once DISCUZ_ROOT.'./source/plugin/dsu_kkvip/kk_lang.func.php';
echo '<script src="static/js/calendar.js" type="text/javascript"></script>';
if(!$_GET['username']){
	showtableheader(klang('edit_user'));
	showformheader('plugins&operation=config&identifier=dsu_kkvip&pmod=user');
	showsetting(klang('username'), 'username', '', 'text');
	showsubmit('search', 'search');
	showformfooter();
	showtablefooter();
}elseif(!submitcheck('submit')){
	$_GET['username'] = daddslashes($_GET['username']);
	$uid = DB::result_first('SELECT uid FROM '.DB::table('common_member')." WHERE username='{$_GET[username]}'");
	if(!$uid) cpmsg(klang('user_not_exist'), '', 'error', array('username' => $_GET['username']));
	require_once libfile('class/vip');
	$vip = $vip ? $vip : new vip();
	if($vip->is_vip($uid)){
		$vip_info = $vip->getvipinfo($uid);
		showtableheader(klang('modify_vip_info'));
		showformheader("plugins&operation=config&identifier=dsu_kkvip&pmod=user&username={$_GET[username]}");
		showsetting(klang('jointime'), 'jointime', dgmdate($vip_info['jointime'], 'dt'), 'text', true);
		showsetting(klang('exptime'), 'exptime', dgmdate($vip_info['exptime'], 'd'), 'calendar');
		showsetting(klang('year_vip'), 'year_pay', $vip_info['year_pay'], 'radio');
		showsetting(klang('czz'), 'czz', $vip_info['czz'], 'number');
		showsubmit('submit');
		showformfooter();
		showtablefooter();
	}else{
		showtableheader(klang('help_pay'));
		showformheader("plugins&operation=config&identifier=dsu_kkvip&pmod=user&username={$_GET[username]}");
		showsetting(klang('pay_time'), 'time', '30', 'number');
		showsubmit('submit');
		showformfooter();
		showtablefooter();
	}
}else{
	$_GET['username'] = daddslashes($_GET['username']);
	$user = DB::fetch_first('SELECT uid, groupid FROM '.DB::table('common_member')." WHERE username='{$_GET[username]}'");
	if(!$user['uid']) cpmsg(klang('user_not_exist'), '', 'error', array('username'=>$_GET['username']));
	require_once libfile('class/vip');
	$vip = $vip ? $vip : new vip();
	if($vip->is_vip($user['uid'])){
		$czz = intval($_GET['czz']);
		DB::update('dsu_vip', array(
			'exptime' => strtotime($_GET['exptime']),
			'year_pay' => $_GET['year_pay'] ? 1 : 0,
			'czz' => $czz
		), array('uid' => $user['uid']));
		if($czz < 600){
			$level = 1;
		}elseif($czz >= 600 && $czz < 1800){
			$level = 2;
		}elseif($czz >= 1800 && $czz < 3600){
			$level = 3;
		}elseif($czz >= 3600 && $czz < 6000){
			$level = 4;
		}elseif($czz >= 6000 && $czz < 10800){
			$level = 5;
		}elseif($czz >= 10800){
			$level = 6;
		}
		$vip->query("UPDATE pre_dsu_vip SET level='{$level}' WHERE uid='{$user[uid]}'");
		$groupid = $vip->group[$level];
		$vip->query("UPDATE pre_common_member SET groupid={$groupid} WHERE uid='{$user[uid]}' AND adminid=0");
		require_once libfile('function/cache');
		updatecache('dsu_kkvip');
	}else{
		$vip->pay_vip($user['uid'], intval($_GET['time']), $user['groupid']);
	}
	cpmsg(klang('user_edit_succeed'), 'action=plugins&operation=config&identifier=dsu_kkvip&pmod=user', 'succeed');
}
?>