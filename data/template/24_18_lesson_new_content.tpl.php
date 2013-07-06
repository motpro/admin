<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('new_content');?><?php include template('lesson/header'); ?></div>


<script src="<?php echo $_G['siteurl'];?>static/mot/jquery.pin.min.js" type="text/javascript"></script>
<script>
jQuery( function() {
jQuery.ajax({
url : 'lesson.php',
type : 'GET',
data : { click_collection : 1 , id: "<?php echo $content['id'];?>", type:'p'},
dataType:'html',
});
});
</script>

<div class="container">
<h5 class="text-left">
<a href="lesson.php"><i class="icon-home"></i> Lean学院</a> <span class="divider">/</span> 
<a href="lesson.php?pages_list=<?php echo $course_info['id'];?>"><i class="icon-book"></i> <?php echo $course_info['fullname'];?></a> <span class="divider">/</span> 
<a href="lesson.php?page_content=<?php echo $content['id'];?>"><i class="icon-file"></i> <?php echo $content['title'];?></a>
</p>
</div>

<div id="play_area" class="mot-block-blackboard" align="center">

<!--Body content-->
<?php if($course_info['is_hidden']) { ?>
<div class="alert alert-info">
课程维护中，即将推出
</div>
<?php } else { if($vip['uid'] === $_G['uid']) { ?>
<script>
jQuery( function () {
jQuery(".pinned").pin( {
containerSelector: '#play_area',
});
});
</script>

    	<link href="<?php echo $_G['siteurl'];?>static/videojs/video-js.css" rel="stylesheet" type="text/css">
    	<script src="<?php echo $_G['siteurl'];?>static/videojs/video.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(function(){
videojs.options.flash.swf = "<?php echo $_G['siteurl'];?>/static/videojs/video-js.swf";
var Player = videojs("_video_player");
var Lang = Array();
Lang[0] = '简体中文';
Lang[1] = '繁体中文';
Lang[2] = '英文';
var isMobile = {
    				Android: function() {  
        				return navigator.userAgent.match(/Android/i) ? true : false;  
   					},  
    				BlackBerry: function() {  
        				return navigator.userAgent.match(/BlackBerry/i) ? true : false;  
    				},  
    				iOS: function() {  
        				return navigator.userAgent.match(/iPhone|iPad|iPod/i) ? true : false;  
    				},  
    				Windows: function() {  
        				return navigator.userAgent.match(/IEMobile/i) ? true : false;  
    				},  
    				any: function() {  
       					return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Windows());  
    				}  
};  
    			if( isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS())
    				var ismobile = true;
jQuery.ajax({
type: 'POST',
url : 'lesson.php?dataajax=1',
data: 'pageid=<?php echo $content['id'];?>',
success: function( result){
result = eval('('+result+')')

if( ismobile)
Player.src( { type: "video/mp4", src: result['video_mb']});
else
Player.src( { type: "video/mp4", src: result['video_pc']});
}
});
    		});
</script>



   	<video id="_video_player" class="video-js vjs-default-skin" controls preload="none" width="800" height="450" poster="<?php echo $_G['siteurl'];?>uploads/page/<?php echo $video['image_file'];?>" data-setup="{}">
    	<track kind="captions" src="<?php echo $video['caption_1'];?>" srclang="en" label="<?php echo $labellang[$video['label_a']];?>" />
    	<track kind="captions" src="<?php echo $video['caption_2'];?>" srclang="en" label="<?php echo $labellang[$video['label_b']];?>" />
 	</video>
</div>

<div align="center">
   	<?php if($prev) { ?><a href="lesson.php?page_content=<?php echo $prev['id'];?>"><span class="label">上一页 : <?php echo $prev['title'];?></span></a><?php } ?>  
<?php if($next) { ?><a href="lesson.php?page_content=<?php echo $next['id'];?>"><span class="label">下一页 : <?php echo $next['title'];?></span></a><?php } ?> 

</div>

