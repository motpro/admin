<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); 
0
|| checktplrefresh('./template/tpl/portal/home/basic.htm', './template/tpl/portal/home/left.htm', 1370698732, '18', './data/template/24_18_portal_home_basic.tpl.php', './template/tpl', 'portal/home/basic')
|| checktplrefresh('./template/tpl/portal/home/basic.htm', './template/tpl/portal/home/buttom.htm', 1370698732, '18', './data/template/24_18_portal_home_basic.tpl.php', './template/tpl', 'portal/home/basic')
|| checktplrefresh('./template/tpl/portal/home/basic.htm', './template/tpl/portal/portalcp_nav.htm', 1370698732, '18', './data/template/24_18_portal_home_basic.tpl.php', './template/tpl', 'portal/home/basic')
;?><?php include template('common/header'); ?><br /><br /><br /><br />
<h1>门户管理</h1>
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

<div class="span10">
<ul class="breadcrumb">
    		<li><a href="portal.php?mod=home">基本设置</a> <span class="divider">-</span></li>
    		<li><a href="portal.php?mod=home&amp;ac=bigphoto">首页大图</a> <span class="divider">-</span></li>
    		<li><a href="portal.php?mod=home&amp;ac=direct">首页展示</a> <span class="divider">-</span></li>
    		<li><a href="portal.php?mod=home&amp;ac=aboutus">关于我们</a> <span class="divider">-</span></li>
    		<li><a href="portal.php?mod=home&amp;ac=service">网站服务</a> <span class="divider">-</span></li>
    		<li><a href="portal.php?mod=home&amp;ac=footer">底部信息</a> <span class="divider">-</span></li>
    		<li><a href="portal.php?mod=home&amp;ac=thumb">图片缩略</a> <span class="divider">-</span></li>
    		<li><a href="portal.php?mod=home&amp;ac=cache">站内缓存</a> </li>
    </ul><h1>基本设置</h1>

<h1 class="pull-left"><small>导航设置</small></h1>
<table class="table">
<tr><th>导航名</th><th>URL</th><th></th></tr><?php if(is_array($director)) foreach($director as $dc) { ?><form class="form-inline" action="portal.php?mod=home" name="_form1" method="post">
<input type="hidden" name="id" value="<?php echo $dc['id'];?>" />
<tr><td>
<input name="c_key" class="input-medium" type="text" value="<?php echo $dc['c_key'];?>" /></td>
<td><input name="c_value" class="input-medium" type="text" value="<?php echo $dc['c_value'];?>" /></td>
<td><button class="btn" type="submit" name="update_director">修改</button></td>
</tr>
</form>
<?php } ?>
</table>	</div>
</div><?php include template('common/footer'); ?>