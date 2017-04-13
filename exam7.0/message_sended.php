<?php


define('PASS_OK',true);
define('SCRIPT','message_sended');
require dirname(__FILE__).'/includes/common.php';



//是否登录
if (isset($_COOKIE['username'])) {
	//获取messages数据
    //分页模块
    global $_pagesize,$_pagenum;
    if(isset($_GET['id'])){
        _page("SELECT message_id FROM user_messages WHERE sender_id='{$_COOKIE['id']}' and type=0 and receiver_id='{$_GET['id']}'",10);   //第一个参数获取总条数，第二个参数，指定每页多少条
        $result = sql_query("SELECT message_id, receiver_name,theme,content, state,message_time FROM user_messages WHERE sender_id='{$_COOKIE['id']}' and type=0 and receiver_id='{$_GET['id']}'");     
    }
    else{
        _page("SELECT message_id FROM user_messages WHERE sender_id='{$_COOKIE['id']}' and type=0",10);   //第一个参数获取总条数，第二个参数，指定每页多少条
    	$result = sql_query("SELECT message_id, receiver_name,theme,content, state,message_time FROM user_messages WHERE sender_id='{$_COOKIE['id']}' and type=0");
    }
} else {
    _alert_back('非法登录');
    jump_page('','login.php');
}


//删除消息
if ($_GET['action'] == 'delete' && isset($_POST['ids'])) {
    $delete_list = array();
    $delete_list['ids'] = _mysql_string(implode(',',$_POST['ids']));
 
    if (!!$_rows = _fetch_array("SELECT
                                           user_id
                                 FROM
                                           users_table
                                 WHERE
                                           user_username='{$_COOKIE['username']}'"
    )) {
        sql_query("DELETE FROM
            user_messages
            WHERE type=0 and (
            message_id
            IN
            ({$delete_list['ids']}))"
        );
        if (sql_affected_rows()) {
            if(isset($_GET['id'])){
                jump_page('私信删除成功！','message_sended.php?id='.$_GET['id']);
            }
            else{
                jump_page('私信删除成功！','message_sended.php');                
            }
        } else {
            _alert_back('私信删除失败！');
        }
    } else {
        _alert_back('非法登录,不存在此用户！');
    }
}


?>

<?php 
	require ROOT_PATH.'includes/header.php';
?>
<link rel="stylesheet" href="styles/mem_aboutme.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>山东大学信息共享平台--我的私信</title>
<html>
<body>

<script type="text/javascript" src="js/mem_aboutme.js"></script>
<div id="member">
<?php 
if(isset($_GET['id'])){?>
        <div id="member_sidebar">
            <h2>用户信息</h2>
                <dl>
            	<dt>账号信息</dt>
            		<dd><a href="friend_info.php?id=<?php echo $_GET['id'];?>">个人信息</a></dd>
                </dl>
                <dl>
                <dt>信息分享</dt>
                    <dd><a href="friend_notice.php?id=<?php echo $_GET['id'];?>">Ta的帖子</a></dd>
                    <dd><a href="mem_aboutme.php?id=<?php echo $_GET['id'];?>">@与我相关</a></dd>
                    <dd><a href="message_sended.php?id=<?php echo $_GET['id'];?>">私信</a></dd>
       	 		</dl>
        </div>
<?php  }
else{
    require ROOT_PATH.'includes/member.inc.php';	    
}
?>
	<div id="member_main">
		<h2>我的私信</h2>
		
		<form method="post" action="?action=delete">
		<table cellspacing="1">
			<tr><th>收信人</th><th>主题</th><th>时间</th><th>操作</th></tr>
			<?php 
				while (!!$_rows = _fetch_array_list($result)) {
				    
					$messages = array();
					$messages['id'] = $_rows['message_id'];
					$messages['receiver_name'] = $_rows['receiver_name'];
					$messages['theme'] = $_rows['theme'];
					$messages['content'] = $_rows['content'];
					$messages['time'] = $_rows['message_time'];
					$messages = _html($messages);
					
			?>
			<tr><td><?php echo $messages['receiver_name']?></td>
			<td><a href="message_content.php?id=<?php echo $messages['id']?>&far=<?php echo "0";?>" title="<?php echo $messages['theme']?>"><?php echo $messages['theme']?></a></td>
			<td><?php echo $messages['time']?></td>
			<td><input  type="checkbox" name="ids[]" value="<?php echo $messages['id']?>"/></td></tr>
			<?php 
				}
				_free_result($result);
			?>
			<tr><td colspan="4"><label for="all">全选 <input type="checkbox" name="chkall" id="all" /></label> <input type="submit" value="批删除" /></td></tr>
		</table>
		</form>
		<?php _paging();?>
	</div>
</div>


<?php 
	require ROOT_PATH.'includes/footer.php';
?>
</body>
</html>
