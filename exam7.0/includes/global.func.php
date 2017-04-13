<?php

/**
 * trans_content($_string) 对数据库中的帖子内容进行解析
 * 返回翻译后的$_string
 */

function trans_content($_string)
{
    $_string = nl2br($_string);
    $_string = preg_replace('/\[size=(.*)\](.*)\[\/size\]/U', '<span style="font-size:\1px">\2</span>', $_string);
    $_string = preg_replace('/\[b\](.*)\[\/b\]/U', '<strong>\1</strong>', $_string);
    $_string = preg_replace('/\[i\](.*)\[\/i\]/U', '<em>\1</em>', $_string);
    $_string = preg_replace('/\[u\](.*)\[\/u\]/U', '<span style="text-decoration:underline">\1</span>', $_string);
    $_string = preg_replace('/\[s\](.*)\[\/s\]/U', '<span style="text-decoration:line-through">\1</span>', $_string);
    $_string = preg_replace('/\[color=(.*)\](.*)\[\/color\]/U', '<span style="color:\1">\2</span>', $_string);
    $_string = preg_replace('/\[url\](.*)\[\/url\]/U', '<a href="\1" target="_blank">\1</a>', $_string);
    $_string = preg_replace('/\[img\](.*)\[\/img\]/U', '<img src="\1" alt="图片" />', $_string);
    return $_string;
}



/**
 * add_friend($user_id,$friend_id)是用来添加好友
 * @access pulblic 
 * @return bool：true 表示添加成功 ； false 表示失败
 */

