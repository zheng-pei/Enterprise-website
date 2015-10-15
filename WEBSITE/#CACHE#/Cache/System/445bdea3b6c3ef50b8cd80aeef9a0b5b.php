<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-capable" content="yes" />
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<base target="mainFrame" />
<title><?php echo C('site_title');?> <?php echo C('site_name');?></title>
<link href="<?php echo RES;?>/css/index.css" rel="stylesheet" type="text/css"  media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo RES;?>/css/bootstrap_min.css"  media="all"/>
<link type="text/css" rel="stylesheet" href="<?php echo RES;?>/css/bootstrap-responsive.min.css" media="all" />
<link href="<?php echo RES;?>/css/style.css" rel="stylesheet" type="text/css"  media="all"/>
<link rel="stylesheet" type="text/css" href="<?php echo RES;?>/font/font-awesome.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo RES;?>/css/theme.css"  media="all"/>
<link rel="stylesheet" type="text/css" href="<?php echo RES;?>/css/todc_bootstrap.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo RES;?>/css/inside.css" media="all" />
<script type="text/javascript" src="<?php echo RES;?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo RES;?>/js/common.js"></script>
<script type="text/javascript" src="<?php echo RES;?>/js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo RES;?>/js/html5shiv.js"></script>
<script type="text/javascript" src="<?php echo RES;?>/js/application.js"></script>
<script type="text/javascript" src="<?php echo RES;?>/js/inside.js"></script>
<script type="text/javascript" src="<?php echo RES;?>/js/resource.js"></script>
<!--表单验证-->
<script type="text/javascript" src="<?php echo RES;?>/js/jquery_form_min.js"></script>
<script type="text/javascript" src="<?php echo RES;?>/js/jquery_validate_min.js"></script>
<script type="text/javascript" src="<?php echo RES;?>/js/jquery_validate_methods.js"></script>
</head>
<body>