<div class="container">
<?php echo $content['contents'];?>
</div>
<?php if(false) { ?>
<div class="margin-top">
 <div class="container">
   <ul id="myTab" class="nav nav-tabs">

   		<li class="active"><a id="q" href="#info" data-toggle="tab">课程信息</a></li>
            <li><a href="#context" data-toggle="tab">阅读</a></li>
            <li><a id="q" href="#ask" data-toggle="tab">问答</a></li>
            <li><a id="n" href="#note" data-toggle="tab">笔记</a></li>
            <script>
              jQuery( function (){
              	jQuery('div#note').hide();
              	jQuery('a#n').click( function() {
              		jQuery('div#note').show();
              	});
              	jQuery('li>a:not(#n)').click( function(){
              		jQuery('div#note').hide();
              	});
              });
            </script>
            <li><a id="d" href="#download" data-toggle="tab">下载</a></li>
   	  </ul>
   </div>
</div>

<div class="container-fluid">
<script>    
jQuery('#myTabContent').click(function (e) {
    e.preventDefault();
    jQuery(this).tab('show');
});
</script>
    <div id="myTabContent" class="tab-content">

    	    <div class="tab-pane fade in active container" id="info">
              	<dl class="dl-horizontal">
              		<dt>视频名称</dt><dd><?php echo $video['v_name'];?></dd>
              		<dt>课程语音</dt><dd><?php echo $voicelang[$video['v_voice']];?></dd>
              		<dt>中文介绍</dt><dd><?php echo $video['cn_intro'];?></dd>
              		<dt>英文介绍</dt><dd><?php echo $video['en_intro'];?></dd>
              		<dt>课程时长</dt><dd><?php echo $video['v_time'];?></dd>
              	</dl>
            </div>
            
            <div class="tab-pane fade container" id="context">
            	<?php echo $content['contents'];?>
            </div>

            <div class="tab-pane fade container" id="ask">
              <?php include template('lesson/page_ask'); ?>            </div>

            <div class="tab-pane fade container" id="note">
              <?php include template('lesson/note/page_note'); ?>            </div>

            <div class="tab-pane fade container" id="download">
              <?php include template('lesson/page_download'); ?>            </div>

    </div>
<?php } } elseif($_G['uid']) { ?>
<div class="hero-unit">
<p><i class="icon-beer"></i> 此课程收费，要使用这些课程，您可以先成为本站<a href="vip.php">收费会员</a></p>
<p><i class="icon-unlock"></i> 或者您可以先免费学习我们的<a href="lesson.php">试听课程</a></p>
</div>

<?php } else { ?>
<div class="container">
<div class="mot-block-a">
<div class="alert alert-info"><i class="icon-info-sign"></i> 游客您好，要学习本课，请先登陆或者注册为本站会员</div><?php include template('member/login_simple'); ?></div>
</div>
<?php } } ?>

</div>

<?php if(false) { ?>
<div class="content container hero-unit">
<form class="form-inline" method="post" action="" name="opinion">
        		<?php if($success) { ?>反馈成功 谢谢您的支持！<?php } ?>
              	<input type="hidden" name="referer" value="<?php echo $_G['referer'];?>">
    		  	<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
<table class="table table-striped" width="100%">
<?php if($_G['uid']) { ?>
<input name="name" value="<?php echo $profile['realname'];?>" type="hidden" />
<input name="phone" value="<?php echo $profile['mobile'];?>" type="hidden" />
<input name="email" value="<?php echo $_G['member']['email'];?>" type="hidden" />
<tr><td><textarea class="span11" name="message" rows="2" cols="20" placeholder="	告诉我们您使用的感受跟建议，我们会根据您的反馈，作出部分修改，让您更好的享受学习过程."></textarea>
</td></tr>
<tr><td><input class="btn btn-info" value="保存" type="submit" name="applysubmit" /></td></tr>
<?php } else { ?>
<tr>
<td class="span3"><input class="input-medium" name="name" type="text" placeholder="您的名字"  /></td> 
<td class="span3"><input class="input-medium" name="email" type="text" placeholder="您的邮箱" /></td>
<td class="span3"><input class="input-medium" name="phone" type="text" placeholder="手机号" /></td> 
<td><textarea name="message" rows="4" cols="12" placeholder="告诉我们您使用的感受跟建议，我们会根据您的反馈，作出部分修改，让您更好的享受学习过程.">
</textarea></td>
</tr>
<tr>
<td>
<input class="btn btn-info" value="提交" type="submit" name="applysubmit" />
</td>
<td></td>
<td></td>
<td></td>
</tr>
<?php } ?>
</table>
</form>
</div>
<?php } ?>


<div><?php include template('lesson/footer'); ?>