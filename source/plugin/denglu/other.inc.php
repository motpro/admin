<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

/** cache menage **/
//error_reporting(E_ALL);
require_once dirname(__FILE__).'/lib/Denglu.php';
loadcache('plugin');
$Plang = $scriptlang['denglu'];
if(!empty($_G['gp_denglusubmit'])){

	$api = new Denglu($_G['cache']['plugin']['denglu']['appid'], $_G['cache']['plugin']['denglu']['dl_apikey'], 'utf-8');
	$img_path = dirname(__FILE__).'/template/images/';
	$arr = $api->getMedia();
	!is_writeable(dirname(__FILE__).'/lib') && exit($Plang['lib_cannot_write']);
	!is_writeable($img_path) && exit($Plang['images_cannot_write']);

	foreach($arr as $v){
		$array[] = $v;
		copy('http://open.denglu.cc/images/denglu_second_'.$v['mediaID'].'.png',$img_path.'denglu_second_'.$v['mediaID'].'.png');
		copy('http://open.denglu.cc/images/denglu_second_icon_'.$v['mediaID'].'.png',$img_path.'denglu_second_icon_'.$v['mediaID'].'.png');
		copy('http://open.denglu.cc/images/denglu_second_icon_no_'.$v['mediaID'].'.png',$img_path.'denglu_second_icon_no_'.$v['mediaID'].'.png');
	}
	$str = "<?php\r\nreturn \$denglu_data = ".var_export($array,1)."\r\n\n?>";

	if($fp = fopen(dirname(__FILE__).'/lib/denglu.data.php','wb')){
		fwrite($fp,$str);
	}else{
		dlalert($Plang['lib_cannot_write']);
	}
    !$arr && exit('network_failed');
	header('location: admin.php?action=plugins&operation=config&do=13&identifier=denglu&pmod=other');
}
require_once dirname(__FILE__).'/lib/denglu.data.php';

if(empty($denglu_data)){
	echo $Plang['denglu_guide'];
}
loadcache('usergroups');

echo $Plang['this_is_our_data'];
showtableheader();
echo '<tr><th>MEDIAIMG</th><th>MEDIANAME</th><th>APPKEY</th><th>SECRETKEY</th></tr>';

foreach($denglu_data as $key ){

	echo '<tr><td><img src="source/plugin/denglu/template/images/denglu_second_icon_'.$key['mediaID'].'.png"></td><td>'.$key[mediaName].'</td><td>'.$key['apiKey'].'</td><td>'.$key['secretKey'].'</td></tr>';
}
showtablefooter();
echo '<br><br>';
showformheader('plugins&operation=config&do='.$pluginid.'&identifier=denglu&pmod=other', 'denglu');
showsubmit('denglusubmit', $Plang['reload']);
showformfooter();

?>
