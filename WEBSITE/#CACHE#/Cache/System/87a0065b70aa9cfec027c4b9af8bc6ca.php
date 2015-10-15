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

<link rel="stylesheet" type="text/css" href="<?php echo STATICS;?>/kindeditor/themes/default/default.css" />
<script type="text/javascript" src="<?php echo STATICS;?>/kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" src="<?php echo STATICS;?>/kindeditor/lang/zh_CN.js"></script>
<div id="main">
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="box">
          <div class="box-title">
            <div class="span10">
              <h3> <i class="icon-plus"></i>
                留言回复详情
              </h3>
            </div>
            <div class="span2">
              <a class="btn" href="Javascript:history.back();">返回</a>
            </div>
          </div>
          <div class="box-content">
            <form action="<?php echo U('Message/save');?>" method="post" id="form" class="form-horizontal form-validate" enctype="multipart/form-data" >
            <input type="hidden" name="id" value="<?php echo ($id); ?>"/>
              <div class="control-group">
                <label for="username" class="control-label">留言人：</label>
                <div class="controls">
                  <input type="text" name="username" class="input-large" disabled="true" data-rule-required="true" value="<?php echo ($info["username"]); ?>" />
                </div>
              </div>
              <div class="control-group">
                <label for="phone" class="control-label">电话：</label>
                <div class="controls">
                <input type="text" name="phone" class="input-xlarge" disabled="true" data-rule-required="true" value="<?php echo ($info["phone"]); ?>" />
                  </div>
              </div>
              <div class="control-group">
                <label for="address" class="control-label">所在地址：</label>
                <div class="controls">
                <input type="text" name="address" class="input-xlarge" readonly disabled="true" data-rule-required="true" value="<?php echo ($info["address"]); ?>" />
                  </div>
              </div>
                <div class="control-group">
                <label for="email" class="control-label">Email：</label>
                <div class="controls">
                <input type="text" name="email" class="input-xlarge" readonly disabled="true" data-rule-required="true" value="<?php echo ($info["email"]); ?>" />
                  </div>
              </div>
              <div class="control-group">
                <label for="createtime" class="control-label">留言时间：</label>
                <div class="controls">
                <input type="text" name="createtime" readonly class="input-xlarge" data-rule-required="true" value="<?php echo (date("Y-m-d H:i:s",$info["createtime"])); ?>" />
                  </div>
              </div>
               <div class="control-group">
                <label for="content" class="control-label">留言内容：</label>
                <div class="controls">
                  <textarea name="content" cols="30"  name="content" row="20" readonly style="resize:none;width:500px;height:250px;"><?php echo ($info["content"]); ?></textarea>
                </div>
              </div>
              <div class="control-group">
                <label for="admin" class="control-label">回复人：</label>
                <div class="controls">
                  <input type="text" name="admin" class="input-large" readonly data-rule-required="true" value="<?php echo ($replyman["username"]); ?>" />
                </div>
              </div>
              <div class="control-group">
                <label for="replycontent" class="control-label">回复内容：</label>
                <div class="controls">
                  <textarea cols="30"  name="replycontent" row="20" style="resize:none;width:500px;height:250px;"><?php echo ($replycontent); ?></textarea>
                </div>
              </div>
              <div class="form-actions">
                <button id="bsubmit" type="submit" data-loading-text="提交中..." class="btn btn-primary">保存</button>
                <a class="btn" href="javascript:history.back();">取消</a>
              </div>
            </form>
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