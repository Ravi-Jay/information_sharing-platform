<?php


define('PASS_OK',true);
define('SCRIPT','admin_notices');
require dirname(__FILE__).'/includes/common.php';



//***********   是否是管理员登录

if (isset($_COOKIE['admin'])) {
	//获取messages数据
    //分页模块
    global $_pagesize,$_pagenum;
    _page("SELECT notice_id FROM user_notices",9);   //获取所有的notice
	$result = sql_query("SELECT    notice_id, time,type,theme, message, user_id 
	                     FROM      user_notices 
	                    ORDER BY   time DESC  
                         LIMIT     $_pagenum,$_pagesize");	
} else {
    _alert_back('非法访问');
}


//*******************************  删除消息    **********************************

if ($_GET['action'] == 'delete' && isset($_POST['ids'])) {
    $delete_list = array();
    $delete_list['ids'] = _mysql_string(implode(',',$_POST['ids']));
 
    if (!!$_rows = _fetch_array("SELECT
                                           user_id
                                 FROM
                                           users_table
                                 WHERE
                                           user_username='{$_COOKIE['username']}'"
    )) {
        sql_query("DELETE FROM   user_notices
                          WHERE  notice_id
                           IN    ({$delete_list['ids']})"
        );
        if (sql_affected_rows()) {
            jump_page('删除成功！','admin_notices.php');
        } else {
            _alert_back('删除失败！');
        }
    } else {
        _alert_back('非法登录,不存在此用户！');
    }
}


?>

<?php 
	require ROOT_PATH.'includes/header.php';
?>
<link rel="stylesheet" href="styles/my_notice.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<html>
<body>

<script type="text/javascript" src="js/my_notice.js"></script>
<div id="member">
<?php 
	require ROOT_PATH.'includes/admin_inc.php';
?>
	<div id="member_main">
		<h2>所有帖子</h2>
		
		<form id="form1" method="post" action="?action=delete">
		<table cellspacing="1">
			<tr><th>标题</th><th>分类</th><th>内容</th><th>时间</th><th>操作</th></tr>
			<?php 
			     require dirname(_FILE_).'/includes/check.inc.php';
				while (!!$_rows = _fetch_array_list($result)) {
			         
					$messages = array();
					$messages['id'] = $_rows['notice_id'];
					$messages['type'] = check_type($_rows['type']);
					$messages['theme'] = check_notice_title($_rows['theme']);
					$messages['content'] = check_notice_concent1($_rows['message']);
					$messages['time'] = $_rows['time'];
					$messages = _html($messages);
					
			?>
			<tr><td><a href="notice_detail.php?id=<?php echo $messages['id']?>" title="<?php echo $messages['theme']?>"><?php echo $messages['theme']?></a></td>
			<td><?php echo $messages['type']?></td>
			<td><a href="notice_detail.php?id=<?php echo $messages['id']?>" title="<?php echo $messages['theme']?>"><?php echo $messages['content']?></a></td>
			<td><?php echo $messages['time']?></td>
			<td><input type="checkbox" name="ids[]" value="<?php echo $messages['id']?> " id="one"/></td></tr>
			<?php 
				}
				_free_result($result);
			?>
			<tr><td colspan="5"><label for="all">全选 <input type="checkbox" name="chkall" id="all" /></label> <input type="submit" value="批删除" /></td></tr>
		</table>
		</form>
		<?php _paging();?>
	</div>
</div>
<?php 
	require ROOT_PATH.'includes/footer.php';
?>
</body>
</html>

