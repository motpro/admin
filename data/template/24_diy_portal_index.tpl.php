<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('index');
0
|| checktplrefresh('./template/tpl/portal/index.htm', './template/tpl/common/header.htm', 1371369323, 'diy', './data/template/24_diy_portal_index.tpl.php', './template/tpl', 'portal/index')
|| checktplrefresh('./template/tpl/portal/index.htm', './template/tpl/common/header_common.htm', 1371369323, 'diy', './data/template/24_diy_portal_index.tpl.php', './template/tpl', 'portal/index')
;?>
  <!DOCTYPE html>
<html lang="en" xmlns:wb=“http://open.weibo.com/wb”>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
<?php if($_G['config']['output']['iecompatible']) { ?><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE<?php echo $_G['config']['output']['iecompatible'];?>" /><?php } ?>
<title><?php if(!empty($navtitle)) { ?><?php echo $navtitle;?> - <?php } if(empty($nobbname)) { ?> <?php echo $_G['setting']['bbname'];?> - <?php } ?> 国内首家精益学习平台</title>
<?php echo $_G['setting']['seohead'];?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="keywords" content="流程管理 生产与制造 品质" />
<meta name="description" content="精益六西格玛 改善法" />
<meta name="production" content="六西格玛 精益创业 精益生产" />
<meta name="author" content="36lean studio" />
<meta name="copyright" content="36lean 精益云学院" />
<meta name="MSSmartTagsPreventParsing" content="True" />
<meta http-equiv="MSThemeCompatible" content="Yes" />
<base href="<?php echo $_G['siteurl'];?>" />
<link href="<?php echo $_G['siteurl'];?>static/bs/css/bootstrap-responsive.min.css" rel="stylesheet" />
   	<link href="<?php echo $_G['siteurl'];?>static/mot/professional.css" rel="stylesheet" />
   	<link href="<?php echo $_G['siteurl'];?>static/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo $_G['siteurl'];?>static/mot/hint.min.css" rel="stylesheet" />
    <link type="text/css" href="<?php echo $_G['siteurl'];?>static/bs_jq_ui/css/custom-theme/jquery-ui-1.10.2.custom.css" rel="stylesheet" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js" type="text/javascript"></script>
<script type="text/javascript">jQuery(function(){jQuery.noConflict()})</script><link rel="stylesheet" type="text/css" href="data/cache/style_<?php echo STYLEID;?>_common.css?<?php echo VERHASH;?>" /><?php if($_G['uid'] && isset($_G['cookie']['extstyle']) && strpos($_G['cookie']['extstyle'], TPLDIR) !== false) { ?><link rel="stylesheet" id="css_extstyle" type="text/css" href="<?php echo $_G['cookie']['extstyle'];?>/style.css" /><?php } elseif($_G['style']['defaultextstyle']) { ?><link rel="stylesheet" id="css_extstyle" type="text/css" href="<?php echo $_G['style']['defaultextstyle'];?>/style.css" /><?php } ?><script type="text/javascript">var STYLEID = '<?php echo STYLEID;?>', STATICURL = '<?php echo STATICURL;?>', IMGDIR = '<?php echo IMGDIR;?>', VERHASH = '<?php echo VERHASH;?>', charset = '<?php echo CHARSET;?>', discuz_uid = '<?php echo $_G['uid'];?>', cookiepre = '<?php echo $_G['config']['cookie']['cookiepre'];?>', cookiedomain = '<?php echo $_G['config']['cookie']['cookiedomain'];?>', cookiepath = '<?php echo $_G['config']['cookie']['cookiepath'];?>', showusercard = '<?php echo $_G['setting']['showusercard'];?>', attackevasive = '<?php echo $_G['config']['security']['attackevasive'];?>', disallowfloat = '<?php echo $_G['setting']['disallowfloat'];?>', creditnotice = '<?php if($_G['setting']['creditnotice']) { ?><?php echo $_G['setting']['creditnames'];?><?php } ?>', defaultstyle = '<?php echo $_G['style']['defaultextstyle'];?>', REPORTURL = '<?php echo $_G['currenturl_encode'];?>', SITEURL = '<?php echo $_G['siteurl'];?>', JSPATH = '<?php echo $_G['setting']['jspath'];?>';</script>
<script src="<?php echo $_G['setting']['jspath'];?>common.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php if(empty($_GET['diy'])) { ?><?php $_GET['diy'] = '';?><?php } if(!isset($topic)) { ?><?php $topic = array();?><?php } ?><meta name="application-name" content="<?php echo $_G['setting']['bbname'];?>" />
<meta name="msapplication-tooltip" content="<?php echo $_G['setting']['bbname'];?>" />
<?php if($_G['setting']['portalstatus']) { ?><meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['1']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['portal']) ? 'http://'.$_G['setting']['domain']['app']['portal'] : $_G['siteurl'].'portal.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/portal.ico" /><?php } ?>
<meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['2']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['forum']) ? 'http://'.$_G['setting']['domain']['app']['forum'] : $_G['siteurl'].'forum.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/bbs.ico" />
<?php if($_G['setting']['groupstatus']) { ?><meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['3']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['group']) ? 'http://'.$_G['setting']['domain']['app']['group'] : $_G['siteurl'].'group.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/group.ico" /><?php } if(helper_access::check_module('feed')) { ?><meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['4']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['home']) ? 'http://'.$_G['setting']['domain']['app']['home'] : $_G['siteurl'].'home.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/home.ico" /><?php } if($_G['basescript'] == 'forum' && $_G['setting']['archiver']) { ?>
<link rel="archives" title="<?php echo $_G['setting']['bbname'];?>" href="<?php echo $_G['siteurl'];?>archiver/" />
<?php } if(!empty($rsshead)) { ?><?php echo $rsshead;?><?php } if(widthauto()) { ?>
<link rel="stylesheet" id="css_widthauto" type="text/css" href="data/cache/style_<?php echo STYLEID;?>_widthauto.css?<?php echo VERHASH;?>" />
<script type="text/javascript">HTMLNODE.className += ' widthauto'</script>
<?php } if($_G['basescript'] == 'forum' || $_G['basescript'] == 'group') { ?>
<script src="<?php echo $_G['setting']['jspath'];?>forum.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } elseif($_G['basescript'] == 'home' || $_G['basescript'] == 'userapp') { ?>
<script src="<?php echo $_G['setting']['jspath'];?>home.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } elseif($_G['basescript'] == 'portal') { ?>
<script src="<?php echo $_G['setting']['jspath'];?>portal.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } if($_G['basescript'] != 'portal' && $_GET['diy'] == 'yes' && check_diy_perm($topic)) { ?>
<script src="<?php echo $_G['setting']['jspath'];?>portal.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } if($_GET['diy'] == 'yes' && check_diy_perm($topic)) { ?>
<link rel="stylesheet" type="text/css" id="diy_common" href="data/cache/style_<?php echo STYLEID;?>_css_diy.css?<?php echo VERHASH;?>" />
<?php } ?>

