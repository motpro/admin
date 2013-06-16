<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<h4><i class="icon-pencil"></i> 我的笔记</h4>
<div style="font-size:12px;">
<ol id="title_tree">
</ol>
</div>


<script>
jQuery( function() {
jQuery.post( "request.php" , { action: "getnote" ,params : { uid : "<?php echo $_G['uid'];?>" , pageid : "<?php echo $content['id'];?>" } } , function(response){
response = eval('('+response+')');
for( var i = 0 ; i < response.length ; ++i){
jQuery('#title_tree').append('<li><a href="user.php?ac=sub_note&amp;edit='+response[i]['id']+'" target="blank">'+response[i]['notetext']+'</a></li>')
}
});
});
</script>