<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('portalcp_category');
0
|| checktplrefresh('./template/tpl/portal/portalcp_category.htm', './template/tpl/portal/portalcp_nav.htm', 1370699161, '18', './data/template/24_18_portal_portalcp_category.tpl.php', './template/tpl', 'portal/portalcp_category')
;?><?php include template('common/header'); ?><h1>portalcp_category</h1>
<div class="content">
<div id="pt">
<div class="z">
<a href="./" class="nvhm" title="首页"><?php echo $_G['setting']['bbname'];?></a> <em>&rsaquo;</em>
<a href="portal.php"><?php echo $_G['setting']['navs']['1']['navname'];?></a> <em>&rsaquo;</em>
<a href="portal.php?mod=portalcp">门户管理</a> <em>&rsaquo;</em>
<a href="portal.php?mod=portalcp&amp;ac=index">频道栏目</a> <em>&rsaquo;</em>
<a href="portal.php?mod=portalcp&amp;ac=category&amp;catid=<?php echo $cate['catid'];?>"><?php echo $cate['catname'];?></a>
</div>
</div>


<div class="row-fluid">

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
<form method="get" href="portal.php" class="form-inline">
<input type="hidden" name="mod" value="portalcp" />
<input type="hidden" name="ac" value="category" />
<input type="hidden" name="type" value="<?php echo $_GET['type'];?>" />
<input type="hidden" value="<?php echo $cate['catid'];?>" name="catid" />
<input type="hidden" value="<?php echo FORMHASH;?>" name="formhash" />
<input type="text" name="searchkey" class="input-medium" value="<?php echo $_GET['searchkey'];?>" />
<select name="perpage"><?php if(is_array($perpagearr)) foreach($perpagearr as $value) { ?><option value="<?php echo $value;?>" <?php if($value == $perpage) { ?> selected="selected"<?php } ?>>每页显示 <?php echo $value;?> 个</option>
<?php } ?>
</select>
<button type="submit" value="true" class="btn">搜索</button>
</form>

<h2>
<a href="portal.php?mod=portalcp">文章管理</a> 
<?php if($cate['catname']) { ?> - <?php echo $cate['catname'];?> <?php } ?>
</h2>

