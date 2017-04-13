<?php

//防止非法调用
if (!defined('PASS_OK')) {
	exit('Access Defined!');
}


define('ROOT_PATH',substr(dirname(__FILE__),0,-8));


/**
 * check_theme($str) 检查str标题，转义后返回
 * @param unknown $str
 * return string
 */
function check_theme($str){
    $res=trim($str);
    if(strlen($res)==0||strlen($res)>120){
        _alert_back("标题长度大于30！");
    }
    return _mysql_string($res);
    
}

/**
 * check_keys($str) 检查str关键词，转义后返回一个数组
 * @param unknown $str
 * return array();
 */
function check_keys($str){
    $res=trim($str);
    $result=_mysql_string(explode(' ',$res));
    return $result;
}

/**
 * check_selection($str) 检查str分类，转义后返回
 * @param unknown $str
 * return string
 */
function check_selection($str){
    return _mysql_string($str);
}
/**
 * check_message($str) 检查str正文，转义后返回
 * @param unknown $str
 * return string
 */
function check_message($str){
    $res=$str;
    if(strlen($res)==0||strlen($res)>2000){
        _alert_back("正文为空或者长度大于500！");
    }
    return _mysql_string($res);
}

/**
 * check_type($str) 检查帖子的分类 返回他的类型
 * @param unknown $str
 * return string
 */
function check_type($str){
    $res="";
    switch ($str){
        case "study": 
            $res="学习交流";
            break;
        case "resource":
            $res="资源分享";
            break;           
        case "news":
            $res="趣闻轶事";
            break;          
        case "lost":
            $res="失物招领";
            break;
        case "school_news":
            $res="校务资讯";
            break;
        case "teacher_news":
            $res="教师信息";
            break;
        default:
            $res="ERROR.";
    }
    return $res;
}
/**
 * check_notice_concent($str) 对帖子截取前一部分显示
 * @param unknown $str
 * return string
 */
function check_notice_concent($str){
    $res=$str;
    if(mb_strlen($res)>84){
       $res=mb_substr($str,0,84);
    }
    return $res;
}
function check_notice_concent1($str){
    $res=$str;
    if(mb_strlen($res)>50){
        $res=mb_substr($str,0,45);
    }
    return $res;
}
function check_notice_title($str){
    $res=$str;
    if(mb_strlen($res)>30){
        $res=mb_substr($str,0,30);
    }
    return $res;
}
/**
 * check_teacher_notice($str) 对帖子截取前一部分显示
 * @param unknown $str
 * return string
 */
function check_teacher_notice($str){
    $res=$str;
    if(mb_strlen($res)>39){
        $res=mb_substr($str,0,39);
    }
    return $res;
}

/**
 * simplify_content($str) 对帖子截取前一部分在信息中心显示
 * @param unknown $str
 * return string
 */
function simplify_content($str){
    $res=$str;
    if(strlen($res)>200){
        $res=substr($str,0,200);
    }
    return $res;
}


?>