<!--[if IE 7]>
   	<link href="<?php echo $_G['siteurl'];?>static/font-awesome/css/font-awesome-ie7.min.css" rel="stylesheet" />
<![endif]-->

<!--[if lte IE 6]>
  	<link rel="stylesheet" type="text/css" href="<?php echo $_G['siteurl'];?>static/ie6bootstrap/css/bootstrap-ie6.css">
  	<![endif]-->
  	<!--[if lte IE 7]>
  	<link rel="stylesheet" type="text/css" href="<?php echo $_G['siteurl'];?>static/ie6bootstrap/css/ie.css">
  	<![endif]-->
  	<style type="text/css">
body{padding-top:20px;}.container-narrow{margin:0 auto;max-width:700px}.container-narrow>hr{margin:30px 0}.jumbotron{margin:60px 0;text-align:center}.jumbotron h1{font-size:54px;line-height:1}.jumbotron .btn{font-size:21px;padding:14px 24px}.marketing{margin:60px 0}.marketing p+h4{margin-top:28px}
    </style>
</head>


<body>

<?php if(false) { ?>
<!--
<div class="navbar-fixed-top">
<script>
jQuery( function () {


jQuery(window).scroll( function () {
if( document.body.scrollTop+document.documentElement.scrollTop > 0){
jQuery('#top_here').addClass('navbar-transparent');
}else {
jQuery('#top_here').removeClass('navbar-transparent');
}
});

jQuery('#top_here').hover( 
function(){
jQuery('#top_here').removeClass('navbar-transparent');
jQuery('#top_here').addClass('navbar-static');
},
function(){
if( document.body.scrollTop+document.documentElement.scrollTop > 0)
jQuery('#top_here').removeClass('navbar-transparent');
}
);


});
</script>
<div id="top_here" class="navbar navbar-static">
    <div class="container-fluid">
    <?php loadcache('director')?>        <ul class="nav">
        	<a class="brand" href="#">Lean学院</a>
        <?php if(is_array($_G['cache']['director'])) foreach($_G['cache']['director'] as $d) { ?>            <li><a href="<?php echo $d['c_value'];?>" title="<?php echo $d['c_key'];?>"><?php echo $d['c_key'];?></a></li>
            
            <?php } ?>

            <?php if($_G['uid']) { ?>
            <li><a href="user.php"><i class="icon-user"></i> 用户中心</a></li>

            <?php } ?>
            
            <li style="padding-left:10px;">
            <form class="navbar-search form-search pull-left" action="msearch.php" method="get">
    			<div class="input-append">
    			<input id="tags" type="text" class="search-query span2" name="keywords" placeholder="课程搜索">
    			<button class="btn" name="findout" value=1>Search</button>
    			</div>
    		</form>
    		<script>
            jQuery.post('request.php' , { action : 'get_top_search', params: {} } , function ( response) {
            	response = eval ( '('+response+')');
            	jQuery("#tags").autocomplete({
                	source:  response,
            	});
            });
            </script>
    		</li>
    		<li><a id="news" href="#"></a></li>
    		<?php if(!$_G['uid']) { ?>

                	<li><a href="member.php?mod=logging&amp;action=login">登陆</a></li>
                	<li><a href="member.php?mod=<?php echo $_G['setting']['regname'];?>">注册</a></li>
            <?php } ?>
        </ul>
    </div>
</div>
</div>
-->
<?php } ?>

