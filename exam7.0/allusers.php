<?php


define('PASS_OK',true);
define('SCRIPT','allusers');
require dirname(__FILE__).'/includes/common.php';


//*******************************  处理添加关注     *******************************

if($_GET['action'] == 'addfriend'){

    $info_friend=array();
    $info_friend['id']=$_GET['id'];
    if(!!$row=_fetch_array("select user_id from users_table where user_id='{$_COOKIE['id']}'")){
        if(!!$row2=_fetch_array("select user_id, user_username from users_table where user_id='{$info_friend['id']}'"))
        {
            if(!!$row3=_fetch_array("select relationship_id from user_friends where user_id='{$_COOKIE['id']}' and friend_id='{$info_friend['id']}'")){
                _alert_back("您已关注该用户！请勿重复关注。");
            }
            if($info_friend['id']==$_COOKIE['id']){
                _alert_back("不能关注自己！");
            }
            else{
                $info_friend['name']=$row2['user_username'];
                sql_query("insert into user_friends(user_id, user_username, friend_id, friend_username)
                    values('{$_COOKIE['id']}','{$_COOKIE['username']}', '{$info_friend['id']}','{$info_friend['name']}')");
                if(sql_affected_rows()==1){
                    jump_page("添加关注成功！", "allusers.php");
                }
                else{
                    jump_page("添加关注失败！请重试。", "allusers.php");
                }
            }

        }
        else{
            _alert_back("该用户已不存在！添加失败。");
        }
    }
    else{
        _alert_back("未登录！".$_COOKIE['id']);
        jump_page("", "login.php");
    }
}

//*********************************      访问用户的主页                *****************************

if($_GET['action']=='home'){
    $info=array();
    $info['id']=$_GET['id'];
    jump_page('', "friend_info.php?id=".$info['id']);
}



//**********   分页模块   ******************
global $_pagesize,$_pagenum,$page_type;
$page_type="table";
//***************   老师列表        **********
if($_GET["action"]== "tea_table"){
    $page_name="老师列表";
    $page_type="tea_table";
    _page("SELECT user_id FROM users_table where user_identity = 1 ",15);   //(总条数，每页多少条）
    $_result = sql_query("SELECT user_id,user_username,user_sex,user_face FROM users_table where user_identity = 1  ORDER BY user_reg_time DESC LIMIT $_pagenum,$_pagesize");
}
//************  学生列表    *****************
else if($_GET["action"]== "stu_table"){
    $page_name="学生列表";
    $page_type="stu_table";
    _page("SELECT user_id FROM users_table where user_identity = 0 ",15);   
    $_result = sql_query("SELECT user_id,user_username,user_sex,user_face FROM users_table where user_identity = 0  ORDER BY user_reg_time DESC LIMIT $_pagenum,$_pagesize");
}  
//************ 所有用户   ******************
else {
    $page_name="所有用户";
    $page_type="table";
    _page("SELECT user_id FROM users_table ",15);  
    $_result = sql_query("SELECT user_id, user_username,user_sex,user_face FROM users_table  ORDER BY user_reg_time DESC LIMIT $_pagenum,$_pagesize");
    
}
?>




<?php 
	require ROOT_PATH.'includes/header.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="styles/allusers.css" type="text/css" />
<script type="text/javascript" src="js/allusers.js"></script>

<title>山东大学信息共享平台--所有用户</title>
<div id="blog">
    <div id="user_table">
    <form method="post" name="tea_table" action="allusers.php?action=tea_table">
      <ul>
        <li><input type="submit" class="submit" value="老师列表"  onMouseOver="this.className='mover'" onMouseOut="this.className='mout'" /></li>       
      </ul>
     </form>
     <form method="post" name="tea_table" action="allusers.php?action=stu_table">
      <ul>
        <li><input type="submit" class="submit" value="学生列表"  onMouseOver="this.className='mover'" onMouseOut="this.className='mout'" /></li> 
      </ul>
     </form>
     <form method="post" name="tea_table" action="allusers.php?action=table">
      <ul>
        <li><input type="submit" class="submit" value="所有用户"  onMouseOver="this.className='mover'" onMouseOut="this.className='mout'" /></li> 
      </ul>
     </form>
   </div>
	<h2><?php echo $page_name;?></h2>
	<?php 
		while (!!$_rows = _fetch_array_list($_result)) {
			$user_info = array();
			$user_info['id'] = $_rows['user_id'];
			$user_info['username'] = $_rows['user_username'];
			$user_info['face'] = $_rows['user_face'];
			$user_info['sex'] = $_rows['user_sex'];
			$user_info = _html($user_info);
	?>
	<dl>
		<dt><img src="<?php echo $user_info['face']?>" alt="" /></dt>
		<dd class="user"><?php echo $user_info['username']?>(<?php echo $user_info['sex']?>)</dd>
		<dd class="message"><a href="javascript:;" name="message" title="<?php echo $user_info['id']?>">发送私信</a></dd>
		<dd class="guest"><a href="javascript:;" name="home" title="<?php echo $user_info['id']?>">他的主页</a></dd>
		<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $user_info['id']?>">添加关注</a></dd>
	</dl>
	<?php }
		_free_result($_result);
		_paging();
	?>


</div>

<?php 
	require ROOT_PATH.'includes/footer.php';
?>

