<?php


define('PASS_OK',true);
define('SCRIPT','firend_notice');
require dirname(__FILE__).'/includes/common.php';



//是否登录
if (isset($_COOKIE['username'])) {
	
    //分页模块
    global $_pagesize,$_pagenum;
    _page("SELECT notice_id FROM user_notices WHERE user_id='{$_GET['id']}'",10);   //第一个参数获取总条数，第二个参数，指定每页多少条
	$result = sql_query("SELECT notice_id, time,type,theme, message, user_id FROM user_notices WHERE user_id='{$_GET['id']}'");	
} else {
    _alert_back('非法登录');
    jump_page('','login.php');
}

?>

<?php 
	require ROOT_PATH.'includes/header.php';
?>
<link rel="stylesheet" href="styles/my_notice.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>山东大学信息共享平台--Ta的帖子</title>
<html>
<body>

<script type="text/javascript" src="js/my_notice.js"></script>
<div id="member">
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
	
	<div id="member_main">
		<h2>Ta的帖子</h2>
		<table cellspacing="1">
			<tr><th>标题</th><th>分类</th><th>内容</th><th>时间</th></tr>
			<?php 
			     require dirname(_FILE_).'/includes/check.inc.php';
				while (!!$_rows = _fetch_array_list($result)) {
			         
					$messages = array();
					$messages['id'] = $_rows['notice_id'];
					$messages['type'] = check_type($_rows['type']);
					$messages['theme'] = $_rows['theme'];
					$messages['content'] = check_notice_concent($_rows['message']);
					$messages['time'] = $_rows['time'];
					$messages = _html($messages);
					
			?>
			<tr><td><a href="notice_detail.php?id=<?php echo $messages['id']?>" title="<?php echo $messages['theme']?>"><?php echo $messages['theme']?></a></td>
			<td><?php echo $messages['type']?></td>
			<td><a href="notice_detail.php?id=<?php echo $messages['id']?>" title="<?php echo $messages['theme']?>"><?php echo $messages['content']?></a></td>
			<td><?php echo $messages['time']?></td></tr>
			<?php 
				}
				_free_result($result);
			?>
		</table>
		<?php _paging();?>
	</div>
</div>


<?php 
	require ROOT_PATH.'includes/footer.php';
?>
</body>
</html>

