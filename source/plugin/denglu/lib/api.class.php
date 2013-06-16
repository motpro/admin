<?php
require_once dirname(__FILE__).'/denglu.func.php';
class denglu_api {
	var $params = array();
	var $api_server = 'http://open.denglu.cc/api/v2/';
	function &instance() {
		static $object;
		if(empty($object)) {
			$object = new denglu_api();
		}
		return $object;
	}
	
	function denglu_api() {
		global $_G;
		loadcache('plugin');
		$this->params['appid'] = $_G['cache']['plugin']['denglu']['appid'];
	}
	
	function post_bind_info($userinfo){////appid=xx&muid=xx&uid=xx&uname=xx&uemail=xx
		global $_G;
		//$this->call_api('apiBind.jsp',array('muid'=>$userinfo['mediaUserID'],'uid'=>$_G['uid'],'uname'=>$_G['username'],'uemail'=>$_G['gp_email']));
		$this->open_url_no_return('apiBind.jsp',array('muid'=>$userinfo['mediaUserID'],'uid'=>$_G['uid'],'uname'=>$_G['username'],'uemail'=>$_G['gp_email']));
	}
	
	function open_url_no_return($path,$array=array()){
		
		$param = '?appid='.$this->params['appid'];
		foreach($array as $k=>$v){
			$param .= '&'.$k.'='.$v;
		}
		$this->api_server = 'http://open.denglu.cc/api/v2/';
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
		echo "<div style='display:none'><iframe src='".$this->api_server.$path.$param."'></iframe></div>";
	}
	function post_login($userinfo){
		global $_G;
		//$this->call_api('apiLoginSendFeed.jsp',array('muid'=>$userinfo['mediaUserID']));
		$this->open_url_no_return('apiLoginSendFeed.jsp',array('muid'=>$userinfo['mediaUserID']));
	}
	
	function post_get_renren(){
		$r = $this->call_api('apiGetMediaApiKey.jsp');
		
		return $r;
	}
	function post_unbind($mediaUserID){
		global $_G;
		//$this->call_api('apiUnbind.jsp',array('muid'=>$mediaUserID));
		$this->open_url_no_return('apiUnbind.jsp',array('muid'=>$mediaUserID));
	}
	function post_unbind_all($uid){
		$this->open_url_no_return('apiAllUnbind.jsp',array('uid'=>$uid));
	}
	function get_media_data(){
		$param = 'appid='.$this->params['appid'];
		$str = $this->callapi('apiGetMedia.jsp',$param);
		$arr = $this->handle_result($str);
		
		return $arr;
	}
	function get_user_info() {//////////get userinfo from api or hidden input
		global $_G;
		if(empty($_GET['token']) && empty($_POST['userbak'])){
			showmessage('denglu:nopermission');
		}
		if(!empty($_G['gp_userbak'])){
			$userinfo = authcode($_G['gp_userbak'],'DECODE');
		}else{
			$param = 'token='.$_GET['token'];
			$userinfo = $this->callapi('user_info',$param);
		}
		
		$_G['userbak'] = authcode($userinfo,'ENCODE');
		$userinfo = $this->handle_result($userinfo);
		return $userinfo;
	}
	
	function callapi($api,$param){//////////获得数据,转换编码
		$url = $this->api_server.$api.'?'.$param;
		$result = $this->fsock_get_contents($url);
		
		return $result;
	}
	
