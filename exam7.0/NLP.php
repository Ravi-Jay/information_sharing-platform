<?php
define('PASS_OK',true);
define('SCRIPT','NLP');
// require dirname(__FILE__).'/includes/common.php';


ini_set('memory_limit', '1024M');
require_once "./src/vendor/multi-array/MultiArray.php";
require_once "./src/vendor/multi-array/Factory/MultiArrayFactory.php";
require_once "./src/class/Jieba.php";
require_once "./src/class/Finalseg.php";


use Fukuball\Jieba\Jieba;
use Fukuball\Jieba\Finalseg;

Jieba::init();
Finalseg::init();

// $seg_list = Jieba::cut("我来到北京清华大学");
// var_dump($seg_list);

// $seg_list = Jieba::cut("我来到北京清华大学", true);
// var_dump($seg_list); #全模式

// $content="高数第五章导数题";
// $seg_list = Jieba::cut($content);
// NLP_search("作者是杰Sir在2017年4月8日的标题为高数");
function NLP_search($string){
    
    $notice_list1=array();
    $notice_list2=array();
    $notice_list3=array();
    
    $seg_list = Jieba::cut($string);
// var_dump($seg_list); #全模式
    
    $or=0;
    $author=0;
    $date=0;
    $date_loc=0;
    $date_type=0;
    for($i=0;$i<sizeof($seg_list);$i++){
        if($seg_list[$i]=='或'||$seg_list[$i]=='或者'){
            $or=1;
        }
        if($seg_list[$i]=='作者'||$seg_list[$i]=='写的'||$seg_list[$i]=='写'||$seg_list[$i]=='发布'){
            $author=1;
        }
        if($seg_list[$i]=='日'||$seg_list[$i]=='号'||$seg_list[$i]=='月'||$seg_list[$i]=='年')
        {
            $date=1;
            if($seg_list[$i]=='年'){
                $seg_list[$i]='';
                $date_loc=$i-1;
            }
            else if($seg_list[$i]=='月'){
                $seg_list[$i]='';
                if($i-3>=0&&$date_loc==$i-3){
                    $seg_list[$i-3]=$seg_list[$i-3].'-';
                    if($seg_list[$i-1]<10){
                        $seg_list[$i-3] =$seg_list[$i-3]."0".$seg_list[$i-1];
                    
                    }else {
                        $seg_list[$i-3] =$seg_list[$i-3].$seg_list[$i-1];
                    }
                    $seg_list[$i-1]='';
                    $date_type=2;
                }
                else{
                    $date_loc=$i-1;
                }
            }else if($seg_list[$i]=='日'||$seg_list[$i]=='号'){
                $seg_list[$i]=''; 
                if($i-3>=0&&$date_loc==$i-3){
                    $seg_list[$i-3]=$seg_list[$i-3].'-';
                    if($seg_list[$i-1]<10){
                        $seg_list[$i-3] =$seg_list[$i-3]."0".$seg_list[$i-1];
                    }else {
                         $seg_list[$i-3] =$seg_list[$i-3].$seg_list[$i-1];
                    }
                    $seg_list[$i-1]='';
                    $date_type=1;
                }
                else if($i-5>=0&&$date_loc==$i-5){
                    $seg_list[$i-5] =$seg_list[$i-5].'-';
                    if($seg_list[$i-1]<10){
                        $seg_list[$i-5] =$seg_list[$i-5]."0".$seg_list[$i-1];
                    
                    }else {
                        $seg_list[$i-5] =$seg_list[$i-5].$seg_list[$i-1];
                    }
                    $seg_list[$i-1]='';
                    $seg_list[$i]='';
                    $date_type=1;
                }
                else{
                    $date_loc=$i-1;
                }
            }
            
        }
        
    }    
    
    if(!!$result1=sql_query("select label,notice_id from notice_label")){
         
        while(!!$rows1=_fetch_array_list($result1)){
            $label=array();
            $label['label']=$rows1['label'];
            $label['notice_id']=$rows1['notice_id'];
            
            for($i=0;$i<sizeof($seg_list);$i++){
                if($seg_list[$i]==''){continue;}
                if($label['label']==$seg_list[$i]){
                    $id=$label['notice_id'];
//                     echo "id:".$id.'<br>';
                    $notice_list1[$id]+=10;
                }
            }
        }
    }
//     if(!!$result2=sql_query("select notice_id , theme from user_notices")){
//         while(!!$rows2=_fetch_array_list($result2)){
//             $label=array();
//             $label['theme']=$rows2['theme'];
//             $label['notice_id']=$rows2['notice_id'];
//             $label_list = Jieba::cut($label['theme']);
    
    
//             for($i=0;$i<sizeof($seg_list);$i++){
//                 if($seg_list[$i]==''){continue;}
//                 for($j=0;$j<sizeof($label_list);$j++){
//                     if($label_list[$j]==$seg_list[$i]){
//                         $id=$label['notice_id'];
//                         $notice_list1[$id]+=1;
//                     }
//                 }
//             }
//         }
//     }
    

    if($author==1){
        if(!!$result3 = sql_query("select notice_id , user_username from user_notices natural join users_table")){
            while(!!$rows3=_fetch_array_list($result3)){
                $label=array();
                $label['notice_id']=$rows3['notice_id'];
                $label['username']=$rows3['user_username'];
                for($i=0;$i<sizeof($seg_list);$i++){
                    if($seg_list[$i]==''){continue;}
                    if(count(explode($seg_list[$i], $label['username']))>1){
                        $id=$label['notice_id'];
                        $notice_list2[$id]+=3;
                    }
                }
            }
        }
    }
    
    if($date==1){
        if($date_loc>=0){
            if($date_type==1){
                if(!!$result4 = sql_query("select notice_id , date(time) as time1 from user_notices")){
                    while(!!$rows4=_fetch_array_list($result4)){
                        $label=array();
                        $label['notice_id']=$rows4['notice_id'];
                        $label['time1']=$rows4['time1'];
                        $label['time2']=substr($rows4['time1'],2);
                        if($label['time2']==$seg_list[$date_loc]||$label['time1']==$seg_list[$date_loc]){
//                             echo 'SEG[TIME]:'.$seg_list[$date_loc].'<br>';
//                             echo 'Label[TIME]:'.$label['time1'].'<br>';
                            
                            $id=$label['notice_id'];
                            $notice_list3[$id]+=3;
                        }
                        
                    }
                }
            
            }else if($date_type==2){
                if(!!$result4 = sql_query("select notice_id , date(time) as time1  from user_notices")){
                    while(!!$rows4=_fetch_array_list($result4)){
                        $label=array();
                        $label['notice_id']=$rows4['notice_id'];
                        $s1=explode('-', $rows4['time1']);
                        $label['time1']=$s1[0]+'-'+$s1[1];
                        $s2=explode('-', $rows4['time1']);
                        $label['time2']=$s2[0]+'-'+$s2[1];
                        $label['time2']=substr($label['time2'],2);
                        
                        if($label['time2']==$seg_list[$date_loc]||$label['time1']==$seg_list[$date_loc]){
                            $id=$label['notice_id'];
                            $notice_list3[$id]+=3;
                        }
                
                    }
                }
            }
        }
    }
    arsort($notice_list1);
    arsort($notice_list2);
    arsort($notice_list3);
//     print_r($notice_list1);
//     echo '<br>';
//     echo 'author:'.$author.'<br>';
//     print_r($notice_list2);
//     echo 'time:'.$date.'<br>';
//     print_r($notice_list3);
    
    
    $key1=array_keys($notice_list1);
    $key2=array_keys($notice_list2);
    $key3=array_keys($notice_list3);
    $list=array();
    if($or==1){
        for($j=0;$j<sizeof($key1);$j++){
            $list[$key1[$j]]+=$notice_list1[$key1[$j]];
        }
        for($j=0;$j<sizeof($key2);$j++){
            $list[$key2[$j]]+=$notice_list2[$key2[$j]];
        }
        for($j=0;$j<sizeof($key3);$j++){
            $list[$key3[$j]]+=$notice_list3[$key3[$j]];
        }
        arsort($list);
        $list=array_keys($list);
        
    }
    else{
        if($author==1){
            if($date==1){
                $sift=array();

                for($j=0;$j<sizeof($key2);$j++){
                    $sift[$key2[$j]]+=1;
                }
                for($j=0;$j<sizeof($key3);$j++){
                    $sift[$key3[$j]]+=1;
                }
                arsort($sift);
                $sift2=array_keys($sift);
                for($j=0;$j<sizeof($sift2);$j++){
                    if($sift[$sift2[$j]]==2)
                        $list[$sift2[$j]]=1;
                }
                arsort($list);
                $list=array_keys($list);
                
            }else{
                $sift=array();
                for($j=0;$j<sizeof($key1);$j++){
                    $sift[$key1[$j]]+=1;
                }
                for($j=0;$j<sizeof($key2);$j++){
                    $sift[$key2[$j]]+=1;
                }
                arsort($sift);
                $sift2=array_keys($sift);
                for($j=0;$j<sizeof($sift2);$j++){
                    if($sift[$sift2[$j]]>0)
                        $list[$sift2[$j]]=1;
                }
                arsort($list);
                $list=array_keys($list);
                
            }
        }
        else if($date==1){
            $sift=array();
            
            for($j=0;$j<sizeof($key1);$j++){
                $sift[$key1[$j]]+=1;
            }
            for($j=0;$j<sizeof($key3);$j++){
                $sift[$key3[$j]]+=1;
            }
            arsort($sift);
            $sift2=array_keys($sift);
            for($j=0;$j<sizeof($sift2);$j++){
                if($sift[$sift2[$j]]>0)
                    $list[$sift2[$j]]=1;
            }
            arsort($list);
            $list=array_keys($list);
        }
        else{
            $list=$key1;
        }
        
    }
    
//     print_r($list);
    return $list ;
    
}

?>

