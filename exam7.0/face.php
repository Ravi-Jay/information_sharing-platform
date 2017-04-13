<?php

//定义个常量，用来授权调用includes里面的文件
define('PASS_OK',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','face');
//引入公共文件
require dirname(__FILE__).'/includes/common.php';


// 执行上传图片功能
if ($_GET['action'] == 'up') {

        // 设置上传图片的类型
        $_files = array(
            'image/jpeg',
            'image/pjpeg',
            'image/png',
            'image/x-png',
            'image/gif'
        );

        // 判断类型是否是数组里的一种

        if (! in_array($_FILES['userfile']['type'], $_files)) {
            _alert_back('上传图片必须是jpg,png,gif中的一种！');
        }

        // 判断文件错误类型
        if ($_FILES['userfile']['error'] > 0) {
            switch ($_FILES['userfile']['error']) {
                case 1:
                    _alert_back('上传文件超过约定值1');
                    break;
                case 2:
                    _alert_back('上传文件超过约定值2');
                    break;
                case 3:
                    _alert_back('部分文件被上传');
                    break;
                case 4:
                    _alert_back('没有任何文件被上传！');
                    break;
            }
            exit();
        }

        // 判断配置大小
        if ($_FILES['userfile']['size'] > 1000000) {
            _alert_back('上传的文件不得超过1M');
        }

        // 获取文件的扩展名 1.jpg
        $_n = explode('.', $_FILES['userfile']['name']);
        $_name = $_POST['dir'].'/'.time().'.'.$_n[1];

        // 移动文件
        if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
            if (! @move_uploaded_file($_FILES['userfile']['tmp_name'], $_name)) {
                _alert_back('移动失败');
            } else {
                // _alert_close('上传成功！');
                echo "<script>
                window.opener.document.getElementById('faceimg').src = '$_name';
	            opener.document.member_main.face.value = '$_name';
                alert('上传成功！');
                window.close();
                </script>";
                exit();
            }
        } else {
            _alert_back('上传的临时文件不存在！');
        }
 
}




?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>头像选择</title>

<link rel="stylesheet" href="styles/face1.css" type="text/css" />

<script type="text/javascript" src="js/opener.js"></script>
</head>
<body>

<div id="face">
	<h3>头像选择</h3>
	<div class="face">
 		<p></p>
  	</div>

		<form id="formx"enctype="multipart/form-data" action="?action=up" method="post">
			<input type="hidden" name="MAX_FILE_SIZE" value="1000000" /> <input
				type="hidden" name="dir" value="face" />
  			<input type="file" name="userfile" id="fileToUpload" onchange="fileSelected()" style="display:none;">
  			
 		</form>
	<dl>
		<dd><img class="normalFace" src="images/up_pho.png" onclick="fileSelect();"></dd>
		<?php foreach (range(1,35) as $num) {?>
		<dd><img src="face/t<?php echo $num?>.jpg" alt="face/t<?php echo $num?>.jpg" title="头像<?php echo $num?>" /></dd>
		<?php }?>
	</dl>

</div>

  	<script type="text/javascript">
        function fileSelect() {
            document.getElementById("fileToUpload").click(); 
        }
        function fileSelected() {
            document.getElementById("formx").submit(); 
        }
  </script>
</body>

