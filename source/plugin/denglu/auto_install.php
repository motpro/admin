<?php
if(!file_exists(dirname(__FILE__).'/install.lock')){
	$src = "themes/template/";
	$dst = "../../../";
	$returs = $install->_copy_move($src, $dst,"copy");
	$warming[][]= '插入注册页LOGO完毕........';
	$warming[][] =  '插入登录页LOGO完毕........';
	$warming[][] =  '恭喜您！您已成功安装灯鹭插件！';
 	//锁定安装程序
	$fp=@fopen("./install.lock","w");
	@fclose($fp);
}else{
	$warming[][] =  '恭喜您！您已成功安装灯鹭插件！';
}
?>