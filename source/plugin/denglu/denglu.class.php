<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_denglu {

	/**
	 * only for personal media infos
	 *
	 */
	function global_header(){
		global $_G;
		loadcache('plugin');
		//$medias = unserialize(htmlspecialchars_decode(getcookie($_G['uid'].'medias')));
		if($_G['uid'] && !$medias){
			require_once './source/plugin/denglu/lib/denglu.func.php';
			$denglu_data = denglu_data();
			$medias = get_bind_users($_G['uid']);
			foreach ($medias as $key =>$media){
				if($denglu_data[$media['mediaID']]['shareFlag'] || $media['tag']==0){
					continue;
				}
				//$last[$key]['screenName'] = $media['screenName'];
				$last[$key]['thread_syn'] = $media['thread_syn'];
				$last[$key]['log_syn'] = $media['log_syn'];
				$last[$key]['mediaID'] = $media['mediaID'];
				$last[$key]['mediauID'] = $media['mediaUserID'];
			}
			if($medias){
				dsetcookie($_G['uid'].'medias', htmlspecialchars(serialize($last),ENT_QUOTES),$_G['gp_cookietime']);
			}
		}
	}
}
class plugin_denglu_member extends plugin_denglu {

	function post_middle_output(){
		include template('denglu:post');
		return $return;
	}
	
}

class plugin_denglu_forum extends plugin_denglu {

	function post_middle_output(){
		global $_G;
		if($_G['cache']['plugin']['denglu']['dl_thread']){
			$image = '';
			$medias = unserialize(htmlspecialchars_decode(getcookie($_G['uid'].'medias')));
			if($medias){
				foreach ($medias as $media){
					if($media['thread_syn']){
						 $image .= "<img onclick='dl_syc(this.id);' src='./source/plugin/denglu/template/images/denglu_second_icon_{$media['mediaID']}.png' id='media_{$media['mediaID']}' style='margin-right:5px;cursor:pointer;'/>";
					}else{
						 $image .= "<img onclick='dl_syc(this.id);' src='./source/plugin/denglu/template/images/denglu_second_icon_no_{$media['mediaID']}.png' id='media_{$media['mediaID']}'  style='margin-right:5px;cursor:pointer;'/>";
					}
				}
				include template('denglu:dl_forumpost_middle');
			}
		}
		return $return;
	}
	
	function post_to_denglu_aftersubmit() {
		$msgforwardSet = (array)@unserialize($GLOBALS['_G']['setting']['msgforward']);
		$msgforwardSet['refreshtime'] = 3;  //只能是大于0的整数
		$msgforwardSet['quick'] = 0;
		$GLOBALS['_G']['setting']['msgforward'] = serialize($msgforwardSet);
	}
	
	function post_to_denglu_aftersubmit_output() {
		global $_G;
		if($_G['cache']['plugin']['denglu']['dl_thread']) {
			require_once './source/plugin/denglu/lib/api.class.php';
			require_once './source/plugin/denglu/lib/denglu.func.php';
			$feed = & denglu_api::instance();
			if( $_G['gp_action'] == 'newthread' && (submitcheck('topicsubmit', 0, $GLOBALS['seccodecheck'], $GLOBALS['secqaacheck']) )) {
				//假如是发主题贴
				$validMedias = array();
				$tempMedias = getcookie($_G['uid'].'temp_medias');
				if(!$tempMedias){
					$medias = unserialize(htmlspecialchars_decode(getcookie($_G['uid'].'medias')));
				}else{
					$medias = unserialize(htmlspecialchars_decode($tempMedias));
				}
				if($medias){
					foreach ($medias as $media){
						if($media['thread_syn']){
							$validMedias[] = $media['mediauID'];
						}
					}
				}
				$tid = isset($GLOBALS['tid']) ? (int)$GLOBALS['tid'] : 0;
				$pid = isset($GLOBALS['pid']) ? (int)$GLOBALS['pid'] : 0;
				if( $tid >= 1 && $pid >= 1 && $validMedias) {
					$subject = (string)$GLOBALS['subject'];
					if(in_array('forum_viewthread', $_G['setting']['rewritestatus'])) {
						$r = array(
							'{tid}' => $tid,
							'{page}' => 1,
							'{prevpage}' => 1,);
						$subjectlink = $_G['siteurl'].str_replace(array_keys($r), $r, $_G['setting']['rewriterule']['forum_viewthread']);
					} else {
						$subjectlink = $_G['siteurl'].'forum.php?mod=viewthread&tid='.$tid;
					}
					if(strtolower($_G['charset']) != 'utf-8') {
						$subject = $feed->convertEncoding($subject,"GBK","UTF-8");
						$subjectlink = $feed->convertEncoding($subjectlink,"GBK","UTF-8");
					}
					if(!$_G['cache']['plugin']['denglu']['dl_source']){
						$subjectlink = '';
					}
					$feed->pushfeed('apiShareInfo.jsp',array('uid'=>$_G['uid'],'url'=>$subjectlink,'content'=>$subject,'muid'=>$validMedias));
				}
				return null;
			} else {
				//上述都不是，则什么都没有发生
				return null;
			}
		}
	}
}


