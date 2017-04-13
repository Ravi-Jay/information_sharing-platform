<?php

//防止恶意调用
if (!defined('PASS_OK')) {
	exit('Access Defined!');
}
?>
	<div id="member_sidebar">
		<h2>中心导航</h2>
		<dl>
			<dt>账号管理</dt>
			<dd><a href="member.php">个人信息</a></dd>
			<dd><a href="info_modify.php">修改资料</a></dd>
		</dl>
		<dl>
			<dt>消息管理</dt>
			<dd><a href="new_notice.php">创建新帖</a></dd>
			<dd><a href="my_notice.php">我的帖子</a></dd>
			<dd><a href="mem_aboutme.php">@与我相关</a></dd>
			<dd><a href="message_sended.php">我的私信</a></dd>
		</dl>
	</div>