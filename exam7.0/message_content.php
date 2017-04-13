<?php


define('PASS_OK',true);
define('SCRIPT','message_content');
require dirname(__FILE__).'/includes/common.php';


	require ROOT_PATH.'includes/header.php';
	
?>
<?php 
if(!isset($_COOKIE["id"])){
    _alert_back("非法登录！");
    
}
if($_GET["id"]){
    
    $messages=array();
    $messages["id"]=$_GET["id"];
    $result=_fetch_array("select sender_name, theme, content,state, message_time from user_messages where message_id='{$messages["id"]}'");
    $messages["sender_name"]=$result["sender_name"];
    $messages["theme"]=$result["theme"];
    $messages["state"]=$result["state"];
    $messages["content"]=$result["content"];
    $messages["message_time"]=$result["message_time"];

}
//删除消息
if ($_GET['action'] == 'delete') {
    $delete_list = array();
    $delete_list['id'] =$_GET["id"];
    if (!!$_rows = _fetch_array("SELECT
                                           user_id
                                 FROM
                                           users_table
                                 WHERE
                                           user_username='{$_COOKIE['username']}'"
    )) {
        sql_query("DELETE FROM
            user_messages
            WHERE
            message_id ='{$delete_list['ids']}'"
        );
        if (sql_affected_rows()) {
            jump_page('短信删除成功','mem_aboutme.php');
        } else {
            _alert_back('短信删除失败');
        }
    } else {
        _alert_back('非法登录,不存在此用户');
    }
}

?>
<link rel="stylesheet" href="styles/message_content.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/message_content.js"></script>

<title>山东大学信息共享平台--私信正文</title>
<html>
<body>
<div id="member">
<?php 
	require ROOT_PATH.'includes/member.inc.php';
?>
	<div id="member_main">
	<h2><?php if($_GET["far"]=="1") echo "@与我相关"; else echo "我的私信";?></h2>
		<dl>
			<dd><?php if($_GET["far"]=="1") echo "发 信 人 ："; else echo "收 信 人 ：";?><?php echo $messages['sender_name']?></dd>
			<dd>发信时间：<?php echo $messages['message_time']?></dd>
			<dd>主　　题：<strong><?php echo $messages['theme']?></strong></dd>
			<dd>内　　容：<strong><?php echo $messages['content']?></strong></dd>		
			<dd class="button"><input type="button"  value="返回" id="back" style="background: #E27575;border: none;box-shadow: 1px 1px 5px #B6B6B6;color: #FFF;border-radius: 3px;text-shadow: 1px 1px 1px #9E3F3F;cursor: pointer;"/> 
				<input type="button" id="delete" name="<?php echo $messages['id']?>" value="删除" style="background: #E27575;border: none;box-shadow: 1px 1px 5px #B6B6B6;color: #FFF;border-radius: 3px;text-shadow: 1px 1px 1px #9E3F3F;cursor: pointer;"/>
			</dd>
		</dl>
  </div>
</div>


</body>
</html>
<?php 
    if(isset($_GET["id"])&&$_GET["far"]=="1"){
        if($messages["state"]==0){   //信息未读过
            $sql="update user_messages
                   set state=1
                   where message_id='{$messages["id"]}'";
            sql_query($sql);
            if(!(sql_affected_rows()==1)){
                _alert_back("私信读取失败！");
                jump_page("", "mem_aboutme.php");
            }
        }
    }
	require ROOT_PATH.'includes/footer.php';
?>