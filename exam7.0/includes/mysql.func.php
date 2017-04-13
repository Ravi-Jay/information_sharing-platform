<?php


//防止恶意调用
if (!defined('PASS_OK')) {
	exit('Access Defined!');
}


/**
 * MySql_connect() 连接MYSQL数据库
 */

function _MySql_connect() {
	//global 表示全局变量的意思，意图是将此变量在函数外部也能访问
	global $_conn;
	if (!$_conn = @mysql_connect(DB_HOST,DB_USER,DB_PWD)) {
		exit('数据库连接失败');
	}
}

/**
 * Select_DB  选择所用的数据库
 */

function Select_DB() {
	if (!mysql_select_db(DB_NAME)) {
		exit('找不到指定的数据库');
	}
}

/**
 * Set_UTF8 设置字符集为UTF8
 */

function Set_UTF8() {
	if (!mysql_query('SET NAMES UTF8')) {
		exit('字符集错误');
	}
}

/**
 * sql_query 用sql语句进行查询
 * @param $_sql sql语句
 * 返回查询的结果集
 */

function sql_query($_sql) {
	if (!$_result = mysql_query($_sql)) {
		exit('SQL执行失败'.mysql_error());
	}
	return $_result;
}


/**
 * if_is_repeat 判断是否在数据库中存在
 * @param $_sql sql查询语句
 * @param $_info 若存在 打印给用户的信息
 */

function if_is_repeat($_sql,$_info) {
    if (_fetch_array($_sql)) {
        _alert_back($_info);
    }
}
/**
 * _fetch_array只能获取指定数据集一条数据组
 * @param $_sql
 */

function _fetch_array($_sql) {
	return mysql_fetch_array(sql_query($_sql),MYSQL_ASSOC);
}

/**
 * _fetch_array_list可以返回指定数据集的所有数据
 * @param $_result
 */

function _fetch_array_list($_result) {
	return mysql_fetch_array($_result,MYSQL_ASSOC);
}

function _num_rows($_result) {
	return mysql_num_rows($_result);
}


/**
 * sql_affected_rows 表示上一条sql语句执行影响到的记录数
 */

function sql_affected_rows() {
	return mysql_affected_rows();
}

/**
 * _free_result销毁结果集
 * @param $_result
 */

function _free_result($_result) {
	mysql_free_result($_result);
}





function DB_close() {
	if (!mysql_close()) {
		exit('关闭异常');
	}
}








?>