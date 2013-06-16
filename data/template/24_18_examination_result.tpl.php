<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('result');?><?php include template('examination/header'); ?><div class="page-header">
<h3><?php echo $result['title'];?> 考试结果 ：</h3>
</div>
<h5>详细信息</h5>
<table class="table table-hover">
<tr>
<td>考试日期</td>
<td><?php echo date('Y/m/d h:i' , $result['generate_date'])?></td> 
</tr>

<tr>
<td>最终成绩</td>
<td><?php echo $result['user_goal'];?></td>
</tr>

</table><?php include template('examination/footer'); ?>