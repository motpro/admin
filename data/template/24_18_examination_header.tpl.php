<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('header');?><?php include template('common/header'); ?><div class="container-fluid mot-block-a">
<div class="row-fluid">
<div class="span2">
<a href="examination.php" title="36lean.com考试中心">
<img class="img-polaroid" src="static/mot/mark.jpg" />
</a>

</div>

<div class="span10">
<blockquote>
<h1><a href="examination.php"><i class="icon-trophy"></i> 在线考试</a>
            </h1>
    	</blockquote>
    </div>
    
</div>
</div>

<div class="container-fluid margin-top">
<div class="row-fluid">

<div class="span3">
<table class="table table-bordered">
<tr><td><?php include template('examination/left_side'); ?></td></tr>
</table>
</div>


<div class="span9">

<?php if(intval( $_G['adminid']) === 1) { ?>
<ul class="nav nav-pills">
<li <?php if('home' === $ac) { ?>class="active"<?php } ?>><a href="examination.php?mod=admin">首页</a></li>
<li class="dropdown <?php if('library' == $ac) { ?>active<?php } ?>">
    	<a class="dropdown-toggle" data-toggle="dropdown" href="examination.php?mod=admin&amp;ac=library">试题 <b class="caret"></b></a>
<ul class="dropdown-menu">
<li><a href="examination.php?mod=admin&amp;ac=library&amp;op=bucket">添加试卷</a></li>
<li><a href="examination.php?mod=admin&amp;ac=library&amp;op=create">添加试题</a></li>
</ul>
</li>

    <li <?php if('notification' == $ac) { ?>class="active"<?php } ?>><a href="examination.php?mod=admin&amp;ac=notification">通知</a></li>
    
    <li <?php if('document' == $ac) { ?>class="active"<?php } ?>><a href="examination.php?mod=admin&amp;ac=document">学籍</a></li>
</ul>
<?php } ?>
