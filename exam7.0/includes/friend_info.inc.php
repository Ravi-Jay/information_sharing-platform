<?php

//防止恶意调用
if (!defined('PASS_OK')) {
	exit('Access Defined!');
}
?>
	<div id="member_sidebar">
		<h2>用户信息</h2>
		<dl>
			<dt>账号信息</dt>
			<dd><a href="friend_info.php">个人信息</a></dd>
		</dl>
		<dl>
			<dt>信息分享</dt>
			<dd><a href="my_notice.php">Ta的帖子</a></dd>
			<dd><a href="mem_aboutme.php">@与我相关</a></dd>
			<dd><a href="message_sended.php？">私信</a></dd>
		</dl>
	</div>