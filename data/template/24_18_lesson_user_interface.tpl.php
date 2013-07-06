<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('user_interface');
0
|| checktplrefresh('./template/tpl/lesson/user_interface.htm', './template/tpl/lesson/header.htm', 1373036573, '18', './data/template/24_18_lesson_user_interface.tpl.php', './template/tpl', 'lesson/user_interface')
|| checktplrefresh('./template/tpl/lesson/user_interface.htm', './template/tpl/lesson/footer.htm', 1373036573, '18', './data/template/24_18_lesson_user_interface.tpl.php', './template/tpl', 'lesson/user_interface')
;?><?php include template('common/header'); ?><script src="static/tinymce/tinymce.min.js" type="text/javascript"></script>
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

<div class="container">  <?php if(is_array($c)) foreach($c as $course) { ?>  <div class="container-fluid">
    <div class="row-fluid">
    <div class="page-header">
    <h3> <?php echo $course['fullname'];?> <small><?php echo $cat[$course['category_id']];?></small></h3>
    </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span4">
        <a href="lesson.php?pages_list=<?php echo $course['id'];?>">
        <img style="height:120px" class="img-polaroid" src="uploads/course/<?php echo $course['logo'];?>" alt="<?php echo $course['fullname'];?>" />
        </a>
      </div>

    <div class="span8">
        <p><?php echo $course['summary'];?></p>
            <a class="btn pull-right" href="lesson.php?pages_list=<?php echo $course['id'];?>">开始学习</a>
    </div>
    </div>
    </div>
  <?php } ?>

    <div class="span12 pagination pagination-large" align="center">
      <?php if(isset($_GET['category'])) { ?>
              <ul>
                <li><a href="lesson.php?category=<?php echo $_GET['category'];?>&amp;page=<?php echo $page-1?>">&laquo;</a></li>
                <li class="active"><a href="lesson.php?category=<?php echo $_GET['category'];?>&amp;page=<?php echo $page?>"><?php echo $page?></a></li>
                <li><a href="lesson.php?category=<?php echo $_GET['category'];?>&amp;page=<?php echo $page+1?>"><?php echo $page+1?></a></li>
                <li><a href="lesson.php?category=<?php echo $_GET['category'];?>&amp;page=<?php echo $page+2?>"><?php echo $page+2?></a></li>
                <li><a href="lesson.php?category=<?php echo $_GET['category'];?>&amp;page=<?php echo $page+1?>">&raquo;</a></li>
              </ul>
      <?php } else { ?>
              <ul>
                <li><a href="lesson.php?page=<?php echo $page-1?>">&laquo;</a></li>
                <li class="active"><a href="lesson.php?page=<?php echo $page?>"><?php echo $page?></a></li>
                <li><a href="lesson.php?page=<?php echo $page+1?>"><?php echo $page+1?></a></li>
                <li><a href="lesson.php?page=<?php echo $page+2?>"><?php echo $page+2?></a></li>
                <li><a href="lesson.php?page=<?php echo $page+1?>">&raquo;</a></li>
              </ul>
      <?php } ?>
    </div><?php include template('common/footer'); ?>