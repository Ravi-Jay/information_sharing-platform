<?php

//防止恶意调用
if (!defined('PASS_OK')) {
	exit('Access Defined!');
}
?>
<head >
<title>山东大学信息共享平台</title>
<link rel="stylesheet" href="styles/layout.css" type="text/css" />
<link rel="shortcut icon" href="images/shanda.ico" />

  <!--########################        wrapper row1       #########################-->
</head>
<body id="top"style="width: 1550px;">
<div class="wrapper row1">
  <div id="header" class="clear">
    <div class="fl_left">
      
      <h1>
      <a href="index.php" ><img alt="logo_header" src="images/logo_header.png" ></a></h1>

    </div>
    <div class="fl_right">
      <p><a href="login.php?type=adm_login">Administrator Login</a> | <a href="login.php">User Login</a></p>
      <form action="search.php?action=search" method="post" id="sitesearch">
        <fieldset>
          <legend>Site Search</legend>
          <input type="text" name="res" value="Search Our Website&hellip;" onfocus="this.value=(this.value=='Search Our Website&hellip;')? '' : this.value ;" />
          <input type="image" src="images/search.gif" id="search" alt="Search" />
        </fieldset>
      </form>
    </div>
    <div id="topnav">
      <ul>
        <li><a href="index.php">首页</a></li>
		<?php 
			if (isset($_COOKIE['username'])){
				echo '<li><a href="member.php">个人中心</a></li>';
				echo '<li><a href="information.php">信息中心</a></li>';
				echo '<li><a href="friends.php">我的关注</a></li>';
				echo '<li><a href="allusers.php">所有用户</a></li>';
				if(isset($_COOKIE['admin'])){
				    echo '<li><a href="admin_page.php">管理</a></li>';
				}
				echo '<li><a href="logout.php">退出</a></li>';
				echo "\n";
			} else {	
				echo '<li><a href="register.php">注册</a></li>';
				echo "\n";
				echo "\t\t";
				echo '<li><a href="login.php">登录</a></li>';
				echo "\n";
			}
// 			echo '<li><a href="logout.php">联系我们</a></li>';
// 			echo '<li></li>';
// 			echo '<li></li>';
		?>
		<li><a href="new_notice.php" ><img alt="logo_write" src="images/Write.png" style="width:20;height:20px;" ></a></li>
      </ul>
    </div>
  </div>
</div>
  <!--head end-->