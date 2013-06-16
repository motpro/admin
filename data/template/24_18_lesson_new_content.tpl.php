<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('new_content');?><?php include template('lesson/header'); ?></div>


<div class="">
<script>
jQuery( function() {
jQuery.ajax({
url : 'lesson.php',
type : 'GET',
data : { click_collection:1 , id: "<?php echo $content['id'];?>", type:'p'},
dataType:'html',
});
});
</script>

<div class="container">
<h4>
<p class="text-left">
<a href="lesson.php"><i class="icon-home"></i> Lean学院</a> <span class="divider">/</span> 
<a href="lesson.php?pages_list=<?php echo $course_info['id'];?>"><i class="icon-book"></i> <?php echo $course_info['fullname'];?></a> <span class="divider">/</span> 
<a href="lesson.php?page_content=<?php echo $content['id'];?>"><i class="icon-file"></i> <?php echo $content['title'];?></a>
</p>
</h4>
</div>

<div class="mot-block-black">

<!--Body content-->
<?php if($course_info['is_hidden']) { ?>

<div class="alert alert-info">
课程维护中，即将推出
</div>

<?php } else { if($vip['uid'] === $_G['uid']) { ?>
  			<div id='loading' align='center'>
  				<img src='static/image/loading.gif' />
  			</div>

    		<div align="center" >
    			<div id="container"></div>
    			<div id="our_logo" class="<?php if('tablet'===$deviceType) { ?>float-item-pad<?php } else { ?>float-item<?php } ?>"><?php echo $_G['username'];?> 36lean.Com</div>
    		</div>
    	<script src="<?php echo $_G['setting']['jspath'];?>jwplayer.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(function(){
var Type = Array();
Type[0] = '简体中文';
Type[1] = '繁体中文';
Type[2] = '英文';
var Dir = Array();
Dir[0] = 'CH/';
Dir[1] = 'TW/';
Dir[2] = 'EN/';
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
success: function(rt){
jQuery('#loading').remove();
if( 404 == rt){
}else{
rt = eval('('+rt+')');
if( ismobile)
file = '<?php echo $p['mobileurl'];?>'+rt.v_path+rt.v_file;
else
file = '<?php echo $p['videourl'];?>'+rt.v_path+rt.v_file;

image = '<?php echo $p['moodlepath'];?>/uploads/'+ rt.image_file;
labels_files = rt.label_a_file+','+rt.label_b_file;
labels_names = Type[rt.label_a]+','+Type[rt.label_b]; 
jwplayer("container").setup({

   							file: file,
   							image: image,
   							flashplayer:	"<?php echo $p['fpurl'];?>",
   							dock:			"<?php echo $p['dock'];?>",
   							stretch:		"<?php echo $p['stretch'];?>",
   							height: 		"<?php echo $p['height'];?>",
   							width:          "<?php echo $p['width'];?>",
   							controlbar:     "<?php echo $p['controlbar'];?>",
   							autostart: 		false,
   							thumbsinplaylist: true,
  
   							plugins: {
 							"captions-2": {
       							files : labels_files,
       							labels: labels_names
     											}
  								}
 							});
if ( ismobile) {
jQuery('#our_logo').css({'left':'-348px','bottom':'36px'})
}else {
jQuery('#our_logo').css({'left':'-348px','bottom':'61px'})
}
 						}
}
});
    		});
</script>
   	</div>

   	<div class="mot-block-f" align="center">
   		<?php if($prev) { ?><a href="lesson.php?page_content=<?php echo $prev['id'];?>">上一页 : <?php echo $prev['title'];?></a><?php } ?>
   		<?php if($next&&$prev ) { ?><a>/</span><?php } if($next) { ?><a href="lesson.php?page_content=<?php echo $next['id'];?>">下一页 : <?php echo $next['title'];?></a><?php } ?>
   	</div>


<div class="margin-top">
 <div class="container">
   <ul id="myTab" class="nav nav-tabs">
              <li class="active"><a href="#context" data-toggle="tab">阅读</a></li>
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
    <div id="myTabContent" class="tab-content">
    <div class="container">
            <div class="lead tab-pane fade in active" id="context">
            	<?php echo $content['contents'];?>
            </div>

            <div class="tab-pane fade" id="ask">
              <?php include template('lesson/page_ask'); ?>            </div>

            <div class="tab-pane fade" id="note">
              <?php include template('lesson/note/page_note'); ?>            </div>

            <div class="tab-pane fade" id="download">
              <?php include template('lesson/page_download'); ?>            </div>
    </div> 
    </div>

</div>

<?php } elseif($_G['uid']) { ?>
<div class="hero-unit">
<p align="center"><a href="vip.php">此课程收费，要使用这些课程，您可以先成为本站收费会员</a></p>
</div>

<?php } else { ?>
<div class="container">
<div class="mot-block-a">
<div class="alert alert-info"><i class="icon-info-sign"></i> 您好游客，要学习本课，请先登陆</div><?php include template('member/login_simple'); ?></div>
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