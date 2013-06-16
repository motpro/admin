<?php
/*  nds_up_ques  v3.1
 *  Plugin FOR Discuz! X 
 *	WWW.NWDS.CN | NDS.西域数码工作室 
 *  Plugin update 20121212 BY singcee
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = '';
$qrewardexisted = false;
$isprivate = false;
$isprivatetext = false;
$isflag = false;
$query = DB::query("SHOW COLUMNS FROM ".DB::table('ques_topic'));
while($temp = DB::fetch($query)) {
	if($temp['Field'] == 'qreward') {
		$qrewardexisted = true; 
	}
	if($temp['Field'] == 'isprivate') {
		$isprivate =  true; 
	}
	if($temp['Field'] == 'isprivatetext') {
		$isprivatetext =  true; 
	}
	if($temp['Field'] == 'ndsflag') {
		$isflag =  true; 
	}
	   	
}

$chmaxexisted = false;
$query2 = DB::query("SHOW COLUMNS FROM ".DB::table('ques_option'));
while($temp2 = DB::fetch($query2)) {
	if($temp2['Field'] == 'chmax') {
		$chmaxexisted = true; 
		break;
	}
}

$sysmode  = DB::result_first("SELECT value FROM ".DB::table('common_pluginvar')." WHERE variable = 'sysmode'");
$sql .= !$qrewardexisted ? "ALTER TABLE  ".DB::table('ques_topic')." ADD COLUMN  `qreward` INT(8) NOT NULL DEFAULT '0';"."\n" : '';
$sql .= !$isprivate ? "ALTER TABLE  ".DB::table('ques_topic')." ADD COLUMN  `isprivate` TINYINT(1) NOT NULL DEFAULT '0';"."\n" : '';
$sql .= !$isprivatetext ? "ALTER TABLE  ".DB::table('ques_topic')." ADD COLUMN  `isprivatetext` TEXT NOT NULL;"."\n" : '';
$sql .= !$isprivate ? "ALTER TABLE  ".DB::table('ques_topic')." ADD COLUMN  `seeanswer` TINYINT(1) NOT NULL DEFAULT '0';"."\n" : '';
$sql .= !$chmaxexisted ? "ALTER TABLE  ".DB::table('ques_option')." ADD COLUMN  `chmax` INT(5) NOT NULL DEFAULT '0';"."\n" : '';
$sql .= !$chmaxexisted ? "ALTER TABLE  ".DB::table('ques_option')." ADD COLUMN  `chmin` INT(5) NOT NULL DEFAULT '0';"."\n" : '';
$sql .= !$chmaxexisted ? "ALTER TABLE  ".DB::table('ques_option')." ADD COLUMN   `othinput` TINYINT(1) NOT NULL DEFAULT '0';"."\n" : '';
$sql .= !$chmaxexisted ? "ALTER TABLE  ".DB::table('ques_option')." ADD COLUMN   `textsize` INT(3) NOT NULL DEFAULT '0';"."\n" : '';
$sql .= !$chmaxexisted ? "ALTER TABLE  ".DB::table('ques_option')." ADD  COLUMN  `textareawidth` INT(3) NOT NULL DEFAULT '0';"."\n" : '';
$sql .= !$chmaxexisted ? "ALTER TABLE  ".DB::table('ques_result')." ADD  COLUMN   `othinput` TEXT NOT NULL;"."\n" : '';
$sql .= !$isflag ? "ALTER TABLE  ".DB::table('ques_topic')." ADD COLUMN `ndsflag` TINYINT(1) NOT NULL DEFAULT '0' ;"."\n" : '';
$sql .= !$isflag ? "ALTER TABLE  ".DB::table('ques_topic')." ADD COLUMN `ndsright` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' ;"."\n" : '';
$sql .= !$isflag ? "ALTER TABLE  ".DB::table('ques_topic')." ADD COLUMN `tmclass` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' ;"."\n" : '';
$sql .= !$isflag ? "ALTER TABLE  ".DB::table('ques_topic')." ADD COLUMN `tmtypehd` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' ;"."\n" : '';
$sql .= !$isflag ? "ALTER TABLE  ".DB::table('ques_topic')." ADD COLUMN `tmtypetext` TEXT ;"."\n" : '';
$sql .= !$isflag ? "ALTER TABLE  ".DB::table('ques_topic')." ADD COLUMN `timeleft` INT(3) UNSIGNED NOT NULL DEFAULT '0' ;"."\n" : '';
$sql .= !$isflag ? "ALTER TABLE  ".DB::table('ques_topic')." ADD COLUMN `expenses` INT(5) UNSIGNED NOT NULL DEFAULT '0' ;"."\n" : '';
$sql .= !$isflag ? "ALTER TABLE  ".DB::table('ques_topic')." ADD COLUMN `posturl` VARCHAR(150);"."\n" : '';
$sql .= !$isflag ? "ALTER TABLE  ".DB::table('ques_topic')." ADD COLUMN `userrepost` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' ;"."\n" : '';
$sql .= !$isflag ? "ALTER TABLE  ".DB::table('ques_topic')." ADD COLUMN `ndsabc` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' ;"."\n" : '';
$sql .= !$isflag ? "ALTER TABLE  ".DB::table('ques_topic')." ADD COLUMN `strategy` TEXT NOT NULL ;"."\n" : '';
$sql .= !$isflag ? "ALTER TABLE  ".DB::table('ques_topic')." ADD COLUMN `isguest` CHAR(6) NOT NULL DEFAULT '0' ;"."\n" : '';
$sql .= !$isflag ? "ALTER TABLE  ".DB::table('ques_topic')." ADD COLUMN `nwds` INT(3) UNSIGNED NOT NULL DEFAULT '0' ;"."\n" : '';
$sql .= !$isflag ? "ALTER TABLE  ".DB::table('ques_option')." ADD COLUMN `tmclass` MEDIUMINT(3) UNSIGNED NOT NULL DEFAULT '0' ;"."\n" : '';
$sql .= !$isflag ? "ALTER TABLE  ".DB::table('ques_user')." ADD COLUMN `isguest` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' ;"."\n" : '';
$sql .= !$isflag ? "ALTER TABLE  ".DB::table('ques_user')." ADD COLUMN `tmclassmark` VARCHAR(80) NOT NULL ;"."\n" : '';
$sql .= !$isflag ? "ALTER TABLE  ".DB::table('ques_user')." ADD COLUMN `timer` CHAR(6) NOT NULL DEFAULT '0:00' ;"."\n" : '';
$sql .= !$isflag ? "ALTER TABLE  ".DB::table('ques_user')." ADD COLUMN `postip` CHAR(15) NOT NULL DEFAULT '0' ;"."\n" : '';
$sql .= !$isflag ? "ALTER TABLE  ".DB::table('ques_user')." ADD COLUMN `credit` INT(3) NOT NULL DEFAULT '0' ;"."\n" : '';
$sql .= !$isflag ? "ALTER TABLE  ".DB::table('ques_result')." ADD COLUMN `score` int(3) NOT NULL default '0' ;"."\n" : '';
$sql .= !$chmaxexisted ? "UPDATE  ".DB::table('ques_topic')." set `ques_mode` = $sysmode ;"."\n":'';
$sql .= !$isflag ? "CREATE TABLE `pre_ques_countlog` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `topicid` int(8) unsigned NOT NULL default '0',
  `type` TINYINT(1)  NOT NULL DEFAULT '0',
  `num` int(8) NOT NULL default '0',
  `dateline` int(10) NOT NULL default '0',
  `uid` int(10) unsigned NOT NULL default '0',
  `tag` TINYINT(1) unsigned NOT NULL DEFAULT '0',
   PRIMARY KEY (id)  
) ENGINE=MyISAM;":'';
runquery($sql);
$finish = true;
?>