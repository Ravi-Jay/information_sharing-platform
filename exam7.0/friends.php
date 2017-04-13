<?php

//******************************   引入公共文件               ***********************

define('PASS_OK',true);
define('SCRIPT','friends');
require dirname(__FILE__).'/includes/common.php';



//******************************    取消用户的关注      **********************

if($_GET['action']=='delete'){
    if(isset($_COOKIE['id'])){//检查已登录
        $info_friend=array();
        $info_friend['id']=$_GET['id'];
        if(!!_fetch_array("select friend_id from user_friends where user_id='{$_COOKIE['id']}'and friend_id='{$info_friend['id']}'"))
        {//检查还关注此用户
            sql_query("delete from user_friends
                        where user_id='{$_COOKIE['id']}'and friend_id='{$info_friend['id']}'");
            if(sql_affected_rows()){
                jump_page("取消关注成功！", "friends.php");
            }
            else{
                jump_page("取消关注失败!请重新操作。", "friends.php");
            }
        }
        else{
            jump_page("您未关注该用户！", "friends.php");
        }
    }
    else{
        jump_page("未登录！", "login.php");
    }
}

//*********************************      访问用户的主页                *****************************

if($_GET['action']=='home'){
    $info=array();
    $info['id']=$_GET['id'];
    jump_page('', "friend_info.php?id=".$info['id']);
}



//*************************************   分页模块     *********************************

global $_pagesize,$_pagenum;
_page("SELECT friend_id FROM user_friends where user_id='{$_COOKIE['id']}'",10);   //(总条数，每页多少条）
$_result = sql_query("SELECT friend_id, friend_username, user_sex,user_face,user_email,user_phone
                       FROM user_friends,users_table 
                       where user_friends.user_id='{$_COOKIE['id']}' and user_friends.friend_id=users_table.user_id
                       LIMIT $_pagenum,$_pagesize");

?>




<?php 
	require ROOT_PATH.'includes/header.php';
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="styles/friends.css" type="text/css" />
<script type="text/javascript" src="js/sender.js"></script>

<title>山东大学信息共享平台--好友</title>
<body>
<div id="blog">
	<h2>好友列表</h2>
	<?php 
		while (!!$_rows = _fetch_array_list($_result)) {
			$user_info = array();
			$user_info['id'] = $_rows['friend_id'];
			$user_info['username'] = $_rows['friend_username'];
			$user_info['face'] = $_rows['user_face'];
			$user_info['sex'] = $_rows['user_sex'];
			$user_info = _html($user_info);
	?>
	<dl>
		<dt><img src="<?php echo $user_info['face']?>" alt="" /></dt>
		<dd class="user"><?php echo $user_info['username']?>(<?php echo $user_info['sex']?>)</dd>
		<dd class="message"><a href="javascript:;" name="message" title="<?php echo $user_info['id']?>">发送私信</a></dd>
		<dd class="guest"><a href="javascript:;" name="home" title="<?php echo $user_info['id']?>">他的主页</a></dd>
		<dd class="guest"><a href="javascript:;" name="deletefriend" title="<?php echo $user_info['id']?>">取消关注</a></dd>
	</dl>
	<?php }
		_free_result($_result);//释放结果集
		_paging();
	?>


</div>

</body>
<?php 
	require ROOT_PATH.'includes/footer.php';
?>

