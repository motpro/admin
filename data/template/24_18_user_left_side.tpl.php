<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
	<ul class="nav nav-pills nav-stacked">
<li class="nav-header">学习</li>

<li <?php if($ac === 'sub_newsfeed') { ?>class="active"<?php } ?>>
<a href="user.php?ac=sub_newsfeed">
<i class="icon-coffee"></i>
<i class="pull-right icon-chevron-right"></i>推送消息
</a>
</li>

<li <?php if($ac === 'sub_register') { ?>class="active"<?php } ?>>
<a href="user.php?ac=sub_register">
<i class="icon-flag"></i>
<i class="pull-right icon-chevron-right"></i>课堂签到
</a>
</li>

<li <?php if($ac === 'sub_plan') { ?>class="active"<?php } ?>>
<a href="user.php?ac=sub_plan">
<i class="icon-calendar"></i>
<i class="pull-right icon-chevron-right"></i>学习计划
</a>
</li>

<li class="nav-header">笔记</li>

<li <?php if($ac === 'sub_note') { ?>class="active"<?php } ?>>
<a href="user.php?ac=sub_note">
<i class="icon-file-alt"></i>
<i class="pull-right icon-chevron-right"></i>课堂笔记
</a>
</li>

<li <?php if($ac === 'sub_repository') { ?>class="active"<?php } ?>>
<a href="user.php?ac=sub_repository">
<i class="icon-book"></i>
<i class="pull-right icon-chevron-right"></i>知识仓库
</a>
</li>

<li class="nav-header">问答</li>

<li <?php if($ac === 'qa') { ?>class="active"<?php } ?>>
<a href="knowledge.php">
<i class="icon-inbox"></i>
<i class="pull-right icon-chevron-right"></i>问答中心
</a>
</li>

<li <?php if($ac === 'question') { ?>class="active"<?php } ?>>
<a href="knowledge.php?mod=user&amp;ac=question">
<i class="icon-question-sign"></i>
<i class="pull-right icon-chevron-right"></i>我的提问
</a>
</li>

<li <?php if($ac === 'answer') { ?>class="active"<?php } ?>>
<a href="knowledge.php?mod=user&amp;ac=answer">
<i class="icon-ok-circle"></i>
<i class="pull-right icon-chevron-right"></i>我的回答
</a>
</li>

<li class="nav-header">工具</li>

<?php if(false) { ?>
<li>
<a href="user.php?ac=sub_vsm">
<i class="icon-coffee"></i>
<i class="pull-right icon-chevron-right"></i>VSM工具
</a>
</li>
<?php } ?>

<li <?php if($ac === 'sub_schedule') { ?>class="active"<?php } ?>>
<a href="user.php?ac=sub_schedule">
<i class="icon-time"></i>
<i class="pull-right icon-chevron-right"></i>日程表
</a>
</li>

<?php if(false) { ?>
<li>
<a href="user.php?ac=sub_pad">
<i class="icon-coffee"></i>
<i class="pull-right icon-chevron-right"></i>便笺
</a>
</li>
<?php } ?>

<li class="nav-header">账户</li>

<li <?php if($ac === 'sub_vip') { ?>class="active"<?php } ?>>
<a href="user.php?ac=sub_vip">
<i class="icon-credit-card"></i>
<i class="pull-right icon-chevron-right"></i>VIP信息
</a>
</li>

<li <?php if($ac === 'sub_other') { ?>class="active"<?php } ?>>
<a href="user.php?ac=sub_other">
<i class="icon-circle-blank"></i>
<i class="pull-right icon-chevron-right"></i>其它
</a>
</li>

<li>
<a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>">
<i class="icon-off"></i>
<i class="pull-right icon-chevron-right"></i>退出

</a>
</li>
</ul>