<div class="container">
<div class="masthead">
        <ul class="nav nav-pills pull-right">
          	<li <?php if(CURSCRIPT === 'portal') { ?>class="active"<?php } ?>><a href="#"><i class="icon-home"></i> 首页</a></li>
          	<li <?php if(CURSCRIPT === 'lesson') { ?>class="active"<?php } ?>><a href="lesson.php"><i class="icon-cloud"></i> 在线课程</a></li>
          	<?php if($_G['uid']) { ?><li><a href="user.php"><i class="icon-user"></i> 用户中心</a></li><?php } ?>
          	<li <?php if(CURSCRIPT === 'knowledge') { ?>class="active"<?php } ?>><a href="knowledge.php"><i class="icon-question-sign"></i> 问答</a></li>
          	<li <?php if(CURSCRIPT === 'aboutus') { ?>class="active"<?php } ?>><a href="./aboutus"><i class="icon-group"></i> 关于我们</a></li>
          	<?php if(!$_G['uid']) { ?>
          	<li><a href="member.php?mod=logging&amp;action=login">登陆</a></li>
            <li><a href="member.php?mod=<?php echo $_G['setting']['regname'];?>">注册</a></li>
         	<?php } ?>
        </ul>
        <h3 class="muted"><img class="" src="<?php echo $_G['siteurl'];?>/static/mot/logo.png"></h3>
    </div>
</div>