<div class="">
<ul class="nav nav-tabs">
<?php if($allowmanage || $admincp2) { ?>
<li <?php if($_GET['type']=='all') { ?>class="active"<?php } ?>><a href="portal.php?mod=portalcp&amp;ac=category&amp;catid=<?php echo $cate['catid'];?>&amp;type=all">全部</a></li>
<?php } ?>
<li <?php if($_GET['type']=='me') { ?>class="active"<?php } ?>><a href="portal.php?mod=portalcp&amp;ac=category&amp;catid=<?php echo $cate['catid'];?>&amp;type=me">我的文章</a></li>
<?php if(empty($cate['disallowpublish'])) { ?>
<li><a href="portal.php?mod=portalcp&amp;ac=article&amp;catid=<?php echo $catid;?>" target="_blank">新文章</a></li>
<?php } ?>
</ul>
<form class="form-inline" name="articlelist" id="articlelist" action="portal.php?mod=portalcp&amp;ac=article&amp;op=batch" method="post" onsubmit="return checkPushSubmit(this);">
<input type="hidden" value="true" name="batchsubmit"/>
<input type="hidden" value="<?php echo FORMHASH;?>" name="formhash"/>
<input type="hidden" value="<?php echo $cate['catid'];?>" name="catid"/>
<table class="table">
<tr>
<th width="20">&nbsp;</th>
<th>文章标题</th>
<th width="80">分类</th>
<th width="105">作者</th>
<th width="120">操作</th>
</tr><?php $line = '&minus;';?><?php $showflag = false;?><?php if(is_array($list)) foreach($list as $key => $value) { ?><tr>
<td><?php if($allowmanage || !empty($permission[$value['catid']]['allowmanage'])) { ?><?php $showflag = true;?><input type="checkbox" value="<?php echo $value['aid'];?>" name="aids[]" class="btn" />
<?php } else { ?>
<?php echo $line;?>
<?php } ?>
</td>
<td>
<a href="portal.php?mod=view&amp;aid=<?php echo $value['aid'];?>" title="<?php echo $value['title'];?>" target="_blank" <?php echo $value['highlight'];?>><?php if($value['shorttitle']) { ?><?php echo $value['shorttitle'];?><?php } else { ?><?php echo $value['title'];?><?php } ?></a>
<?php if($value['taghtml']) { ?><em><?php echo $value['taghtml'];?></em><?php } if($value['status'] == 1) { ?><b>(待审核)</b><?php } if($value['status'] == 2) { ?><b>(已忽略)</b><?php } ?>
</td>
<td><a href="portal.php?mod=portalcp&amp;ac=category&amp;catid=<?php echo $value['catid'];?>"><?php echo $category[$value['catid']]['catname'];?></a></td>
<td>
<a href="home.php?mod=space&amp;uid=<?php echo $value['uid'];?>" title="查看空间" target="_blank"><?php echo $value['username'];?></a>
<br /><span class="xs0 xg1"><?php echo $value['dateline'];?></span>
</td>
<td>
<?php if($value['allowmanage'] || ($value['allowpublish'] && $value['uid'] == $_G['uid'])) { ?>
<a href="portal.php?mod=portalcp&amp;ac=article&amp;op=edit&amp;aid=<?php echo $value['aid'];?>" target="_blank">编辑</a>
<?php } else { ?>
<?php echo $line;?>
<?php } if($value['allowmanage']) { if($value['status']>0) { ?>
<a href="portal.php?mod=portalcp&amp;ac=article&amp;op=verify&amp;aid=<?php echo $value['aid'];?>" onclick="showWindow('articleverify', this.href, 'get', 0);" id="article_verify_<?php echo $value['aid'];?>">审核</a>
<?php } else { ?>
<a href="portal.php?mod=portalcp&amp;ac=article&amp;op=delete&amp;aid=<?php echo $value['aid'];?>" onclick="showWindow('articledelete', this.href, 'get', 0);" id="article_delete_<?php echo $value['aid'];?>">删除</a>
<?php } } if($_G['group']['allowdiy'] || $admincp4 || $admincp5 || $admincp6) { ?>
<a href="portal.php?mod=portalcp&amp;ac=portalblock&amp;op=recommend&amp;idtype=aid&amp;id=<?php echo $value['aid'];?>" onclick="showWindow('recommend', this.href, 'get', 0)">模块推送</a>
<?php } ?>
</td>
</tr>
<?php } if($showflag) { ?>
<tr>
<td colspan="5">
<label class="checkbox" for="chkall" onclick="checkall(this.form, 'aids')"><input type="checkbox" name="chkall" id="chkall" class="pc" />全选</label>

<label class="radio" for="op_trash"><input type="radio" id="op_trash" class="pr" value="trash" name="optype">放入回收站</label>
<label class="radio" for="op_delete">
<input type="radio" id="op_delete" value="delete" name="optype">直接删除
</label>

<label class="radio" for="op_move">
<input type="radio" id="op_move" class="pr" value="move" name="optype">移到栏目
</label>

<div class="input-prepend">
<?php echo $categoryselect;?>
<button type="submit" value="true" class="btn">提交</button>
</div>
</td>
</tr>
<?php } ?>
</table>
</form>
<?php if($multi) { ?><div><?php echo $multi;?></div><?php } ?>

</div>
</div>

</div>
</div>
<!--row-fluid ends-->
</div>
<script type="text/javascript">
function checkPushSubmit(form){
var arr = [];
var checkbox = form.getElementsByTagName('input');
for(var i = 0; i<checkbox.length; i++){
if (checkbox[i].name == 'aids[]' && checkbox[i].checked) arr.push(checkbox[i].value);
}
if (arr.length == 0) {
alert('请选择要操作的文章');
return false;
}
if(!$('op_trash').checked && !$('op_delete').checked && !$('op_move').checked) {
alert('请选择要进行的操作');
return false;
}
return true;
}
</script><?php include template('common/footer'); ?>