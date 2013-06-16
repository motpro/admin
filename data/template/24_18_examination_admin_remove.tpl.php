<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('admin_remove');?><?php include template('examination/header'); ?><h1><small>要删除 <<?php echo $bucket_info['title'];?>> 并且清空里面的题目吗</small></h1>


<div>
<div class="span3"><a href="examination.php?mod=admin&amp;ac=home&amp;op=remove&amp;eid=<?php echo $bucket_info['id'];?>&amp;submit=1" class="btn btn-block btn-success">是</a></div>
<div class="span3"><a href="examination.php?mod=admin&amp;ac=home&amp;op=remove&amp;eid=<?php echo $bucket_info['id'];?>&amp;submit=0" class="btn btn-block">否</a></div>

</div><?php include template('examination/footer'); ?>