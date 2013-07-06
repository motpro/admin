<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('new_pages_list');?><?php include template('lesson/header'); ?><script>
jQuery( function() {

  jQuery.ajax({
    url : 'lesson.php',
    type : 'GET',
    data : { click_collection:1 , id: "<?php echo $lesson['id'];?>", type:'c'},
    dataType:'html',
  });
});
</script>

<div class="container">
<h5>
<p class="text-left"> 
  <a href="lesson.php"><i class="icon-home"></i> 在线课程</a> <span class="divider">/</span> 
  <a href="lesson.php?pages_list=<?php echo $lesson['id'];?>"><i class="icon-book"></i> <?php echo $lesson['fullname'];?></a> 
</p>
</h5>
</div>


<div class="container-fluid">
<div class="row-fluid">
<div class="span12">

  <div class="span2">

    <div class="text-center">
      <p><img src="uploads/course/<?php echo $lesson['logo'];?>" width="100%" /></p>

            <p align="center">
                <?php if($vip['uid']) { ?>
                  <?php if(is_array($favorite)) foreach($favorite as $f) { ?>                    <?php if($f['courseid'] == $lesson['id']) { ?><?php $flag=true?><a class="btn btn-danger btn-medium btn-block" href="lesson.php?cancel_favorite=<?php echo $lesson['id'];?>">取消选课</a><?php } ?>
                  <?php } ?>
                    <?php if(!$flag) { ?>
                    <a class="btn btn-danger btn-medium btn-block" href="lesson.php?add_favorite=<?php echo $lesson['id'];?>">选课</a>
                    <?php } ?>
                  <?php } elseif($_G['uid'] == 0 ) { ?>
                    <a href="forum.php"></a>
                  <?php } else { ?>
                    <a class="btn btn-danger btn-large btn-block" href="vip.php?action=active" target="_blank">开通会员</a>
                  <?php } ?>
            </p>


    <?php if(!$lesson['is_hidden']) { ?>
    <h4>课程大纲</h4>
    <ul class="nav nav-tabs nav-stacked">
      <?php if(is_array($pages)) foreach($pages as $p) { ?>      <li><a href="lesson.php?page_content=<?php echo $p['id'];?>"><small><strong><?php echo cutstr( $p['title'] , 15 , '' )?></strong></small></a></li>
      <?php } ?>
    </ul>
    <?php } ?>

    </div>

  </div>



  <div class="span10">

  <?php if($lesson['is_hidden']) { ?>
          <div class="row-fluid">
            <div>
                  <h3 align="center">《<?php echo $lesson['fullname'];?>》 课程介绍</h3>
                   <div><?php echo $lesson['summary'];?></div>
            </div>
          </div>
    <div class="alert alert-info">
      很抱歉，本课程正在准备当中，即将推出。。。
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
  <?php } else { ?>
  
      <div>
            <div class="span12">
                  <h3 align="center">《<?php echo $lesson['fullname'];?>》 课程介绍</h3>
                   <div><?php echo $lesson['summary'];?></div>
            </div>
            <hr>



            <?php if(is_array($pages)) foreach($pages as $p) { ?>            <div class="container-fluid well">
            <div class="row-fluid">
              <div class="span4 text-center">
                <a id="<?php echo $p['id'];?>" href="lesson.php?page_content=<?php echo $p['id'];?>" title="<?php echo $p['title'];?>">
                   <img class="span12 image img-polaroid" id="<?php echo $p['id'];?>" src="uploads/page/small/<?php echo $p['image_file'];?>" alt="<?php echo $p['title'];?>"/>
                </a>
              </div>
              
              <div class="span8">
                
                <h4>
                  <a id="<?php echo $p['id'];?>" href="lesson.php?page_content=<?php echo $p['id'];?>" title="<?php echo $p['title'];?>">
                    <?php echo $p['title'];?>
                  </a>
                </h4>
                
                <ul class="inline">
                  <li><span class="label label-info">语音 : <?php echo $p['v_voice'] == 1 ? '英语' : '普通话'?></span></li>
                  <li><span class="label label-info">时长 : <?php echo $p['v_time'];?></span></li>
                </ul>

                <?php echo cutstr( $p['contents'], 140 , ' .. ')?>              </div>

            </div>
            </div>
            <?php } ?>


      </div>
   
    <?php } ?>
  </div>

  </div>

</div>
</div>
</div>

<?php if(false) { ?>
<div class="container">
<div class="page-header">
  <h2>学习指南
    <small>指导</small>
  </h2>
</div>

<div class="page-header">
  <h2>学后考试
    <small>考试试题</small>
  </h2>
</div>
<dt>
  <dl><a href="examination.php?mod=do&amp;id=<?php echo $exam_bucket['id'];?>"><i class="icon-credit-card"></i> <?php echo $exam_bucket['title'];?></a></dl>
  <dt><?php echo $exam_bucket['info'];?></dt>
</dt>

<div class="page-header">
  <h2>成长路线图
    <small>记录改变</small>
  </h2>


  <div class="progress progress-striped active">
    <div class="bar" style="width: 90%;"></div>
  </div>
</div>


</div>
<?php } include template('lesson/footer'); ?>