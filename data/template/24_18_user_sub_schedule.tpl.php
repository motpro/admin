<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('sub_schedule');?><?php include template('user/header'); ?><ul class="breadcrumb">
<li><a href="user.php">用户中心</a> <span class="divider">/</span></li>
    <li>工具 <span class="divider">/</span></li>
    <li><a href="user.php?ac=sub_schedule">日程表</a></li>
</ul>

<div class="container">
<h4>
我的日程计划
<small> <cite title="Source Title">把杂乱的时间变成有序的时间，学会排序是时间管理的最高水平</cite></small>
</h4>
<hr />


<h2><small>今日计划</small>
<hr />
</h2>
<?php if(count($today) == 0) { ?><span class="badge badge-info">无</span> 这个时间段没有任何计划<?php } if(is_array($today)) foreach($today as $t) { ?><dl class="dl-horizontal">
<dt><span class="label label-success">进行中</span></dt>
<dd><i class="icon-spinner icon-spin"></i> <span class="text-success"><?php echo $t['event'];?></span> - <small><a href="request.php?event_cancel=<?php echo $t['id'];?>">关闭</a></small></dd>
<dt>时间戳</dt>
<dd><?php echo date('Y/m/d' , $t['start'])?> - <?php echo date('Y/m/d' , $t['start']+86400)?></dd>

</dl>
<?php } ?>


<h2><small>未来的计划</small>
<hr />
</h2>

<?php if(count($future) == 0) { ?><span class="badge badge-info">无</span> 这个时间段没有任何计划<?php } if(is_array($future)) foreach($future as $f) { ?><dl class="dl-horizontal">
<dt><span class="label label-info">准备中</span></dt>
<dd><i class="icon-comment-alt icon-flip-horizontal"></i> <span class="text-info"><?php echo $f['event'];?></span> - <small><a href="request.php?event_cancel=<?php echo $f['id'];?>">关闭</a></small></dd>
<dt>时间戳</dt>
<dd><?php echo date('Y/m/d' , $f['start'])?> - <?php echo date('Y/m/d' , $f['start']+86400)?></dd>	
</dl>
<?php } ?>


<h2><small>过期的计划</small>
<hr />
</h2>
<?php if(count($outofdate) == 0) { ?><span class="badge badge-info">无</span> 这个时间段没有任何计划<?php } if(is_array($outofdate)) foreach($outofdate as $o) { ?><dl class="dl-horizontal">
<dt><span class="label">已过期</span></dt>
<dd><i class="icon-remove icon-spin"></i> <span style="text-decoration:line-through"><?php echo $o['event'];?></span> - <small><a href="request.php?event_cancel=<?php echo $o['id'];?>">关闭</a></small></dd>
<dt>时间戳</dt>
<dd><?php echo date('Y/m/d' , $o['start'])?> - <?php echo date('Y/m/d' , $o['start']+86400)?></dd>

</dl>
<?php } ?>


</div><?php include template('user/footer'); ?>