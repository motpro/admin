<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

loadcache('plugin');
$Plang = $scriptlang['denglu'];


if(!empty($_G['gp_oldswitch'])){
	$q = DB::query("select uid,mediaUID as mediaUserID,mediaID,username as screenName, regdate as createtime  from ".DB::table('common_member')." where mediaID <> 0");
	while($arr = DB::fetch($q)){
		DB::insert('denglu_bind_info',$arr);
		DB::query("update  ".DB::table('common_member')." set mediaID=0 where uid={$arr['uid']}");
	}
	echo "<script>alert('".$Plang['switch_success']."')</script>";	
}

echo "<script>function dl_switch(id){document.getElementById('dl_s').style.display='';document.getElementById('dl_s').src='source/plugin/denglu/'+id+'.php'}</script>";


echo $Plang['old_switch'];

showformheader('plugins&operation=config&do='.$pluginid.'&identifier=denglu&pmod=swith', 'denglu');
showsubmit('oldswitch', $Plang['here']);
showformfooter();

echo '<br>'.$Plang['renren_switch'].'<input type="submit" value="'.$Plang['here'].'"   class="btn" onclick="dl_switch(\'renren\')"><p>'.$Plang['sina_switch'].'<input type="submit" value="'.$Plang['here'].'"   class="btn" onclick="dl_switch(\'sina\')">';
showtableheader();
echo '<tr><td><iframe  id="dl_s"  style="width:100%;height:200px;display:none;border:0px;"></iframe></td></tr>';

showtablefooter();

?>

