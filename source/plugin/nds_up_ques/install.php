<?php

/*  nds_up_ques  v3.1
 *  Plugin FOR Discuz! X 
 *	WWW.NWDS.CN | NDS.西域数码工作室 
 *  Plugin update 20121212 BY singcee
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$sql = <<<EOF
DROP TABLE IF EXISTS `pre_ques_topic`;
CREATE TABLE `pre_ques_topic` (
  `topicid` int(10) unsigned NOT NULL auto_increment,
  `subject` varchar(255) NOT NULL default 'NoName',
  `message` text NOT NULL,
  `author`  char(16) NOT NULL ,
  `authorid` int(8) NOT NULL default '0',
  `dateline` int(10) NOT NULL default '0',
  `person` int(8) NOT NULL default '100',
  `stop` tinyint(1) NOT NULL default '0',
  `credit` tinyint(1) NOT NULL default '0',
  `postmust` tinyint(1) NOT NULL default '0',
  `secret` tinyint(1) NOT NULL default '0',
  `exp` int(10) NOT NULL default '0',
  `tid` MEDIUMINT(8) NOT NULL DEFAULT '0',
  `usergroup` varchar(45), 
  `qclass` varchar(8) NOT NULL default '0',
  `opcheck` tinyint(1) NOT NULL default '0',
  `copyauthor` varchar(20) NOT NULL default '', 
  `copyauthorid` int(8) NOT NULL default '0', 
  `opcheckauthorid` int(8) NOT NULL default '0',
  `opcheckauthor` varchar(20) NOT NULL default '',
  `post_count` int(8) NOT NULL default '0',
  `ques_mode` tinyint(1) NOT NULL default '0',
  `qreward` INT(8) NOT NULL default '0',
  `isprivate` TINYINT(1) NOT NULL DEFAULT '0',
  `isprivatetext` TEXT NOT NULL,
  `seeanswer` TINYINT(1) NOT NULL DEFAULT '0',
  `ndsflag` TINYINT(1) NOT NULL DEFAULT '0',
  `ndsright` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' ,
  `tmclass` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' ,
  `tmtypehd` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' ,
  `tmtypetext` TEXT NOT NULL,
  `timeleft` INT(3) UNSIGNED NOT NULL DEFAULT '0' ,
  `expenses` INT(5) UNSIGNED NOT NULL DEFAULT '0',
  `posturl` VARCHAR(150),
  `userrepost` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' ,
  `ndsabc` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
  `strategy` text NOT NULL ,
  `nwds` INT(3) UNSIGNED NOT NULL DEFAULT '0',
  `isguest` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0', 
    PRIMARY KEY (topicid),
    KEY authorid (authorid)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_ques_option`;
CREATE TABLE `pre_ques_option` (
  `oid` int(10) unsigned NOT NULL auto_increment,
  `topicid` int(10) NOT NULL default '0',
  `title` varchar(255) NOT NULL default 'NoName',
  `desp` text NOT NULL,
  `mark` text NOT NULL,
  `option` text NOT NULL,
  `key` text NOT NULL,
  `order` int(8) NOT NULL default '0',
  `least` tinyint(1) NOT NULL default '0',
  `type` int(3) NOT NULL default '0',
  `multiplemax` int(3) unsigned NOT NULL default '0',
  `chmax` int(5) NOT NULL default '0', 
  `chmin` int(5) NOT NULL default '0',
  `othinput` tinyint(1) unsigned NOT NULL default '0',
  `textsize` int(3) unsigned NOT NULL default '0',
  `textareawidth` int(3) unsigned NOT NULL default '0', 
  `tmclass` MEDIUMINT(3) UNSIGNED NOT NULL DEFAULT '0',  
  PRIMARY KEY (oid),
  KEY topicid (topicid)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_ques_user`;
CREATE TABLE `pre_ques_user` (
  `qid` int(10) unsigned NOT NULL auto_increment,
  `topicid` int(10) NOT NULL default '0',
  `author` char(16) NOT NULL ,
  `authorid` int(8) NOT NULL default '0',
  `mark` int(10) NOT NULL default '0',
  `dateline` int(10) NOT NULL default '0',
  `isguest` CHAR(6) NOT NULL DEFAULT '0',
  `tmclassmark` VARCHAR(80) NOT NULL,
  `credit` INT(3) NOT NULL DEFAULT '0',
  `timer` CHAR(6) NOT NULL DEFAULT '0:00',
  `postip` CHAR(15) NOT NULL DEFAULT '0',   
   PRIMARY KEY (qid),
   KEY topicid (topicid),
   KEY authorid (authorid)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_ques_result`;
CREATE TABLE `pre_ques_result` (
  `qid` int(10) unsigned NOT NULL default '0',
  `topicid` int(10) unsigned NOT NULL default '0',
  `oid` int(10) unsigned NOT NULL default '0',
  `authorid` int(8) NOT NULL default '0',
  `answer` text NOT NULL,
  `score` int(3) NOT NULL default '0',
  `othinput` TEXT NOT NULL,
  KEY topicid (topicid)  
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_ques_countlog`;
CREATE TABLE `pre_ques_countlog` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `topicid` int(10) unsigned NOT NULL default '0',
  `type` TINYINT(1)  NOT NULL DEFAULT '0',
  `num` int(8) NOT NULL default '0',
  `uid` int(8) NOT NULL default '0',
  `dateline` int(10) NOT NULL default '0',
  `tag` TINYINT(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  KEY topicid (topicid),
  KEY uid (uid)
) ENGINE=MyISAM;
EOF;

runquery($sql);
$finish = TRUE;

?>