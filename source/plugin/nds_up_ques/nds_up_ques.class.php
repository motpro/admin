<?PHP
/*  nds_up_ques  v3.1
 *  Plugin FOR Discuz! X 
 *	WWW.NWDS.CN | NDS.西域数码工作室 
 *  Plugin update 20121212 BY singcee
 */
if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}

class plugin_nds_up_ques {
    function plugin_nds_up_ques() {
       global $_G;
	    $this->ndsquesname = trim($_G['cache']['plugin']['nds_up_ques']['ndsquesname']); 
        $this->allowcredit = unserialize($_G['cache']['plugin']['nds_up_ques']['allowcredit']);
        $this->allowsubmit = unserialize($_G['cache']['plugin']['nds_up_ques']['allowsubmit']);
        $this->cvar = $_G['cache']['plugin']['nds_up_ques']['creditvar']; 
        $this->allowhookgroups = unserialize($_G['cache']['plugin']['nds_up_ques']['allowhookgroups']);
        $this->allowhookforums = unserialize($_G['cache']['plugin']['nds_up_ques']['allowhookforums']);
        $this->deftype = $_G['cache']['plugin']['nds_up_ques']['deftype'];
        $this->defleas = $_G['cache']['plugin']['nds_up_ques']['defleas'];
        $this->quesadmins = $_G['cache']['plugin']['nds_up_ques']['quesadmins'];
        $this->opcheck = $_G['cache']['plugin']['nds_up_ques']['opcheck'];
        $this->qclassset = $_G['cache']['plugin']['nds_up_ques']['qclass'];
    }
}

 class plugin_nds_up_ques_forum extends plugin_nds_up_ques {
     function viewthread_posttop_output(){
        global $_G;
        $viframeheight = 260;
        $siframeheight = 260;
        $ndsvtreturn = array();
        if(!in_array($_G['fid'], $this->allowhookforums)) return $ndsvtreturn; 
        $questpid = DB::fetch_first("SELECT topicid,postmust,isprivate FROM ".DB::table('ques_topic')." WHERE tid = '$_G[tid]' "); 
        if (!$questpid['topicid']) {
        	return $ndsvtreturn;
        }else{
           	$viframeheight +=  $questpid['iframeheight'];
            $ndsvtreturn[0] = '<iframe id="nds_ques" name="nds_ques" height="'.$viframeheight.'" width="766" scrolling="no" border="0" frameborder="0" src="'.$_G[siteurl].'plugin.php?id=nds_up_ques&action=viewques&hook=1&topicid='.$questpid[topicid].'" ></iframe>';
        }
		return $ndsvtreturn;   
		   
         }
 } 
?>