<div class="container">
<div id="append_parent"></div><div id="ajaxwaitid"></div>
<?php if($_GET['diy'] == 'yes' && check_diy_perm($topic)) { include template('common/header_diy'); } if(check_diy_perm($topic)) { ?><?php
$__STATICURL = STATICURL;$diynav = <<<EOF


<img class="img-polaroid" src="{$__STATICURL}image/diy/panel-toggle.png" alt="DIY" />
<div id="diy-tg_menu" style="display: none;">
<ul>
<li><a href="javascript:saveUserdata('diy_advance_mode', '');openDiy();">简洁模式</a></li>
<li><a href="javascript:saveUserdata('diy_advance_mode', '1');openDiy();">高级模式</a></li>
</ul>
</div>

EOF;
?>
<?php } if(CURMODULE == 'topic' && $topic && empty($topic['useheader']) && check_diy_perm($topic)) { ?>
<?php echo $diynav;?>
<?php } if(empty($topic) || $topic['useheader']) { if($_G['setting']['mobile']['allowmobile'] && (!$_G['setting']['cacheindexlife'] && !$_G['setting']['cachethreadon'] || $_G['uid']) && ($_GET['diy'] != 'yes' || !$_GET['inajax']) && ($_G['mobile'] != '' && $_G['cookie']['mobile'] == '' && $_GET['mobile'] != 'no')) { ?>
<div class="xi1 bm bm_c">
    请选择 <a href="<?php echo $_G['siteurl'];?>forum.php?mobile=yes">进入手机版</a> <span class="xg1">|</span> <a href="<?php echo $_G['setting']['mobile']['nomobileurl'];?>">继续访问电脑版</a>
</div>
<?php } if(CURSCRIPT == 'forum') { ?>
<br /><br />
<h1>改善社区<small></small></h1>



<?php if(!IS_ROBOT) { if($_G['uid'] && !empty($_G['style']['extstyle'])) { ?>
<div id="sslct_menu" class="cl p_pop" style="display: none;">
<?php if(!$_G['style']['defaultextstyle']) { ?><span class="sslct_btn" onclick="extstyle('')" title="默认"><i></i></span><?php } if(is_array($_G['style']['extstyle'])) foreach($_G['style']['extstyle'] as $extstyle) { ?><span class="sslct_btn" onclick="extstyle('<?php echo $extstyle['0'];?>')" title="<?php echo $extstyle['1'];?>"><i style='background:<?php echo $extstyle['2'];?>'></i></span>
<?php } ?>
</div>
<?php } ?>

<div id="qmenu_menu" class="p_pop <?php if(!$_G['uid']) { ?>blk<?php } ?>" style="display: none;">
<?php if($_G['uid']) { ?>
<ul><?php if(is_array($_G['setting']['mynavs'])) foreach($_G['setting']['mynavs'] as $nav) { if($nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))) { ?>
<li><?php echo $nav['code'];?></li>
<?php } } ?>
</ul>
<?php } elseif($_G['connectguest']) { ?>
<div class="ptm pbw hm">
请先<br /><a class="xi2" href="member.php?mod=connect"><strong>完善帐号信息</strong></a> 或 <a href="member.php?mod=connect&amp;ac=bind" class="xi2 xw1"><strong>绑定已有帐号</strong></a><br />后使用快捷导航
</div>
<?php } else { ?>
<div class="ptm pbw hm">
请 <a href="javascript:;" class="xi2" onclick="lsSubmit()"><strong>登录</strong></a> 后使用快捷导航<br />没有帐号？<a href="member.php?mod=<?php echo $_G['setting']['regname'];?>" class="xi2 xw1"><?php echo $_G['setting']['reglinkname'];?></a>
</div>
<?php } ?>
</div>
<?php } ?><?php echo adshow("headerbanner/wp a_h");?><div id="hd">
<div class="wp">
<div class="hdc cl"><?php $mnid = getcurrentnav();?><?php if($_G['uid']) { ?>
<!--用户信息栏跟菜单栏-->
<div align="center">
<table class="table table-bordered">
<tr>
<td>
<strong class="vwmy<?php if($_G['setting']['connect']['allow'] && $_G['member']['conisbind']) { ?> qq<?php } ?>"><a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>" target="_blank" title="访问我的空间"><?php echo $_G['member']['username'];?></a></strong>

<?php if($_G['group']['allowinvisible']) { ?>
<span id="loginstatus">
<a id="loginstatusid" href="member.php?mod=switchstatus" title="切换在线状态" onclick="ajaxget(this.href, 'loginstatus');return false;"></a>
</span>
<?php } ?>

<?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra1'])) echo $_G['setting']['pluginhooks']['global_usernav_extra1'];?>
<span class="pipe">|</span><?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra4'])) echo $_G['setting']['pluginhooks']['global_usernav_extra4'];?><a href="home.php?mod=spacecp">设置</a>

<span class="pipe">|</span><a href="home.php?mod=space&amp;do=pm" id="pm_ntc">消息</a>

<span class="pipe">|</span><a href="home.php?mod=space&amp;do=notice" id="myprompt">提醒<?php if($_G['member']['newprompt']) { ?>(<?php echo $_G['member']['newprompt'];?>)<?php } ?></a><span id="myprompt_check"></span>

<?php if($_G['setting']['taskon'] && !empty($_G['cookie']['taskdoing_'.$_G['uid']])) { ?><span class="pipe">|</span><a href="home.php?mod=task&amp;item=doing" id="task_ntc">进行中的任务</a><?php } if(($_G['group']['allowmanagearticle'] || $_G['group']['allowpostarticle'] || $_G['group']['allowdiy'] || getstatus($_G['member']['allowadmincp'], 4) || getstatus($_G['member']['allowadmincp'], 6) || getstatus($_G['member']['allowadmincp'], 2) || getstatus($_G['member']['allowadmincp'], 3))) { ?>

<span class="pipe">|</span><a href="portal.php?mod=portalcp"><?php if($_G['setting']['portalstatus'] ) { ?>门户管理<?php } else { ?>模块管理<?php } ?></a>
<?php } if($_G['uid'] && $_G['group']['radminid'] > 1) { ?>
<span class="pipe">|</span><a href="forum.php?mod=modcp&amp;fid=<?php echo $_G['fid'];?>" target="_blank"><?php echo $_G['setting']['navs']['2']['navname'];?>管理</a>
<?php } if($_G['uid'] && $_G['adminid'] == 1 && $_G['setting']['cloud_status']) { ?>
<span class="pipe">|</span><a href="admin.php?frames=yes&amp;action=cloud&amp;operation=applist" target="_blank">云平台</a>
<?php } if($_G['uid'] && getstatus($_G['member']['allowadmincp'], 1)) { ?>
<span class="pipe">|</span><a href="admin.php" target="_blank">管理中心</a>
<?php } ?><?php $upgradecredit = $_G['uid'] && $_G['group']['grouptype'] == 'member' && $_G['group']['groupcreditslower'] != 999999999 ? $_G['group']['groupcreditslower'] - $_G['member']['credits'] : false;?><span class="pipe">|</span><a href="home.php?mod=spacecp&amp;ac=credit&amp;showcredit=1" id="extcreditmenu"<?php if(!$_G['setting']['bbclosed']) { ?> onmouseover="delayShow(this, showCreditmenu);" class="showmenu"<?php } ?>>积分: <?php echo $_G['member']['credits'];?></a>

<span class="pipe">|</span>用户组: <a href="home.php?mod=spacecp&amp;ac=usergroup"<?php if($upgradecredit !== 'false') { ?> id="g_upmine" onmouseover="delayShow(this, showUpgradeinfo)"<?php } ?>><?php echo $_G['group']['grouptitle'];?></a>
<?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra2'])) echo $_G['setting']['pluginhooks']['global_usernav_extra2'];?>
<span class="pipe">|</span><a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>">退出</a>
<?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra3'])) echo $_G['setting']['pluginhooks']['global_usernav_extra3'];?>
</td>
</tr>
</table>
</div>
<!--用户信息栏跟菜单栏-->


<?php } elseif(!empty($_G['cookie']['loginuser'])) { ?>
<!--未登录-->
<p>
<strong><a id="loginuser" class="noborder"><?php echo dhtmlspecialchars($_G['cookie']['loginuser']); ?></a></strong>
<span class="pipe">|</span><a href="member.php?mod=logging&amp;action=login" onclick="showWindow('login', this.href)">激活</a>
<span class="pipe">|</span><a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>">退出</a>
</p>
<?php } elseif(!$_G['connectguest']) { include template('member/login_simple'); } else { ?>
<div id="um">
<div class="avt y"><?php echo avatar(0,small);?></div>
<p>
<strong class="vwmy qq"><?php echo $_G['member']['username'];?></strong>
<?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra1'])) echo $_G['setting']['pluginhooks']['global_usernav_extra1'];?>
<span class="pipe">|</span><a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>">退出</a>
</p>
<p>
<a href="home.php?mod=spacecp&amp;ac=credit&amp;showcredit=1">积分: 0</a>
<span class="pipe">|</span>用户组: <?php echo $_G['group']['grouptitle'];?>
</p>
</div>
<!--未登录-->
<?php } ?>
</div>

