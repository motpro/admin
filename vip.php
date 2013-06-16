<?php

define('IN_KKVIP', true);
define('CURSCRIPT', 'vip');

require './source/class/class_core.php';
$discuz = & discuz_core::instance();
$cachelist = array('plugin','dsu_kkvip');
$discuz->cachelist = $cachelist;
$discuz->init();
include_once libfile('class/vip');
$vip = $vip ? $vip : new vip();
if(!$vip->on) showmessage('undefined_action');
$is_vip = $vip->is_vip();
$_G['vip'] = $vip->getvipinfo($_G['uid']);
$_G['vip']['czz'] = intval($_G['vip']['czz']);
$_G['vip']['exptime_text']=dgmdate($_G['vip']['exptime'],'d');

$_G['basescript'] = 'vip';
$action = $_GET['action'] ? $_GET['action'] : 'vipcenter';
if (preg_match('/[^a-zA-Z0-9_]/', $action)) showmessage('undefined_action');
if (!$_G['uid']) showmessage('not_loggedin','member.php?mod=logging&action=login');
define('CURMODULE', str_replace('_', '', $action));

$vip_czz=!$_G['vip']['year_vip']?$vip->vars['vip_czzday']:$vip->vars['vip_czzday']+$vip->vars['vip_czz_year'];

switch ($_G['vip']['level']) {
	case 5:
		$update_days=round((10800-$_G['vip']['czz'])/$vip_czz);
		$update_time=dgmdate($_G['timestamp']+$update_days*86400,'d');
		$next_level=6;
		break;
	case 4:
		$update_days=round((6000-$_G['vip']['czz'])/$vip_czz);
		$update_time=dgmdate($_G['timestamp']+$update_days*86400,'d');
		$next_level=5;
		break;
	case 3:
		$update_days=round((3600-$_G['vip']['czz'])/$vip_czz);
		$update_time=dgmdate($_G['timestamp']+$update_days*86400,'d');
		$next_level=4;
		break;
	case 2:
		$update_days=round((1800-$_G['vip']['czz'])/$vip_czz);
		$update_time=dgmdate($_G['timestamp']+$update_days*86400,'d');
		$next_level=3;
		break;
	case 1:
		$update_days=round((600-$_G['vip']['czz'])/$vip_czz);
		$update_time=dgmdate($_G['timestamp']+$update_days*86400,'d');
		$next_level=2;
		break;
}
$next_level = ($_G['vip']['level']>0 && $_G['vip']['level']<6) ? $_G['vip']['level'] + 1 : 0;

$vipmenu = array(
	0 => array(
		'action' => 'vipcenter',
		'name' => lang('plugin/dsu_kkvip', 'vip_index'),
	),
	/*
	5 => array(
		'action' => 'continue',
		'name' => lang('plugin/dsu_kkvip', 'continue'),
	),
	*/
	10 => array(
		'action' => 'active',
		'name' => lang('plugin/dsu_kkvip', 'active'),
	),

	/*
	15 => array(
		'action' => 'paycenter',
		'name' => lang('plugin/dsu_kkvip', $vip->is_vip() ? 'vip_pay2' : 'vip_pay'),
	),
	*/
	20 => array(
		'action' => 'history',
		'name' => lang('plugin/dsu_kkvip' , 'history'),
	),
	/*
	25 => array(
		'action' => 'use_history',
		'name' => lang('plugin/dsu_kkvip', 'use_history'),
	),
	*/
	/*
	30 => array(
		'action' => 'give_vip',
		'name' => lang('plugin/dsu_kkvip', 'vip_pay_give'),
	),
	*/
	/*
	50 => array(
		'action' => 'mylevel',
		'name' => lang('plugin/dsu_kkvip', 'vip_mylevel'),
	),
	55 => array(
		'action' => 'new_vip',
		'name' => lang('plugin/dsu_kkvip', 'new_vip'),
	),
	60 => array(
		'action' => 'vip_top',
		'name' => lang('plugin/dsu_kkvip', 'vip_top'),
	),
	65 => array(
		'action' => 'year',
		'name' => lang('plugin/dsu_kkvip', 'year'),
	),
	*/

);
$vip_credit_name=$_G['setting']['extcredits'][$vip->vars['creditid']]['title'];
$vip_credit='extcredits'.$vip->vars['creditid'];
$query=DB::fetch($vip->query("SELECT {$vip_credit} FROM pre_common_member_count WHERE uid='{$_G[uid]}'"));
$my_credit=$query[$vip_credit];

runhooks();
ksort($vipmenu);
$file = DISCUZ_ROOT."./source/plugin/dsu_kkvip/module/{$action}.inc.php";
if ($_GET['plugin']) {
	if (preg_match('/[^a-zA-Z0-9_]/', $_GET['plugin'])) showmessage('undefined_action');
	$file = DISCUZ_ROOT."./source/plugin/{$_GET[plugin]}/vip/{$action}.inc.php";
}

if (!file_exists($file)) showmessage('undefined_action');
include $file;

?>