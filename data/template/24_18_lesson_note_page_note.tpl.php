<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<div class="container clearfix">
<div class="rowfluid">

<table>
<tr><td class="span9 mot-block-b">
<div align="center">

<textarea id="markItUp"></textarea>

<button id="Get_Note" class="btn btn-info" data-loading-text="添加中...">添加笔记</button>

<script>
jQuery( function() {

jQuery('#Get_Note').on( 'click' , function () {

if( tinyMCE.get('markItUp').getContent().length > 0)

jQuery.post("request.php", { action: "setnote" ,params : { notetext : tinyMCE.get('markItUp').getContent() ,  pageid: "<?php echo $content['id'];?>" } },
   			function(response){
   				if( 0 != response){
   					response = eval('('+response+')');
   					jQuery('#title_tree').append('<li><a href="user.php?ac=sub_note&amp;note_id='+response['id']+'">'+response['text']+'</a></li>');
   				}else {
   					
   				}
   			});	
});
});
</script>
</div>

</td>

<td></td>

<td class="span3 mot-block-b" style="vertical-align:top"><?php include template('lesson/note/page_record'); ?></td></tr>
</table>

</div>
</div>