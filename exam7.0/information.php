<?php
session_start();
define('PASS_OK',true);
define('SCRIPT','information');

require dirname(__FILE__).'/includes/common.php';

?>

<?php 
	require ROOT_PATH.'includes/header.php';
?>


<link rel="stylesheet" href="styles/information.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>山东大学信息共享平台--信息中心</title>
<div id="information">
<?php 
//******************************** 对帖子进行筛选  & 分页  ********************************
//*** 1----师生交流 ---- study
//*** 2----资源共享----  resource
//*** 3----趣闻轶事 ---- news
//*** 4----失物招领 ---- lost
//*** 5----校务资讯 ---- school_news
//*** 6----教师资讯 ---- teacher_news

if(isset($_GET['type'])){
    global $_pagesize,$_pagenum;
    switch ($_GET['type']){
        
        case 1:
            $_SESSION['type_kind']=1;
            _page("SELECT notice_id FROM user_notices where type='study'",4);   //第一个参数获取总条数，第二个参数，指定每页多少条
            $result = sql_query("SELECT notice_id, time, type, theme, message, user_id, user_username
                                  FROM user_notices NATURAL JOIN users_table
                                  WHERE TYPE =  'study'
                                  ORDER BY time desc
                                  LIMIT  $_pagenum,$_pagesize");
            break;
            
        case 2:
            $_SESSION['type_kind']=2;
            _page("SELECT notice_id FROM user_notices where  type='resource'",4);   
            $result = sql_query("select notice_id, time,type,theme, message, user_id,user_username
                              from  user_notices natural join users_table
                              where  type='resource'
                              ORDER BY time desc
                              LIMIT $_pagenum,$_pagesize");
            break;
        case 3:
            $_SESSION['type_kind']=3;
            _page("SELECT notice_id FROM user_notices where  type='news'",4);
            $result = sql_query("select notice_id, time,type,theme, message, user_id,user_username
                          from  user_notices natural join users_table
                          where  type='news'
                          ORDER BY time desc
                          LIMIT $_pagenum,$_pagesize");
            break;
        case 4:
            $_SESSION['type_kind']=4;
            _page("SELECT notice_id FROM user_notices where  type='lost'",4);
            $result = sql_query("select notice_id, time,type,theme, message, user_id,user_username
                      from  user_notices natural join users_table
                      where  type='lost'
                      ORDER BY time desc
                      LIMIT $_pagenum,$_pagesize");
            break;                            
        case 5:
            $_SESSION['type_kind']=5;
            _page("SELECT notice_id FROM user_notices where  type='school_news'",4 );
            $result = sql_query("select notice_id, time,type,theme, message, user_id,user_username
                      from  user_notices natural join users_table
                      where  type='school_news'
                      ORDER BY time desc
                      LIMIT $_pagenum,$_pagesize");
            break;
        
        case 6:
            $_SESSION['type_kind']=6;
            _page("SELECT notice_id FROM user_notices where  type='teacher_news'",4);
            $result = sql_query("select notice_id, time,type,theme, message, user_id,user_username
                      from  user_notices natural join users_table
                      where  type='teacher_news'
                      ORDER BY time desc
                      LIMIT $_pagenum,$_pagesize");
              break;        
        default:

            _page("SELECT notice_id FROM user_notices",4);
            $result = sql_query("SELECT notice_id, time,type,theme, message, user_id,user_username 
                                  FROM  user_notices natural join users_table
                                  where CURDATE()- DATE(time) <5  
                                  ORDER BY view_count desc
                                  LIMIT $_pagenum,$_pagesize");
    }

}
else {
    _page("SELECT notice_id FROM user_notices",4);
    $result = sql_query("SELECT notice_id, time,type,theme, message, user_id,user_username
                          FROM  user_notices natural join users_table
                          where CURDATE()- DATE(time) <5  
                          ORDER BY view_count desc
                          LIMIT $_pagenum,$_pagesize");
        
}


	require ROOT_PATH.'includes/information.inc.php';
	require ROOT_PATH.'includes/check.inc.php';
	
?>
	<div id="information_main">
		<h2>信息中心</h2>
        <div class="news-list-left">  
		<?php while(!!$_rows = _fetch_array_list($result)){?>
          <div class="news-list-item">  
            <div class="author-time">  
              <span><strong><?php echo $_rows["user_username"]?></strong></span> 发表于 <span><?php echo $_rows["time"]?></span>  
            </div>  
            <div class="news-des">  
              <h3 class="news-title"><a href="notice_detail.php?id=<?php echo $_rows['notice_id']?>"><?php echo $_rows["theme"]?></a></h3>  
              <div class="news-content-des">  
              	<?php echo simplify_content($_rows["message"])?>             
              </div>  
            </div>  
          </div>  
  		<?php }?>
        <?php _free_result($result);
                _paging();?>  
        </div>  
	</div>
</div>


<?php 
	require ROOT_PATH.'includes/footer.php';
?>
</body>
</html>
