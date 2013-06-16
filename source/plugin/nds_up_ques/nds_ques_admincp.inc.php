<?PHP
/*  nds_up_ques  v3.1
 *  Plugin FOR Discuz! X 
 *	WWW.NWDS.CN | NDS.西域数码工作室 
 *  Plugin update 20121212 BY singcee
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$cp = $_G['gp_cp'];
if($cp == 'delete'){
	
  if($_G['adminid'] != 1) showmessage('nds_up_ques:nodelete' , '' ,'',array('alert' => 'error')); 
	$count =  DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('ques_user')." WHERE `topicid`='$topicid' LIMIT 1"), 0);		
  if($count) showmessage('nds_up_ques:nodeletesheet' , '' ,'',array('alert' => 'error')); 	
  if(submitcheck('quesadminsubmit')) { 	
 	DB::query("DELETE FROM ".DB::table('ques_topic')." WHERE  topicid = '$topicid'");
	DB::query("DELETE FROM ".DB::table('ques_option')." WHERE  topicid = '$topicid'");
  showmessage('nds_up_ques:deleteok', 'plugin.php?id=nds_up_ques', array(), array('showdialog' => true, 'locationtime' => true));
  }	
  include template('nds_up_ques:ques_adminwindow'); 
	
}elseif($cp == 'deletesheet'){	
	$count =  DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('ques_topic')." WHERE `authorid`='$_G[uid]' AND `topicid`='$topicid' LIMIT 1"), 0);
	if($_G['adminid'] != 1 && !$count) showmessage('nds_up_ques:noopa' , '' ,'',array('alert' => 'error')); 
	//if($_G['adminid'] != 1 ) showmessage('nds_up_ques:noopa' , '' ,'',array('alert' => 'error')); 
  if(submitcheck('delsubmit')) { 
	$questopic =  DB::fetch_first("SELECT credit,qreward FROM ".DB::table('ques_topic')." WHERE  `topicid`='$topicid' LIMIT 1");
	$quesuser = DB::fetch_first("SELECT authorid,mark FROM ".DB::table('ques_user')." WHERE  `qid` = '$qid' LIMIT 1"); 
	if ($questopic['credit'] &&  $quesuser['mark'] ){
    	$mark = $sysmode == 1 ? $questopic['qreward']:$quesuser['mark'];
		$mark = 0 - ($mark > $creditmax ? $creditmax:$mark) ;
    	$extcreditn = 'extcredits'.$cvar;
    	$extcreditarr = array($extcreditn => $mark );
    	updatemembercount($quesuser['authorid'], $extcreditarr, $checkgroup = false,'','','');
    }
    DB::query("UPDATE ".DB::table('ques_topic')." SET `post_count`= post_count - 1 WHERE `topicid`='$topicid'");
    DB::query("UPDATE ".DB::table('ques_topic')." SET `person`= person + 1 WHERE `topicid`='$topicid'");
    DB::query("UPDATE ".DB::table('ques_countlog')." SET `tag`= 1 WHERE `topicid`='$topicid' and `uid` = $quesuser[authorid] ");
	DB::query("DELETE FROM ".DB::table('ques_user')." WHERE  qid = '$qid'");
	DB::query("DELETE FROM ".DB::table('ques_result')." WHERE  qid = '$qid'");
  showmessage('nds_up_ques:deleteok', 'plugin.php?id=nds_up_ques:nds_up_ques&action=viewques&topicid='.$topicid, array(), array('showdialog' => true, 'locationtime' => true));
  }
	include template('nds_up_ques:ques_delwindow'); 
	
}elseif($cp == 'cleanall'){	
	
	//$count =  DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('ques_topic')." WHERE `authorid`='$_G[uid]' AND `topicid`='$topicid' LIMIT 1"), 0);
	//if($touser = $count) $ar = 1;
   // if($_G['adminid'] != 1 && !$ar) showmessage('nds_up_ques:noopa' , '' ,'',array('alert' => 'error')); 
    if($_G['adminid'] != 1 ) showmessage('nds_up_ques:noopa' , '' ,'',array('alert' => 'error'));
 /*  $questopic =  DB::fetch_first("SELECT credit FROM ".DB::table('ques_topic')." WHERE  `topicid`='$topicid' LIMIT 1");
   if ($questopic['credit']){
   	$query1 = DB::query(" SELECT authorid,mark FROM ".DB::table('ques_user')." WHERE `topicid`='$topicid' ORDER by `qid`");		
   	$extcreditn = 'extcredits'.$cvar;	
   	WHILE($quesuser = DB::fetch($query1)){
    	if (!empty($quesuser['mark']) ){
  		  	$mark = $quesuser['mark'] > $creditmax ? $creditmax:$quesuser['mark'] ;
    		$extcreditarr = array($extcreditn => $mark );
    		updatemembercount($quesuser['authorid'], $extcreditarr, $checkgroup = false,'','','');
        }
  	}
   } */
   if(submitcheck('quesadminsubmit')) { 
 	DB::query("DELETE FROM ".DB::table('ques_user')." WHERE  topicid = '$topicid'");
	DB::query("DELETE FROM ".DB::table('ques_result')." WHERE  topicid = '$topicid'");
    DB::query("UPDATE ".DB::table('ques_topic')." SET `post_count`=0  WHERE `topicid` = '$topicid'");
    DB::query("UPDATE ".DB::table('ques_countlog')." SET `tag`= 1 WHERE `topicid`='$topicid' ");	
   showmessage('nds_up_ques:deleteok', 'plugin.php?id=nds_up_ques:nds_up_ques&action=viewques&topicid='.$topicid, array(), array('showdialog' => true, 'locationtime' => true));
  }				
	include template('nds_up_ques:ques_adminwindow'); 
}elseif($cp == 'delmyans'){
   $count =  DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('ques_user')." WHERE `authorid`='$_G[uid]' AND `qid`='$qid' LIMIT 1"), 0);
	if(!$count) showmessage('nds_up_ques:noopa' , '' ,'',array('alert' => 'error')); 
   $questopic =  DB::fetch_first("SELECT credit,qreward,userrepost FROM ".DB::table('ques_topic')." WHERE  `topicid`='$topicid' LIMIT 1");
   	if(!$questopic['userrepost']) showmessage('nds_up_ques:noopa' , '' ,'',array('alert' => 'error'));  	
  if(submitcheck('delsubmit')) { 
	$questopic =  DB::fetch_first("SELECT credit,qreward,userrepost FROM ".DB::table('ques_topic')." WHERE  `topicid`='$topicid' LIMIT 1");
   	$quesuser = DB::fetch_first("SELECT authorid,mark FROM ".DB::table('ques_user')." WHERE  `qid` = '$qid' LIMIT 1"); 
	if ($questopic['credit'] &&  $quesuser['mark'] ){
    	$mark = $sysmode == 1 ? $questopic['qreward']:$quesuser['mark'];
		$mark = 0 - ($mark > $creditmax ? $creditmax:$mark) ;
    	$extcreditn = 'extcredits'.$cvar;
    	$extcreditarr = array($extcreditn => $mark );
    	updatemembercount($_G[uid], $extcreditarr, $checkgroup = false,'','','');
   }
    DB::query("UPDATE ".DB::table('ques_topic')." SET `post_count`= post_count - 1 WHERE `topicid`='$topicid'");
    DB::query("UPDATE ".DB::table('ques_topic')." SET `person`= person + 1 WHERE `topicid`='$topicid'");
    DB::query("UPDATE ".DB::table('ques_countlog')." SET `tag`= 1 WHERE `topicid`='$topicid' and `uid` = $_G[uid] ");
	DB::query("DELETE FROM ".DB::table('ques_user')." WHERE  qid = '$qid'");
	DB::query("DELETE FROM ".DB::table('ques_result')." WHERE  qid = '$qid'");
    showmessage('nds_up_ques:deleteok', 'plugin.php?id=nds_up_ques:nds_up_ques&action=viewques&topicid='.$topicid, array(), array('showdialog' => true, 'locationtime' => true));
  }	
    include template('nds_up_ques:ques_delwindow'); 
		
}elseif($cp == 'stop'){
	
	if($_G['adminid'] != 1) showmessage('nds_up_ques:noopa' , '' ,'',array('alert' => 'error')); 
	
	DB::query("UPDATE ".DB::table('ques_topic')." SET `stop`='1' WHERE `topicid`='$topicid'");
	showmessage('nds_up_ques:stopok','plugin.php?id=nds_up_ques:nds_up_ques');
	
}elseif($cp == 'open'){
	
	if($_G['adminid'] != 1) showmessage('nds_up_ques:noopa' , '' ,'',array('alert' => 'error')); 
	
	DB::query("UPDATE ".DB::table('ques_topic')." SET `stop`='0' WHERE `topicid`='$topicid'");
	showmessage('nds_up_ques:openok','plugin.php?id=nds_up_ques:nds_up_ques');
}elseif($cp == 'goopcheck'){
	if(!$ndsopcheck  ||  (!in_array($_G['groupid'],$ndsquesadmins) && $_G['adminid'] != 1)) showmessage('nds_up_ques:noopa' , '' ,'',array('alert' => 'error')); 
	DB::query("UPDATE ".DB::table('ques_topic')." SET `opcheck`='1' , `opcheckauthorid` = '".$_G['uid']."' ,  `opcheckauthor` = '".$_G['username']."'  WHERE `topicid`='$topicid'");
	showmessage('nds_up_ques:goopcheckok','plugin.php?id=nds_up_ques:nds_up_ques&action=viewques&topicid='.$topicid);
}elseif($cp == 'unopcheck'){
	if(!$ndsopcheck ||  (!in_array($_G['groupid'],$ndsquesadmins) && $_G['adminid'] != 1)) showmessage('nds_up_ques:noopa' , '' ,'',array('alert' => 'error')); 
	DB::query("UPDATE ".DB::table('ques_topic')." SET `opcheck`='0' , `opcheckauthorid` = '".$_G['uid']."' ,  `opcheckauthor` = '".$_G['username']."'  WHERE `topicid`='$topicid'");
    showmessage('nds_up_ques:unopcheckok','plugin.php?id=nds_up_ques:nds_up_ques&action=viewques&topicid='.$topicid);
}elseif($cp == 'dexpenses'){
      	if(!$_G['uid']) {
       	 showmessage('nds_up_ques:paynologin', '', array(), array('login' => true));
      	}else{
	      	$questopic =  DB::fetch_first("SELECT expenses  FROM ".DB::table('ques_topic')." WHERE  `topicid`='$topicid' LIMIT 1"); 
			$balance = getuserprofile('extcredits'.$cvar) - $questopic['expenses'] ;
		    if ($balance < $questopic['expenses']){
	            showmessage('nds_up_ques:nds_paymessyebz' , '' ,'',array('alert' => 'error'));      
		    }
      	}
  if(submitcheck('paysubmit')) { 
	$questopic =  DB::fetch_first("SELECT expenses  FROM ".DB::table('ques_topic')." WHERE  `topicid`='$topicid' LIMIT 1"); 
	if ($questopic['expenses'] ){
     	$mark = 0 - $questopic['expenses'] ;
    	$extcreditn = 'extcredits'.$cvar;
    	$extcreditarr = array($extcreditn => $mark );
    	updatemembercount($_G[uid], $extcreditarr, $checkgroup = false,'','','');
        $data = array('uid' =>$_G['uid'],'topicid' => $topicid,'type' => 2, 'num' =>$questopic['expenses'],'dateline' => $_G['timestamp']);
        DB::insert('ques_countlog', $data, true);
	};
       showmessage('nds_up_ques:nds_paysucc', 'plugin.php?id=nds_up_ques:nds_up_ques&action=viewques&topicid='.$topicid, array(), array('showdialog' => true, 'locationtime' => true));
  }
	include template('nds_up_ques:ques_dexwindow'); 
	
}

?>