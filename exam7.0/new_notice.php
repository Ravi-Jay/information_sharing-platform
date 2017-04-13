<?php


define('PASS_OK',true);
define('SCRIPT','new_notice');
require dirname(__FILE__).'/includes/common.php';



//是否登录
if (!(isset($_COOKIE['username']))) {
    _alert_back('非法登录!');
    jump_page('','login.php');
}


//发布帖子
if ($_GET['action'] == 'create') {
    
    require dirname(__FILE__).'/includes/check.inc.php';
    $notice = array(); 
    $notice["theme"]=check_theme($_POST["name"]);
    $notice["selection"]=check_selection($_POST["selection"]);
    $notice["message"]=check_message($_POST["cont"]);
    
    $keys=array();
    $keys=check_keys($_POST["keys"]);
    if (!!$_rows = _fetch_array("SELECT
                                           user_id
                                 FROM
                                           users_table
                                 WHERE
                                           user_username='{$_COOKIE['username']}'"
    )) {
        
        //******************  数据库---事务   ***************
        sql_query("insert into user_notices(user_id, time, theme, type, message)
                    values('{$_COOKIE['id']}', NOW(),'{$notice["theme"]}' , '{$notice["selection"]}' , '{$notice["message"]}' )");
        $num=array();
        $num=_fetch_array("select notice_id from user_notices order by time desc limit 1");
        
        if(!!$keys){
            for($i=0;$i<sizeof($keys);$i++){
                $str1=trim($keys[$i]);
                if($str1==''){
                    continue;
                }
                sql_query("insert into notice_label(label,notice_id)
                                 values('$str1','{$num[notice_id]}')");
            }
        }
        if (sql_affected_rows()) {
            jump_page('新帖发布成功','my_notice.php');
        } else {
            _alert_back('新帖创建失败！');
        }
    } else {
        _alert_back('非法登录,不存在此用户');
    }
}


?>

<?php 
	require ROOT_PATH.'includes/header.php';
?>
<link rel="stylesheet" href="styles/new_notice.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/new_notice.js"></script>

<title>山东大学信息共享平台--个人中心</title>
<html>
<body>
<div id="member">
<?php 
	require ROOT_PATH.'includes/member.inc.php';
?>
	<div id="member_main">
		<h2>创建新帖</h2>
			<form id="form1" method="post" action="?" >
                <label>
                <span>标题:</span>
                <input id="name" type="text" name="name" placeholder="（不超过30字）" />
                </label>
                <label>
                <span>关键字:</span>
                <input id="keys" type="text" name="keys" placeholder="（以空格分离）" />
                </label>
                <label>
                <span>分类:</span><select name="selection">
                <option value="study">学习交流</option>
                <option value="resource">资源分享</option>
                <option value="news">趣闻轶事</option>
                <option value="lost">失物招领</option>
                
                <?php  //*************** 只有老师和管理员可以发布教师信息和教务资讯  ***************
                    $le=_fetch_array("select user_identity from users_table where user_id ='{$_COOKIE['id']}'");
                    $level=$le['user_identity'];
                    if($level>0){?>
                <option value="school_news">校务资讯</option>
                <option value="teacher_news">教师信息</option>
                <?php }?>
                
                </select>
                </label>
                <label>
                <span>内容:</span>
                <dd>
              	<input type="hidden" name="url" id="url" readonly="readonly" class="text" />
				<?php include ROOT_PATH.'includes/textinput.inc.php'?>
				</dd>
                <textarea id="message" name="cont"  placeholder="（不超过500字）"></textarea>
                </label>
                <input type="button" class="button1" value="Send"  id="send"/>
                <input type="button" class="button2" value="Cancel" id="cancel" />         
            </form>      
	</div>
</div>


<?php 
	require ROOT_PATH.'includes/footer.php';
?>
</body>
</html>
