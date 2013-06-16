<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('admin');
0
|| checktplrefresh('./template/tpl/portal/lesson/admin.htm', './template/tpl/portal/portalcp_nav.htm', 1370685246, '18', './data/template/24_18_portal_lesson_admin.tpl.php', './template/tpl', 'portal/lesson/admin')
;?><?php include template('common/header'); ?><style type="text/css">
.parentcat {}
.cat { margin-left: 20px; }
.lastchildcat, .childcat { margin-left: 40px; }
</style>
<script>
widthauto();
</script>
<br /><br /><br /><br />

<div id="pt">
<div class="z">
<a href="./" class="nvhm" title="首页"><?php echo $_G['setting']['bbname'];?></a> <em>&rsaquo;</em>
<?php if($_G['setting']['portalstatus'] ) { ?><a href="portal.php"><?php echo $_G['setting']['navs']['1']['navname'];?></a> <em>&rsaquo;</em><?php } ?>
<a href="portal.php?mod=portalcp"><?php if($_G['setting']['portalstatus'] ) { ?>门户管理<?php } else { ?>模块管理<?php } ?></a> <em>&rsaquo;</em>
课程

</div>
</div>

<div class="content row-fluid">
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
<div class="mn">
<div class="">
<p>课程列表
<a class="btn" style="margin-left:100px;padding-left:20px;padding-right:20px;" href="portal.php?mod=lesson&amp;ac=add_course">添加课程</a> 
<a class="btn" style="padding-left:20px;padding-right:20px;" href="portal.php?mod=lesson&amp;ac=add_category">添加分类</a> 
<a class="btn" style="padding-left:20px;padding-right:20px;" href="portal.php?mod=lesson&amp;ac=edit_category">编辑分类</a> 
<a class="btn" style="padding-left:20px;padding-right:20px;" href="portal.php?mod=lesson&amp;ac=generate">缓存缩略图</a>

</p>
<table class="table table-bordered table-condensed">
<tr><th>类别</th> <th>序号</th> <th>课程名</th> <th>单元数目</th> <th>视频数目</th> <th>类型</th> <th>状态</th> <th>操作</th></tr><?php if(is_array($list)) foreach($list as $c) { ?><tr><td><?php echo $category_list[$c['category_id']];?></td>
<td><?php echo $c['sortid'];?></td>
<td><?php echo $c['fullname'];?></td> 
<td><?php echo $c['page_num'];?></td>
<td><?php echo $c['v_num'];?><?php if($c['video_num']) { ?> 中:<?php echo $c['cn'];?> 英:<?php echo $c['en'];?><?php } ?></td>
<td><?php echo $c['is_free']?'免费':'收费';?></td> 
<td><?php echo $c['is_hidden']?'<span style="color:red;">隐藏</span>':'公开'?></td> 
<td><a class="xi2" href="portal.php?mod=lesson&amp;ac=course_info&amp;id=<?php echo $c['id'];?>">详细</a> 
<a class="xi2" href="portal.php?mod=lesson&amp;ac=course_delete&amp;id=<?php echo $c['id'];?>">删除</a></td>
</tr>
<?php } ?>
</table>

</div>
<script type="text/javascript">
$("cppwd").focus();
</script>
</div>

</div>

</div><?php include template('common/footer'); ?>