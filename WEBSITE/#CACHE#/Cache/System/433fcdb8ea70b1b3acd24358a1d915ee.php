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
              <h3><i class="icon-edit"></i>编辑其他图片</h3>
            </div>
            <div class="span2"><a class="btn" href="Javascript:history.back();">返回</a></div>
          </div>
          <div class="box-content">
          <form action="<?php echo U('Pics/update');?>" method="post" id="form1" name="form1" class="form-horizontal form-validate">
          <input type="hidden" name="getid" value="<?php echo ($vo["id"]); ?>"/>
               <div class="control-group">
                <label for="type" class="control-label">网站版本：</label>
                 <div class="controls">
                 <input type="text" name="versionid" readonly="true" value="<?php echo ($versionname["versionname"]); ?>">
                  <span class="maroon">*</span> <span class="help-inline"></span></div>
              </div>
              <div class="control-group">
                <label for="username" class="control-label">图片标题描述：</label>
                <div class="controls">
                  <input type="text" name="title" id="title" class="input-large" data-rule-required="true" data-rule-maxlength="20" placeholder="请注明是logo还是静态banner" value="<?php echo ($vo["title"]); ?>" />
                  <span class="maroon">*</span> <span class="help-inline">请注明是“logo”还是“静态banner”</span> </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="pic">上传图片:</label>
                <div class="controls">
                  <input type="text" id="pic" name="pic" class="input-xlarge" data-rule-required="true" readonly value="<?php echo ($vo["pic"]); ?>" />
                  <button class="btn btn-primary select_img" type="button">选择图片</button>
                    <span class="maroon">*</span> <span class="help-inline"><?php echo gettips('category','pic',1);?></span></div>
              </div>
              <div class="control-group">
                <label for="status" class="control-label">是否启用：</label>
                <div class="controls">
                  <select name="status" id="status">
                  <option value="1" <?php if($vo['status'] == 1): ?>selected<?php endif; ?>>启用</option>
                  <option value="2" <?php if($vo['status'] == 2): ?>selected<?php endif; ?>>禁用</option>
                  </select>
                  <span class="maroon">*</span> <span class="help-inline"></span> </div>
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
<script type="text/javascript" src="<?php echo RES;?>/js/jquery_uploadify.js"></script>
<script type="text/javascript" src="<?php echo RES;?>/js/jupload.js"></script>
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