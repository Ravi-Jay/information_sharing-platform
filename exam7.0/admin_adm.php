<?php

session_start();
define('PASS_OK', true);
define('SCRIPT', 'admin_adm');
require dirname(__FILE__) . '/includes/common.php';


//*****************************   判断身份    ***********************
if(!isset($_COOKIE['admin']))
{
    _alert_back("无权访问！");
}
else{
    $info=_fetch_array("select user_identity from users_table where user_id='{$_COOKIE['id']}'");
    
}
//****************************    执行删除管理员的操作       ***************************

if($_GET['action']=='delete'){
    
    $del=array();
    $del['id']=$_GET['id'];
    if(!!_fetch_array("select * from users_table where user_id='{$del['id']}'")){
        sql_query("delete from users_table where user_id ='{$del['id']}'");
        if(sql_affected_rows()==1){
            jump_page('删除成功！', 'admin_users.php');
        }
        else{
            jump_page('删除失败！请重试。', 'admin_users.php');
        }
    }
    else{
        _alert_back("已不存在该用户数据。");
    }
}

//*************************************  分页模块         ***********************

global $_pagesize, $_pagenum;
_page("SELECT user_id FROM users_table where user_identity>1", 11);
$_result = sql_query("SELECT 	user_id,	user_username,	user_identity,	user_reg_time
					  FROM    users_table
                      WHERE   user_identity>1
				      ORDER BY  	user_reg_time DESC  
                      LIMIT  	$_pagenum,$_pagesize");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="styles/admin_users.css" type="text/css" />

<script type="text/javascript" src="js/admin_users.js"></script>
<?php
require ROOT_PATH . 'includes/header.php';
?>
</head>

<body>
<div id="member">
<?php
require ROOT_PATH . 'includes/admin_inc.php';
?>
	<div id="member_main">
		<h2>用户列表</h2>
		<form method="post" action="?action=delete">
			<table cellspacing="1">
				<tr>
					<th>ID</th>
					<th>管理员</th>
					<th>等级</th>
					<th>注册时间</th>
					<th>操作</th>
				</tr>
<?php
$_html = array();
while (! ! $_rows = _fetch_array_list($_result)) {
    $_html['id'] = $_rows['user_id'];
    $_html['username'] = $_rows['user_username'];
    $_html['identity'] = $_rows['user_identity'];
    $_html['reg_time'] = $_rows['user_reg_time'];
    $_html = _html($_html);
    ?>
			<tr>
					<td><?php echo $_html['id']?></td>
					<td><?php echo $_html['username']?></td>
					<td><?php echo $_html['identity']?></td>
					<td><?php echo $_html['reg_time']?></td>
					<?php if ($info['user_identity']>$_html['identity']){ echo '<td>[<a href="javascript:;" name="delete"
					title="action=delete&id='.$_html['id'].'">删除</a>]</td>';}
                     else{
                         echo '<td></td>';
                     }?>
												
			</tr>
	<?php }?>
	</table>
	</form>
                <input type="button" class="button" title="level=<?php echo $info['user_identity'];?>" value="添加管理员" id="add" />         
	
		<?php
    _free_result($_result);
    _paging();
		?>
	</div>
</div>

<?php 
	require ROOT_PATH.'includes/footer.php';
?>
</body>
</html>

