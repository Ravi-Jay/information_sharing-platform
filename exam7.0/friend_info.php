<?php


define('PASS_OK',true);
define('SCRIPT','friend_info');
require dirname(__FILE__).'/includes/common.php';



//是否登录
if (isset($_COOKIE['username'])) {
	$user_info= array();
    $user_info['id']=$_GET['id'];
	//获取数据
	$result = _fetch_array("SELECT user_username,user_identity,user_sex,user_face,user_email,user_phone,user_qq FROM users_table WHERE user_id='{$_GET['id']}'");
	if (!!$result) {
		$user_info['username'] = $result['user_username'];
		$user_info['sex'] = $result['user_sex'];
		$user_info['face'] = $result['user_face'];
		$user_info['email'] = $result['user_email'];
		$user_info['phone'] = $result['user_phone'];
		$user_info['qq'] = $result['user_qq'];
		
		switch ($result['user_identity']) {
			case 0:
				$user_info['identity'] = '学生';
				break;
			case 1:
				$user_info['identity'] = '老师';
				break;
			default:
				$user_info['identity'] = '未知';
		}
		$user_info = _html($user_info);
	} else {
		_alert_back('此用户不存在');
	}
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

	<div id="member_sidebar">
		<h2>用户信息</h2>
		<dl>
			<dt>账号信息</dt>
			<dd><a href="friend_info.php?id=<?php echo $user_info['id'];?>">个人信息</a></dd>
		</dl>
		<dl>
			<dt>信息分享</dt>
			<dd><a href="friend_notice.php?id=<?php echo $user_info['id'];?>">Ta的帖子</a></dd>
			<dd><a href="mem_aboutme.php?id=<?php echo $user_info['id'];?>">@与我相关</a></dd>
			<dd><a href="message_sended.php?id=<?php echo $user_info['id'];?>">私信</a></dd>
		</dl>
	</div>
	<div id="member_main">
		<h2>个人中心</h2>
		<dl>
			<dt><img src="<?php echo $user_info['face']?>" alt="" /></dt>
			<dd>用 户 名 ：<?php echo $user_info['username']?></dd>
			<dd>性　　别：<?php echo $user_info['sex']?></dd>
			<dd>电子邮件：<?php echo $user_info['email']?></dd>
			<dd>身　　份：<?php echo $user_info['identity']?></dd>
		</dl>
	</div>
</div>


<?php 
	require ROOT_PATH.'includes/footer.php';
?>
</body>
</html>
