<?php


define('PASS_OK',true);
define('SCRIPT','notice_modify');
require dirname(__FILE__).'/includes/common.php';



//************************   是否登录    **********************

if (!(isset($_COOKIE['username']))) {
    _alert_back('非法登录!');
    jump_page('','login.php');
}


//************************************  获得本贴的信息  *****************************

$notice=array();
if(isset($_GET["id"])){
    $notice["id"]=$_GET["id"];
    $row=_fetch_array("select  notice_id, time, theme, type, message,user_id
                       from    user_notices 
                       where   notice_id='{$notice["id"]}'");
    if($_COOKIE['id']!=$row['user_id']&&!isset($_COOKIE['admin'])){//不是发帖人且不是管理员
        _alert_back("无权修改");
    }
    $notice["theme"]=$row["theme"];
    $notice["time"]=$row["time"];
    $notice["type"]=$row["type"];
    $notice["content"]=$row["message"];
}
else{//*********没有得到帖子的id************************
    _alert_back("网页数据丢失！");
}


//********************   修改帖子    ********************

if ($_GET['action'] == 'create') {
    
    require dirname(__FILE__).'/includes/check.inc.php';

    $notice["theme"]=check_theme($_POST["name"]);
    $notice["selection"]=check_selection($_POST["selection"]);
    $notice["message"]=check_message($_POST["message"]);
    

    if (!!$_rows = _fetch_array("select    user_id   FROM  users_table   WHERE  user_username='{$_COOKIE['username']}'"
    )) {
        sql_query("update user_notices set  time=NOW(), theme='{$notice["theme"]}', type='{$notice["selection"]}', message= '{$notice["message"]}'   
                   where notice_id='{$notice['id']}'");
        if (sql_affected_rows()==1) {
            jump_page('修改成功','notice_detail.php?id='.$notice['id']);
        } else {
            _alert_back('修改失败！');
        }
    } else {
        _alert_back('非法登录,不存在此用户');
    }
}


?>

<?php 
	require ROOT_PATH.'includes/header.php';
?>
<link rel="stylesheet" href="styles/notice_modify.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/notice_modify.js"></script>

<title>山东大学信息共享平台</title>
<html>
<body>
<div id="member">

	<div id="member_main">
		<h2>修改帖子</h2>
			<form id="form1" method="post" action="?" >
                <label>
                <span>标题:</span>
                <input id="name" type="text" name="name" value="<?php echo $notice['theme'];?>" />
                <input id="notice_id" type="hidden" value="<?php echo $notice['id'];?>" />
                </label>
                <label>
                <span>分类:</span><select name="selection">
                <option value="study">学习交流</option>
                <option value="resource">资源分享</option>
                <option value="news">趣闻轶事</option>
                <option value="lost">失物招领</option>
                <option value="school_news">校务资讯</option>
                <option value="teacher_news">教师信息</option>   
                </select>
                </label>
                <label>
                <span>内容:</span>
                <textarea id="message" name="message" ><?php echo $notice['content'];?></textarea>
                </label>
                <input type="button" class="button1" value="修改"  id="send"/>
                <input type="button" class="button2" value="取消" id="cancel" />         
            </form>      
	</div>
</div>


<?php 
	require ROOT_PATH.'includes/footer.php';
?>
</body>
</html>
