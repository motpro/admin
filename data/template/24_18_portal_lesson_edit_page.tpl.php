<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('edit_page');
0
|| checktplrefresh('./template/tpl/portal/lesson/edit_page.htm', './template/tpl/portal/portalcp_nav.htm', 1370698756, '18', './data/template/24_18_portal_lesson_edit_page.tpl.php', './template/tpl', 'portal/lesson/edit_page')
;?><?php include template('common/header'); ?><script src="<?php echo $_G['siteurl'];?>static/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script type="text/javascript">
tinyMCE.init({
mode : "textareas",
theme : "simple"
});
</script>
<style type="text/css">
.parentcat {}
.cat { margin-left: 20px; }
.lastchildcat, .childcat { margin-left: 40px; }
</style>
<script>
widthauto(document);
</script>
<br /><br /><br /><br />

<div id="pt">
<div class="z">
<a href="./" class="nvhm" title="首页"><?php echo $_G['setting']['bbname'];?></a> <em>&rsaquo;</em>
<?php if($_G['setting']['portalstatus'] ) { ?><a href="portal.php"><?php echo $_G['setting']['navs']['1']['navname'];?></a> <em>&rsaquo;</em><?php } ?>
<a href="portal.php?mod=portalcp"><?php if($_G['setting']['portalstatus'] ) { ?>门户管理<?php } else { ?>模块管理<?php } ?></a> <em>&rsaquo;</em><a href="portal.php?mod=lesson">课程</a><em>&rsaquo;</em> <a href="portal.php?mod=lesson&amp;ac=course_info&amp;id=<?php echo $page['lessonid'];?>"><?php echo $course['fullname'];?></a><em>&rsaquo;</em> <?php echo $page['title'];?>
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
<div>
<div>
<h3 class="xi1">编辑页面信息 - 《<?php echo $page['title'];?>》</h3>
<br />

<form class="form-inline" name="_save_course_information" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php echo $page['id'];?>" />
<input type="hidden" name="film_id" value="<?php echo $page['film_id'];?>" />
<input type="hidden" name="image_file" value="<?php echo $page['image_file'];?>" />

<span class="xi2">视频内容 
<a style="padding-left:400px;"><input class="pn pnc" style="padding-left:20px;padding-right:20px;padding-bottom:8px;" type="submit" name="save_page" value="保存" /></a>
</span>

<table class="table table-condensed table-bordered" width="100%">
<tr><td>页面名称</td> <td><input type="text" name="title" value="<?php echo $page['title'];?>" /></td> 
<td>章节名称</td> <td><?php echo $course['fullname'];?></td>
</tr>

<tr><td>视频文件</td> <td><input type="text" name="v_file" value="<?php echo $page['v_file'];?>" /></td> 
<td>视频路径</td> <td><input type="text" name="v_path" value="<?php echo $page['v_path'];?>" /></td>
</tr>

<tr><td>字幕1语言</td> <td><select name="label_a">
<option <?php if($page['label_a'] == 0) { ?>selected="selected"<?php } ?> value=0>简体中文</option>
<option <?php if($page['label_a'] == 1) { ?>selected="selected"<?php } ?> value=1>繁体中文</option>
<option <?php if($page['label_a'] == 2) { ?>selected="selected"<?php } ?> value=2>英文</option>
   </select>
</td> 
<td>字幕1文件</td> <td><input type="text" name="label_a_file" value="<?php echo $page['label_a_file'];?>" /></td>
</tr>

<tr><td>字幕2语言</td> <td><select name="label_b">
<option <?php if($page['label_b'] == 1) { ?>selected="selected"<?php } ?> value=1>繁体中文</option>
<option <?php if($page['label_b'] == 0) { ?>selected="selected"<?php } ?> value=0>简体中文</option>
<option <?php if($page['label_b'] == 2) { ?>selected="selected"<?php } ?> value=2>英文</option>
   </select>
</td> 
<td>字幕2语言</td> <td><input type="text" name="label_b_file" value="<?php echo $page['label_b_file'];?>" /></td>
</tr>

<tr><td>视频语音</td> <td><select name="v_voice">
<option value="1" <?php if($page['v_voice']==1) { ?>selected="selected"<?php } ?>>英语</option>
<option value="0" <?php if($page['v_voice']==0) { ?>selected="selected"<?php } ?>>普通话</option>
<option value="2" <?php if($page['v_voice']==2) { ?>selected="selected"<?php } ?>>其它语言</option>
</select>
</td> 
<td>视频时间</td> <td><input type="text" name="v_time" value="<?php echo $page['v_time'];?>" /></td>
</tr>

