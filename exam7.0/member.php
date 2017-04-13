<?php


define('PASS_OK',true);
define('SCRIPT','member');
require dirname(__FILE__).'/includes/common.php';



//是否登录
if (isset($_COOKIE['username'])) {
	//获取数据
	$result = _fetch_array("SELECT user_username,user_identity,user_sex,user_face,user_email,user_phone,user_qq,user_reg_time FROM users_table WHERE user_username='{$_COOKIE['username']}'");
	if ($result) {
		$user_info= array();
		$user_info['username'] = $result['user_username'];
		$user_info['sex'] = $result['user_sex'];
		$user_info['face'] = $result['user_face'];
		$user_info['email'] = $result['user_email'];
		$user_info['phone'] = $result['user_phone'];
		$user_info['qq'] = $result['user_qq'];
		$user_info['reg_time'] = $result['user_reg_time'];
		
		switch ($result['user_identity']) {
			case 0:
				$user_info['identity'] = '学生';
				break;
			case 1:
				$user_info['identity'] = '老师';
				break;
			case 2:
			    $user_info['identity'] = '管理员';
			    break;
		    case 3:
		        $user_info['identity'] = '管理员';
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
<?php 
	require ROOT_PATH.'includes/member.inc.php';
?>
	<div id="member_main">
		<h2>个人中心</h2>
		<dl>
			<dt><img src="<?php echo $user_info['face']?>" alt="" /></dt>
			<dd>用 户 名 ：<?php echo $user_info['username']?></dd>
			<dd>性　　别：<?php echo $user_info['sex']?></dd>
			<dd>电子邮件：<?php echo $user_info['email']?></dd>
			<dd>手　　机：<?php echo $user_info['phone']?></dd>
			<dd>Q 　 　Q：<?php echo $user_info['qq']?></dd>
			<dd>注册时间：<?php echo $user_info['reg_time']?></dd>
			<dd>身　　份：<?php echo $user_info['identity']?></dd>
		</dl>
	</div>
</div>


<?php 
	require ROOT_PATH.'includes/footer.php';
?>
</body>
</html>
