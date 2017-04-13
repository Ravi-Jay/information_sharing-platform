<?php


define('PASS_OK',true);
define('SCRIPT','notice_detail');
require dirname(__FILE__).'/includes/common.php';


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="styles/notice_detail.css" type="text/css" />
<script type="text/javascript" src="js/notice_detail.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>山东大学信息共享平台--信息中心</title>

</head>
<body>
<div id="article">

	
	<?php if(isset($_COOKIE['username'])) {?>
	<a name="ree"></a>
		<form method="post" action="?action=rearticle">
			<input type="hidden" name="reid" value="<?php echo $_html['reid']?>" />
			<input type="hidden" name="type" value="<?php echo $_html['type']?>" />
			<dl>
				<dd>
					标 题：<input type="text" name="title" class="text"
						value="RE:<?php echo $_html['title']?>" /> (*必填，2-40位)
				</dd>
				<dd id="q">
					贴 图： <a href="javascript:;">Q图系列[1]</a> <a href="javascript:;">Q图系列[2]</a>
					<a href="javascript:;">Q图系列[3]</a>
				</dd>
				<dd>
				<?php include ROOT_PATH.'includes/textinput.inc.php'?>
				<textarea name="cont" rows="9"></textarea>
				</dd>

				<dd>
			<?php if (!empty($_system['code'])) {?>
			验 证 码：
			<input type="text" name="code" class="text yzm" /> <img
						src="code.php" id="code" /> 
			<?php }?>
			<input type="submit" class="submit" value="发表帖子" />
				</dd>
			</dl>
		</form>
	<?php }?>
</div>			

<?php 
	require ROOT_PATH.'includes/footer.php';
?>
</body>
</html>