	function fsock_get_contents($url) {
		if(function_exists('ini_get') && ini_get('allow_url_fopen')){
			if($fp = fopen($url,'rb')){
				while(!feof($fp)){
					$content .= fgets($fp,1024);
				}
				fclose($fp);
				return $content;
			}	
		}
		if(!function_exists('fsockopen')) {
			if(function_exists('curl_init')){
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				$data = curl_exec($curl);
				curl_close($curl);
				return $data;
			}else{
				return 500;
			}
		} else {
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			$url = eregi_replace('^http://', '', $url);
			$temp = explode('/', $url);
			$host = array_shift($temp);
			$path = '/'.implode('/', $temp);
			$temp = explode(':', $host);
			$host = $temp[0];
			$port = isset($temp[1]) ? $temp[1] : 80;
			$fp = @fsockopen($host, $port, $errno, $errstr, 30);
			if ($fp){
				@fputs($fp, "GET $path HTTP/1.1\r\nHost: $host\r\nAccept: */*\r\nReferer:$url\r\nUser-Agent: $user_agent\r\nConnection: Close\r\n\r\n");
			}
			$content = '';
			while ($str = @fread($fp, 4096)){
				$content .= $str;
			}
			@fclose($fp);
			//Redirect
			if(preg_match("/^HTTP\/\d.\d 301 Moved Permanently/is", $content)){
				if(preg_match("/Location:(.*?)\r\n/is", $content, $murl)){
					return fsock_get_contents($murl[1]);
				}
			}
			//Read contents
			if(preg_match("/^HTTP\/\d.\d 200 OK/is", $content)){
				preg_match("/Content-Type:(.*?)\r\n/is", $content, $murl);
				$contentType = trim($murl[1]);
				$content = explode("\r\n\r\n", $content, 2);
				$content = $content[1];
			}
			return $content;
		}
	}

	function handle_result($result) {
		if(!function_exists('json_decode')) {
			require_once ROOT_PATH.'./source/plugin/renren/class/JSON.class.php';
			$json=new Services_JSON();
			$array = $json->decode($result,1);
			$json = null;
		} else {
			$array = json_decode($result,1);
		}
		
		$array = $this->check_charset($array);
		
		return $array;
	}
	
	function check_charset($code){
		global $_G;
		if(strtolower($_G['charset']) != 'utf-8') {
			$code=dl_conv($code, "GBK", "UTF8");
		}
		return $code;
	}
/*     seperate   */
	function pushfeed($method, $params = array(),$methodType = 'get') {
		$result=$this->call_api($method,$params,$methodType);
		return $result;
	}

	function call_api($method, $params, $methodType = 'get') {
		$methodType = strtolower($methodType);
		if(!empty($params) && is_array($params)) {
			foreach($params as $k => $v) {
				$this->params[$k] = $v;
			}
		}
		$this->api_server = $this->api_server.$method;

		$post_body = $this->create_post_body();
		if($methodType == 'get'){
			$this->api_server = $this->api_server.'?'.$post_body;
		}
		if(function_exists('curl_init')&&function_exists('curl_setopt')&&function_exists('curl_exec')) {
			$request = curl_init();
			curl_setopt($request, CURLOPT_URL, $this->api_server);
			if($methodType == 'post'){
				curl_setopt($request, CURLOPT_POST, 1);
				curl_setopt($request, CURLOPT_POSTFIELDS, $post_body);
			}
			curl_setopt($request, CURLOPT_RETURNTRANSFER, true);

			$result = curl_exec($request);
			curl_close($request);
		} else {
			if($methodType == 'post'){
				$context =array('http' => array('method' => 'POST',
					'header' => 'Content-type: application/x-www-form-urlencoded'."\r\n".
					'User-Agent: Facebook API PHP5 Client 1.1 '."\r\n".
					'Content-length: ' . strlen($post_body),
					'content' => $post_body));
			}else{
				$context = array();
			}
			$contextid=stream_context_create($context);
			$sock=fopen($this->api_server, 'r', false, $contextid);
			if($sock) {
				$result='';
				while (!feof($sock))
				  $result.=fgets($sock, 4096);
					fclose($sock);
			}
		}
		return $result;
	}
	
	function convertEncoding($str,$from,$to){
		if(is_array($str)){
			foreach($str as $k => $v){
				$k = convertEncoding($k,$to,$from);
				$v = convertEncoding($v,$to,$from);
				$str[$k] = $v;
			}
		}else{
			return  mb_convert_encoding($str,$to,$from);
		}
		return $str;
	}
	
	function create_post_body() {
		$post_params = array();
		foreach ($this->params as $key => &$val) {
			if(is_array($val)) 
				$val = implode(',', $val);
			$post_params[] = $key.'='.urlencode($val);
		}

		return implode('&', $post_params);
	}
}
?>
