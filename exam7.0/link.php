<?php


define('PASS_OK',true);
define('SCRIPT','link');
require dirname(__FILE__).'/includes/common.php';

if(!isset($_COOKIE['id'])){
    _alert_back("请登录！");
}
?>
<?php 
	require ROOT_PATH.'includes/header.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="styles/link.css" type="text/css" />
<div id="information">
<?php 
    require ROOT_PATH.'includes/information.inc.php';
?>
	<div id="information_main">
	  <h2>友情链接</h2>
        <div id="top1">
        	<label>
                <span><strong>机关:</strong></span>
                <select id="selection1" onchange="option_change1()">
                <option value="">--机关部门网站--</option>    
                <option value="http://www.sdu.edu.cn/">山东大学官网
                <option value="http://www.dxb.sdu.edu.cn/">学校办公室    
                <option value="http://www.jjsh.sdu.edu.cn">纪律检查委员会办公室    
                <option value="http://www.jjsh.sdu.edu.cn/">监察审计部    
                <option value="http://WWW.ZZB.SDU.EDU.CN">组织部    
                <option value="http://www.shidian.sdu.edu.cn/">宣传部    
                <option value="http://www.sdtz.sdu.edu.cn/">统战部    
                <option value="http://www.rsc.sdu.edu.cn/">人事部    
                <option value="http://www.fzgh.sdu.edu.cn/">发展规划部    
                <option value="http://www.jwc.sdu.edu.cn/">本科生院    
                <option value="http://www.jwc.sdu.edu.cn/">本科生院党工委    
                <option value="http://www.xsyjb.sdu.edu.cn/">学术研究部    
                <option value="http://www.grad.sdu.edu.cn/">研究生院    
                <option value="http://www.ygb.sdu.edu.cn/">研究生工作部    
                <option value="http://www.ipo.sdu.edu.cn/">国际事务部    
                <option value="http://www.cwc.sdu.edu.cn/">财务部    
                <option value="http://www.gzc.sdu.edu.cn/">资产与实验室管理部    
                <option value="http://www.jj.sdu.edu.cn">基建部    
                <option value="http://www.hqc.sdu.edu.cn/">后勤保障部    
                <option value="http://www.dcd.sdu.edu.cn/">合作发展部    
                <option value="http://www.qlyxb.sdu.edu.cn/">齐鲁医学部    
                <option value="http://www.qd.sdu.edu.cn/">青岛校区建设指挥部    
                <option value="http://www.job.sdu.edu.cn/">就业与发展服务中心    
                </select>
            </label>
        
        
        	<label>
                <span><strong>基层:</strong></span>
                <select id="selection2" onchange="option_change2()">
                    <option value="">--基层党组织、群团组织和直属单位网站--</option>    
                    <option value="http://www.jgdw.sdu.edu.cn">机关党委    
                    <option value="http://www.gonghui.sdu.edu.cn/">工会、妇委会    
                    <option value="http://www.youth.sdu.edu.cn/">团委    
                    <option value="http://www.net.sdu.edu.cn/">网络与信息中心    
                    <option value="http://www.nwhxq.sdu.edu.cn/">兴隆山校区管理办公室    
                    <option value="http://www.gxfdy.edu.cn/daoyuan_website/">辅导员工作研究会与培训基地办公室    
                    <option value="http://www.adult.sdu.edu.cn/">继续（网络）教育学院    
                    <option value="http://www.archives.sdu.edu.cn/">档案馆    
                    <option value="http://www.sdu.edu.cn/csdu/bwg.htm">博物馆    
                    <option value="http://www.lib.sdu.edu.cn/">图书馆    
                    <option value="http://www.xlzx.sdu.edu.cn/">工程训练中心    
                    <option value="http://www.wljy.sdu.edu.cn/">学报编辑部（自然科学版）    
                    <option value="http://www.wljy.sdu.edu.cn/">学报编辑部（哲学社会科学版    
                    <option value="http://www.wljy.sdu.edu.cn/">文史哲编辑部    
                    <option value="http://www.cbs.sdu.edu.cn/2009/">出版社    
                    <option value="http://www.wljy.sdu.edu.cn/">第一附属中学    
                    <option value="http://www.wljy.sdu.edu.cn/">第二附属中学    
                    <option value="http://www.qiluhospital.com/">齐鲁医院    
                    <option value="http://www.sdey.net/">第二医院    
                    <option value="http://www.sdkq.sdu.edu.cn/">口腔医院    
                </select>    
            </label>
        </div>
        <div id="top2">
        	<label>
                <span><strong>学院:</strong></span>
                <select id="selection3" onchange="option_change3()">
                        <option value="">--院部网站导航--</option>    
                        <option value="http://www.sps.sdu.edu.cn">哲学与社会发展学院    
                        <option value="http://www.eco.sdu.edu.cn/">经济学院    
                        <option value="http://www.pspa.sdu.edu.cn/">政治学与公共管理学院    
                        <option value="http://www.law.sdu.edu.cn/">法学院    
                        <option value="http://www.lit.sdu.edu.cn/">文学与新闻传播学院    
                        <option value="http://www.flc.sdu.edu.cn/">外国语学院    
                        <option value="http://www.art.sdu.edu.cn">艺术学院    
                        <option value="http://www.history.sdu.edu.cn">历史文化学院    
                        <option value="http://www.maths.sdu.edu.cn/">数学学院    
                        <option value="http://www.phym.sdu.edu.cn/">物理学院    
                        <option value="http://www.chemnew.sdu.edu.cn/">化学与化工学院    
                        <option value="http://www.ise.sdu.edu.cn">信息科学与工程学院    
                        <option value="http://www.cs.sdu.edu.cn/">计算机科学与技术学院    
                        <option value="http://www.life.sdu.edu.cn">生命科学学院    
                        <option value="http://www.cmse.sdu.edu.cn/">材料科学与工程学院    
                        <option value="http://www.mech.sdu.edu.cn">机械工程学院    
                        <option value="http://control.sdu.edu.cn/">控制科学与工程学院    
                        <option value="http://epe.sdu.edu.cn/">能源与动力工程学院    
                        <option value="http://www.ee.sdu.edu.cn">电气工程学院    
                        <option value="http://www.tjsl.sdu.edu.cn">土建与水利学院    
                        <option value="http://www.huanke.sdu.edu.cn/">环境科学与工程学院    
                        <option value="http://www.sph.sdu.edu.cn/">公共卫生学院    
                        <option value="http://www.medicine.sdu.edu.cn">医学院    
                        <option value="http://www.dent.sdu.edu.cn">口腔医学院    
                        <option value="http://www.nursing.sdu.edu.cn">护理学院    
                        <option value="http://www.pharm.sdu.edu.cn">药学院    
                        <option value="http://www.glxy.sdu.edu.cn/">管理学院    
                        <option value="http://www.tyb.sdu.edu.cn">体育学院    
                        <option value="http://www.mlb.sdu.edu.cn">马克思主义学院    
                        <option value="http://www.cie.sdu.edu.cn/">国际教育学院    
                        <option value="http://www.qlsc.sdu.edu.cn">软件学院 
                </select>    
            </label>
        
        
        	<label>
                <span><strong>高校:</strong></span>
                <select id="selection4" onchange="option_change4()">
                        <option value="">--高校网站导航--</option>    
                        <option value="http://www.sdu.edu.cn/">山东大学    
                        <option value="http://www.tsinghua.edu.cn/">清华大学    
                        <option value="http://www.pku.edu.cn/">北京大学    
                        <option value="http://www.ouqd.edu.cn/">青岛海洋大学    
                        <option value="http://www.hdpu.edu.cn/">华东石油大学    
                        <option value="http://www.sdust.edu.cn/">山东科技大学    
                        <option value="http://www.sdnu.edu.cn/">山东师范大学    
                        <option value="http://www.sdutcm.edu.cn/">山东中医药大学    
                        <option value="http://www.bj.edu.cn/">北京市教育和科研计算机网    
                        <option value="http://www.bupt.edu.cn/">北京邮电大学    
                        <option  value="http://www.buaa.edu.cn/">北京航空航天大学    
                        <option value="http://www.njtu.edu.cn/">北方交通大学    
                        <option  value="http://www.bnu.edu.cn/">北京师范大学    
                        <option  value="http://www.bjucmp.edu.cn/">北京中医药大学    
                        <option  value="http://www.cugb.edu.cn/">中国地质大学(北京)    
                        <option  value="http://www.ruc.edu.cn/">中国人民大学    
                        <option  value="http://www.tju.edu.cn/">天津大学    
                        <option  value="http://www.nankai.edu.cn/">南开大学    
                        <option  value="http://www.jlu.edu.cn/">吉林大学    
                        <option  value="http://www.sjtu.edu.cn/">上海交通大学    
                        <option  value="http://www.fudan.edu.cn/">复旦大学    
                        <option  value="http://www.tongji.edu.cn/">同济大学    
                        <option  value="http://www.ecust.edu.cn/">华东理工大学    
                        <option  value="http://www.shufe.edu.cn/">上海财经大学    
                        <option  value="http://www.seu.edu.cn/">东南大学    
                        <option  value="http://www.nju.edu.cn/">南京大学    
                        <option  value="http://www.zju.edu.cn/">浙江大学    
                        <option  value="http://www.xmu.edu.cn/">厦门大学    
                        <option  value="http://www.hit.edu.cn/">哈尔滨工业大学    
                        <option  value="http://www.whu.edu.cn/">武汉大学    
                        <option  value="http://www.nudt.edu.cn/">国防科技大学    
                        <option  value="http://www.hunu.edu.cn/">湖南大学    
                        <option  value="http://www.xtu.edu.cn/">湘潭大学    
                        <option  value="http://www.scut.edu.cn/">华南理工大学    
                        <option  value="http://www.zsu.edu.cn/">中山大学    
                        <option  value="http://www.jnu.edu.cn/">暨南大学    
                        <option  value="http://www.xjtu.edu.cn/">西安交通大学    
                        <option  value="http://www.xidian.edu.cn/">西安电子科技大学    
                        <option  value="http://www.fmmu.edu.cn/">第四军医大学    
                        <option  value="http://www.xjife.edu.cn/">新疆财经学院    
                        <option  value="http://www.nthu.edu.tw/">清华大学(台湾)    
                        <option  value="http://www.nctu.edu.tw/">交通大学    
                        <option  value="http://www.cuhk.hk/">香港中文大学    
                        <option  value="http://www.cityu.edu.hk/">香港城市大学    
                        <option  value="http://www.polyu.edu.hk/">香港理工大学    
                        <option  value="http://www.hku.hk/">香港大学    
                        <option  value="http://www.ust.hk/">香港科技大学    
                        <option  value="http://www.ln.edu.hk/">岭南学院    
                        <option  value="http://www.umac.mo/">澳门大学    
                </select>    
             </label>
          </div>
        <div id="up">
			<table >
				<tr style="font-size: 20px;"><th>关于山大</th><th>科研机构</th></tr>			
				<tr><th><a href="https://www.baidu.com/" target="_blank">山东大学主页</a></th><th><a href="http://www.fzgh.sdu.edu.cn/" target="_blank">学科建设</a></th></tr>			
				<tr><th><a href="http://www.bkjx1.sdu.edu.cn/" target="_blank">本科生院</a></th><th><a href="http://www.rd.sdu.edu.cn/website/index" target="_blank">科学技术</a></th></tr>			
				<tr><th><a href="https://online.sdu.edu.cn/" target="_blank">学生在线</a></th><th><a href="http://www.rwsk.sdu.edu.cn/website/home" target="_blank">人文社科</a></th></tr>			
				<tr><th><a href="http://www.youth.sdu.edu.cn/" target="_blank">青春山大</a></th><th><a href="http://www.rd.sdu.edu.cn/kycg/lwzz" target="_blank">科研成果</a></th></tr>			
				<tr><th><a href="http://student.sdu.edu.cn/companyCTRL.do" target="_blank">信息服务平台</a></th><th><a href="http://zcysysb.sdu.edu.cn/" target="_blank">实验资源</a></th></tr>			
				<tr><th><a href="http://course.sdu.edu.cn/G2S/ShowSystem/Index.aspx" target="_blank">课程中心</a></th><th><a href="http://www.sdu.edu.cn/2010/kyjg.html" target="_blank">社科基地</a></th></tr>			
				<tr><th><a href="http://sdu.fy.chaoxing.com/portal" target="_blank">尔雅平台</a></th><th><a href="http://www.sdu.edu.cn/2010/kyjg.html" target="_blank">重点实验室</a></th></tr>			
				<tr></tr>
				<tr></tr>
				<tr></tr>
			
			</table>
        </div>
        <div id="down">
			<table  >
				<tr style="font-size: 20px;"><th>合作交流</th><th>人才人事</th></tr>			
				<tr><th><a href="http://www.ipo.sdu.edu.cn/" target="_blank">国际合作</a></th><th><a href="http://www.rcb.sdu.edu.cn/" target="_blank">人才工作</a></th></tr>			
				<tr><th><a href="http://www.sdu.org.cn/index.html" target="_blank">校友工作</a></th><th><a href="http://www.rcb.sdu.edu.cn/" target="_blank">人事工作</a></th></tr>			
				<tr><th><a href="#" target="_blank">出国留学</a></th><th><a href="http://www.rsc.sdu.edu.cn/2010new2/zp.php"" target="_blank">招聘信息</a></th></tr>			
				<tr><th><a href="#" target="_blank">留学信息</a></th><th><a href="http://www.rsc.sdu.edu.cn/2010new2/zp.php" target="_blank">校园兼职</a></th></tr>			
				<tr><th><a href="#" target="_blank">校友交流</a></th><th></th></tr>			

			</table>
       	</div>
    </div>
</div>
	<script type="text/JavaScript">
       function option_change1(){
       		var opt = document.getElementById("selection1");
       		if(opt.value!=''){
            	window.open(opt.value);
       		}
       }
       function option_change2(){
     		var opt = document.getElementById("selection2");
     		if(opt.value!=''){
          	window.open(opt.value);
     		}
     	}
       function option_change3(){
   			var opt = document.getElementById("selection3");
   			if(opt.value!=''){
        		window.open(opt.value);
   			}
   		}
       function option_change4(){
 			var opt = document.getElementById("selection4");
 			if(opt.value!=''){
      		window.open(opt.value);
 			}
 		}
	</script>
	
	
<?php 
	require ROOT_PATH.'includes/footer.php';
?>