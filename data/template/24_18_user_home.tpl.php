<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('home');?><?php include template('user/header'); ?><script src="static/tinymce/tinymce.min.js" type="text/javascript"></script>
    <blockquote>
    一滴水,用显微镜看,也是一个大世界。
    <small class="pull-right"> 鲁迅 <cite title="Source Title"></cite></small>
    </blockquote>

<div class="alert alert-info"><i class="icon-file-alt icon-large"></i> 便笺</div>
<?php if($successed) { ?>
<div class="alert alert-success"><i class="icon-ok"></i> 发表成功<button type="button" class="close" data-dismiss="alert">&times;</button></div>
<?php } ?>
<div class="content">
<form name="_user_pad" action="" method="post">
<textarea class="span12" name="text"></textarea>
<br />
<button name="add_pad" class="btn" type="submit"><i class="icon-save icon-medium"></i> 记录</button>
</form>
</div>

<?php if($last['lastpageid']) { ?>
<div class="alert alert-info margin-top"><i class="icon-bookmark icon-large"></i> 上次学习到的位置</div>
<blockquote>
<h4><i class="icon-star"></i>《<?php echo $last['title'];?>》 
<a href="lesson.php?page_content=<?php echo $last['lastpageid'];?>">继续学习上次课程 <i class="icon-ok"></i></a> 
</h4>
<small><?php echo $last['contents'];?></small>
</blockquote>
<?php } ?>

<div id="user_event" class="alert alert-info margin-top">
<i class="icon-time icon-large"></i> 
日程表 
<small><a href="user.php?ac=sub_schedule"><i class="icon-cog"></i> 管理</a> 
<a id="tips" href="user.php#" data-toggle="tooltip" data-placement="top" title="点击日历日期的空白处 添加新的日程计划"><i class="icon-info-sign"></i> 如何使用</a>
<script>jQuery( function() {jQuery('#tips').tooltip()})</script>
</small>
</div>

<div>
<link href='static/calender/fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='static/calender/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='static/calender/jquery/jquery-ui-1.10.2.custom.min.js'></script>
<script src='static/calender/fullcalendar/fullcalendar.min.js'></script>
<script>
jQuery(document).ready(function() {

var date = new Date();
var d = date.getDate();
var m = date.getMonth();
var y = date.getFullYear();

var calendar = jQuery('#calendar').fullCalendar({
header: {
left: 'prev,next',
center: 'title',
right: 'month'
},

droppable: false,
selectable: true,
selectHelper: true,

select: function(start, end, allDay) {
var title = prompt('添加新的待办事件 :');
if (title) {
jQuery.post('request.php' , {action: 'calendar' , params : { Title : title , Start : start.getTime() , End : end.getTime()}} , function( response) {

if( response) {
jQuery( '#user_event').after('<div class="alert alert-success"><strong>完成!</strong> 成功添加一个日程计划<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
}
});

calendar.fullCalendar('renderEvent',
{
title: title,
start: start,
end: end,
allDay: allDay
},
true // make the event "stick"
);
}
calendar.fullCalendar('unselect');
},
eventDragStop:function(  event, jsEvent, ui, view){
alert(100)
},
editable : false,
events : [<?php if(is_array($event)) foreach($event as $e) { ?>{
            		'title':  "<?php echo $e['event'];?>",
            		'start':  "<?php echo date('Y-m-d', $e['start'])?>",
            		'allDay': true
        		},
        	<?php } ?>
]
});
});

</script>
<style>
#calendar {
width: 100%;
margin: 0 auto;
}
</style>
<div id='calendar'></div>
</div><?php include template('user/footer'); ?>