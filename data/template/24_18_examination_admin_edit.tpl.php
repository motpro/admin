<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('admin_edit');?><?php include template('examination/header'); ?><blockquote>
<h4 class="page-header"><?php echo $bucket_info['title'];?> 正在编辑</h4>
    <small>对应课程 <a href="lesson.php?pages_list=<?php echo $bucket_info['bind_course'];?>"><?php echo $bucket_info['fullname'];?></a></small>
</blockquote>

<div class="page-header">
<h4><i class="icon-edit"></i> 相关信息 <small><a href="examination.php?mod=do&amp;id=<?php echo $bucket_info['id'];?>">预览</a></small></h4>
</div>
<form class="form-inline" action="" method="post">
<input type="hidden" name="id" value="<?php echo $bucket_info['id'];?>">
<table class="table table-bordered table-condensed">
<tr>
<td width="25%"><h5>试题名称 <i class="icon-caret-right"></i> </h5></td>
<td width="75%"><input name="title" class="span10" type="text" value="<?php echo $bucket_info['title'];?>" /></td>
</tr>

<tr>
<td><h5>试卷介绍 <i class="icon-caret-right"></i> </h5></td>
<td><input name="info" class="span10" type="text" value="<?php echo $bucket_info['info'];?>" /></td>
</tr>
<tr>
<td> <h5>所属课程 <i class="icon-caret-right"></i> <small>( 当前 <?php echo $bucket_info['fullname'];?>  )</small></h5></td>
<td>
<select name="bind_course"><?php if(is_array($c)) foreach($c as $course) { ?><option value="<?php echo $course['id'];?>"><?php echo $course['fullname'];?></option>
<?php } ?>
</select>
</td>
</tr>
<tr>
<td> <h5>操作  <i class="icon-caret-right"></i> <small><a href="#">更新本试题缓存</a></small></h5></td>
<td>
<button name="save_bucket_info" class="btn btn-success" type="submit"><i class='icon-save'></i> 保存</button>
</td>
</tr>

</table>
</form>

