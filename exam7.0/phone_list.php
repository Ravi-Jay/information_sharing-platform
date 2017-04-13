<?php


define('PASS_OK',true);
define('SCRIPT','phone_list');
require dirname(__FILE__).'/includes/common.php';

if(!isset($_COOKIE['id'])){
    _alert_back("请登录！");
}
?>
<?php 
	require ROOT_PATH.'includes/header.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="styles/phone_list.css" type="text/css" />
<div id="information">
<?php 
    require ROOT_PATH.'includes/information.inc.php';
?>
	<div id="information_main">
	  <h2>电话查询</h2>
	  	<table>
	  		<tr style="font-size: 20px;height:40px"><th>部门</th><th>电话</th></tr>
	  		<tr><th>办公室</th><th>90031</th></tr>
	  		<tr><th>图书馆</th><th>90032</th></tr>
	  		<tr><th>物业</th><th>90033</th></tr>
	  		<tr><th>打印店</th><th>90034</th></tr>
	  		<tr><th>台球厅</th><th>90035</th></tr>
	  		<tr><th>人事部</th><th>90036</th></tr>
	  		<tr><th>财务部</th><th>90038</th></tr>
	  		<tr><th>医务室</th><th>90035</th></tr>
	  		<tr><th>学生会</th><th>90034</th></tr>
	  		<tr><th>纪检部</th><th>90036</th></tr>
			<tr><th>办公室</th><th>90031</th></tr>
	  		<tr><th>图书馆</th><th>90032</th></tr>
	  		<tr><th>物业</th><th>90033</th></tr>
	  		<tr><th>打印店</th><th>90034</th></tr>
	  		<tr><th>台球厅</th><th>90035</th></tr>
	  		<tr><th>人事部</th><th>90036</th></tr>
	  		<tr><th>财务部</th><th>90038</th></tr>
	  		<tr><th>医务室</th><th>90035</th></tr>
	  		<tr><th>学生会</th><th>90034</th></tr>
	  		<tr><th>纪检部</th><th>90036</th></tr>
	  	</table>
	  
    </div>
</div>

	
<?php 
	require ROOT_PATH.'includes/footer.php';
?>