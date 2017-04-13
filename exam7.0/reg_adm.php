<?php
session_start();


define('PASS_OK',true);
define('SCRIPT','reg_adm');
require dirname(__FILE__).'/includes/common.php';



$user_inf = array();
//********* 判断是否为管理员  *************
if(isset($_COOKIE['admin'])){
    
    $user_inf['level']=$_GET['level']-1;//得到该管理员的等级，新增的管理员等级低于他
}
else{
    _alert_back("非法访问！");
}

//注册数据提交给本页  判断并处理数据
if ($_GET['action'] == 'register') {
    
	//判断验证码是否正确  不正确则报错返回注册界面
	check_code($_POST['code'],$_SESSION['code']);
	
	//引入注册的函数库
	include ROOT_PATH.'includes/register.func.php';



	$user_inf['uniqid'] = check_uniqid($_POST['uniqid'],$_SESSION['uniqid']); //唯一标示符标识，验证cookie
	$user_inf['username'] = check_username($_POST['username'],2,20);
	$user_inf['level'] = check_level($_POST['level'],$user_inf['level']);
	$user_inf['password'] = check_password($_POST['password'],$_POST['notpassword'],6);
	$user_inf['question'] = check_question($_POST['question'],2,20);
	$user_inf['answer'] = check_answer($_POST['answer'],2,20);
	$user_inf['sex'] = check_sex($_POST['sex']);
	$user_inf['face'] = check_face($_POST['face']);
	$user_inf['phone'] = check_phone($_POST['phone']);
	$user_inf['email'] = check_email($_POST['email'],6,40);
	$user_inf['qq'] = check_qq($_POST['qq']);
	_alert_back($user_inf['level']);
	
	//判断用户名是否重复
	if_is_repeat(
				"SELECT user_username FROM users_table WHERE user_username='{$user_inf['username']}'",
				'对不起，此用户已被注册'
	);
	
	//新增用户 
	sql_query(
						"INSERT INTO users_table (
												user_uniqid,
												user_username,
	                                            user_identity,
												user_password,
												user_question,
												user_answer,
												user_sex,
												user_face,
	                                            user_phone,
												user_email,
												user_qq,				
												user_reg_time,
												user_last_time,
												user_last_ip
																) 
									VALUES (
											'{$user_inf['uniqid']}',
											'{$user_inf['username']}',
											'{$user_inf['level']}',
											'{$user_inf['password']}',
											'{$user_inf['question']}',
											'{$user_inf['answer']}',
											'{$user_inf['sex']}',
											'{$user_inf['face']}',
											'{$user_inf['phone']}',
											'{$user_inf['email']}',
											'{$user_inf['qq']}',
											NOW(),
											NOW(),
											'{$_SERVER["REMOTE_ADDR"]}'
											)"
	);
	if (sql_affected_rows() == 1) {  //如果只改变了数据库中的一条语句则成功插入了
		_Session_destroy(); //删除Session
		jump_page('恭喜您，注册成功！','');
	} else {
		_Session_destroy();
		jump_page('注册失败！请重新注册。','reg_adm.php');
	}
} else { //假若没有提交数据，生成一个uniqid并且保存在$_uniqid中，用于注册时发送出去，验证是同一地址注册并发送的数据，防止其他地址向数据库发送数据
	$uniqid = _sha1_uniqid();
	$_SESSION['uniqid'] = $uniqid;
}

?>

<?php 
    require ROOT_PATH.'includes/header.php';
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/register.js"></script>
<link rel="stylesheet" href="styles/register.css" type="text/css" />

<body id='top'>
<div id="member_main">
	<h2>用户注册  </h2>
	<form method="post" name="member_main" action="reg_adm.php?action=register">
		<input type="hidden" name="uniqid" value="<?php echo $uniqid ?>" />
		<dl>
			<dd class="face"><input type="hidden" name="face" value="face/t1.jpg" /><img src="face/t1.jpg" alt="头像选择" id="faceimg" /></dd>
			<dd>用 户 名 ： <input type="text" name="username" class="text" /> (*必填，至少两位)</dd>
			<dd>密　　码：<input type="password" name="password" class="text" /> (*必填，至少六位)</dd>
			<dd>等　　级：<input type="text" name="level" class="text" placeholder="<?php echo $user_inf['level'];?>"/> (*须低于自身等级)</dd>
			<dd>确认密码：<input type="password" name="notpassword" class="text" />(*必填，同上填写)</dd>
			<dd>密码提示：<input type="text" name="question" class="text" /> (*必填，至少两位)</dd>
			<dd>密码回答：<input type="text" name="answer" class="text" /> (*必填，至少两位)</dd>
			<dd>性　　别：<input type="radio" name="sex" value="男" checked="checked" />男 <input type="radio" name="sex" value="女" />女</dd>
			<dd>手　　 机: <input type="text" name="phone" class="text" />(*必填，十一位号)</dd>
			<dd style= "padding-right: 4px">电子邮件：<input type="text" name="email" class="text" /> (选填,以接收通知)</dd>
			<dd style= "padding-right: 78px" > Q  Q ：    <input type="text" name="qq" class="text qq" /></dd>
			<dd style= "padding-right: 40px">验 证 码  ：　<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" /></dd>
			<dd><input type="submit" class="submit" value="注册" /></dd>
		</dl>
	</form>
</div>

<?php 
    require ROOT_PATH.'includes/footer.php';
?>
</body>
