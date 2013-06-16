<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('portalcp_login');
0
|| checktplrefresh('./template/tpl/portal/portalcp_login.htm', './template/tpl/portal/portalcp_nav.htm', 1370685236, '18', './data/template/24_18_portal_portalcp_login.tpl.php', './template/tpl', 'portal/portalcp_login')
;?><?php include template('common/header'); ?><h1>portalcp_login</h1>
<style type="text/css">
.parentcat {}
.cat { margin-left: 20px; }
.lastchildcat, .childcat { margin-left: 40px; }
</style>

<div class="content row-fluid">

<div>

<?php if($op == 'push') { ?>
<h4>
<em>生成文章</em>
<?php if($_G['inajax']) { ?><span><a href="javascript:;" onclick="hideWindow('<?php echo $_GET['handlekey'];?>');" class="flbc" title="关闭">关闭</a></span><?php } ?>
</h4>

<div>
<p>选择一个频道分类：</p>
<table class="mtw dt">
<?php echo $categorytree;?>
</table>
</div>
</div>
<?php } else { ?>
<div id="pt">
<div class="z">
<a href="./" class="nvhm" title="首页"><?php echo $_G['setting']['bbname'];?></a> <em>&rsaquo;</em>
<?php if($_G['setting']['portalstatus'] ) { ?><a href="portal.php"><?php echo $_G['setting']['navs']['1']['navname'];?></a> <em>&rsaquo;</em><?php } ?>
<a href="portal.php?mod=portalcp"><?php if($_G['setting']['portalstatus'] ) { ?>门户管理<?php } else { ?>模块管理<?php } ?></a> <em>&rsaquo;</em>
登录
</div>
</div>

<div id="ct">

<div class="span2"><h1>portalcp_nav</h1>
<h3><?php if($_G['setting']['portalstatus'] ) { ?>门户管理<?php } else { ?>模块管理<?php } ?></h3>
<ul class="nav nav-pills nav-stacked">
<?php if($_G['setting']['portalstatus'] ) { if($admincp2 || $_G['group']['allowmanagearticle']) { ?><li<?php if($ac == 'index') { ?> class="active"<?php } ?>><a href="portal.php?mod=portalcp&amp;ac=index">频道栏目</a></li><?php } if($admincp2 || $admincp3 || $_G['group']['allowmanagearticle'] || $_G['group']['allowpostarticle']) { ?><li<?php if($ac == 'category') { ?> class="active"<?php } ?>><a href="portal.php?mod=portalcp&amp;ac=category">文章管理</a></li><?php } } if($admincp4 || $admincp6 || $_G['group']['allowdiy']) { ?>
<li<?php if($ac == 'portalblock' || $ac=='block') { ?> class="active"<?php } ?>><a href="portal.php?mod=portalcp&amp;ac=portalblock">模块管理</a></li>
<?php } if(!$_G['inajax'] && !empty($_G['setting']['plugins']['portalcp'])) { if(is_array($_G['setting']['plugins']['portalcp'])) foreach($_G['setting']['plugins']['portalcp'] as $id => $module) { if(!$module['adminid'] || ($module['adminid'] && $_G['adminid'] > 0 && $module['adminid'] >= $_G['adminid'])) { ?><li<?php if($_GET['id'] == $id) { ?> class="active"<?php } ?>><a href="portal.php?mod=portalcp&amp;ac=plugin&amp;id=<?php echo $id;?>"><?php echo $module['name'];?></a></li><?php } } } ?>

<li<?php if($_GET['mod'] == 'lesson') { ?> class="active"<?php } ?>><a href="portal.php?mod=lesson">课程</a></li>

<li<?php if($_GET['mod'] == 'home') { ?> class="active"<?php } ?>><a href="portal.php?mod=home">主页</a></li>

<?php if(!empty($modsession->islogin)) { ?>
<li><a href="portal.php?mod=portalcp&amp;ac=logout">退出</a></li>
<?php } ?>
</ul></div>

<div class="span10">
<table class="table">
<tr><td>
<h3>登录管理面板</h3>
<div>首次进入管理面板或空闲时间过长, 您输入密码才能进入。如果密码输入错误超过 5 次，管理面板将会锁定 15 分钟。</div>
<form method="post" autocomplete="off" action="portal.php?mod=portalcp" class="form-inline">
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>">
<input type="hidden" name="submit" value="yes">
<input type="hidden" name="login_panel" value="yes">
<table cellspacing="0" cellpadding="5">
<tr>
<th width="60">用户名:</th><td><?php echo $_G['member']['username'];?></td>
</tr>
<tr>
<th>密码:</th><td><input id="cppwd" type="password" name="cppwd" class="px" /></td>
</tr>
<tr>
<th></th><td>
<button type="submit" class="btn" name="submit" id="submit" value="true">
<strong>提交</strong>
</button></td>
</tr>
</table>
</form>
</td></tr></table>
</div>
<script type="text/javascript">
$("cppwd").focus();
</script>
</div>

</div>
<?php } ?>

</div><?php include template('common/footer'); ?>