<?php if(!empty($_G['setting']['plugins']['jsmenu'])) { ?>
<ul class="p_pop h_pop" id="plugin_menu" style="display: none"><?php if(is_array($_G['setting']['plugins']['jsmenu'])) foreach($_G['setting']['plugins']['jsmenu'] as $module) { ?> <?php if(!$module['adminid'] || ($module['adminid'] && $_G['adminid'] > 0 && $module['adminid'] >= $_G['adminid'])) { ?>
 <li><?php echo $module['url'];?></li>
 <?php } } ?>
</ul>
<?php } ?>

<?php echo $_G['setting']['menunavs'];?>
<div id="mu" class="cl">
<?php if($_G['setting']['subnavs']) { if(is_array($_G['setting']['subnavs'])) foreach($_G['setting']['subnavs'] as $navid => $subnav) { if($_G['setting']['navsubhover'] || $mnid == $navid) { ?>
<ul class="cl <?php if($mnid == $navid) { ?>current<?php } ?>" id="snav_<?php echo $navid;?>" style="display:<?php if($mnid != $navid) { ?>none<?php } ?>">
<?php echo $subnav;?>
</ul>
<?php } } } ?>
</div><?php echo adshow("subnavbanner/a_mu");?></div>
</div>
<?php } ?>
<?php if(!empty($_G['setting']['pluginhooks']['global_header'])) echo $_G['setting']['pluginhooks']['global_header'];?>
<?php } ?>

