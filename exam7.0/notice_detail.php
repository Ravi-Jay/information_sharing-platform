<?php


define('PASS_OK',true);
define('SCRIPT','notice_detail');
require dirname(__FILE__).'/includes/common.php';


?>

<?php 

if(!isset($_COOKIE["id"])){
    _alert_back("未登录！");
    jump_page("", "login.php");
}

//*****************************  删除本帖(级联删除数据库中它的评论)  ***********************

if(isset($_GET['delete1'])){
    $del=array();
    $del['id']=$_GET['delete1'];
    sql_query("delete from user_notices where notice_id ='{$del['id']}'");
    if(sql_affected_rows()==1){
        sql_query("delete from user_comment where notice_id='{$del['id']}'");
        jump_page("删除成功！", "information.php");
    }
    else{
        
        jump_page("删除失败！请重试。", "notice_detail.php?id=".$_GET['id']);
    }
}


//*******************************  删除回复    **************************************

if(isset($_GET['delete2'])){
    $delete=array();
    $delete['id']=$_GET['delete2'];
    sql_query("delete from user_comment where comment_id='{$delete['id']}'");
    if(sql_affected_rows()==1){
        sql_query("UPDATE user_notices SET comment_count=comment_count-1 WHERE notice_id='{$_GET['id']}'");
        jump_page("删除回复成功！", "notice_detail.php?id=".$_GET['id']);
    }
    else{
        jump_page("删除回复失败！", "information.php");
    }
}


//*********************************   添加关注    **********************************

if(isset($_GET['friend'])){
    
    $user_id=$_COOKIE['id'];
    $friend_id=$_GET['friend'];
    if(add_friend($user_id, $friend_id)){
        jump_page("添加关注成功！", "notice_detail.php?id=".$_GET['id']);
    }
    else{
        jump_page("添加关注失败！请重试。", "notice_detail.php?id=".$_GET['id']);
    }   
}


// ************************************处理回帖**********************************

