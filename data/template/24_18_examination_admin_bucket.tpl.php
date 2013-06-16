<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('admin_bucket');?><?php include template('examination/header'); ?><div class="page-header">
<h3>添加新的试卷 ( question bucket )</h3>
</div>

<?php if($status) { ?>
<h3><small>添加成功</small></h3>
<?php } elseif(0 === $status) { ?>
<h3><small>请勿重复提交数据</small></h3>
<?php } ?>
<form action="" method="post">
<div class="input-prepend">
    	<span class="add-on"> 试题名称</span>
    	<input name="title" class="span3" id="itemid" type="text" placeholder="试卷的名字" /> 
    </div> 

 	<div class="input-prepend">
    	<span class="add-on"> 试卷介绍</span>
    	<input name="info" class="span8" id="itemid" type="text" placeholder="详细信息 介绍本题库" /> 
    </div>

 	<div class="input-prepend">
    	<span class="add-on"> 所属课程</span>
    	<select name="bind_course">
    <?php if(is_array($c)) foreach($c as $course) { ?>    		<option value="<?php echo $course['id'];?>"><?php echo $course['fullname'];?></option>
    		<?php } ?>
    	</select>
    </div>   

    <input class="btn" type="submit" name="add_bucket" value="添加" />
</form><?php include template('examination/footer'); ?>