<tr><td>中文描述</td> 
<td><textarea name="cn_intro" id="elm4" rows="5" cols="15" style="width: 80%"><?php echo $page['cn_intro'];?></textarea></td> 
<td>英文描述</td> 
<td><textarea name="en_intro" id="elm5" rows="5" cols="15" style="width: 80%"><?php echo $page['en_intro'];?></textarea></td>
</tr>

<tr>
<td>上传封面</td> <td><input type="file" name="images" /></td>
<td>预览</td> <td><a><img src="uploads/<?php echo $page['image_file'];?>" width="260px" /></a></td>
</tr>
</table>
<br />
<span class="xi2">正文内容</span>

<table class="dt mtm">
<tr><td>课程内容</td>

<td><textarea name="contents" id="elm6" rows="18" cols="40" style="width: 80%"><?php echo $page['contents'];?></textarea></td>

</tr>
<tr><td>左右页面</td> 
<td>上一页<select name="prevpageid"><option value="0">无</option><?php if(is_array($allpages)) foreach($allpages as $ap) { ?><option <?php if($page['prevpageid'] == $ap['id']) { ?>selected="selected"<?php } ?> value="<?php echo $ap['id'];?>"><?php echo $ap['title'];?></option><?php } ?></select> 
下一页<select name="nextpageid"><option value="0">无</option><?php if(is_array($allpages)) foreach($allpages as $ap) { ?><option <?php if($page['nextpageid'] == $ap['id']) { ?>selected="selected"<?php } ?> value="<?php echo $ap['id'];?>"><?php echo $ap['title'];?></option><?php } ?></select> 
</td>
</tr>
</table>

<div>
<p>Preview</p>

<?php if(strlen( $page['v_file'])) { ?>
<div style="margin: 25px;" align="center" ><p id="container"></p></div>
<script src="static/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="static/js/jwplayer.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(function(){

jQuery.noConflict();

var Type = Array();
Type[0] = '简体中文';
Type[1] = '繁体中文';
Type[2] = '英文';

var Dir = Array();
Dir[0] = 'CH/';
Dir[1] = 'TW/';
Dir[2] = 'EN/';

file = '<?php echo $p['videourl'];?><?php echo $page['v_path'];?><?php echo $page['v_file'];?>';
image = '<?php echo $p['moodlepath'];?>/uploads/<?php echo $page['image_file'];?>';
labels_files = "<?php echo $page['label_a_file'];?>,<?php echo $page['label_b_file'];?>";
labels_names = Type[<?php echo $page['label_a'];?>]+','+Type[<?php echo $page['label_b'];?>]; 
jwplayer("container").setup({
   					file: file,
   					image: image,
   					flashplayer:	"<?php echo $p['fpurl'];?>",
   					dock:			"<?php echo $p['dock'];?>",
   					stretch:		"<?php echo $p['stretch'];?>",
   					height: 		"400",
   					width:          "700",
   					controlbar:     "<?php echo $p['controlbar'];?>",
  
   					plugins: {
 						"captions-2": {
       						files : labels_files,
       						labels: labels_names
     										}
  							}
 					});
    			});		
</script>
<?php } ?>
</div>

</form>

</div>

<?php if(DEBUG) { ?>
<div>
<p>静态资源DEBUG：</p>

<table class="dt mtm" width="100%">
<tr><td>字幕1</td> <td><a href="<?php echo $page['label_a_file'];?>" target="blank"><?php echo $page['label_a_file'];?></a></td></tr>

<tr><td>字幕2</td> <td><a href="<?php echo $page['label_b_file'];?>" target="blank"><?php echo $page['label_b_file'];?></a></td></tr>

<tr><td>封面大图</td> <td><a href="<?php echo $_G['siteurl'];?>uploads/<?php echo $page['image_file'];?>" target="blank"><?php echo $_G['siteurl'];?>uploads/<?php echo $page['image_file'];?></a></td></tr>

<tr><td>封面小图</td> <td><a href="<?php echo $_G['siteurl'];?>uploads/small/<?php echo $page['image_file'];?>" target="blank"><?php echo $_G['siteurl'];?>uploads/small/<?php echo $page['image_file'];?></a></td></tr>
</table>
</div>
<?php } ?>


</div>
</div><?php include template('common/footer'); ?>