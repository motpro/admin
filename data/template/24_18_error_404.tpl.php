<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('404');?><?php include template('common/header'); ?><div class="">
<div class="page-header">
<h1><i class="icon-spinner icon-spin"></i> 404 页面未找到
<small> 非常抱歉 </small>
</h1>
</div>

<?php if(!$_G['uid']) { ?>
<div class="alert alert-info">
<i class="icon-thumbs-up"></i> 您现在是游客状态 您可以 <button type="button" class="close" data-dismiss="alert">&times;</button>
<ul class="inline">
<li><a href="member.php?mod=logging&amp;action=login"><i class="icon-exchange"></i> 登陆本站</a></li>
<li><a href="member.php?mod=<?php echo $_G['setting']['regname'];?>"><i class="icon-group"></i> 快速注册成为会员</a></li>
</ul>
</div>
<?php } ?>

<h3><i class="icon-flag"></i> 站内地图 <small>参考网站地图</small></h3>

<div class="container-fluid">
<div class="row-fluid">
<div class="mot-block-b span3">
Cols
</div>
<div class="mot-block-b span3">
Cols
</div>
<div class="mot-block-b span3">
Cols
</div>
<div class="mot-block-b span3">
Cols
</div>


</div>
</div>

</div>