<div class="page-header">
<h4><i class="icon-edit"></i> 题目信息</h4>
</div><?php if(is_array($question_list)) foreach($question_list as $q) { ?><dl>
<dt><?php echo $q['sid'];?> . <?php echo $q['title'];?>  <i class="icon-edit"></i> &nbsp;&nbsp;&nbsp;&nbsp;
<small><a href="examination.php?mod=admin&amp;ac=home&amp;op=rm_question&amp;eid=<?php echo $bucket_info['id'];?>&amp;qid=<?php echo $q['id'];?>"><i class="icon-remove"></i> 删除</a></small>
</dt>
    
    <dd>
        <form action="" method="post">
        <input name="update_type" type="hidden" value="<?php echo $q['type'];?>">
        <input name="id" type="hidden" value="<?php echo $q['id'];?>">
    	<table class="table table-bordered"><tr><td>
    	<?php if('s' === $q['type']) { ?>
        <?php $option = json_decode( $q['question'])?>    	<p class="page-header"><strong><i class="icon-lightbulb"></i> 单选题</strong></p>
    	<div class="input-prepend span12">
    		<span class="add-on"> 序&nbsp;&nbsp;号 </span>
    		<input name="sid" class="span3" id="itemid" type="text" placeholder="题目排列的序号" value="<?php echo $q['sid'];?>">
    	</div>
    	<div class="input-prepend span12">
    		<span class="add-on"> 标&nbsp;&nbsp;题 </span>
    		<input name="title" class="span8" id="itemid" type="text" placeholder="问题的标题" value="<?php echo $q['title'];?>">
    	</div>
    	<div class="input-prepend span12">
    		<span class="add-on"> 选项A </span>
    		<input name="a" class="span8" id="itemid" type="text" placeholder="A选项的答案" value="<?php echo $option->A;?>">
    	</div>    	
        <div class="input-prepend span12">
    		<span class="add-on"> 选项B </span>
    		<input name="b" class="span8" id="itemid" type="text" placeholder="B选项的答案" value="<?php echo $option->B;?>">
    	</div>    	
        <div class="input-prepend span12">
    		<span class="add-on"> 选项C </span>
    		<input name="c" class="span8" id="itemid" type="text" placeholder="C选项的答案" value="<?php echo $option->C;?>">
    	</div>    	
        <div class="input-prepend span12">
    		<span class="add-on"> 选项D </span>
    		<input name="d" class="span8" id="itemid" type="text" placeholder="D选项的答案" value="<?php echo $option->D;?>">
    	</div>
        <div class="input-prepend span12">
            <span class="add-on"> 正确选项 </span>
            <select name="answer">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
            <span class="add-on">当前 : <?php echo $q['answer'];?></span>
        </div>
        <div class="input-prepend span12">
            <span class="add-on"> 提示信息</span>
            <input name="tips" class="span8" id="itemid" type="text" placeholder="D选项的答案" value="<?php echo $q['tips'];?>">
        </div>

    	<button class="btn btn-small btn-success" type="submit"><i class=" icon-save"></i> 保存修改</button>
        </form>
    	<?php } elseif('m' === $q['type']) { ?>
        <form action="" method="post">
        <input name="update_type" type="hidden" value="<?php echo $q['type'];?>">
        <input name="id" type="hidden" value="<?php echo $q['id'];?>">
        <?php $option = json_decode( $q['question'])?>    	<p class="page-header"><strong><i class="icon-beer"></i> 多选题</strong></p>
    	<div class="input-prepend span12">
    		<span class="add-on"> 序&nbsp;&nbsp;号 </span>
    		<input name="sid" class="span3" id="itemid" type="text" placeholder="题目排列的序号" value="<?php echo $q['sid'];?>">
    	</div>
    	<div class="input-prepend span12">
    		<span class="add-on"> 标&nbsp;&nbsp;题 </span>
    		<input name="title" class="span8" id="itemid" type="text" placeholder="问题的标题" value="<?php echo $q['title'];?>">
    	</div>
    	<div class="input-prepend span12">
    		<span class="add-on"> 选项A </span>
    		<input name="a" class="span8" id="itemid" type="text" placeholder="A选项的答案" value="<?php echo $option->A;?>">
    	</div>    	
        <div class="input-prepend span12">
    		<span class="add-on"> 选项B </span>
    		<input name="b" class="span8" id="itemid" type="text" placeholder="B选项的答案" value="<?php echo $option->B;?>">
    	</div>    	
        <div class="input-prepend span12">
    		<span class="add-on"> 选项C </span>
    		<input name="c" class="span8" id="itemid" type="text" placeholder="C选项的答案" value="<?php echo $option->C;?>">
    	</div>    	
        <div class="input-prepend span12">
    		<span class="add-on"> 选项D </span>
    		<input name="d" class="span8" id="itemid" type="text" placeholder="D选项的答案" value="<?php echo $option->D;?>">
    	</div>
        </div>      
        <div class="input-prepend span12">
            <span class="add-on"> 提示信息</span>
            <input name="d" class="span8" id="itemid" type="text" placeholder="D选项的答案" value="<?php echo $q['tips'];?>">
        </div>
        <span class="add-on">正确答案</span> <small><span class="add-on">当前 : <?php echo $q['answer'];?></span></small>
        <label class="checkbox"><input type="checkbox" name="A" value="A" />A</label>
        <label class="checkbox"><input type="checkbox" name="B" value="B" />B</label>
        <label class="checkbox"><input type="checkbox" name="C" value="C" />C</label>
        <label class="checkbox"><input type="checkbox" name="D" value="D" />D</label>


    	<button class="btn btn-small btn-success" type="submit"><i class=" icon-save"></i> 保存修改</button>
        </form>
    	<?php } elseif('d' === $q['type']) { ?>
        <form action="" method="post">
        <input name="update_type" type="hidden" value="<?php echo $q['type'];?>">
        <input name="id" type="hidden" value="<?php echo $q['id'];?>">
    	<p class="page-header"><strong><i class="icon-coffee"></i> 描述题</strong></p>
    	<div class="input-prepend span12">
    		<span class="add-on"> 序&nbsp;&nbsp;号 </span>
    		<input name="sid" class="span3" id="itemid" type="text" placeholder="题目排列的序号" value="<?php echo $q['sid'];?>">
    	</div>
    	<div class="input-prepend span12">
    		<span class="add-on"> 标&nbsp;&nbsp;题 </span>
    		<input name="title" class="span8" id="itemid" type="text" placeholder="问题的标题" value="<?php echo $q['title'];?>">
    	</div>

    	<h5>问题描述</h5>
    	<textarea class="span12" name="question"><?php echo $q['question'];?></textarea>
        <div class="input-prepend span12">
            <span class="add-on"> 提示信息</span>
            <input name="tips" class="span8" id="itemid" type="text" placeholder="D选项的答案" value="<?php echo $q['tips'];?>">
        </div>

    	<button class="btn btn-small btn-success" type="submit"><i class=" icon-save"></i> 保存修改</button>
        </form>
    	<?php } ?>
    	</td></tr></table>
    </dd>
</dl>
<?php } include template('examination/footer'); ?>