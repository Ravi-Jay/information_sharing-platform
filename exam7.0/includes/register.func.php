<?php

//防止恶意调用
if (!defined('PASS_OK')) {
	exit('Access Defined!');
}

if (!function_exists('_alert_back')) {
	exit('_alert_back()函数不存在，请检查!');
}

if (!function_exists('_mysql_string')) {
	exit('_mysql_string()函数不存在，请检查!');
}
/**
 * check_level($post,$user_inf) 判断新增管理员的等级
 * 2=<$post<=$user_inf return true 
 */
function check_level($post,$user_inf){
    
    if($post>1&&$post<=$user_inf){
        return true;
    }
    else{
        return false;
    }
}



/**
 * check_uniqid 判断标识符是否一致
 * @param unknown_type $_first_uniqid
 * @param unknown_type $_end_uniqid
 */

function check_uniqid($_first_uniqid,$_end_uniqid) {
	
	if ((strlen($_first_uniqid) != 40) || ($_first_uniqid != $_end_uniqid)) {
		_alert_back('标识符不正确');
	}
	
	return _mysql_string($_first_uniqid);
}

/**
 * check_username 检查并过滤用户名
 * @param string $_string 用户名
 * @param int $_min_num  最小位数
 * @param int $_max_num 最大位数
 * @return string  
 */
function check_username($_string,$_min_num,$_max_num) {
	//去掉两边的空格
	$_string = trim($_string);
	
	//长度小于两位或者大于20位
	if (mb_strlen($_string,'utf-8') < $_min_num || mb_strlen($_string,'utf-8') > $_max_num) {
		_alert_back('用户名长度不得小于'.$_min_num.'位或者大于'.$_max_num.'位');
	}
	
	//将用户名转义输入
	return _mysql_string($_string);
}


/**
 * check_password 验证密码
 * @param string 第一次输入的密码
 * @param string 第二次输入的密码
 * @param int $_min_num 最小位数
 * @return string $_first_pass 返回一个利用sha1函数求哈希值加密后的密码
 */

function check_password($_first_pass,$_end_pass,$_min_num) {
	//判断密码
	if (strlen($_first_pass) < $_min_num) {
		_alert_back('密码不得小于'.$_min_num.'位！');
	}
	
	//密码和密码确认必须一致
	if ($_first_pass != $_end_pass) {
		_alert_back('密码和确认密码不一致！');
	}
	
	//将密码返回
	return sha1($_first_pass);
}
	
/**
 * check_question 返回密码提示
 * @access public
 * @param string $_string
 * @param int $_min_num
 * @param int $_max_num
 * @return string $_string 返回密码提示
 */

function check_question($_string,$_min_num,$_max_num) {
	$_string = trim($_string);
	//长度小于4位或者大于20位
	if (mb_strlen($_string,'utf-8') < $_min_num || mb_strlen($_string,'utf-8') > $_max_num) {
		_alert_back('密码提示不得小于'.$_min_num.'位或者大于'.$_max_num.'位');
	}
	
	//返回密码提示
	return _mysql_string($_string);
}

/**
 *check_answer() 检查密码提示  并且求哈希值返回
 * @param string $_answ
 * @param int $_min_num
 * @param int $_max_num
 * @return $_answ
 */
function check_answer($_answ,$_min_num,$_max_num) {
	$_answ = trim($_answ);
	//长度小于2位或者大于20位
	if (mb_strlen($_answ,'utf-8') < $_min_num || mb_strlen($_answ,'utf-8') > $_max_num) {
		_alert_back('密码答案不得小于'.$_min_num.'位或者大于'.$_max_num.'位');
	}
	//加密返回
	return _mysql_string(sha1($_answ));
}

/**
 * check_sex  检查性别 
 */

function check_sex($_string) {
	return _mysql_string($_string);
}
/**
 * check_identity  检查身份 直接返回转义后的字符串
 */

function check_identity($_string) {
    return _mysql_string($_string);
}

/**
 * check_face 头像
 */

function check_face($_string) {
	return _mysql_string($_string);
}

/**
 * check_email() 检查邮箱是否合法
 * @access public
 * @param string $_string 提交的邮箱地址
 * @return string $_string 验证后的邮箱
 */

function check_email($_string,$_min_num,$_max_num) {

	if (!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/',$_string)) {
		_alert_back('邮件格式不正确！');
	}
	if (strlen($_string) < $_min_num || strlen($_string) > $_max_num) {
		_alert_back('邮件长度不合法！');
	}
	return _mysql_string($_string);
}

/**
 * check_qq 
 */

function check_qq($_string) {
	if (empty($_string)) {
		return null;
	} else {
		if (!preg_match('/^[1-9]{1}[\d]{4,9}$/',$_string)) {
			_alert_back('QQ号码不正确！');
		}
	}
	
	return _mysql_string($_string);
}

/**
 * check_phone 检查手机号是否合法
 */
function check_phone($_string) {
    if (empty($_string)) {
        return null;
    } else {
        if (!preg_match('/^[0-9]{11}$/',$_string)) {
            _alert_back('手机号码不正确！');
        }
    }

    return _mysql_string($_string);
}

/**
 *   check_content  检查用户输入的发送内容
 *   转义后返回字符串
 */
function check_content($string){
    
    if(strlen($string)>500){
        _alert_back("发送内容太长，请分条发送！");
    }
    else 
        return _mysql_string($string);
}

?>