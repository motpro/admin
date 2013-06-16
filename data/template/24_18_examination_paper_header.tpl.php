<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('paper_header');?><?php include template('common/header'); ?><div class="container-fluid mot-block-a">
<div class="row-fluid">
<div class="span2">
<a href="examination.php" title="36lean.com考试中心">
<img class="img-polaroid" src="static/mot/mark.jpg" />
</a>

</div>

<div class="span10">
<blockquote>
<h1><a href="examination.php?mod=do&amp;id=<?php echo $bucket_info['id'];?>"><i class="icon-pencil"></i> <?php echo $bucket_info['title'];?> 考试中</a>
            </h1>
            <small><?php echo $bucket_info['info'];?></small><?php if(MODULENAME === 'do') { ?><a href="examination.php?mod=do&amp;get_goal&amp;eid=<?php echo $bucket_info['id'];?>">查看本考试的成绩</a><?php } ?>
    	</blockquote>
    </div>


</div>
</div>

<div class="container-fluid margin-top">
<div class="row-fluid">
<div class="span12">
