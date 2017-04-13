<?php  
    session_start();
    define("PASS_OK", true);
    define("SCRIPE", "sender");
    require dirname(__FILE__).'/includes/common.php';
    require ROOT_PATH."includes/header.php";
    
?>
<?php 
//对用户发送的信息存入数据库

if($_GET["action"]=="write"){
    if (!!$_rows = _fetch_array("SELECT
                                         user_id
                                         FROM
                                         users_table
                                  WHERE
                                         user_id='{$_COOKIE['id']}'
        ")){//确认是登录状态发送消息
        include ROOT_PATH.'includes/register.func.php';
        $_user_info = array();
        $_user_info['receiver_id'] = $_POST['receiver_id'];
        $_user_info['receiver_name'] = $_POST['receiver_name'];
        $_user_info['theme'] = substr($_POST['theme'], 12);
        
        $_user_info['sender_name'] = $_COOKIE['username'];
        $_user_info['sender_id'] = $_COOKIE['id'];
        
        $_user_info['content'] = check_content($_POST['content']);
        $_user_info = _mysql_string($_user_info);
        //写入表
        sql_query("INSERT INTO user_messages (
            sender_id,
            sender_name,
            receiver_id,
            receiver_name,
            content,
            theme,
            message_time,
            type
            )
            VALUES (
            '{$_user_info['sender_id']}',
            '{$_user_info['sender_name']}',
            '{$_user_info['receiver_id']}',
            '{$_user_info['receiver_name']}',
            '{$_user_info['content']}',
            '{$_user_info['theme']}',
            NOW(),
            0
            )
            ");
        sql_query("INSERT INTO user_messages (
            sender_id,
            sender_name,
            receiver_id,
            receiver_name,
            content,
            theme,
            message_time,
            type
            )
            VALUES (
            '{$_user_info['sender_id']}',
            '{$_user_info['sender_name']}',
            '{$_user_info['receiver_id']}',
            '{$_user_info['receiver_name']}',
            '{$_user_info['content']}',
            '{$_user_info['theme']}',
            NOW(),
            1
            )
            ");
        //新增成功
        if (sql_affected_rows() == 1) {
            _Session_destroy();
            _alert_close('短信发送成功');
        } else {
            _Session_destroy();
            _alert_back('短信发送失败');
        }
    } else {//cookies 不存在  非登录状态
        _alert_close('非法登录！');
    }
}


//得到父页面发来的接受者的id，对接收者的信息进行select并存下来
    if(isset($_GET["id"])){
        
        $receiver_info=array();
        $receiver_info["id"]=$_GET["id"];
        $result=_fetch_array("select user_username from users_table where user_id ='{$_GET["id"]}'");
        $receiver_info["user_username"]=$result["user_username"];
        $receiver_info = _html($receiver_info);
    }
    else{
        _alert_back("非法访问");
        jump_page("页面跳转...", "index.php");
    }


?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="styles/sender.css" type="text/css" />


<title>发送消息</title>
<div id = "sender">
	<h3>写短信</h3>
	<form method="post" action="?action=write">
	<input type="hidden" name="receiver_name" value="<?php echo  $receiver_info["user_username"];?>" />
	<input type="hidden" name="receiver_id" value="<?php echo  $receiver_info["id"];?>" />
	
	<dl>
		<dd><input type="text" class="text to_user" readonly="readonly" value="TO: <?php echo  $receiver_info["user_username"];?>"/></dd>
		<dd ><input type="text" value="主题 : |   " name="theme" class="text theme"></dd>
		<dd><textarea name="content"></textarea></dd>
		<dd><input type="submit" class="submit" value="发送"/></dd>
	</dl>
	</form>
</div>

<?php 
    require ROOT_PATH."includes/footer.php";
?>