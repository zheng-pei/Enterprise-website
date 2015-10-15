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

<link href="<?php echo RES;?>/css/pages.css" rel="stylesheet" type="text/css"  media="all" />
<div id="main">
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="box">
          <div class="box-title">
            <div class="span7">
              <h3><i class="icon-table"></i>管理员管理</h3>
            </div>
            <div class="span5"></div>
          </div>
          <div class="box-content nozypadding" style="width:100%;">
            <div class="row-fluid">
              <div class="span8 control-group"> <a class="btn" href="<?php echo U('Roleuser/add');?>"><i class="icon-plus"></i>添加管理员</a> <a class="btn" href="javascript:location.reload()"><i class="icon-refresh"></i>刷新</a> </div>
            </div>
            <div class="row-fluid dataTables_wrapper">
              <table id="listTable" class="table table-hover table-nomargin table-bordered usertable dataTable">
                <thead>
                  <tr>
                    <th>管理员编号</th>
                    <th>管理员昵称</th>
                    <th>所属角色</th>
                    <th>登录时间</th>
                    <th>登录ip</th>
                    <th>是否启用</th>
                    <th style="text-align:center;">操作</th>
                  </tr>
                </thead>
                <tbody>
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($vo["id"]); ?></td>
                    <td><?php echo ($vo["username"]); ?></td>
                    <td><?php echo ($vo["rolename"]); ?></td>
                    <td><?php echo (date("Y-m-d H:i:s",$vo["logintime"])); ?></td>
                    <td><?php echo ($vo["loginip"]); ?></td>
                    <td class="statuscg">
                    <?php if($vo['status'] == 1): ?><span class="label label-success">启用</span>
                     <?php else: ?>
                     <span class="label label-warning">未启用</span><?php endif; ?>
                     </td>
                     <td style="text-align:center;">
                     <?php if($vo['status'] == 1): ?><a href="javascript: drop_confirm('确定禁用？','<?php echo U('Roleuser/changestatus',array('id'=>$vo['id'],'status'=>2,'p'=>$p));?>')" class="btnra" title="禁用"><i class="icon-stop"></i>禁用</a>
                     <?php else: ?>
                     <a href="javascript: drop_confirm('确定启用？','<?php echo U('Roleuser/changestatus',array('id'=>$vo['id'],'status'=>1,'p'=>$p));?>')" class="btnra" title="启用"><i class="icon-play"></i>启用</a><?php endif; ?>
                     <a href="<?php echo U('Roleuser/edit',array('id'=>$vo['id']));?>" class="btnra" title="编辑"><i class="icon-edit"></i>编辑</a>
                     <a href="javascript: G.ui.tips.confirm('确定删除？','<?php echo U("Roleuser/delete",array('id'=>$vo['id']));?>')" class="btnra" title="删除"><i class="icon-remove"></i>删除</a>
                    </td>
                  </tr><?php endforeach; endif; else: echo "" ;endif; ?> 
                 </tbody>
              </table>
              <div class="pages dataTables_paginate paging_full_numbers"><?php echo ($page); ?></div>
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