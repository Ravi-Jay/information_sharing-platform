<?php

//防止恶意调用
if (!defined('PASS_OK')) {
	exit('Access Defined!');
}
DB_close(); //关闭数据库
?>
<link rel="stylesheet" href="styles/layout.css" type="text/css" />
<!-- ######################################    wrapper row4       ########################################## -->
<div class="wrapper row4">
  <div id="footer" class="clear">
    <!-- ####################################################################################################### -->
    <div class="footbox">
      <h2>网址导航</h2>
      <ul>
        <li><a href="#">&raquo; 山大主页</a></li>
        <li><a href="#">&raquo; 研究生院</a></li>
        <li><a href="#">&raquo; 本科生院</a></li>
        <li><a href="#">&raquo; 山大教务系统</a></li>
      </ul>
    </div>
    <div class="footbox">
      <h2>联系我们</h2>
      <address>
	    山东大学计算机学院<br />
             基地班<br />
      Ravi<br />
      <br />
      Tel: 123456789<br />
      Email: <a href="#">ravi_jay@163.com</a>
      </address>
    </div>
    <div class="fl_right">
      <div id="social">
        <h2>山东大学</h2>
        <ul>
          <br> 山东大学计算机学院<br/>
                     基地班<br/>
          Ravi<br/>
          <br/>
          Tel: 123456789<br />
          Email: <a href="#">ravi_jay@163.com</a>
        </ul>
      </div>
    </div>
    <!-- ####################################################################################################### -->
  </div>
</div>
<!-- ####################################################################################################### -->
<div class="wrapper">
  <div id="copyright" class="clear">
    <p class="fl_left">Copyright &copy; 2017 - All Rights Reserved - <a href="#">Ravi</a></p>
  </div>
</div>