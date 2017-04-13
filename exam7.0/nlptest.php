<?php
define('PASS_OK',true);
// define('SCRIPT','NLP');
require dirname(__FILE__).'/includes/common.php';


ini_set('memory_limit', '1024M');
require_once "./src/vendor/multi-array/MultiArray.php";
require_once "./src/vendor/multi-array/Factory/MultiArrayFactory.php";
require_once "./src/class/Jieba.php";
require_once "./src/class/Finalseg.php";


use Fukuball\Jieba\Jieba;
use Fukuball\Jieba\Finalseg;

Jieba::init();
Finalseg::init();

$seg_list = Jieba::cut("2017年4月9号的帖子");
var_dump($seg_list);

// $s=explode("年", "2015年");
// print_r($s);
// $s=_fetch_array("select date(time)as t from user_notices where notice_id=28");
// echo $s['t'];


?>