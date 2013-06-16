<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('admin_create');?><?php include template('examination/header'); if(isset( $_GET['status'])) { ?>
<div class="alert alert-info">题目添加成功 <a href="examination.php?mod=admin&amp;ac=home&amp;op=edit&amp;eid=<?php echo $_GET['bucket_id'];?>"><i class="icon-edit"></i> 点击这里可以编辑</a></div>
<?php } ?>

<div class="container-fluid">
<div class="row-fluid">

<div class="span8">
<div class="page-header">
<h3><i class="icon-share"></i> 添加新的试题</h3>
</div>

<div class="tabbable"> <!-- Only required for left/right tabs -->
    		<ul class="nav nav-tabs">
    			<li class="active"><a href="#tab1" data-toggle="tab">创建单选题</a></li>
    			<li><a href="#tab2" data-toggle="tab">创建多选题</a></li>
    			<li><a href="#tab3" data-toggle="tab">创建问答题</a></li>
    		</ul>
    
    		<div class="tab-content">

    		<div class="tab-pane active" id="tab1">
                <form action="" method="post">
     			<div class="input-prepend">
    				<span class="add-on"> 序&nbsp;&nbsp;号 </span>
    				<input name="sid" class="span3" id="itemid" type="text" placeholder="题目排列的序号">
    			</div>   			
    			<div class="input-prepend">
    				<span class="add-on"> 题&nbsp;&nbsp;目 </span>
    				<input name="title" class="span10" id="title" type="text" placeholder="关于问题的描述">
    			</div>
    			<div class="input-prepend">
    				<span class="add-on">选项A</span>
    				<input name="optiona" class="span10" id="a" type="text" placeholder="A选项的答案">
    			</div>
    			<div class="input-prepend">
    				<span class="add-on">选项B</span>
    				<input name="optionb" class="span10" id="b" type="text" placeholder="B选项的答案">
    			</div>
    			<div class="input-prepend">
    				<span class="add-on">选项C</span>
    				<input name="optionc" class="span10" id="c" type="text" placeholder="C选项的答案">
    			</div>
    			<div class="input-prepend">
    				<span class="add-on">选项D</span>
    				<input name="optiond" class="span10" id="d" type="text" placeholder="D选项的答案">
    			</div>
    			
    				<span class="add-on">正确答案</span>
           			<label class="radio"><input type="radio" name="answer" value="A" />A</label>
           			<label class="radio"><input type="radio" name="answer" value="B" />B</label>
           			<label class="radio"><input type="radio" name="answer" value="C" />C</label>
           			<label class="radio"><input type="radio" name="answer" value="D" />D</label>
    			
    			<div class="input-prepend">
    				<span class="add-on">附加信息</span>
    				<input name="single_info" class="span10" id="prependedInput" type="text" placeholder="附加的额外信息">
    			</div>
                <div class="input-prepend">
                    <span class="add-on">所属试卷</span>
                    <select id="preview" name="bucket_id">
                        <?php if(is_array($bucket_list)) foreach($bucket_list as $bucket) { ?>                        <option value="<?php echo $bucket['id'];?>"><?php echo $bucket['title'];?> - <?php echo $bucket['fullname'];?></option>
                        <?php } ?>
                    </select>
                </div>


    			<input class="btn btn-success" type="submit" value="添加" />
                </form>

    		</div>

    		<div class="tab-pane" id="tab2">

                <form action="" method="post">
   				<div class="input-prepend">
    				<span class="add-on"> 序&nbsp;&nbsp;号 </span>
    				<input name="sid" class="span3" id="itemid" type="text" placeholder="题目排列的序号">
    			</div>   			
    			<div class="input-prepend">
    				<span class="add-on"> 题&nbsp;&nbsp;目 </span>
    				<input name="title" class="span10" id="title" type="text" placeholder="关于问题的描述">
    			</div>
    			<div class="input-prepend">
    				<span class="add-on">选项A</span>
    				<input name="optiona" class="span10" id="a" type="text" placeholder="A选项的答案">
    			</div>
    			<div class="input-prepend">
    				<span class="add-on">选项B</span>
    				<input name="optionb" class="span10" id="b" type="text" placeholder="B选项的答案">
    			</div>
    			<div class="input-prepend">
    				<span class="add-on">选项C</span>
    				<input name="optionc" class="span10" id="c" type="text" placeholder="C选项的答案">
    			</div>
    			<div class="input-prepend">
    				<span class="add-on">选项D</span>
    				<input name="optiond" class="span10" id="d" type="text" placeholder="D选项的答案">
    			</div>
    			
    				<span class="add-on">正确答案</span>
           			<label class="checkbox"><input type="checkbox" name="a" value="A" />A</label>
           			<label class="checkbox"><input type="checkbox" name="b" value="B" />B</label>
           			<label class="checkbox"><input type="checkbox" name="c" value="C" />C</label>
           			<label class="checkbox"><input type="checkbox" name="d" value="D" />D</label>
    			
    			<div class="input-prepend">
    				<span class="add-on">附加信息</span>
    				<input name="info" class="span10" id="prependedInput" type="text" placeholder="附加的额外信息">
    			</div>
                <div class="input-prepend">
                    <span class="add-on">所属试卷</span>
                    <select id="preview" name="bucket_id">
                        <?php if(is_array($bucket_list)) foreach($bucket_list as $bucket) { ?>                        <option value="<?php echo $bucket['id'];?>"><?php echo $bucket['title'];?> - <?php echo $bucket['fullname'];?></option>
                        <?php } ?>
                    </select>
                </div>
    			<input name="multi_info" class="btn btn-success" type="submit" value="添加" />
                </form>
    		</div>

    		<div class="tab-pane" id="tab3">
                <form action="" method="post">
   				<div class="input-prepend">
    				<span class="add-on"> 序&nbsp;&nbsp;号 </span>
    				<input name="sid" class="span3" id="itemid" type="text" placeholder="题目排列的序号">
    			</div>   	
                <div class="input-prepend">
                    <span class="add-on"> 标&nbsp;&nbsp;题 </span>
                    <input name="question" class="span10" id="itemid" type="text" placeholder="问题的标题">
                </div>              <div class="input-prepend">
                    <span class="add-on"> 问&nbsp;&nbsp;题 </span>
                    <input name="question" class="span10" id="itemid" type="text" placeholder="问题的内容">
                </div>
    			<div class="input-prepend">
    				<span class="add-on">附加信息</span>
    				<input name="info" class="span10" id="prependedInput" type="text" placeholder="附加的额外信息">
    			</div>
                <div class="input-prepend">
                    <span class="add-on">所属试卷</span>
                    <select id="preview" name="bucket_id">
                        <?php if(is_array($bucket_list)) foreach($bucket_list as $bucket) { ?>                        <option value="<?php echo $bucket['id'];?>"><?php echo $bucket['title'];?> - <?php echo $bucket['fullname'];?></option>
                        <?php } ?>
                    </select>
                </div>
    			<input name="descript_info" class="btn btn-success" type="button" value="添加" />
                </form>
    		</div>
    	</div>
    	</div>

</div>

<div class="span4">
    <script>
    jQuery( function () {

        jQuery('#preview').click( function() {
            jQuery('#header_info').html('<h3>试题目录预览</h3>');
            jQuery('ul#list').html('');


            var bucket = jQuery(this).val();

            jQuery.post('examination.php?mod=admin' , { action : 'read_bucket_info' , params : { bucket_id : bucket }} , function( response) {

                if( response)
                    jQuery('#header_info').html('');

                response = eval('('+response+')');

                jQuery('#header_info').append('<h3><i class="icon-reorder"></i> '+response['info']['title']+'试题</h3>');

                for( x = 0 ; x < response['question'].length ; ++x)
                    jQuery('ul#list').append('<li><a href="">'+response['question'][x]['id']+'. '+response['question'][x]['title']+'</a></li>');
            });
            


        });

    });
    </script>

<div id="header_info" class="page-header">
<h3>试题目录预览</h3>
</div>

<ul id="list">

</ul>

</div>

</div>
</div><?php include template('examination/footer'); ?>