if ($_GET['action'] == 'rearticle') {

    if (!!$_rows = _fetch_array("SELECT
                                            user_id
                                FROM
                                            users_table
                                WHERE
                                            user_username='{$_COOKIE['username']}'
                                LIMIT
                                            1")) {
        // 接受数据
        $_clean = array();
        $_clean['reid'] =$_POST["reid"];
        $_clean['title'] = $_POST['title'];
        $_clean['content'] = $_POST['cont'];
        $_clean['user_id'] = $_COOKIE['id'];
        $_clean['username'] = $_COOKIE['username'];
        $_clean = _mysql_string($_clean);
        // 写入数据库
        sql_query("INSERT INTO user_comment (
            notice_id,
            user_id,
            user_username,
            title,
            content,
            time
            )
            VALUES (
            '{$_clean['reid']}',
            '{$_clean['user_id']}',
            '{$_clean['username']}',
            '{$_clean['title']}',
            '{$_clean['content']}',
            NOW()
            )");
        if (sql_affected_rows() == 1) {
            sql_query("UPDATE user_notices SET comment_count=comment_count+1 WHERE  notice_id='{$_clean['reid']}'");
            jump_page('回帖成功！', 'notice_detail.php?id='.$_clean['reid']);
        } else {
    
            _alert_back('回帖失败！');
        }
    } else {
        _alert_back('非法登录！');
    }
}



//************************************处理&获得本贴的信息*****************************

if(isset($_GET["id"])){
    $notice=array();
    $notice["notice_id"]=$_GET["id"];
    $row=_fetch_array("select notice_id, time, theme, type, message,view_count, comment_count, user_id, user_username,user_face,user_sex,user_phone,user_email
        from user_notices natural join users_table
        where notice_id='{$notice["notice_id"]}'");
    $notice["time"]=$row["time"];
    $notice["theme"]=$row["theme"];
    $notice["face"]=$row["user_face"];
    $notice["sex"]=$row["user_sex"];
    $notice["email"]=$row["user_email"];
    $notice["phone"]=$row["user_phone"];
    $notice["user_id"]=$row["user_id"];
    $notice["username"]=$row["user_username"];
    $notice["type"]=$row["type"];
    $notice["content"]=$row["message"];
    $notice["view_count"]=$row["view_count"];
    $notice["comment_count"]=$row["comment_count"];
//************更新评论数****************
    if(!!$com=_fetch_array("select count(comment_id) as cou
                           from  user_comment 
                          where notice_id='{$notice['notice_id']}'")){
                      
        $notice['comment_count']=$com['cou'];
        sql_query("update user_notices 
                    set  comment_count='{$com['cou']}'
                    where notice_id='{$notice['id']}'");
    }
    
    
//************更新访问量****************
 
    sql_query("UPDATE user_notices SET view_count=view_count+1 WHERE  notice_id='{$notice['notice_id']}'");

//************获取评论数&分页***********
    global $_pagesize, $_pagenum, $_page;
    _page("SELECT comment_id FROM user_comment WHERE notice_id='{$notice["notice_id"]}'", 10);
    $_result = sql_query("SELECT  comment_id, user_id, user_username, title,content, time
        FROM   user_comment
        WHERE   notice_id ='{$notice["notice_id"]}'
        ORDER BY time ASC
        LIMIT $_pagenum,$_pagesize");
}
else{//*********没有得到帖子的id************************
    _alert_back("网页数据丢失！");
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="styles/notice_detail.css" type="text/css" />
<script type="text/javascript" src="js/notice_detail.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>山东大学信息共享平台--信息中心</title>

<?php 
	require ROOT_PATH.'includes/header.php';
?>
</head>
<body>
<div id="article">
	<h2>帖子详情</h2>
<?php 
if ($_page == 1) {
 //*******************************  原帖信息的显示   ******************************
    ?>
	<div id="subject">
			<dl>
				<dt>
					<img src="<?php echo $notice['face']?>"
						alt="<?php echo $notice['username']?>" />
				</dt>
				<dd class="user"><?php echo $notice["username"]?>(<?php echo $notice["sex"]?>)</dd>
				<?php if ($notice['user_id']!=$_COOKIE['id']){?>
				<dd class="message">
					<a href="javascript:;" name="message"
						title="<?php echo $notice["user_id"]?>">发消息</a>
				</dd>
				<dd class="friend">
					<a href="javascript:;" name="friend"
						title="id=<?php echo $notice['notice_id']?>&friend=<?php echo $notice['user_id']?>">添加关注</a>
				</dd>
                <?php }?>


				<dd class="email">
					邮件：<a href="mailto:<?php echo $notice['email']?>"><?php echo $notice['email']?></a>
				</dd>

			</dl>
			<div class="content">
				<div class="user">
					<span>

					<?php echo $notice['username']?> 1#
				</span><?php echo $notice["username"]?> | 发表于：<?php echo $notice['time']?>
				<span><?php 
				   if($notice['user_id']==$_COOKIE['id']){?>
				   	<a href="javascript:;" name="modify"
					title="id=<?php echo $notice['notice_id']?>" >修改</a>
				     <a style="padding-right: 10px;" href="javascript:;" name="delete1"
					title="id=<?php echo $notice['notice_id']?>&delete1=<?php echo $notice['notice_id']?>">删除</a>
				<?php } ?>
				</span>
			</div>
				<h3>标题：<?php echo $notice["theme"]?> </h3>
				<div class="detail">
				<?php echo trans_content($notice["content"]);?><!-- trans_content 对原帖进行翻译 -->
			</div>
				<div class="read">
				阅读量：(<?php echo $notice["view_count"]?>) 评论量：(<?php echo $notice['comment_count']?>)
			</div>
			</div>
		</div>
	<?php }?>
	
	
	<p class="line"></p>
	
	<?php
	
//******************************获取每条评论的信息&显示*******************************

$_i = 2;
while (!!$_rows = _fetch_array_list($_result)) {
    $commenter['user_id'] = $_rows['user_id'];
    $commenter['username'] = $_rows['user_username'];
    $commenter['comment_id'] = $_rows['comment_id'];
    $commenter['content'] = $_rows['content'];
    $commenter['time'] = $_rows['time'];
    $commenter['retitle'] = $_rows['title'];
    
    $commenter = _html($commenter);
    
    if (!!$_rows = _fetch_array("SELECT 
											user_sex,
											user_face,
											user_email,
											user_phone,
											user_qq
							       FROM 
							  				users_table 
						           WHERE 
											user_username='{$commenter['username']}'")) {
        // 提取用户信息
        $commenter['sex'] = $_rows['user_sex'];
        $commenter['face'] = $_rows['user_face'];
        $commenter['email'] = $_rows['user_email'];
        $commenter['phone'] = $_rows['user_phone'];
        $commenter['qq'] = $_rows['user_qq'];
        $commenter = _html($commenter);
        

    } else {
       _alert_back("该用户已不存在！");
    }
   
    ?>
	<div class="re">
			<dl>
				<dt>
					<img src="<?php echo $commenter['face']?>"
						alt="<?php echo $commenter['username']?>" />
				</dt>
				<dd class="user"><?php echo $commenter['username']?>(<?php echo $commenter['sex']?>)</dd>
				<?php if ($commenter['user_id']!=$_COOKIE['id']){?>
				<dd class="message">
					<a href="javascript:;" name="message"
						title="<?php echo $commenter['user_id']?>">发消息</a>
				</dd>
				<dd class="friend">
					<a href="javascript:;" name="friend"
						title="id=<?php echo $notice['notice_id']?>&friend=<?php echo $commenter['user_id']?>">添加关注</a>
				</dd>
				<?php }?>
				<dd class="email">
					邮件：<a href="mailto:<?php echo $commenter['email']?>"><?php echo $commenter['email']?></a>
				</dd>
			</dl>
			<div class="content">
				<div class="user">
					<span><?php echo $_i + (($_page-1) * $_pagesize);?>#</span><?php echo $commenter['username']?> | 发表于：<?php echo $commenter['time']?>
					<span><?php 
					   if($commenter['user_id']==$_COOKIE['id']){?>
					      <a href="javascript:;" name="delete"
						title="id=<?php echo $notice['notice_id']?>&delete2=<?php echo $commenter['comment_id']?>">删除</a>
					<?php } ?>
					</span>
			</div>
				<h3>标题：<?php echo $commenter['retitle']?></h3>
				<div class="detail">
				<?php echo trans_content($commenter["content"]);?>
			</div>
			</div>
		</div>
		<p class="line"></p>
	<?php
    $_i ++;
}
_free_result($_result);
_paging();
?>
	<?php 
//*****************************  评论框           *************************
	if(isset($_COOKIE['username'])) {
	?>
	<a name="ree"></a>
		<form id="form1" method="post" action="?action=rearticle" style="height: 300px;">
			<dl>
				<dd>标 题：
				<input type="text" name="title" class="text" value="RE  <?php echo $commenter['title']?>" /> (*必填，2-40位)
				<input type="hidden" name="reid" value="<?php echo $notice["notice_id"];?>"/>
				</dd>
				<dd>
				<input type="hidden" name="url" id="url" readonly="readonly" class="text" />
				<?php include ROOT_PATH.'includes/textinput.inc.php'?>
				<textarea name="cont" rows="9" ></textarea>
				</dd>
				<dd>
				<input type="submit" class="submit" value="发表回复" />
				</dd>
			</dl>
		</form>
	<?php 
     }
	?>
</div>			

<?php 
	require ROOT_PATH.'includes/footer.php';
?>
</body>
</html>
