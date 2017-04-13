<?php

session_start();
//定义个常量，用来授权调用includes里面的文件
define('PASS_OK',true);
//引入公共文件

require dirname(__FILE__).'/includes/common.php'; 

//运行验证码函数
_code();

?>