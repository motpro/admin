<?php
	define('DISCUZ_ROOT', dirname(__FILE__).'/../../../');
	define('IN_DISCUZ',1);
	
	require_once DISCUZ_ROOT.'source/class/class_core.php';
	$discuz = & discuz_core::instance();
	
	$discuz->cachelist = $cachelist;
	$discuz->init();

	$myphp = substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
	$myurl = $_G['siteurl'].$myphp;
	
	$Dlang = lang('plugin/denglu');
	$offset = 10;
	$step = intval($_G['gp_s'])*$offset;
	//检查新浪数据表是否存在
	$xl_tb = DB::table("xwb_bind_info");
	$sql = "show tables like '$xl_tb'";
	$r = DB::result_first($sql);
	if($r == $xl_tb){
		define('XWB',1);
	}
	
	if(!defined('XWB')){
		showMsg($Dlang['sina_no_exists']);
	}
	//////////////检查是否成功安装灯鹭连接 
	$dl_tb = DB::table("denglu_bind_info");
	$sql = "show tables like '$dl_tb'";
	$r = DB::result_first($sql);
	if($r == $dl_tb){
		define('DENGLU',1);
	}
	if(!defined('DENGLU')){
		showMsg($Dlang['denglu_no_exists']);
	}
	//////////////检查人人表字段是否正常
	$sql = "desc ".DB::table("xwb_bind_info");
	$q = DB::query($sql);
	while ($arr=DB::fetch($q)){
		$field[] = $arr['Field'];
	}
	if(!(in_array('sina_uid',$field) && in_array('uid',$field))){
		showMsg($Dlang['sina_table_false']);
	}
	///////////////开始转换
	$sql = "select uid,sina_uid from ".DB::table("xwb_bind_info")." limit $step,$offset";
	$q = DB::query($sql);
	while($a = DB::fetch($q)){
		$ret[$a['uid']] = $a['sina_uid'];/////////////////传参
		$chk[$a['sina_uid']] = $a['uid'];/////////////////////核对
	}
	empty($ret) && showMsg($Dlang['sina_switch_success']);

	$x = implode(',',$ret);
	
	$str = file_get_contents("http://open.denglu.cc/api/v2/apiGetMediaData.jsp?x=$x&m=3");
	$userinfo = json_decode($str,1);
	!$userinfo && showMsg($Dlang['error_network']);

	if(strtolower($_G['charset']) != 'utf-8') {
		$userinfo=dl_conv1($userinfo, "GBK", "UTF8");
	}
	$n = 0;
	foreach($userinfo as $v){
		$mediaUID=$mediaID=$uid=0;
		$uid = $chk[$v['mediaUID']];
		!$uid && showMsg($Dlang['receive_data_false']);
		extract($v);
		$sql = "select uid from  ".DB::table("denglu_bind_info")." where mediaUserID='$mediaUserID'";
		$r = DB::fetch_first($sql);
		if(isset($r['uid'])){
			continue;
		}
		$sql = "select uid from ".DB::table("denglu_bind_info")." where uid='$uid' and mediaID=3";
		if(DB::fetch_first($sql)){
			continue;
		}
		$sql = "select uid,regdate from ".DB::table("common_member")." where uid=$uid";
		$dz = DB::fetch_first($sql);
		$sql = "select is_first from ".DB::table('denglu_bind_info')." where is_first=1 and uid=$uid";
		$is_first = DB::result_first($sql) ? 0 : 1;
		$r = DB::insert('denglu_bind_info',array('uid'=>$uid,'mediaUserID'=>$v['mediaUserID'],'mediaID'=>3,'screenName'=>$v['screenName'],'tag'=>1,'createtime'=>$dz['regdate'],'is_first'=>$is_first));
		!$r && showMsg($uid.$Dlang['insert_db_false']);
		$n++;
	}
	$s = $step/$offset;
	$s +=1;
	showMsg($Dlang['success_update'].$n.$Dlang['records'],$myurl.'?s='.$s);
	
		if(!function_exists('json_decode')){
		function djson_decode($json)
		{
			$comment = false;
			$out = '$x=';
		
			for ($i=0; $i<strlen($json); $i++)
			{
				if (!$comment)
				{
					if (($json[$i] == '{') || ($json[$i] == '['))       $out .= ' array(';
					else if (($json[$i] == '}') || ($json[$i] == ']'))   $out .= ')';
					else if ($json[$i] == ':')    $out .= '=>';
					else                         $out .= $json[$i];
				}
				else $out .= $json[$i];
				if ($json[$i] == '"' && $json[($i-1)]!="\\")    $comment = !$comment;
			}
			eval($out . ';');
			return $x;
		}
	}
	function dfopen($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE) {
		$return = '';
		$matches = parse_url($url);
		$host = $matches['host'];
		$path = $matches['path'] ? $matches['path'].(isset($matches['query']) && $matches['query'] ? '?'.$matches['query'] : '') : '/';
		$port = !empty($matches['port']) ? $matches['port'] : 80;
	
		if($post) {
			$out = "POST $path HTTP/1.0\r\n";
			$out .= "Accept: */*\r\n";
			$out .= "Accept-Language: zh-cn\r\n";
			$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$out .= "Host: $host\r\n";
			$out .= 'Content-Length: '.strlen($post)."\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Cache-Control: no-cache\r\n";
			$out .= "Cookie: $cookie\r\n\r\n";
			$out .= $post;
		} else {
			$out = "GET $path HTTP/1.0\r\n";
			$out .= "Accept: */*\r\n";
			$out .= "Accept-Language: zh-cn\r\n";
			$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$out .= "Host: $host\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Cookie: $cookie\r\n\r\n";
		}
	
		if(function_exists('fsockopen')) {
			$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
		} elseif (function_exists('pfsockopen')) {
			$fp = @pfsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
		} else {
			$fp = false;
		}
	
		if(!$fp) {
			return '';
		} else {
			stream_set_blocking($fp, $block);
			stream_set_timeout($fp, $timeout);
			@fwrite($fp, $out);
			$status = stream_get_meta_data($fp);
			if(!$status['timed_out']) {
				while (!feof($fp)) {
					if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n")) {
						break;
					}
				}
	
				$stop = false;
				while(!feof($fp) && !$stop) {
					$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
					$return .= $data;
					if($limit) {
						$limit -= strlen($data);
						$stop = $limit <= 0;
					}
				}
			}
			@fclose($fp);
			$return = json_decode($return,1);
			return $return;
		}
	}
	if(!function_exists('mb_convert_encoding')){
		function mb_convert_encoding($string,$to,$from)
		{
			if ($from == "UTF-8")
			$iso_string = utf8_decode($string);
			else
			if ($from == "UTF7-IMAP")
			$iso_string = imap_utf7_decode($string);
			else
			$iso_string = $string;
	
			if ($to == "UTF-8")
			return(utf8_encode($iso_string));
			else
			if ($to == "UTF7-IMAP")
			return(imap_utf7_encode($iso_string));
			else
			return($iso_string);
		}
	}
	function dl_conv1($str,$to,$from){
		if(is_array($str)){
			foreach($str as $k => $v){
				$k = dl_conv1($k,$to,$from);
				$v = dl_conv1($v,$to,$from);
				$str[$k] = $v;
			}
		}else{
			return  mb_convert_encoding($str,$to,$from);
		}
		return $str;
	}
	function showMsg($msg,$url=false){
		global $_G,$Dlang;
		echo '<div id="messagetext" class="alert_info"><p>'.$msg.'</p>';
		if($url!=false){
			echo '<p class="alert_btnleft"><a href="'.$url.'">'.$Dlang['jump_tip'].'</a></p>';
			echo '<script type="text/javascript" reload="1">setTimeout("window.location.href =\''.$url.'\';", 3000);</script>';
		}
		echo '</div>';
		exit();
	}
	
?>
