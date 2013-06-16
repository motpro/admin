<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('admin_group');?><?php include template('examination/view_header'); ?><div class="page-header">
<h4>参加 <a href="examination.php?mod=do&amp;id=<?php echo $bucket_info['id'];?>"><?php echo $bucket_info['title'];?></a> 测试的用户</h4>
<small><?php echo $bucket_info['info'];?></small>
</div>

<table class="table table-hover table-condensed table-bordered">
<tr><th>排行</th><th>用户</th><th>分数</th><th>考试日期</th><th>了解</th></tr><?php if(is_array($list)) foreach($list as $key => $user) { ?><tr><td><?php echo $key+1?></td>
<td><?php echo $user['username'];?></td>
<td><?php echo $user['user_goal'];?></td>
<td><?php echo date('Y / m / d h : i' , $user['generate_date'])?></td>
<td><a href="examination.php?mod=admin&amp;ac=home&amp;op=detail&amp;id=<?php echo $user['id'];?>">详细</a></td>
</tr>
<?php } ?>
</table><?php include template('examination/footer'); ?>