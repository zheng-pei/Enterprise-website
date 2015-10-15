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
<link rel="stylesheet" type="text/css" href="<?php echo RES;?>/css/uploadify_t.css" media="all" />
<script type="text/javascript" src="<?php echo RES;?>/js/jquery_uploadify.js"></script>
<script type="text/javascript" src="<?php echo RES;?>/js/jupload.js"></script>
<div id="main">
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="box">
          <div class="box-title">
            <div class="span10">
              <h3><i class="icon-edit"></i>文件上传管理</h3>
            </div>
            <div class="span2"><a class="btn" href="Javascript:history.back();">返回</a></div>
          </div>
          <div class="box-content">
          <form action="<?php echo U('Download/insert');?>" method="post" id="form1" name="form1" class="form-horizontal form-validate">
          <input type="hidden" name="getid" value="<?php echo ($vo["id"]); ?>"/>
              <div class="control-group">
                <label for="type" class="control-label">网站版本：</label>
                 <div class="controls">
                 <input type="hidden" name="versionid" value="<?php echo ($key); ?>"/>
                   <select class="input-medium" name="versionid" id="ver" data-rule-required="true" data-rule-notem="true">
                 <?php if(is_array($versionlist)): $i = 0; $__LIST__ = $versionlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                 </select>
                 </div>
              </div>
                <div class="control-group">
                <label for="title" class="control-label">文件标题：</label>
                <div class="controls">
                  <input type="text" name="title" class="input-xlarge" data-rule-required="true" data-rule-maxlength="40" placeholder="最多输入40个字符"　value="" />
                  <span class="maroon">*</span> <span class="help-inline"></span> </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="url">文件上传：</label>
                <div class="controls">
                  <input type="text" id="file" name="url" class="input-xlarge" readonly data-rule-required="true" value="" />
                  <span class="help-inline">
                  <button class="btn btn-primary select_file" type="button">选择文件</button>
                </span> <span class="help-inline">允许上传格式（<font color="blue">doc,docx,xls,xlsx,ppt,htm,html,txt,zip,rar,gz,bz2</font>）</span> </div>
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