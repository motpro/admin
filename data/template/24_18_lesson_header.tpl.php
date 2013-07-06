<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('header');?><?php include template('common/header'); ?><script src="static/tinymce/tinymce.min.js" type="text/javascript"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    language: "zh_CN",
    toolbar: "",
    statusbar : false,
    menubar : false,
 });
</script>

<?php if(false) { ?>
  	<div class="pull-right">
<wb:share-button type="button" size="small" relateuid="1806407650" ></wb:share-button>
</div>
<?php } if(false) { ?>
<div class="container">
    <h3><small><i class="icon-search"></i> 快速索引 </small></h3>
<ul class="nav nav-pills">
        <li><a href="lesson.php">所有课程</a></li>
        <?php if(is_array($category)) foreach($category as $nav) { ?>        <li><a href="lesson.php?category=<?php echo $nav['id'];?>"><?php echo $nav['category'];?></a></li>
        <?php } ?>
    </ul>
</div>
<?php } ?>

<div class="container">