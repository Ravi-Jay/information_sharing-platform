<?php

//定义个常量，用来授权调用includes里面的文件
define('PASS_OK',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','index');
//引入公共文件
require dirname(__FILE__).'/includes/common.php'; 
include dirname(__FILE__).'/includes/check.inc.php';
?>

<?php 
        $result = sql_query("SELECT notice_id, time,type,theme, message, user_id,user_username
                             FROM  user_notices natural join users_table
                             ORDER BY view_count desc
                             LIMIT 3");
        $result2 = _fetch_array("SELECT notice_id, time,type,theme, message, user_id,user_username
                                 FROM  user_notices natural join users_table
                                 where notice_id=28
                                 ORDER BY view_count desc
                                 ");
        $result3 = _fetch_array("SELECT notice_id, time,type,theme, message, user_id,user_username
                                 FROM  user_notices natural join users_table
                                 where notice_id=29
                                 ORDER BY view_count desc
                                 ");

        $result4 = sql_query("SELECT notice_id, time,type,theme, message, user_id,user_face,user_username
                                 FROM  user_notices natural join users_table
                                 where  type='teacher_news'
                                 ORDER BY time desc
                                 LIMIT 3");


 	require ROOT_PATH.'includes/header.php';
?>
<link rel="stylesheet" href="styles/layout.css" type="text/css" />
<body id="top">




<!-- ######################################   wrapper row3        ################################## -->
<div class="wrapper row3">
  <div id="container" class="clear">
    <!-- ####################################################################################################### -->
    <div id="homepage" class="clear">
      <!-- ###### -->
      <div id="content">
        <div id="top_featured" class="clear">
          <ul class="clear">
            <li class="last">
              <h2><?php echo $result2['theme']?></h2>
              <img src="images/6.jpg" alt="" />
              <p><?php echo check_notice_concent($result2['message'])?> &hellip;</p>
         		<p class="readmore"><a href="notice_detail.php?id=28">了解更多 &raquo;</a></p>
            </li>
            <li class="last">
              <h2><?php echo $result3['theme']?></h2>
              <img src="images/7.jpg" alt="" />
              <p><?php echo check_notice_concent($result3['message'])?>&hellip;</p>
         		<p class="readmore"><a href="notice_detail.php?id=29">了解更多 &raquo;</a></p>
          </ul>
        </div>
        
        
        <div id="latestnews">
          <h2>新帖发布 &amp; 趣闻</h2>
          <ul>
      		<?php while(!!$rows = _fetch_array_list($result)){?>
            <li>
              <p><strong><?php echo $rows['theme']?></strong><br />
               	<?php echo check_notice_concent($rows['message'])?> &hellip;</p>
              <p class="readmore"><a href="notice_detail.php?id=<?php echo $rows['notice_id']?>">了解更多 &raquo;</a></p>
            </li>
			<?php }?>
          </ul>
        </div>
      </div>
      
      <!-- ###### -->
      <div id="column">
        <div class="holder">
          <h2>通知公告</h2>
          <p>这是测试版1.0</p>
          <p class="readmore"><a href="#">了解更多 &raquo;</a></p>
        </div>
        
        <div class="holder last">
          <h2>导师通知</h2>
          <ul class="staffmembers">
      	  <?php if(!!$result4){
      	            while(!!$rows4 = _fetch_array_list($result4)){?>
                    <li class="clear"><img class="imgl" src="<?php echo $rows4['user_face']?>" alt="" />
                      <div class="fl_left">
                        <p><strong><?php echo $rows4['user_username']?></strong></p>
                        <p><?php echo check_teacher_notice($rows4['message'])?></p>
                        <p><a href="notice_detail.php?id=<?php echo $rows4['notice_id']?>"> 阅读原文 &raquo;</a></p>
                      </div>
                    </li>
    		 <?php }
          	  }?>
          </ul>
        </div>
      </div>
      <!-- ###### -->
    </div>
    <!-- ####################################################################################################### -->
  </div>
</div>
<?php require ROOT_PATH.'includes/footer.php';?>
</body>
