<?php

//防止恶意调用
if (!defined('PASS_OK')) {
	exit('Access Defined!');
}
?>
	<div id="member_sidebar">
		<h2>管理中心</h2>
		<dl>
			<dt>后台管理</dt>
			<dd><a href="admin_page.php">后台信息</a></dd>
		</dl>
		<dl>
			<dt>账号管理</dt>
			<dd><a href="admin_adm.php">管理员</a></dd>
			<dd><a href="admin_users.php">所有用户</a></dd>
		</dl>
		<dl>
			<dt>消息管理</dt>
			<dd><a href="admin_notices.php">所有帖子</a></dd>

		</dl>
	</div>