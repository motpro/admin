<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('admin');?><?php include template('examination/header'); ?><table class="table table-bordered table-condensed">
<tr>
<th>状态</th> <th>发布</th> <th>试题名字</th> <th>介绍</th> <th>所属课程</th> <th>操作</th> 
</tr><?php if(is_array($list)) foreach($list as $q) { ?><tr>

<td><?php if($q['status']) { ?><i class="icon-ok"></i><?php } else { ?><i class="icon-remove"></i><?php } ?></td>
<td>
<?php if($q['status']) { ?>
<a href="examination.php?mod=admin&amp;ac=pop&amp;bucket_id=<?php echo $q['id'];?>" title="已经发布的试题"><i class="icon-remove-circle"></i> 隐藏试题</a>
<?php } else { ?>
<strong><a href="examination.php?mod=admin&amp;ac=push&amp;bucket_id=<?php echo $q['id'];?>" title="本试题未发布"><i class="icon-ok-circle"></i> 发布试题</a></strong>
<?php } ?>
</td>
<td><i class="icon-file-alt"></i> <a href="examination.php?mod=do&amp;id=<?php echo $q['id'];?>"><?php echo $q['title'];?></a></td>
<td><i class="icon-info-sign"></i> <?php echo $q['info'];?></td>
<td>
<i class="icon-facetime-video"></i> <a href="lesson.php?pages_list=<?php echo $q['bind_course'];?>"><strong><?php echo $q['fullname'];?></strong></a>
</td>
<td>
<a href="examination.php?mod=admin&amp;ac=home&amp;op=edit&amp;eid=<?php echo $q['id'];?>"><i class="icon-edit"></i></a> 
<a href="examination.php?mod=admin&amp;ac=home&amp;op=group&amp;eid=<?php echo $q['id'];?>"><i class="icon-group"></i></a> 
<a href="examination.php?mod=admin&amp;ac=home&amp;op=remove&amp;eid=<?php echo $q['id'];?>"><i class="icon-remove"></i></a>  
</td>

</tr>
<?php } ?>
</table><?php include template('examination/footer'); ?>