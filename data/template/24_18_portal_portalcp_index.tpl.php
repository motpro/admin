<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('portalcp_index');
0
|| checktplrefresh('./template/tpl/portal/portalcp_index.htm', './template/tpl/portal/portalcp_nav.htm', 1370685243, '18', './data/template/24_18_portal_portalcp_index.tpl.php', './template/tpl', 'portal/portalcp_index')
;?><?php include template('common/header'); ?><style type="text/css">
.parentcat {}
.cat { margin-left: 20px; }
.lastchildcat, .childcat { margin-left: 40px; }
</style>
<div class="content">
<h1>portalcp_index</h1>
<?php if($op == 'push') { ?>
<h3>
<em>生成文章</em>
<?php if($_G['inajax']) { ?><span><a href="javascript:;" onclick="hideWindow('<?php echo $_GET['handlekey'];?>');" class="flbc" title="关闭">关闭</a></span><?php } ?>
</h3>

<div class="c" style="width:260px; height: 300px; overflow: hidden; overflow-y: scroll;">
<p>选择一个频道分类：</p>
<?php if($categorytree) { ?>
<table>
<?php echo $categorytree;?>
</table>
<?php } else { ?>
<p>您还没有可管理的频道栏目</p>
<?php } ?>
</div>

<script language="javascript">
function toggle_group(oid, obj, conf) {
obj = obj ? obj : $('a_'+oid);
if(!conf) {
var conf = {'show':'[-]','hide':'[+]'};
}
var obody = $(oid);
if(obody.style.display == 'none') {
obody.style.display = '';
obj.innerHTML = conf.show;
} else {
obody.style.display = 'none';
obj.innerHTML = conf.hide;
}
}
</script>

<?php } else { ?>
<div id="pt">
<div class="z">
<a href="./" class="nvhm" title="首页"><?php echo $_G['setting']['bbname'];?></a> <em>&rsaquo;</em>
<a href="portal.php"><?php echo $_G['setting']['navs']['1']['navname'];?></a> <em>&rsaquo;</em>
<a href="portal.php?mod=portalcp">门户管理</a> <em>&rsaquo;</em>
频道栏目
</div>
</div>




<div id="ct" class="row ">

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

<div class="span9">
<div>
<?php if($categorytree) { ?>
<table class="table">
<tr>
<th>分类名称</th>
<th width="80">文章数</th>
<th width="120">操作</th>
</tr>
<?php echo $categorytree;?>
</table>
<?php } elseif(empty($_G['cache']['portalcategory'])) { ?>
<p>您还没有创建任何频道栏目</p>
<?php } else { ?>
<p>您还没有可管理的频道栏目</p>
<?php } ?>
</div>
</div>

</div>
</div>
<?php } include template('common/footer'); ?>