/**
 * 日志
 *
 */
class plugin_denglu_home extends plugin_denglu {

	/**
	 * 日志发表同步按钮
	 */
	function spacecp_middle_output(){
		global $_G;
		if($_G['cache']['plugin']['denglu']['dl_log']){
			require_once './source/plugin/denglu/lib/denglu.func.php';
			$image = '';
			$medias = unserialize(htmlspecialchars_decode(getcookie($_G['uid'].'medias')));
			if($medias){
				foreach ($medias as $media){
					if($media['log_syn']){
						 $image .= "<img onclick='dl_syc(this.id);' src='./source/plugin/denglu/template/images/denglu_second_icon_{$media['mediaID']}.png' id='media_{$media['mediaID']}'  style='margin-right:5px;cursor:pointer;'/>";
					}else{
						 $image .= "<img onclick='dl_syc(this.id);' src='./source/plugin/denglu/template/images/denglu_second_icon_no_{$media['mediaID']}.png' id='media_{$media['mediaID']}'  style='margin-right:5px;cursor:pointer;'/>";
					}
				}
				include template('denglu:dl_spacecp_newblog');
			}
		}
		return $return;
	}
	
	function spacecp_blog_sync_to_denglu_aftersubmit(){
		$msgforwardSet = (array)@unserialize($GLOBALS['_G']['setting']['msgforward']);
		$msgforwardSet['refreshtime'] = 3;  //只能是大于0的整数
		$msgforwardSet['quick'] = 0;
		$GLOBALS['_G']['setting']['msgforward'] = serialize($msgforwardSet);
	}
	

	function spacecp_blog_sync_to_denglu_aftersubmit_output(){
		global $_G;
		if($_G['cache']['plugin']['denglu']['dl_log']) {
			require_once './source/plugin/denglu/lib/api.class.php';
			require_once './source/plugin/denglu/lib/denglu.func.php';
			$feed = & denglu_api::instance();
			if(submitcheck('blogsubmit', 0, $GLOBALS['seccodecheck'], $$GLOBALS['secqaacheck'])){
				//假如是发日志
				//先获取临时媒体cookie,如果没有再获取全局的媒体cookie
				$tempMedias = getcookie($_G['uid'].'temp_medias');
				if(!$tempMedias){
					$medias = unserialize(htmlspecialchars_decode(getcookie($_G['uid'].'medias')));
				}else{
					$medias = unserialize(htmlspecialchars_decode($tempMedias));
				}
				if($medias){
					foreach ($medias as $media){
						if($media['thread_syn']){
							$validMedias[] = $media['mediauID'];
						}
					}
				}
				
				$blogid = isset($GLOBALS['newblog']['blogid']) ? (int)$GLOBALS['newblog']['blogid'] : 0;
				if( $blogid >= 0  && $validMedias) {
					$subject = (string)$GLOBALS['newblog']['subject'];
					$subjectlink = $_G['siteurl']. "home.php?mod=space&uid={$_G['uid']}&do=blog&id={$blogid}";
					if(strtolower($_G['charset']) != 'utf-8') {
						$subject = $feed->convertEncoding($subject,"GBK","UTF-8");
						$subjectlink = $feed->convertEncoding($subjectlink,"GBK","UTF-8");
					}
					if(!$_G['cache']['plugin']['denglu']['dl_source']){
						$subjectlink = '';
					}
					$feed->pushfeed('apiShareInfo.jsp',array('uid'=>$_G['uid'],'url'=>$subjectlink,'content'=>$subject,'muid'=>$validMedias));
				}
				return null;
			} else {
				//上述都不是，则什么都没有发生
				return null;
			}
		}
	}
}
?>
