<?php


//防止恶意调用
if (!defined('PASS_OK')) {
	exit('Access Defined!');
}



/**
 * _setcookies生成登录cookies
 * @param unknown_type $_username
 * @param unknown_type $_uniqid
 */


function _setcookies($_username,$_id,$uniqid,$_time) {
	switch ($_time) {
		case '0':  //浏览器进程
			setcookie('username',$_username);
			setcookie('uniqid',$uniqid);	
			setcookie('id',$_id);
			break;
		case '1':  //一天
			setcookie('username',$_username,time()+86400);
			setcookie('uniqid',$uniqid);
			setcookie('id',$_id,time()+86400);
			break;
		case '2':  //一周
			setcookie('username',$_username,time()+604800);
			setcookie('uniqid',$uniqid);
			setcookie('id',$_id,time()+604800);
			break;
		case '3':  //一月
			setcookie('username',$_username,time()+2592000);
			setcookie('uniqid',$uniqid);
			setcookie('id',$_id,time()+2592000);
			break;
	}
}

/**
 * check_username    验证用户名
 * @access public 
 * @param string $_string 输入用户名
 * @param int $_min_num  最小位数
 * @param int $_max_num 最大位数
 * @return string  转义用户名 
 */
function check_username($_string,$_min_num,$_max_num) {
	//去掉两边的空格
	$_string = trim($_string);
	
	if (mb_strlen($_string,'utf-8') < $_min_num || mb_strlen($_string,'utf-8') > $_max_num) {
		_alert_back('用户名长度不得小于'.$_min_num.'位或者大于'.$_max_num.'位');
	}
	
	//将用户名转义输入
	return _mysql_string($_string);
}


/**
 * _check_password  验证密码
 * @access public
 * @param string $_first_pass
 * @param int $_min_num
 * @return string $_first_pass 返回一个加密后的密码
 */

function check_password($_string,$_min_num) {
	//判断密码
	if (strlen($_string) < $_min_num) {
		_alert_back('密码不得小于'.$_min_num.'位！');
	}
	
	//将密码返回
	return sha1($_string);
}


function check_time($_string) {
	$_time = array('0','1','2','3');
	if (!in_array($_string,$_time)) {
		_alert_back('保留方式出错！');
	}
	return _mysql_string($_string);
}

?>