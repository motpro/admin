<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('edit_category');
0
|| checktplrefresh('./template/tpl/portal/lesson/edit_category.htm', './template/tpl/portal/portalcp_nav.htm', 1370685253, '18', './data/template/24_18_portal_lesson_edit_category.tpl.php', './template/tpl', 'portal/lesson/edit_category')
;?><?php include template('common/header'); ?><style type="text/css">
.parentcat {}
.cat { margin-left: 20px; }
.lastchildcat, .childcat { margin-left: 40px; }
</style>
<br /><br /><br /><br />

<div id="pt" class="bm cl">
<div class="z">
<a href="./" class="nvhm" title="首页"><?php echo $_G['setting']['bbname'];?></a> <em>&rsaquo;</em>
<?php if($_G['setting']['portalstatus'] ) { ?><a href="portal.php"><?php echo $_G['setting']['navs']['1']['navname'];?></a> <em>&rsaquo;</em><?php } ?>
<a href="portal.php?mod=portalcp"><?php if($_G['setting']['portalstatus'] ) { ?>门户管理<?php } else { ?>模块管理<?php } ?></a> <em>&rsaquo;</em> <a href="portal.php?mod=lesson&amp;ac=lesson">课程</a> <em>&rsaquo;</em> 
 编辑分类
</div>
</div>


<div id="ct" class="content row-fluid">

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

<div id="ct" class="span10">
<div class="">
<div class="">
<form name="__add_new__category" action="" method="post">
<table class="table table-bordered">
<tr><th><?php if($ok) { ?><span class="xi2">修改成功</span><?php } ?></th> <th><a class="xi2" href="portal.php?mod=lesson&amp;ac=add_category">添加分类</a> </th></tr><?php if(is_array($category)) foreach($category as $c) { ?><form name="save" action="" method="post">
<input type="hidden" name="id" value="<?php echo $c['id'];?>" />
<tr><td><input type="text" name="category" value="<?php echo $c['category'];?>" /></td> <td> <input type="submit" name="s" value="保存修改" /></td></tr>
</form>
<?php } ?>
</table>
</form>

</div>
<script type="text/javascript">
$("cppwd").focus();
</script>
</div>
</div><?php include template('common/footer'); ?>