function add_friend($user_id,$friend_id){
    $user_info=array();
    $friend_info=array();
    $user_info['id']=$user_id;
    $friend_info['id']=$friend_id;
    if($friend_id==$user_id){
        _alert_back("您不能关注自己！");
    }
    if(!!$row1=_fetch_array("select user_username from users_table where user_id=$user_id")){
        $user_info['name']=$row1['user_username'];
    }
    else{
        _alert_back("您的账号已不存在！");
    }
    if(!!$row2=_fetch_array("select user_username from users_table where user_id=$friend_id")){
        $friend_info['name']=$row2['user_username'];
    }
    else{
        _alert_back("该用户已不存在！");
    }    
    sql_query("insert into user_friends(user_id, user_username, friend_id, friend_username)
                values('{$user_info['id']}','{$user_info['name']}','{$friend_info['id']}','{$friend_info['name']}')");
    if(sql_affected_rows()==1){
        return true;
    }
    else{
        return false;
    }
}


/**
 *_runtime()是用来获取执行耗时
 * @access public  表示函数对外公开
 * @return float 表示返回出来的是一个浮点型数字
 */
function _runtime() {
	$_mtime = explode(' ',microtime());
	return $_mtime[1] + $_mtime[0];
}

/**
 * _alert_close() 关掉本页面
 */

function _alert_close($_info) {
    echo "<script type='text/javascript'>alert('$_info');window.close();</script>";
    exit();
}
/**
 * _alert_back()表是JS弹窗
 * @access public
 * @param $_info
 * @return void 弹窗
 */
function _alert_back($_info) {
	echo "<script type='text/javascript'>alert('$_info');history.back();</script>";
	exit();
}

/**
 * jump_page 页面跳转  如果$_info 为空，直接跳$_url 否则打印$_info后跳转
 * @param string $_info
 * @param string $_url
 */

function jump_page($_info,$_url) {
	if (!empty($_info)) {
		echo "<script type='text/javascript'>alert('$_info');location.href='$_url';</script>";
		exit();
	} else {
		header('Location:'.$_url);
	}
}

/**
 * if_login_state登录状态的判断
 */

function if_login_state() {
	if (isset($_COOKIE['username'])) {
		_alert_back('登录状态无法进行本操作！');
	}
}

/**
 * _html() 函数表示对字符串进行HTML过滤显示，如果是数组按数组的方式过滤，
 * 如果是单独的字符串，那么就按单独的字符串过滤
 * @param unknown_type $_string
 */


function _html($_string) {
	if (is_array($_string)) {
		foreach ($_string as $_key => $_value) {
			$_string[$_key] = _html($_value); 
		}
	} else {
		$_string = htmlspecialchars($_string);
	}
	return $_string;
}

/**
 * 
 * @param $_sql
 * @param $_size
 */

function _page($_sql,$_size) {
	//将里面的所有变量取出来，外部可以访问
	global $_page,$_pagesize,$_pagenum,$_pageabsolute,$_num;
	if (isset($_GET['page'])) {
		$_page = $_GET['page'];
		if (empty($_page) || $_page < 0 || !is_numeric($_page)) {
			$_page = 1;
		} else {
			$_page = intval($_page);
		}
	} else {
		$_page = 1;
	}
	$_pagesize = $_size;
	$_num = _num_rows(sql_query($_sql));
	if ($_num == 0) {
		$_pageabsolute = 1;
	} else {
		$_pageabsolute = ceil($_num / $_pagesize);
	}
	if ($_page > $_pageabsolute) {
		$_page = $_pageabsolute;
	}
	$_pagenum = ($_page - 1) * $_pagesize;
}


/**
 * _paging分页函数
 * @param $_type
 * @return 返回分页
 */

function _paging() {
	global $_page,$_pageabsolute,$_num;

		echo '<div id="page_text">';
		echo '<ul>';
		echo '<li>'.$_page.'/'.$_pageabsolute.'页 | </li>';
		echo '<li>共有<strong>'.$_num.'</strong>个 | </li>';
				if ($_page == 1) {
					echo '<li>首页 | </li>';
					echo '<li>上一页 | </li>';
				} else {
				    if(!isset($_SESSION['type_kind'])){
				        echo '<li><a href="'.SCRIPT.'.php">首页</a> | </li>';
					    echo '<li><a href="'.SCRIPT.'.php?page='.($_page-1).'">上一页</a> | </li>';				    
				    }
				    else{
				        echo '<li><a href="'.SCRIPT.'.php?type='.$_SESSION['type_kind'].'">首页</a> | </li>';
				        echo '<li><a href="'.SCRIPT.'.php?type='.$_SESSION['type_kind'].'&page='.($_page-1).'">上一页</a> | </li>';	
				    }
				}
				if ($_page == $_pageabsolute) {
					echo '<li>下一页 | </li>';
					echo '<li>尾页</li>';
				} else {
				    if(!isset($_SESSION['type_kind'])){
    					echo '<li><a href="'.SCRIPT.'.php?'.'page='.($_page+1).'">下一页</a> | </li>';
    					echo '<li><a href="'.SCRIPT.'.php?'.'page='.$_pageabsolute.'">尾页</a></li>';
				    }
				    else{
				        echo '<li><a href="'.SCRIPT.'.php?type='.$_SESSION['type_kind'].'&page='.($_page+1).'">下一页</a> | </li>';
				        echo '<li><a href="'.SCRIPT.'.php?type='.$_SESSION['type_kind'].'&page='.$_pageabsolute.'">尾页</a></li>';
				        
				    }
				}
		echo '</ul>';
		echo '</div>';
}
/**
 *  search_paging()用于搜索结果的分页
 */
function search_paging() {
    global $_page,$_pageabsolute,$_num;

    echo '<div id="page_text">';
    echo '<ul>';
    echo '<li>'.$_page.'/'.$_pageabsolute.'页 | </li>';
    echo '<li>共有<strong>'.$_num.'</strong>个 | </li>';
    if ($_page == 1) {
        echo '<li>首页 | </li>';
        echo '<li>上一页 | </li>';
    } else {
            echo '<li><a href="'.SCRIPT.'.php?">首页</a> | </li>';
            echo '<li><a href="'.SCRIPT.'.php?page='.($_page-1).'">上一页</a> | </li>';

    }
    if ($_page == $_pageabsolute) {
        echo '<li>下一页 | </li>';
        echo '<li>尾页</li>';
    } else {
            echo '<li><a href="'.SCRIPT.'.php?'.'page='.($_page+1).'">下一页</a> | </li>';
            echo '<li><a href="'.SCRIPT.'.php?'.'page='.$_pageabsolute.'">尾页</a></li>';
    }
    echo '</ul>';
    echo '</div>';
}


/**
 * _Session_destroy 删除session
 */

function _Session_destroy() {
	session_destroy();
}

/**
 * 删除cookies   _unsetcookies()
 */

function _unsetcookies() {
	setcookie('username','',time()-1);
	setcookie('uniqid','',time()-1);
	setcookie('id','',time()-1);
	if(isset($_COOKIE['admin'])){
	    setcookie('admin','',time()-1);
	}
	_Session_destroy();
	jump_page(null,'index.php');
}


/**
 * 
 */

function _sha1_uniqid() {
	return _mysql_string(sha1(uniqid(rand(),true)));
}

/**
 * _mysql_string 转义输入的内容返回
 * @param string $_string
 * @return string $_string
 */

function _mysql_string($_string) {
	//get_magic_quotes_gpc()如果开启状态，那么就不需要转义
	if (!GPC) {
		return mysql_real_escape_string($_string);
	} 
	return $_string;
}


/**
 * check_code
 * @param string $_first_code
 * @param string $_end_code
 * @return void 验证码比对
 */

function check_code($_first_code,$_end_code) {
	if ($_first_code != $_end_code) {
		_alert_back('验证码不正确!');
	}
}

/**
 * _code()是验证码函数
 * @access public 
 * @param int $_width 表示验证码的长度
 * @param int $_height 表示验证码的高度
 * @param int $_rnd_code 表示验证码的位数
 * @param bool $_flag 表示验证码是否需要边框 
 * @return void 这个函数执行后产生一个验证码
 */
function _code($_width = 75,$_height = 25,$_rnd_code = 4,$_flag = false) {
	
	//创建随机码
	for ($i=0;$i<$_rnd_code;$i++) {
		$_nmsg .= dechex(mt_rand(0,15));
	}
	
	//保存在session
	$_SESSION['code'] = $_nmsg;
	
	//创建一张图像
	$_img = imagecreatetruecolor($_width,$_height);
	
	//白色
	$_white = imagecolorallocate($_img,255,255,255);
	
	//填充
	imagefill($_img,0,0,$_white);
	
	if ($_flag) {
		//黑色,边框
		$_black = imagecolorallocate($_img,0,0,0);
		imagerectangle($_img,0,0,$_width-1,$_height-1,$_black);
	}
	
	//随即画出6个线条
	for ($i=0;$i<6;$i++) {
		$_rnd_color = imagecolorallocate($_img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
		imageline($_img,mt_rand(0,$_width),mt_rand(0,$_height),mt_rand(0,$_width),mt_rand(0,$_height),$_rnd_color);
	}
	
	//随即雪花
	for ($i=0;$i<100;$i++) {
		$_rnd_color = imagecolorallocate($_img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
		imagestring($_img,1,mt_rand(1,$_width),mt_rand(1,$_height),'*',$_rnd_color);
	}
	
	//输出验证码
	for ($i=0;$i<strlen($_SESSION['code']);$i++) {
		$_rnd_color = imagecolorallocate($_img,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200));
		imagestring($_img,5,$i*$_width/$_rnd_code+mt_rand(1,10),mt_rand(1,$_height/2),$_SESSION['code'][$i],$_rnd_color);
	}
	
	//输出图像
	header('Content-Type: image/png');
	imagepng($_img);
	
	//销毁
	imagedestroy($_img);
}












?>