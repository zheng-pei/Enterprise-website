<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="keywords" content="<?php echo ($keywords); ?>">
<meta name="description" content="<?php echo ($description); ?>">
<title><?php echo ($title); ?></title>
<link href="/pro/public_html/static/Home/css/common.css" rel="stylesheet" type="text/css" />
<link href="/pro/public_html/static/Home/css/index.css" rel="stylesheet" type="text/css" />
<script src="/pro/public_html/static/Home/js/jquery.js" type="text/javascript"></script>
<script src="/pro/public_html/static/Home/js/index.js" type="text/javascript"></script>
</head>
<body>
<div class="container">
<!--头部-->
<div class="headerbg">
  <div class="header width_1100">
   <div class="h_box">
   <a href="<?php echo U('Index/index');?>">
      <div class="h_logo">
          <?php if($logo != ''): ?><img src="<?php echo ($logo); ?>" /><?php endif; ?>
      </div>
      <div class="h_wname">
       <i><img src="/pro/public_html/static/Home/images/img01.png"></i>
       <p><img src="/pro/public_html/static/Home/images/img02.png"></p>
      </div>
    </a>
   </div>
   <!-- 搜索 -->
    <form action="<?php echo U('Common/search',array('versionid'=>$versionid));?>" method="post" id="submit" class="form-horizontal">
   <div class="h_search">
    <div class="h_so">
    <span class="h_sbtn"><input type="submit" value="" /></span>
    <span class="h_sk"><input type="text" name="keyword" <?php if($versionid == 1): ?>placeholder="请输入搜索的关键字"<?php else: ?>placeholder="Enter search keywords"<?php endif; ?> value="<?php echo ($keyword); ?>"/></span>
    </div>
   </div>
 </form>
   <div class="zh_en">
     <ul class="clearfix">
       <li><a href="<?php echo U('Index/index',array('versionid'=>1));?>" <?php if($versionid == 1): ?>class="cur"<?php endif; ?>>中文</a></li>
       <li><a href="<?php echo U('Index/index',array('versionid'=>2));?>"  <?php if($versionid == 2): ?>class="cur"<?php endif; ?>>EN</a></li>
     </ul>
   </div>
  </div></div>
  <div class="clear"></div>
 <!--nav-->
  <div class="nav">
   <ul class="navlist width_1100 clearfix">
      <li>
        <?php if($versionid == 1): ?><a  href="<?php echo U('Index/index',array('versionid'=>$versionid));?>" <?php if(ACTION_NAME == 'index'): ?>class="cur"<?php endif; ?>>首页</a>
          <?php elseif($versionid == 2): ?>
            <a id="ennavlist" href="<?php echo U('Index/index',array('versionid'=>$versionid));?>" <?php if(ACTION_NAME == 'index'): ?>class="cur"<?php endif; ?>>Index</a><?php endif; ?>

      </li>
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li> 
          <a <?php if($versionid == 2): ?>id="ennavlist"<?php endif; ?> href="<?php echo U('Article/lists',array('pid'=>$vo['id'],'cateid'=>$vo['id'],'versionid'=>$versionid));?>" <?php if(($pid == $vo['id']) and (ACTION_NAME != 'index')): ?>class="cur"<?php endif; ?>><?php echo ($vo["catename"]); ?></a>
          <dl class="clearfix">
          <?php if(is_array($vo['sub'])): $i = 0; $__LIST__ = $vo['sub'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$subvo): $mod = ($i % 2 );++$i;?><dd>
              <a href="<?php echo U('Article/lists',array('pid'=>$subvo['pid'],'cateid'=>$subvo['id'],'versionid'=>$versionid));?>"><?php echo ($subvo["catename"]); ?></a>
            </dd><?php endforeach; endif; else: echo "" ;endif; ?>
          </dl>
        </li><?php endforeach; endif; else: echo "" ;endif; ?>
   </ul>
  </div>
  <div class="clear"></div>
 <!--active banner-->
	<!--轮播图片banner-->
  <div class="focus" id="focus">
   <ul>
      <?php if(is_array($lunbo)): $i = 0; $__LIST__ = $lunbo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$banner): $mod = ($i % 2 );++$i;?><li style="background:url(<?php echo ($banner["pic"]); ?>) no-repeat center center"></li><?php endforeach; endif; else: echo "" ;endif; ?>
   </ul>
   <div class="guidebox">
   <span class="guide">
   <a href="javascript:;" class="cur"></a>
   <a href="javascript:;"></a>
   <a href="javascript:;"></a>
   <a href="javascript:;"></a>
   </span>
   </div>
  </div>
  <!--content-->
   <div class="content">
  <div class="gaikuang">
     <div class="c_box width_1100">
      <div class="c_img">
       <img src="<?php echo ($labinfo["pic"]); ?>" />
      </div>
      <div class="c_txt">
      <div class="c_head"><img src="/pro/public_html/static/Home/images/arrow03.png" /><h2 class="c_h2"><?php echo ($lab["catename"]); ?></h2></div>
      <hr/>
      <p><?php echo (msubstr(strip_tags(htmlspecialchars_decode($labinfo["content"])),0,300)); ?>.... <a href="<?php echo U('Article/lists',array('pid'=>$lab['id'],'cateid'=>$lab['id'],'versionid'=>$versionid));?>"><?php if($versionid == 1): ?>详细<?php else: ?>Details<?php endif; ?>>></a></p>
      </div>
     </div>
   </div>

  <div class="team">
       <div class="teambox width_1100">
         <div class="boxcon">
           <a class="cur"><?php echo ($teamname); ?></a>
           <a><?php echo ($prize); ?></a>
         </div>
         <!--团队-->
         <div class="teamlist" style="display:block">
           <ul>
            <?php if(is_array($teamlists)): $i = 0; $__LIST__ = $teamlists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
              <a href="<?php echo U('News/news',array('pid'=>$teampid,'cateid'=>$teamcateid,'versionid'=>$versionid,'id'=>$vo['id']));?>"
              title="<?php echo ($vo['title']); ?>">
            <div class="team_li">
              <i><img src="<?php echo ($vo["pic"]); ?>" /></i>
              <strong ><?php echo ($vo["title"]); ?></strong>
              <p><?php echo ($vo["subtitle"]); ?></p>
              <b class="t_ck">ENTER</b>
             </div>
             </a>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
           </ul>
         </div><!--end-->
         <!--奖励-->
         <div class="teamlist">
           <ul>
              <?php if(is_array($prizelists)): $i = 0; $__LIST__ = $prizelists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
              <a href="<?php echo U('News/news',array('pid'=>$prizepid,'cateid'=>$prizecateid,'versionid'=>$versionid,'id'=>$vo['id']));?>"
              title="<?php echo ($vo['title']); ?>" title="<?php echo ($vo['title']); ?>">
            <div class="team_li">
              <i><img src="<?php echo ($vo["pic"]); ?>" /></i>
              <strong ><?php echo ($vo["title"]); ?></strong>
              <p><?php echo ($vo["subtitle"]); ?></p>
              <b class="t_ck">ENTER</b>
             </div>
             </a>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
           </ul>
         </div><!--end-->
       </div>
    </div>

    <div class="news width_1100">
       <div class="controls" id="controls">
         <a class="cur"><?php echo ($newsname); ?></a>
         <a><?php echo ($proname); ?></a>
         <a><?php echo ($openname); ?></a>
       </div>
       <div class="newscons">
       <!--新闻中心-->
       <div class="newscon" style="display:block">
          <div class="con_left" id="news_con" >
          <?php if(is_array($newsleft)): $i = 0; $__LIST__ = $newsleft;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="con_left_t" <?php if($i == 1): ?>style="display:block"<?php endif; ?>>
             <a href="<?php echo U('News/news',array('pid'=>$newspid,'cateid'=>$newscateid,'versionid'=>$versionid,'id'=>$vo['id']));?>" title="<?php echo ($vo['title']); ?>">
             <i style="background:url(<?php echo ($vo["pic"]); ?>) no-repeat"></i>
             <h3><?php echo ($vo["title"]); ?></h3>
             <p><?php echo (msubstr(strip_tags(htmlspecialchars_decode($vo["content"])),0,60)); ?></p>
             </a>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
            <span class="conguide">
              <a href="javascript:;" class="cur"></a>
              <a href="javascript:;"></a>
              <a href="javascript:;"></a>
            </span>
          </div>
          <div class="con_right">
             <ul>
             <?php if(is_array($newsright)): $i = 0; $__LIST__ = $newsright;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?><li>
               <a href="<?php echo U('Article/lists',array('pid'=>$newspid,'cateid'=>$newscateid,'versionid'=>$versionid,'id'=>$vo1['id']));?>" title="<?php echo ($vo1['title']); ?>">
                 <div class="con_r_left">
                   <strong><?php echo (date("d",$vo1["createtime"])); ?></strong>
                   <b><?php echo (date("Y-m",$vo1["createtime"])); ?></b>
                 </div>
                 <div class="con_r_right">
                    <h4><?php echo ($vo1["title"]); ?></h4>
                    <p><?php echo (msubstr(strip_tags(htmlspecialchars_decode($vo1["content"])),0,60)); ?></p>
                 </div></a>
               </li><?php endforeach; endif; else: echo "" ;endif; ?>
             </ul>
          </div>
          <a class="more" href="<?php echo U('Article/lists',array('pid'=>$newspid,'cateid'=>$newscateid,'versionid'=>$versionid));?>"><?php if($versionid == 1): ?>查看更多<?php else: ?>See more<?php endif; ?></a>
       </div>
         <!--项目-->
         <div class="newscon">
          <div class="con_left" id="news_con2" >
          <?php if(is_array($proleft)): $i = 0; $__LIST__ = $proleft;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="con_left_t" <?php if($i == 1): ?>style="display:block"<?php endif; ?>>
             <a href="<?php echo U('News/news',array('pid'=>$propid,'cateid'=>$procateid,'versionid'=>$versionid,'id'=>$vo['id']));?>" title="<?php echo ($vo['title']); ?>">
             <i style="background:url(<?php echo ($vo["pic"]); ?>) no-repeat"></i>
             <h3><?php echo ($vo["title"]); ?></h3>
             <p><?php echo (msubstr(strip_tags(htmlspecialchars_decode($vo["content"])),0,60)); ?></p>
             </a>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
            <span class="conguide">
              <a href="javascript:;" class="cur"></a>
              <a href="javascript:;"></a>
              <a href="javascript:;"></a>
            </span>
          </div>
          <div class="con_right">
             <ul>
             <?php if(is_array($proright)): $i = 0; $__LIST__ = $proright;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?><li>
               <a href="<?php echo U('News/news',array('pid'=>$propid,'cateid'=>$procateid,'versionid'=>$versionid,'id'=>$vo1['id']));?>" title="<?php echo ($vo1['title']); ?>">
                 <div class="con_r_left">
                   <strong><?php echo (date("d",$vo1["createtime"])); ?></strong>
                   <b><?php echo (date("Y-m",$vo1["createtime"])); ?></b>
                 </div>
                 <div class="con_r_right">
                    <h4><?php echo ($vo1["title"]); ?></h4>
                    <p><?php echo (msubstr(strip_tags(htmlspecialchars_decode($vo1["content"])),0,60)); ?></p>
                 </div></a>
               </li><?php endforeach; endif; else: echo "" ;endif; ?>
             </ul>
          </div>
          <a class="more" href="<?php echo U('Article/lists',array('pid'=>$propid,'cateid'=>$procateid,'versionid'=>$versionid));?>"><?php if($versionid == 1): ?>查看更多<?php else: ?>See more<?php endif; ?></a>
       </div>
        <!--开放和交流-->
       <div class="newscon">
           <div class="con_left" id="news_con3">
           <?php if(is_array($openleft)): $i = 0; $__LIST__ = $openleft;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?><div class="con_left_t" <?php if($i == 1): ?>style="display:block"<?php endif; ?>>
            <a href="<?php echo U('News/news',array('pid'=>$openpid,'cateid'=>$opencateid,'versionid'=>$versionid,'id'=>$vo2['id']));?>" title="<?php echo ($vo2['title']); ?>">
             <i style="background:url(<?php echo ($vo2['pic']); ?>) no-repeat"></i>
             <h3><?php echo ($vo2["title"]); ?></h3>
             <p><?php echo (msubstr(strip_tags(htmlspecialchars_decode($vo2["content"])),0,60)); ?>...</p>
             </a>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
            <span class="conguide">
              <a href="javascript:;" class="cur"></a>
              <a href="javascript:;"></a>
              <a href="javascript:;"></a>
            </span>
          </div>
          <!-- 开放和交流右边的内容 -->
          <div class="con_right">
             <ul>
             <?php if(is_array($openright)): $i = 0; $__LIST__ = $openright;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo3): $mod = ($i % 2 );++$i;?><li>
               <a href="<?php echo U('News/news',array('pid'=>$openpid,'cateid'=>$opencateid,'versionid'=>$versionid,'id'=>$vo3['id']));?>" title="<?php echo ($vo3['title']); ?>">
                 <div class="con_r_left">
                 <!-- 显示时间 -->
                   <strong><?php echo (date("d",$vo3["createtime"])); ?></strong>
                   <b><?php echo (date("Y-m",$vo3["createtime"])); ?></b>
                 </div>
                 <div class="con_r_right">
                    <h4><?php echo ($vo3["title"]); ?></h4>
                    <p><?php echo (msubstr(strip_tags(htmlspecialchars_decode($vo3["content"])),0,60)); ?>...</p>
                 </div></a>
               </li><?php endforeach; endif; else: echo "" ;endif; ?> 
             </ul>
          </div>
          <a class="more" href="<?php echo U('Article/lists',array('pid'=>$openpid,'cateid'=>$opencateid,'versionid'=>$versionid));?>"><?php if($versionid == 1): ?>查看更多<?php else: ?>See more<?php endif; ?></a>
       </div>
      </div>
    </div>  
  </div>
 <!--footer-->
  <div class="footer">
    <div class="width_1100 clearfix">
     <span><img src="/pro/public_html/static/Home/images/logo01.png" /></span>
     <div class="footxt"><p><?php if($versionid == 1): ?>华中科技大学生命与科学技术学院 版权所有 鄂ICP备05002857号 文保网安备案1101050063号<?php else: ?>College of life and science and technology, Huazhong University of Science and Technology All rights reserved Hubei ICP No. 05002857 security network security record number 1101050063<?php endif; ?></p>
     <p><?php if($versionid == 1): ?>地址：湖北省武汉市珞喻路1037号 邮编：100101 联系我们<?php else: ?>Address: Hubei Province, Wuhan 1037 Luoyu road zip code: 100101 contact us<?php endif; ?></p></div>
    </div>
  </div>
</div>
</body>
</html>