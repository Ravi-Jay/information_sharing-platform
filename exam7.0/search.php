<?php
session_start();
define('PASS_OK',true);
define('SCRIPT','search');
require dirname(__FILE__).'/includes/common.php';

?>

<?php 
	require ROOT_PATH.'includes/search_header.php';
?>


<link rel="stylesheet" href="styles/search.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>山东大学信息共享平台</title>
<div id="information">
<?php 
//******************************** 获取搜索后的数据集  ********************************


if($_GET['action']=='search'){
        $_SESSION['list']='';
        $res=trim($_POST['res']);
        if($res!=''){
            require ROOT_PATH.'NLP.php';
            $notices=array();
            $notices=NLP_search($res);
            if(!!$notices){
                
                $notice_list = _mysql_string(implode(',',$notices));
//                 _alert_back($notice_list);
                
                $_SESSION['list']=$notice_list;
//                 _alert_back($_SESSION['list']);
                
    //             $notices2=array();
    //             for($i=0;$i<$_pagesize;$i++){
    //                 $notices2[$i]=$notices[$i+$_pagenum];
    //             }
    //             $notice_list2 = _mysql_string(implode(',',$notices2));
            }
        }
}
        global $_pagesize,$_pagenum;
        $list=$_SESSION['list'];
//         _alert_back($list);
        if(trim($list)!=''){
            _page("SELECT notice_id FROM user_notices where notice_id in ($list)",4);   //第一个参数获取总条数，第二个参数，指定每页多少条
            
            $result = sql_query("SELECT notice_id, time, type, theme, message, user_id, user_username
                                FROM user_notices NATURAL JOIN users_table
                                where notice_id in ($list)
                                LIMIT  $_pagenum,$_pagesize
                                 ");
        }
        
	require ROOT_PATH.'includes/check.inc.php';
	
?>

	<div id="information_main">
		<h2>本站搜索</h2>
          <form action="?action=search" method="post" id="sitesearch" style="margin-right:180px;margin-bottom:20px;width:500px;">
            <fieldset>
              <legend>Site Search</legend>
              <input type="text" name="res" value="Search Our Website&hellip;" onfocus="this.value=(this.value=='Search Our Website&hellip;')? '' : this.value ;"  style="font-size:15px;background:rgb(54, 52, 50);border-radius: 6px;width:300px; height:40px;" />
              <input type="submit" value="Search" id="search" alt="Search" style="font-size:15px;background:rgb(54, 52, 50);width: 100px;height: 40px;border:none;box-shadow: 1px 1px 5px #B6B6B6;border-radius: 6px;text-shadow: 1px 1px 1px #9E3F3F;cursor: pointer;"/>
            </fieldset>
          </form>
        <div class="news-list-left">  
		<?php 
		if(!!$result){//如果存在结果集
    		while(!!$_rows = _fetch_array_list($result)){?>
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
  		<?php }
  		?>
        <?php 
                 _free_result($result);
                search_paging();
		}
		else{
        ?>
        <h3 id="result_intr">无搜索结果，请输入搜索内容重试。</h3>
   		<?php   
		}
        ?>  
        </div>  
	</div>
</div>


<?php 
	require ROOT_PATH.'includes/footer.php';
?>
</body>
</html>