</div>



<div id="wp" class="container">  <div class="container-narrow">

      <div class="jumbotron">
        
        <h1>全球首家中文精益在线学院</h1>
        <img src="<?php echo $_G['siteurl'];?>/static/mot/ads.jpg" class="img-circle" width="280px">
        <p class="lead"><i class="icon-flag"></i>  Lean学院是一个全新的在线精益学习平台，我们采用了全新的在线教育模式，使用视频+问答社区这样一个全新的在线学习模式，脱离传统的文档类为主学习资源，使用直观、深入浅出的视频为主要教学资源，让原本晦涩难懂的精益技术以一个全新的方式展现在您的面前。</p>
        <?php if($_G['uid']) { ?>
        <a class="btn btn-success btn-large" href="user.php?ac=sub_plan"><i class="icon-hand-right"></i> 继续学习 </a>
        <?php } else { ?>
        <a class="btn btn-success btn-large" href="member.php?mod=<?php echo $_G['setting']['regname'];?>"><i class="icon-hand-up"></i> 现在就注册 !</a>
        <?php } ?>
      </div>

      <hr>
      <table>
        <tr>
          <td class="page-header span5">
            <h3><i class="icon-tasks"></i> 经营的课程 <small><a href="lesson.php">更多</a></small></h3>
          </td>
          <td class="span2"></td>
          <td class="page-header span5">
            <h3><i class="icon-thumbs-up"></i> 学院的特色</h3>
          </td>
        </tr>

        <tr>
          <td>
              <ul class="masthead-links">
              <?php if(is_array($allcourse)) foreach($allcourse as $key=>$course) { ?>              <li><small><a href="lesson.php?pages_list=<?php echo $course['id'];?>" title="<?php echo $course['fullname'];?>"><?php echo $course['fullname'];?></a></small></li>
              <?php if($key%2 == 0 && $key > 0) { ?><li><br /></li><?php } ?>
              <?php } ?>
              </ul>
          </td>
          <td></td>
          <td>
            <p>知识的掌握和提炼重在反复复习。 视频教学已经可以给您一个对知识的直观的展示，但是要记忆、掌握并融汇贯通，还需要不断的服务和测试。每一个视频课程我们都配以数个针对本课重点知识的测评考试，只有达到80%的准确率才能够完成本课程的学习。
            </p>
          </td>
        </tr>
        

        <tr>
          <td class="page-header">
            <h3><i class="icon-mobile-phone"></i> 跨平台学习</h3>
          </td>
          <td></td>
          <td class="page-header">
            <h3><i class="icon-heart"></i> 加入我们</h3>
          </td>
        </tr>

        <tr>
          <td>
            <p>
            我们的下一步工作是打造移动学习的平台，移动在线学院课程同样为高清课程，
            同时课程还将可以在电脑，手机，平板电脑等移动设备上观看。同时可以用投影仪放大在培训室进行观看。
            </p>
          </td>
          <td></td>
          <td>
            <p>只要进行免费的简单的<a href="member.php?mod=<?php echo $_G['setting']['regname'];?>">注册</a>，就可以加入到我们的学院，海量的课程和资料以及特有的工具，帮助你更好的工作。</p>
          </td>
        </tr>

        <tr>
          <td class="page-header"><h3><i class="icon-hand-right"></i> 我们的目标</h3></td>
          <td></td>
          <td class="page-header"><h3><i class="icon-lightbulb"></i> 专业的讲师</h3></td>
        </tr>

        <tr>
          <td>
          <ul class="unstyle">
            <li>以互联网的模式改变传统的行业</li>
            <li>让用户以更快、更简单、更方便、更廉价的形式学习更多的知识</li>
            <li>精益求精的技术，深入浅出的讲解</li>
            <li>更切合实际、不拘泥于书本</li>
          </ul>
          </td>
          <td></td>
          <td>
            <p>授人以鱼，不如授人以渔。 我们的课程均为拥有权威技术及大量实际生产环境经验的权威讲师并且并不是单纯的讲授技术，而是传播学习方法、实际经验。让您更的学习更接近实际操作。</p>
          </td>
        </tr>
      </table>
    </div><?php include template('common/footer'); ?>