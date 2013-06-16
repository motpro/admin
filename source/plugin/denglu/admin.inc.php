<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$Plang = $scriptlang['denglu'];

if($_G['gp_op'] == 'delete') {
	
	require_once './source/plugin/denglu/lib/api.class.php';
	$api = new denglu_api;
	
//	$q = DB::query("select mediaUserID from ".DB::table('denglu_bind_info')." where uid=".$_G['gp_uid']);
	ajaxshowheader();

	$api->post_unbind_all($_G['gp_uid']);
	DB::query("DELETE FROM ".DB::table('denglu_bind_info')." WHERE uid='$_G[gp_uid]'");

	echo $Plang['deleted'];
	ajaxshowfooter();
}

$ppp = 20;
$resultempty = FALSE;
$srchadd = $searchtext = $extra = $srchuid = '';
$page = max(1, intval($_G['gp_page']));
if(!empty($_G['gp_srchuid'])) {
	$srchuid = intval($_G['gp_srchuid']);
	$resultempty = TRUE;
} elseif(!empty($_G['gp_srchusername'])) {
	$_G['gp_srchusername'] = trim($_G['gp_srchusername']);
	$srchuid = DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username='$_G[gp_srchusername]'");
	if(!$srchuid) {
		$resultempty = false;
	}else{
		$resultempty = TRUE;
	}
}

if($searchtext) {
	$searchtext = '<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=denglu&pmod=admin">'.$Plang['viewall'].'</a>&nbsp'.$searchtext;
}

loadcache('usergroups');

showtableheader();
showformheader('plugins&operation=config&do='.$pluginid.'&identifier=denglu&pmod=admin', 'repeatsubmit');
showsubmit('denglusubmit', $Plang['search'], $lang['uid'].': <input name="srchuid" value="'.htmlspecialchars(stripslashes($_G['gp_srchuid'])).'" class="txt" />&nbsp;&nbsp;'.$Plang['username'].': <input name="srchusername" value="'.htmlspecialchars(stripslashes($_G['gp_username'])).'" class="txt" />', $searchtext);
showformfooter();

if($resultempty){
	$uids = (array)$srchuid;
	$count = 1; 
}else{
	$q = DB::query("SELECT distinct uid FROM ".DB::table('denglu_bind_info')." denglu  where 1");
	$uids = array();
	while($r = DB::fetch($q)){
		$uids[] = $r['uid'];
	}
	$count = count($uids);
}

$uid = '('.implode(',',$uids).')';
if($uids){
	echo '<tr class="header"><th>UID</th><th>'.$Plang['username'].'</th><th>'.$lang['usergroup'].'</th><th>'.$Plang['dl_first'].'</th><th>'.$Plang['bindtime'].'</th><th>'.$Plang['bindother'].'</th><th>'.$Plang['operation'].'</th><th></th></tr>';

	$query = DB::query("SELECT uid ,username, groupid FROM ".DB::table('common_member')."  WHERE uid in $uid ORDER BY uid LIMIT ".(($page - 1) * $ppp).",$ppp");
	
	$i = 0;
	while($denglu = DB::fetch($query)) {
		$q = DB::query("SELECT * FROM ".DB::table('denglu_bind_info')." where uid={$denglu['uid']}");
		
		$other_img = '';
		$media_users = array();
		while($muser = DB::fetch($q)){
			if($muser['is_first']==1){
				$media_users['first'] = $muser;
				continue;
			}
			$media_users[] = $muser;
			$other_img .= '<img src="source/plugin/denglu/template/images/denglu_second_icon_'.$muser['mediaID'].'.png"/>';
		}
		$i++;
		echo '<tr><td><a href="javascript:;">'.$denglu['uid'].'</a></td>'. 
			'<td><a href="javascript:;">'.$denglu['username'].'</a></td>'.
			'<td>'.$_G['cache']['usergroups'][$denglu['groupid']]['grouptitle'].'</td>'.
			'<td><img src="source/plugin/denglu/template/images/denglu_second_icon_'.$media_users['first']['mediaID'].'.png" /></td>'.
			'<td>'.date('Y-m-d H:i:s',intval($media_users['first']['createtime'])).'</td>'.
			'<td>'.$other_img.'</td>'.
			'<td><a id="p'.$i.'" onclick="ajaxget(this.href, this.id, \'\');return false" href="'.ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=denglu&pmod=admin&uid='.$denglu['uid'].'&op=delete">['.$lang['delete'].']</a></td></tr>';
	}
	
}else{
	echo '<tr><td>'.$Plang['no_user_data'].'</td></tr>';
}



showtablefooter();

echo multi($count, $ppp, $page, ADMINSCRIPT."?action=plugins&operation=config&do=$pluginid&identifier=denglu&pmod=admin");

?>
