<?php


define('PASS_OK',true);
define('SCRIPT','admin_page');
require dirname(__FILE__).'/includes/common.php';



//是否是管理员登录
if (isset($_COOKIE['admin'])) {
	//获取数据
	$result = _fetch_array("SELECT user_username,user_identity,user_sex,user_face,user_email,user_phone,user_qq,user_reg_time FROM users_table WHERE user_username='{$_COOKIE['username']}'");

} else {
    _alert_back('非法登录');
    jump_page('','index.php');

}
?>

<?php 
	require ROOT_PATH.'includes/header.php';
?>
<link rel="stylesheet" href="styles/member.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>山东大学信息共享平台--个人中心</title>
<div id="member">
<?php 
	require ROOT_PATH.'includes/admin_inc.php';
?>
	<div id="member_main">
		<h2>后台管理中心</h2>
			<dl>
				<dd>服务器主机名称：<?php echo $_SERVER['SERVER_NAME']; ?></dd>
				<dd>服务器版本：<?php echo $_ENV['OS'] ?></dd>
				<dd>通信协议名称/版本：<?php echo $_SERVER['SERVER_PROTOCOL']; ?></dd>
				<dd>服务器IP：<?php echo $_SERVER["SERVER_ADDR"]; ?></dd>
				<dd>客户端IP：<?php echo $_SERVER["REMOTE_ADDR"]; ?></dd>
				<dd>服务器端口：<?php echo $_SERVER['SERVER_PORT']; ?></dd>
				<dd>客户端端口：<?php echo $_SERVER["REMOTE_PORT"]; ?></dd>
				<dd>管理员邮箱：<?php echo $_SERVER['SERVER_ADMIN'] ?></dd>

			</dl>
	</div>
</div>


<?php 
	require ROOT_PATH.'includes/footer.php';
?>
</body>
</html>
