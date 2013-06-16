<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('course_info');
0
|| checktplrefresh('./template/tpl/portal/lesson/course_info.htm', './template/tpl/portal/portalcp_nav.htm', 1370698747, '18', './data/template/24_18_portal_lesson_course_info.tpl.php', './template/tpl', 'portal/lesson/course_info')
;?><?php include template('common/header'); ?><script>
widthauto();
</script>
<script src="<?php echo $_G['siteurl'];?>static/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script type="text/javascript">
tinyMCE.init({
// General options
mode : "exact",
elements : "elm3",
theme : "advanced",
skin : "o2k7",
skin_variant : "silver",
plugins : "lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

// Theme options
theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
theme_advanced_statusbar_location : "bottom",
theme_advanced_resizing : true,

// Example content CSS (should be your site CSS)
content_css : "css/content.css",

// Drop lists for link/image/media/template dialogs
template_external_list_url : "lists/template_list.js",
external_link_list_url : "lists/link_list.js",
external_image_list_url : "lists/image_list.js",
media_external_list_url : "lists/media_list.js",

// Replace values for the template plugin
template_replace_values : {
username : "Some User",
staffid : "991234"
}
});
</script>
<style type="text/css">
.parentcat {}
.cat { margin-left: 20px; }
.lastchildcat, .childcat { margin-left: 40px; }
</style>
<br /><br /><br /><br />

<div id="pt" class="">
<div class="z">
<a href="./" class="nvhm" title="首页"><?php echo $_G['setting']['bbname'];?></a> <em>&rsaquo;</em>
<?php if($_G['setting']['portalstatus'] ) { ?><a href="portal.php"><?php echo $_G['setting']['navs']['1']['navname'];?></a> <em>&rsaquo;</em><?php } ?>
<a href="portal.php?mod=portalcp"><?php if($_G['setting']['portalstatus'] ) { ?>门户管理<?php } else { ?>模块管理<?php } ?></a> <em>&rsaquo;</em><a href="portal.php?mod=lesson">课程</a> <em>&rsaquo;</em> <?php echo $course_info['fullname'];?>
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
<div class="">
<div class="">
<div class="alert alert-info">编辑课程信息 - 《<?php echo $course_info['fullname'];?>》</div>
<form class="form-inline" name="_save_course_information" action="" method="post">
<input type="hidden" name="id" value="<?php echo $course_info['id'];?>" />
<table class="table table-condensed table-bordered">

<tr><th>课程序号</th> <th><input type="text" name="sortid" value="<?php echo $course_info['sortid'];?>" /></th></tr>

<tr><td>课程分类</td> 
<td>
<select name="category_id"><?php if(is_array($category)) foreach($category as $c) { ?><option <?php if($c['id'] == $course_info['category_id']) { ?>selected="selected"<?php } ?> value="<?php echo $c['id'];?>"><?php echo $c['category'];?></option>
<?php } ?>
</select>
</td>
</tr>

<tr><th>类型</th> <th><select name="is_free"><option <?php if(0==$course_info['is_free']) { ?>selected="selected"<?php } ?> value="0">收费</option><option <?php if(1==$course_info['is_free']) { ?>selected="selected"<?php } ?> value="1">免费</option></select></th></tr>

<tr><td>状态</td> <td><select name="is_hidden"><option <?php if(0==$course_info['is_hidden']) { ?>selected="selected"<?php } ?> value="0">公开</option><option <?php if(1==$course_info['is_hidden']) { ?>selected="selected"<?php } ?> value="1">隐藏</option></select></td></tr>

<tr><th>课程全名</th> <th><input type="text" name="fullname" value="<?php echo $course_info['fullname'];?>" /></th></tr>

<tr><td>Logo文件</td> <td><input type="text" name="logo" value="<?php echo $course_info['logo'];?>" /> <a class="xi2" href="portal.php?mod=lesson&amp;ac=view_logo" target=blank>查看可用的LOGO</a> <span style="color:#336699;padding-left:180px;">位于 uploads/lesson/ 目录下</span></td></tr>

<tr><th>课程介绍</th> <th><textarea id="elm3" name="summary" rows="15" cols="80" style="width: 80%"><?php echo $course_info['summary'];?></textarea></td></th>

<tr><td></td> <td>
<input class="btn-info" style="padding-left:20px;padding-right:20px;padding-bottom:4px;" type="submit" name="save_courseinfo" value="保存" />
</td></tr>
</table>
</form>


</div>
<script type="text/javascript">
$("cppwd").focus();
</script>
</div>
</div>

<div>
<hr />
<p>管理章节</p>
<table class="table table-condensed table-bordered">
<tr><th>页面名称</th> <th>视频文件</th> <th>视频目录</th> <th>字幕1</th> <th>字幕2</th> <th>预览图片</th> <th>操作</th></tr>

<form class="form-inline" name="add_new_page" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="lessonid" value="<?php echo $course_info['id'];?>" />
<tr><td><input style="width:60px;" type="text" name="title" /></td> 
<td><input style="width:60px;" type="text" name="v_file" /></td> 
<td><input style="width:60px;" type="text" name="v_path" /></td> 
<td><input style="width:60px;" type="text" name="label_a_file" /></td> 
<td><input style="width:60px;" type="text" name="label_b_file" /></td> 
<td><input class="span2" type="file" name="image_file" /></td> 
<td><input style="width:60px;" class="btn btn-success" style="padding-left:20px;padding-right:20px;padding-bottom:4px;" type="submit" name="add_new_page" value="添加" /></th></tr>
</form><?php if(is_array($pages)) foreach($pages as $p) { ?><tr><td><a style="color:#336699;" href="portal.php?mod=lesson&amp;ac=edit_page&amp;id=<?php echo $p['id'];?>"><?php echo $p['title'];?></a></td> 
<td><?php echo $p['v_file'];?></td> 
<td><?php echo $p['v_path'];?></td> 
<td><?php echo $p['label_a_file'];?></td> 
<td><?php echo $p['label_b_file'];?></td> 
<td><a href="uploads/<?php echo $p['image_file'];?>"><img src="uploads/<?php echo $p['image_file'];?>" width="100px" height="20px;" /></a></td> 
<td><a href="lesson.php?page_content=<?php echo $p['id'];?>">预览</a> 
<a href="portal.php?mod=lesson&amp;ac=delete_page&amp;cid=<?php echo $course_info['id'];?>&amp;id=<?php echo $p['id'];?>">删除</a></td></tr>
<?php } ?>
</table>
</div>

</div><?php include template('common/footer'); ?>