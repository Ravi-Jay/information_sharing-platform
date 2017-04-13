<?php

session_start();

define('PASS_OK',true);

define('SCRIPT','login');
//引入公共文件
require dirname(__FILE__).'/includes/common.php';



if_login_state();//检查一下cookies 判断是否登录,未登陆直接退出 



//************************       判断登录的用户类型   *******************************
    Global $label;
    $label='用户';
    if($_GET['type']=='adm_login'){
        $label='管理员';
    }
    else {
        $label='用户';
    }



//*************************       处理登录信息          ********************************

if ($_GET['action'] == 'login') {

	check_code($_POST['code'],$_SESSION['code']);
    
	//引入登录的函数库
	include ROOT_PATH.'includes/login.func.php';
    
	$login_info = array();
	$login_info['username'] = check_username($_POST['username'],2,20);
	$login_info['password'] = check_password($_POST['password'],6);
	$login_info['time'] = check_time($_POST['time']);
	//到数据库去验证
    if (!!$_rows = _fetch_array("SELECT user_id,user_identity,user_uniqid,user_username FROM users_table WHERE user_username='{$login_info['username']}' AND user_password='{$login_info['password']}'")) {
        _session_destroy();
        _setcookies($_rows['user_username'],$_rows['user_id'],$_rows['uniqid'],$login_info['time']);
        if($_rows['user_identity']>=2){
            setcookie('admin',true);
        }
        jump_page(null,'member.php');
    } else {
        _session_destroy();
        jump_page('用户名或者密码不正确','login.php');
    } 
}
?>


<?php 
	require ROOT_PATH.'includes/header.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>山东大学信息共享平台--登录</title>

<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/login.js"></script>
<link rel="stylesheet" href="styles/login.css" type="text/css" />

<div id="login">
	<h2><?php echo $label?>登录</h2>
	<form method="post" name="login" action="login.php?action=login">
		<dl>
			<dt></dt>
			<dd>用 户 名：<input type="text" name="username" class="text" /></dd>
			<dd>密 　码 :　<input type="password" name="password" class="text" /></dd>
			<dd style="width: 270px;">记住密码：<input type="radio" name="time" value="0" checked="checked" /> 不保留 <input type="radio" name="time" value="1" /> 一天 <input type="radio" name="time" value="2" /> 一周 <input type="radio" name="time" value="3" /> 一月</dd>
			<dd>验 证 码：<input type="text" name="code" class="text code"  /> <img src="code.php" id="code" /></dd>
			<dd style="margin-left:40px;"><input type="submit" value="登录" class="button" /></dd>
		</dl>
	</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.php';
?>