<div id="main">
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="box">
          <div class="box-title">
            <div class="span2">
              <h3> <i class="icon-table"></i>
                文章列表管理
              </h3>
            </div>
            <div class="fr">
              <form name="searchform" action="<?php echo U('Article/lists');?>" method="post" class="form-horizontal">
              <input type="hidden" name="cateid" value="<?php echo ($cateid); ?>"/>
               <select class="input-medium" name="catename">
                 <option value="0">子栏目分类</option>
                 <?php if(is_array($subcolumn)): $i = 0; $__LIST__ = $subcolumn;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($catename == $key): ?>selected="selected"<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                 </select>&nbsp;     
               <input name="title" type="text" class="input-medium" value="<?php echo ($title); ?>" placeholder="文章标题"/>
                <input name="source" type="text" class="input-medium" value="<?php echo ($source); ?>" placeholder="文章来源"/>
             <select class="input-small" name="_order">
                 <option value="createtime" <?php if($_order == 'createtime'): ?>selected="selected"<?php endif; ?>>按时间</option>
                  <option value="hits" <?php if($_order == 'hits'): ?>selected="selected"<?php endif; ?>>按浏览量</option>
                 </select>&nbsp;
                 <select class="input-medium" name="_sort" id="ver" data-rule-required="true" data-rule-notem="true">
                 <option value="asc" <?php if($_sort == 'asc'): ?>selected="selected"<?php endif; ?>>升序排列</option>
                 <option value="desc" <?php if($_sort == 'desc'): ?>selected="selected"<?php endif; ?>>降序排列</option>
                 </select>&nbsp;
                  <select name="status"  class="input-small-s"> 
                   <option value="">所有状态</option>
                   <option value="1" <?php if($status == 1): ?>selected="selected"<?php endif; ?>>已发布</option>
                   <option value="2" <?php if($status == 2): ?>selected="selected"<?php endif; ?>>未发布</option>
                 </select>&nbsp; 
                  <input type="submit" id="dosubmit" name="search" class="btncx" value="搜索" />
             </form>
            </div>
          </div>
          <div class="box-content nozypadding" style="width:100%;">
           
            <div class="row-fluid dataTables_wrapper">
          
              <table id="listTable" class="table table-hover table-nomargin table-bordered usertable dataTable">
                <thead >
                  <tr>
                    <th>编号</th>
                    <th>文章标题</th>
                    <th>栏目名称</th>
                    <th>封面图片</th>
                    <th>浏览量</th>
                    <th>文章来源</th>
                    <th>文章编辑者</th>
                    <th>时间</th>    
                    <th>状态</th>            
                    <th>操作</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                      <td><?php echo ($vo["id"]); ?></td>
                      <td><?php echo ($vo["title"]); ?></td> 
                      <td><?php echo ($vo["catename"]); ?></td>                           
                      <td>
                      <?php if($vo['pic'] != ''): ?><img src="<?php echo ($vo["pic"]); ?>" width="50px;" height="40px">
                      <?php else: ?>未上传图片<?php endif; ?>
                      </td>
                      <td><?php echo ($vo["hits"]); ?></td>
                      <td><?php echo ($vo["source"]); ?></td>
                      <td><?php echo ($vo["author"]); ?></td>
                      <td><?php echo (date("Y-m-d H:i:s",$vo["createtime"])); ?></td>
                      <td class="statuscg">
                      <?php if($vo["status"] == 1): ?><span class="label label-success">已发布</span>
                        <?php elseif($vo["status"] == 2): ?>
                        <span class="label label-warning">未发布</span><?php endif; ?>
                    </td> 
                    <td>
                      <?php if($vo['status'] == 1): ?><a href="javascript: drop_confirm('确定禁用？','<?php echo U('Article/changestatus',array('cateid'=>$cateid,'id'=>$vo['id'],'status'=>2,'p'=>$p));?>')" class="btnra" title="禁用"><i class="icon-stop"></i>未发布</a>
                       <?php else: ?>
                       <a href="javascript: drop_confirm('确定启用？','<?php echo U('Article/changestatus',array('cateid'=>$cateid,'id'=>$vo['id'],'status'=>1,'p'=>$p));?>')" class="btnra" title="启用"><i class="icon-play"></i>已发布</a><?php endif; ?>
                      <a href="<?php echo U('Article/edit',array('cateid'=>$vo['cateid'],'id'=>$vo['id']));?>" class="btnra" title="编辑">
                        <i class="icon-edit"></i>
                        编辑
                      </a>
                      <a href="javascript: G.ui.tips.confirm('确定删除？','<?php echo U('Article/delete',array('cateid'=>$vo['cateid'],'id'=>$vo['id']));?>')" class="btnra" title="删除">
                        <i class="icon-remove"></i>
                        删除
                      </a>
                    </td>
                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
              </tbody>
            </table>
            <div class="dataTables_paginate paging_full_numbers"><span><?php echo ($page); ?></span></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script language="javascript">
KindEditor.ready(function (K) {
  var editor1 = K.create("textarea.editors", G.set.KindEditor_seting);
  var editor = K.editor({
      themeType: "default",
        allowFileManager: true
      });
      var _mp3_i = 0;
      K('button.select_img,a.select_img').click(function (e) {
	
          editor.loadPlugin('smimage', function () {
              editor.plugin.imageDialog({
                imageUrl: $(e.target).prevAll("input[type=hidden],input[type=text]").val(),
                  clickFn: function (url, title, width, height, border, align) {
                      var $input = $(e.target).prevAll("input[type=hidden],input[type=text]")
                      $input.val(url)
                          editor.hideDialog();
                    }
                  });
                });
              });
      K('button.select_file,a.select_file').click(function (e) {

          editor.loadPlugin('insertfile', function () {
              editor.plugin.fileDialog({
                fileUrl: $(e.target).parent().prevAll("input[type=hidden]").val(),
                  clickFn: function (url, title, width, height, border, align) {
                      var $input = $(e.target).parent().prevAll("input[type=hidden],input[type=text]")
                      $input.val(url)
                          editor.hideDialog();
                    }
                  });
                });
              });          
    });
 KindEditor.ready(function(K) {
        var editor = K.editor({
          allowFileManager : true
        });
        K('#J_selectImage').click(function() {
          editor.loadPlugin('multiimage', function() {
            editor.plugin.multiImageDialog({
              clickFn : function(urlList) {
                var div = K('#J_imageView');
                div.html('');
                K.each(urlList, function(i, data) {
                  div.append('<img src="./static' + data + '" width="50px" height="40px;"/>');
                });
                editor.hideDialog();
              }
            });
          });
        });
      });
</script>
</body>
</html>