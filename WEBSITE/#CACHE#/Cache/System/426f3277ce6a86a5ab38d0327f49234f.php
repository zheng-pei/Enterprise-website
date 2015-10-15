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
               留言列表管理
              </h3>
            </div>
            <div class="fr">
              <form name="searchform" action="<?php echo U('Message/index');?>" method="post" class="form-horizontal">
              <input name="username" type="text" class="input-text" value="<?php echo ($username); ?>" placeholder="姓名"/>&nbsp;
               <select class="input-medium" name="_order" id="ver" data-rule-required="true" data-rule-notem="true">
                 <option value="createtime" <?php if($_order == 'createtime'): ?>selected="selected"<?php endif; ?>>时间</option>
                 </select>&nbsp;
               <select class="input-medium" name="_sort" id="ver" data-rule-required="true" data-rule-notem="true">
                 <option value="">排序方式</option>
                 <option value="asc" <?php if($_sort == 'asc'): ?>selected="selected"<?php endif; ?>>升序排序</option><option value="desc" <?php if($_sort == 'desc'): ?>selected="selected"<?php endif; ?>>降序排序</option>
                 </select>&nbsp;
                 <select name="isread" data-rule-required="true"> 
                   <option value="">是否查看</option>
                 <option value="1" <?php if($isread == '1'): ?>selected="selected"<?php endif; ?>>已查看</option><option value="2" <?php if($isread == 2): ?>selected="selected"<?php endif; ?>>未查看</option>
                 </select>&nbsp; 
                <input type="submit" id="dosubmit" name="search" class="btncx" value="搜索" />
             </form>
            </div>
          </div>
          <div class="box-content nozypadding" style="width:100%;">
            <div class="row-fluid">
              <div class="span8 control-group">
               　<a class="btn" href="javascript:location.reload()">
                  <i class="icon-refresh"></i>
                  刷新
                </a>
              </div>
            </div>
            <div class="row-fluid dataTables_wrapper">
              <table id="listTable" class="table table-hover table-nomargin table-bordered usertable dataTable">
                <thead >
                  <tr>
                    <th>编号</th>
                    <th>姓名</th>
                    <th>性别</th>
                    <th>电话号码</th>
                    <th>地址</th>
                    <th>Email</th>
                    <th>留言时间</th>  
                    <th>是否查看</th>       
                    <th>操作</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                      <td><?php echo ($vo["id"]); ?></td>
                      <td><?php echo ($vo["username"]); ?></td>
                      <td><?php if($vo["sex"] == 1): ?>男<?php elseif($vo["sex"] == 2): ?>女<?php else: ?>保密<?php endif; ?></td>                   
                      <td><?php echo ($vo["phone"]); ?></td>
                      <td><?php echo ($vo["address"]); ?></td>
                      <td><?php echo ($vo["email"]); ?></td>
                      <td><?php echo (date("Y-m-d H:i:s",$vo["createtime"])); ?></td>
                      <td class="statuscg">
                        <?php if($vo["isread"] == 1): ?><span class="label label-success">已查看</span>
                        <?php else: ?>
                          <span class="label label-warning">未查看</span><?php endif; ?>
                      </td>              
                    <td>
                      <a href="<?php echo U('Message/detail',array('id'=> $vo['id']));?>" class="btnra" title="查看">
                        <i class="icon-eye-open"></i>
                        查看留言
                      </a>
                       <a href="<?php echo U('Message/leave_message',array('id'=> $vo['id']));?>" class="btnra" title="回复留言">
                        <i class="icon-plus"></i>
                        回复留言
                      </a>
                    </td>
                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
              </tbody>
            </table>
            <div class="dataTables_paginate paging_full_numbers">
              <span><?php echo ($page); ?></span>
            </div>
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