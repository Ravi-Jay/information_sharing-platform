<?php

session_start();

define('PASS_OK',true);
define('SCRIPT','info_modify');
require dirname(__FILE__).'/includes/common.php';


//修改资料
if ($_GET['action'] == 'modify'){
	
    //判断验证码是否正确  不正确则报错返回修改界面
    check_code($_POST['code'],$_SESSION['code']);
    
    //引入注册的函数库
    include ROOT_PATH.'includes/register.func.php';
    
    $user_inf = array();
    
    $user_inf['uniqid'] = check_uniqid($_POST['uniqid'],$_SESSION['uniqid']); //唯一标示符标识，验证cookie
    $user_inf['username'] = $_COOKIE['username'];
    $user_inf['sex'] = check_sex($_POST['sex']);
    $user_inf['face'] = check_face($_POST['face']);
    $user_inf['password'] = check_password($_POST['password'],$_POST['notpassword'],6);
    $user_inf['phone'] = check_phone($_POST['phone']);
    $user_inf['email'] = check_email($_POST['email'],6,40);
    $user_inf['qq'] = check_qq($_POST['qq']);
    
    
    //判断用户名存在
    $res=sql_query(
        "SELECT user_username FROM users_table WHERE user_username='{$user_inf['username']}'" );
    
    //若该用户存在 更新用户信息
    if($res){
        sql_query(
            "update users_table 
             set 
                user_uniqid = '{$user_inf['uniqid']}',
                user_password = '{$user_inf['password']}',
                user_sex = '{$user_inf['sex']}',
                user_face ='{$user_inf['face']}',
                user_phone ='{$user_inf['phone']}',
                user_email = '{$user_inf['email']}',
                user_qq = '{$user_inf['qq']}',
                user_last_time = NOW(), 
                user_last_ip = '{$_SERVER["REMOTE_ADDR"]}'
            where user_username='{$user_inf['username']}'"
        );
    }
    if (sql_affected_rows() == 1) {  //如果只改变了数据库中的一条语句则成功插入了
        _Session_destroy(); //删除Session
        jump_page('恭喜您，资料修改成功！','member.php');
    } else {
        _Session_destroy();
        jump_page('修改失败！请重新操作。','info_modify.php');
    }
    
} else { //假若没有提交数据，生成一个uniqid并且保存在$_uniqid中，用于注册时发送出去，验证是同一地址注册并发送的数据，防止其他地址向数据库发送数据
    $uniqid = _sha1_uniqid();
    $_SESSION['uniqid'] = $uniqid;
}
//是否正常登录
if (isset($_COOKIE['username'])){
	//获取数据
	$result = _fetch_array("SELECT user_username,user_sex,user_face,user_email,user_phone,user_qq FROM users_table WHERE user_username='{$_COOKIE['username']}'");
	if($result) {
		$user_info= array();
		$user_info['username'] = $result['user_username'];
		$user_info['sex'] = $result['user_sex'];
		$user_info['face'] = $result['user_face'];
		$user_info['email'] = $result['user_email'];
		$user_info['phone'] = $result['user_phone'];
		$user_info['qq'] = $result['user_qq'];
		$user_info = _html($user_info);
		
		//性别选择
		if ($user_info['sex'] == '男') {
			$user_info['sex_html'] = '<input type="radio" name="sex" value="男" checked="checked" /> 男 <input type="radio" name="sex" value="女" /> 女';
		} elseif ($user_info['sex'] == '女') {
			$user_info['sex_html'] = '<input type="radio" name="sex" value="男" /> 男 <input type="radio" name="sex" value="女" checked="checked" /> 女';
		}

	} else {
		_alert_back('此用户不存在');
	}
}else{
	_alert_back('非法登录');
    jump_page('','index.php');
}
?>




<?php 
	require ROOT_PATH.'includes/header.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>山东大学信息共享平台--个人中心</title>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/info_modify.js"></script>
<link rel='stylesheet' href="styles/info_modify.css" type="text/css" />


<div id="member">
<?php 
	require ROOT_PATH.'includes/member.inc.php';
?>
	<div id="member_main">
		<h2>资料修改</h2>
		<form method="post" name="member_main" action="info_modify.php?action=modify">
		<input type="hidden" name="uniqid" value="<?php echo $uniqid ?>" />
		<dl>
			<dd class="face"><input type="hidden" name="face" value="<?php echo $user_info['face']?>" /><img src="<?php echo $user_info['face']?>" alt="头像选择" id="faceimg" /></dd>
			<dd>用 户 名：<?php echo $user_info['username']?></dd>
			<dd>性　　别：<?php echo $user_info['sex_html']?></dd>
			<dd>密　　码：<input type="password" name="password" class="text" /></dd>
			<dd>确认密码：<input type="password" name="notpassword" class="text" /></dd>
			<dd>电子邮件：<input type="text" class="text" name="email" value="<?php echo $user_info['email']?>" /></dd>
			<dd>手　　机：<input type="text" class="text" name="phone" value="<?php echo $user_info['phone']?>" /></dd>
			<dd>Q 　 　Q：<input type="text" class="text" name="qq" value="<?php echo $user_info['qq']?>" /></dd>
			<dd>验 证 码：<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" /></dd>
			<dd><input type="submit" class="submit" value="修改资料" /></dd>
		</dl>
		</form>
	</div>
</div>


<?php 
	require ROOT_PATH.'includes/footer.php';
?>

