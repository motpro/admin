<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('guest');?><?php include template('user/header'); ?><div class="alert alert-info">
<i class="icon-lock"></i> 游客 您可以
<strong><a href="member.php?mod=logging&amp;action=login">登陆</a></strong>
或者
<strong><a href="member.php?mod=<?php echo $_G['setting']['regname'];?>">注册</a></strong>
</div><?php include template('user/footer'); ?>