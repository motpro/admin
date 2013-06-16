<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('do');?><?php include template('examination/paper_header'); ?><style>
.colorful {
background:#eeeeee;
}
</style>

<script>
jQuery( function() {

jQuery('input:radio').click( function() {
var id = jQuery(this).attr('name');
jQuery('div #'+id).addClass('text-info');
});

});
</script>
<div class="alert alert-info"><i class="icon-info-sign"></i> 提醒:考试只能进行一次，成绩以第一次为准，重复考试请先申请. <button type="button" class="close" data-dismiss="alert">&times;</button></div>

<?php if($bucket_info['id']) { ?>
<form action="" method="post">
<input name="target_exam" type="hidden" value="<?php echo $id;?>" /><?php if(is_array($question)) foreach($question as $q) { ?><table class="table table-bordered">
<tr><td>
<div class="page-header">
<h3>
<div><?php echo $q['sid'];?>. <?php echo $q['title'];?>
<?php if('s' === $q['type']) { ?><small> <i class="icon-hand-right"></i> <abbr title="提示 : <?php echo $q['tips'];?>">单选题</attr> </small>
<?php } elseif('m' === $q['type']) { ?><small> <i class="icon-hand-right"></i> <abbr title="提示 : <?php echo $q['tips'];?>">多选题</attr> </small>
<?php } elseif('d' === $q['type']) { ?> <small> <i class="icon-hand-right"></i> <abbr title="提示 : <?php echo $q['tips'];?>">描述题</attr> </small>
<?php } ?>
</div> 
</h3>
</div>
<?php if('s' === $q['type']) { ?><?php $options = json_decode( $q['question'])?><label class="radio">
<h4>
<input type="radio" name="<?php echo $q['sid'];?>" value="A">A. 
<?php echo $options->A;?>
</h4>
</label>
<label class="radio">
<h4>
<input type="radio" name="<?php echo $q['sid'];?>" value="B">B. 
<?php echo $options->B;?>
</h4>
</label>
<label class="radio">
<h4>
<input type="radio" name="<?php echo $q['sid'];?>" value="C">C.
<?php echo $options->C;?>
</h4>
</label>
<label class="radio">
<h4>
<input type="radio" name="<?php echo $q['sid'];?>" value="D">D.
<?php echo $options->D;?>
</h4>
</label>
<?php } elseif('m' === $q['type']) { ?><?php $options = json_decode( $q['question'])?><label class="checkbox">
<h4>
<input type="checkbox" name="<?php echo $q['sid'];?>_A" value="A" rel="<?php echo $q['sid'];?>">A. 
<?php echo $options->A;?>
</h4>
</label>
<label class="checkbox">
<h4>
<input type="checkbox" name="<?php echo $q['sid'];?>_B" value="B" rel="<?php echo $q['sid'];?>">B. 
<?php echo $options->B;?>
</h4>
</label>
<label class="checkbox">
<h4>
<input type="checkbox" name="<?php echo $q['sid'];?>_C" value="C" rel="<?php echo $q['sid'];?>">C.
<?php echo $options->C;?>
</h4>
</label>
<label class="checkbox">
<h4>
<input type="checkbox" name="<?php echo $q['sid'];?>_D" value="D" rel="<?php echo $q['sid'];?>">D.
<?php echo $options->D;?>
</h4>
</label>

<?php } elseif('d' === $q['type']) { ?>
    	<blockquote>
    	<p><?php echo $q['question'];?></p>
    	</blockquote>

    	<textarea class="span10" name="<?php echo $q['sid'];?>"></textarea>
<?php } ?>
</td></tr>
</table>
<?php } ?>

<button name="post_paper" class="btn btn-success btn-block" type="submit"><h4><i class="icon-reply"></i> 交卷</h4></button>
</form>


<?php } else { ?>

<p class="lead text-center"><i class="icon-info-sign"></i> 没有找到相关的试卷</p>

<?php } include template('examination/footer'); ?>