<?php
/*
 * @version $Id: install_boot.php 376 2012-05-24 06:06:23Z miaojb $
 */

$denglu_p_root = dirname(__FILE__);
include($denglu_p_root.'/lib/Extension_class.php');
include $denglu_p_root.'/file_name.php';
$install = new extension();
$action = $_GET['action'];
if($action == 'plugins'){
	include('install.php');
	$action = '';
}


switch ($action){
	case '':
		 include($denglu_p_root.'/themes/install/welcome.html');
		 break;
	case 'one':

		//检测PHP版本
		$php_v = $install->Env();
		//检测文件目录是否可写(不存在就是不可写)
		$file_info = $install->file_mode_info($file_name);
		//var_dump($file_info);die;
		//检测函数
		$function_info = $install->FunctionTest($list);
		include($denglu_p_root.'/themes/install/env.html');
		break;
	case 'two':
		//检测服务器时间
		date_default_timezone_set('PRC');
		//$standard = $install->GetStandardTimestamp();
        $str = file_get_contents("http://ntp.news.sohu.com/mtime.php");
        $str = substr($str,5);
        $time = explode(",", $str);
        $formate = $time[3].','.$time[4].','.$time[5].','.$time[0].','.$time[1].','.$time[2];
        $standard = mktime($formate);
		$local = time();
		include $denglu_p_root.'/lib/cache_timestamp.php';
		$cache_timestamp = empty($cache_timestamp)?0:$cache_timestamp;
		$AdjustmentTime = $local+(int)$cache_timestamp;
		$time_dif = $standard-$AdjustmentTime;
		$time_cha = abs($time_dif);
		if($time_cha<=10*60){
			$time = 1;
		}else {
			$time = 0;
		}
		include($denglu_p_root.'/themes/install/dbs.html');
		break;
	case 'three':

		//复制指定文件到根目录
		$src = array(denglu=>'./themes/denglu.php',dl_receiver=>'./themes/dl_receiver.php');
		$dst = '../../../';
		foreach ($src as $v=>$val){
				$install-> _copy_move($src, $dst, 'copy');
				//$back_v[$v] = $install->_isFind($dst.$val);
		}

		//复制指定文件夹到根目录
		$src_photo = './template/denglu';
        $dst_d = '../../../template/default/';
		$install-> _copy_move($src_photo, $dst_d, 'copy');


		if($_GET['type']!='agin'){

        define('IN_ADMINCP', TRUE);
        define('NOROBOT', TRUE);
        define('ADMINSCRIPT', basename(__FILE__));
        define('CURSCRIPT', 'admin');
        define('HOOKTYPE', 'hookscript');
        define('APPTYPEID', 0);

        //$path_install = substr(dirname(__FILE__),0,-13);
        //echo $path_install;die;
        require '../../class/class_core.php';
        require '../../function/function_misc.php';
        require '../../function/function_forum.php';
        require '../../function/function_admincp.php';
        require '../../function/function_cache.php';

        $discuz = C::app();
        $discuz->init();



		    $res = DB::query("select pluginid from pre_common_pluginvar where title='APIKEY'");

		    $row = DB::fetch($res);
              //var_dump($row);die;
		    $pluginid = $row['pluginid'];
			DB::query("UPDATE pre_common_pluginvar SET value= '".$_POST['denglu_appid'] ."' WHERE pluginid='$pluginid' AND variable='appid'");
			DB::query("UPDATE pre_common_pluginvar SET value= '".$_POST['denglu_appkey']."' WHERE pluginid='$pluginid' AND variable='dl_apikey'");

			updatecache(array('plugin', 'setting', 'styles'));
			include_once(dirname(__FILE__).'/lib/Extension_class.php');
			$install = new extension();
			$denglu_cache = $_POST;
			$install->saveAppkey(dirname(__FILE__).'/lib/denglu_cache.php',$denglu_cache);
			$install->updateImgDate(dirname(__FILE__).'/lib/Denglu.php',dirname(__FILE__).'/lib/denglu_cache.php',dirname(__FILE__).'/lib/denglu.data.php','utf-8');

		}
       //  echo 'bbbbbb';die;
		//检测文件是否复制到指定位置
		$src_d = array(denglu=>'../../../denglu.php',dl_receiver=>'../../../dl_receiver.php');
		foreach ($src_d as $v=>$val){
				$back_v[$v] = $install->_isFind($val);
		}
		//检测文件夹是否复制到指定位置
		$dir_uc = 1;
		include(dirname(__FILE__).'/file_name.php');
		//社会化平台素材图片验证
		$pathImg = dirname(__FILE__).'/template/images/';
		$tb = $install->testImg(dirname(__FILE__).'/lib/denglu.data.php',$pathImg);

		include(dirname(__FILE__).'/themes/install/config.html');
		break;
	case 'four':
		//安装文件
		//更新缓存引入的$_SESSION['hash']
		//define('PHPCMS_PATH', substr(dirname(__FILE__),0,-22).DIRECTORY_SEPARATOR);
		//include PHPCMS_PATH.'/phpcms/base.php';
		//$session_storage = 'session_'.pc_base::load_config('system','session_storage');
		//pc_base::load_sys_class($session_storage);


		//$install_method = $_POST['install_method'];
		include($denglu_p_root.'/themes/install/install.html');
		break;
	case 'testing_appid':
		//检测APPID和APPKEY
		$test_result = $install->testAppID($denglu_p_root.'/lib/Denglu.php',$_POST['app_id'],$_POST['app_key'],'utf-8');
		echo $test_result;
		break;
	case 'adjust_time':
		$time_dif = $_POST['time_dif'];
		$back = $install->write_time($time_dif);
		echo $back;
		break;
	case 'updateImg':
		 $back_img = $install->updateImg($denglu_p_root.'/lib/denglu.data.php',$denglu_p_root.'/template/images/');
		 //$install->testImg('./lib/denglu_data.php','./images/');
		 echo $back_img;
		 break;
	case 'entry':
		//锁定安装程序
		$fp=@fopen(dirname(__FILE__).'/install/install.off',"w");
		@fclose($fp);
		header('location:../../../');
		break;
}
?>