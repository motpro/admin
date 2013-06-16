<?php

/*
 *	KK Plugin Installer
 */
if(!defined('IN_ADMINCP')) exit('Access Denied');

$request_url=str_replace('&step='.$_GET['step'],'',$_SERVER['QUERY_STRING']);
showsubmenusteps($installlang['header'], array(
	array($installlang['step2'], !$_GET['step']),
	array($installlang['step3'], $_GET['step']=='stat' || $_GET['step']=='ok'),
));
$sql=<<<EOF
CREATE TABLE `pre_dsu_vip` (
   `uid` int(11) not null,
   `jointime` int(10) not null,
   `exptime` int(10) not null,
   `year_pay` tinyint(1) not null,
   `level` tinyint(4) not null,
   `czz` int(11) not null,
   `oldgroup` tinyint(4) not null,
   PRIMARY KEY (`uid`),
   KEY `jointime` (`jointime`),
   KEY `czz` (`czz`)
) ENGINE=MyISAM;

CREATE TABLE `pre_dsu_vip_codes` (
   `code` char(32),
   `money` int(5),
   `only_once` tinyint(1) unsigned default '1',
   `exptime` int(10),
   UNIQUE KEY (`code`),
   KEY `exptime` (`exptime`)
) ENGINE=MyISAM;
INSERT INTO `pre_common_cron` SET available=1, type='system', name='[DSU] VIP', filename='cron_dsu_kkvip.php', weekday='-1', day='-1', hour=0, minute=0;
EOF;
switch($_GET['step']){
	default:
	case 'sql':
		runquery($sql);
		save_syscache('dsu_kkvip', array());
		cpmsg($installlang['step2_ok'], "{$request_url}&step=stat", 'loading');
		break;
	case 'stat':
		$_statInfo = array();
		$_statInfo['pluginName'] = $pluginarray['plugin']['identifier'];
		$_statInfo['pluginVersion'] = $pluginarray['plugin']['version'];
		require_once DISCUZ_ROOT.'./source/discuz_version.php';
		$_statInfo['bbsVersion'] = DISCUZ_VERSION;
		$_statInfo['bbsRelease'] = DISCUZ_RELEASE;
		$_statInfo['timestamp'] = TIMESTAMP;
		$_statInfo['bbsUrl'] = $_G['siteurl'];
		$_statInfo['bbsAdminEMail'] = $_G['setting']['adminemail'];
		$_statInfo['action'] = substr($operation,6);
		$_statInfo=base64_encode(serialize($_statInfo));
		$_md5Check=md5($_statInfo);
		$dsuStatUrl='http://www.dsu.cc/stat.php';
		$_StatUrl=$dsuStatUrl.'?action=do&info='.$_statInfo.'&md5check='.$_md5Check;
		$code = "<script src=\"{$_StatUrl}\" type=\"text/javascript\"></script>";
		cpmsg($installlang['step3_ok'], "{$request_url}&step=ok", 'loading', array('stat_code'=>$code));
		break;
	case 'ok':
		$finish = TRUE;
		break;
}
?>