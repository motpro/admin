<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: helper_page.php 29236 2012-03-30 05:34:47Z chenmengshu $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class helper_page {


	public static function multi($num, $perpage, $curpage, $mpurl, $maxpages = 0, $page = 10, $autogoto = FALSE, $simple = FALSE, $jsfunc = FALSE) {
		global $_G;
		$ajaxtarget = !empty($_GET['ajaxtarget']) ? " ajaxtarget=\"".dhtmlspecialchars($_GET['ajaxtarget'])."\" " : '';

		$a_name = '';
		if(strpos($mpurl, '#') !== FALSE) {
			$a_strs = explode('#', $mpurl);
			$mpurl = $a_strs[0];
			$a_name = '#'.$a_strs[1];
		}
		if($jsfunc !== FALSE) {
			$mpurl = 'javascript:'.$mpurl;
			$a_name = $jsfunc;
			$pagevar = '';
		} else {
			$pagevar = 'page=';
		}

		if(defined('IN_ADMINCP')) {
			$shownum = $showkbd = TRUE;
			$showpagejump = FALSE;
			$lang['prev'] = '&lsaquo;&lsaquo;';
			$lang['next'] = '&rsaquo;&rsaquo;';
		} else {
			$shownum = $showkbd = FALSE;
			$showpagejump = TRUE;
			if(defined('IN_MOBILE') && !defined('TPL_DEFAULT')) {
				$lang['prev'] = lang('core', 'prevpage');
				$lang['next'] = lang('core', 'nextpage');
			} else {
				$lang['prev'] = '&nbsp;&nbsp;';
				$lang['next'] = lang('core', 'nextpage');
			}
			$lang['pageunit'] = lang('core', 'pageunit');
			$lang['total'] = lang('core', 'total');
			$lang['pagejumptip'] = lang('core', 'pagejumptip');
		}
		if(defined('IN_MOBILE') && !defined('TPL_DEFAULT')) {
			$dot = '..';
			$page = intval($page) < 10 && intval($page) > 0 ? $page : 4 ;
		} else {
			$dot = '...';
		}
		$multipage = '';
		if($jsfunc === FALSE) {
			$mpurl .= strpos($mpurl, '?') !== FALSE ? '&amp;' : '?';
		}

		$realpages = 1;
		$_G['page_next'] = 0;
		$page -= strlen($curpage) - 1;
		if($page <= 0) {
			$page = 1;
		}
		if($num > $perpage) {

			$offset = floor($page * 0.5);

			$realpages = @ceil($num / $perpage);
			$curpage = $curpage > $realpages ? $realpages : $curpage;
			$pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;

			if($page > $pages) {
				$from = 1;
				$to = $pages;
			} else {
				$from = $curpage - $offset;
				$to = $from + $page - 1;
				if($from < 1) {
					$to = $curpage + 1 - $from;
					$from = 1;
					if($to - $from < $page) {
						$to = $page;
					}
				} elseif($to > $pages) {
					$from = $pages - $page + 1;
					$to = $pages;
				}
			}
			$_G['page_next'] = $to;
			$multipage = ($curpage - $offset > 1 && $pages > $page ? '<li><a href="'.$mpurl.$pagevar.'1'.$a_name.'" class="first"'.$ajaxtarget.'>1 '.$dot.'</a></li>' : '').
			($curpage > 1 && !$simple ? '<li><a href="'.$mpurl.$pagevar.($curpage - 1).$a_name.'" class="prev"'.$ajaxtarget.'>上一页</a><li>' : '');

			for($i = $from; $i <= $to; $i++) {
				$multipage .= ($i == $curpage) ? '<li><a href="#">'.$i.'</a></li>' :
				'<li><a href="'.$mpurl.$pagevar.$i.($ajaxtarget && $i == $pages && $autogoto ? '#' : $a_name).'"'.$ajaxtarget.'>'.$i.'</a></li>';
			}

			$multipage .= ($to < $pages ? '<li><a href="'.$mpurl.$pagevar.$pages.$a_name.'" class="last"'.$ajaxtarget.'>'.$dot.' '.$realpages.'</a></li>' : '').
			($curpage < $pages && !$simple ? '<li><a href="'.$mpurl.$pagevar.($curpage + 1).$a_name.'" class="nxt"'.$ajaxtarget.'>'.$lang['next'].'</a></li>' : '').
			($showkbd && !$simple && $pages > $page && !$ajaxtarget ? '<kbd><input type="text" name="custompage" size="3" onkeydown="if(event.keyCode==13) {window.location=\''.$mpurl.$pagevar.'\'+this.value; doane(event);}" /></kbd>' : '');

			$multipage = $multipage ? '<div class="pagination" align="center"><ul>'.($shownum && !$simple ? '<em>&nbsp;'.$num.'&nbsp;</em>' : '').$multipage.'</ul></div>' : '';
		}
		$maxpage = $realpages;
		return $multipage;
	}

	public static function simplepage($num, $perpage, $curpage, $mpurl) {
		$return = '';
		$lang['next'] = lang('core', 'nextpage');
		$lang['prev'] = lang('core', 'prevpage');
		$next = $num == $perpage ? '<a href="'.$mpurl.'&amp;page='.($curpage + 1).'" class="nxt">'.$lang['next'].'</a>' : '';
		$prev = $curpage > 1 ? '<span class="pgb"><a href="'.$mpurl.'&amp;page='.($curpage - 1).'">'.$lang['prev'].'</a></span>' : '';
		if($next || $prev) {
			$return = '<div class="pg">'.$prev.$next.'</div>';
		}
		return $return;
	}
}

?>