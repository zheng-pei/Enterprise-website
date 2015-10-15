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
 <!--分配两个版本的每个一级栏目下的静态banner --> 
<div class="bg_banner">
 	<?php if(in_array(($pid), explode(',',"1,26"))): ?><img src="<?php echo ($pics[0]['pic']); ?>" width="100%"/><?php endif; ?>
 	<?php if(in_array(($pid), explode(',',"2,27"))): ?><img src="<?php echo ($pics[1]['pic']); ?>" width="100%"/><?php endif; ?>
 	<?php if(in_array(($pid), explode(',',"3,28"))): ?><img src="<?php echo ($pics[2]['pic']); ?>" width="100%"/><?php endif; ?>
 	<?php if(in_array(($pid), explode(',',"4,29"))): ?><img src="<?php echo ($pics[3]['pic']); ?>" width="100%"/><?php endif; ?>
 	<?php if(in_array(($pid), explode(',',"5,30"))): ?><img src="<?php echo ($pics[4]['pic']); ?>" width="100%"/><?php endif; ?>
 	<?php if(in_array(($pid), explode(',',"6,31"))): ?><img src="<?php echo ($pics[5]['pic']); ?>" width="100%"/><?php endif; ?>
 	<?php if(in_array(($pid), explode(',',"7,32"))): ?><img src="<?php echo ($pics[6]['pic']); ?>" width="100%"/><?php endif; ?>
 	<?php if(in_array(($pid), explode(',',"8,33"))): ?><img src="<?php echo ($pics[7]['pic']); ?>" width="100%"/><?php endif; ?>
 	<?php if(in_array(($pid), explode(',',"9,34"))): ?><img src="<?php echo ($pics[8]['pic']); ?>" width="100%"/><?php endif; ?>
</div>
 <!-- 显示正上方栏目的列表 -->
<div class="content">
   <div class="news width_1100">
       <div class="controls">
        <?php if($pid == $cateid): if(is_array($subcolumn)): $i = 0; $__LIST__ = $subcolumn;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Article/lists',array('pid'=>$pid,'cateid'=>$vo['id'],'versionid'=>$versionid));?>" <?php if($i == 1): ?>class="cur"<?php endif; ?>><?php echo ($vo["catename"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
      <?php elseif($pid != $cateid): ?>
         <?php if(is_array($subcolumn)): $i = 0; $__LIST__ = $subcolumn;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Article/lists',array('pid'=>$pid,'cateid'=>$vo['id'],'versionid'=>$versionid));?>" <?php if($vo['id'] == $cateid): ?>class="cur"<?php endif; ?>><?php echo ($vo["catename"]); ?></a><?php endforeach; endif; else: echo "" ;endif; endif; ?>    
       </div>
  <!--科研成果近期项目,开放课题设置列表-->
   <div class="ky_program mrt30">
     <ul class="pr_list clearfix">
        <?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
         <i class="quare"></i>
         <div class="pr_list_right">
         <h3><a href="<?php echo U('News/news',array('pid'=>$pid,'cateid'=>$cateid,'versionid'=>$versionid,'id'=>$vo['id']));?>"  class="fs18 fonth" title="<?php echo ($vo["title"]); ?>"><font color="<?php echo ($vo["color"]); ?>" class="abc"><?php echo ($vo["title"]); ?></font></a></h3>
           <?php if($vo['subtitle'] != ''): ?><p class="color84 list clearfix"><?php echo (msubstr($vo["subtitle"],0,90)); ?></p><?php endif; ?>
           <hr />
           <p class="con"><?php echo (msubstr(strip_tags(htmlspecialchars_decode($vo["content"])),0,500)); ?></p>
           <a href="<?php echo U('News/news',array('pid'=>$pid,'cateid'=>$cateid,'versionid'=>$versionid,'id'=>$vo['id']));?>" class="color_blue xq"><?php if($versionid == 1): ?>点击查看详情<?php else: ?>Click to view the details<?php endif; ?>>></a>
         </div>
       </li><?php endforeach; endif; else: echo "" ;endif; ?>
     </ul>
      <span class="guidelist"><?php echo ($page); ?></span>
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