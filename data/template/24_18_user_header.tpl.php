<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('header');?><?php include template('common/header'); ?></div>
<div class="container">
<div class="container-fluid mot-block-a">
<div class="row-fluid">
<div class="span2">
<div class="thumbnail text-center lead">
<a href="user.php"><?php echo avatar($_G['uid'] , 'big');?></a>
</div>
</div>

<div class="span10">
<blockquote>
<h1><a href="user.php"><i class="icon-home"></i> 用户中心</a></h1>
    			<small><a><?php echo $_G['username'];?>在线</a></small>
    		</blockquote>
</div>
</div>
</div>
</div>

<div class="container margin-top">
<div class="container-fluid">
<div class="row-fluid">

<div class="span3">
<table class="table table-bordered">
<tr><td><?php include template('user/left_side'); ?></td></tr>
</table>
</div>

<div class="span9">
