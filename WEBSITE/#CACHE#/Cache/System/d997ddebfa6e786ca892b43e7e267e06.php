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
            <div class="span10">
              <h3> <i class="icon-plus"></i>
                留言字段设置
              </h3>
            </div>
            <div class="span2">
              <a class="btn" href="Javascript:history.back();">返回</a>
            </div>
          </div>
          <div class="box-content">
            <form action="<?php echo U('Messageconfig/update');?>" method="post" id="form" class="form-horizontal form-validate">
          
            <input type="checkbox" <?php if(in_array(($username), is_array($str)?$str:explode(',',$str))): ?>checked="checked"<?php endif; ?> name="msgfields[]" value="username"/>
              留言昵称　　　
              <input type="checkbox" <?php if(in_array(($sex), is_array($str)?$str:explode(',',$str))): ?>checked="checked"<?php endif; ?>  name="msgfields[]" value="sex"/>
              性别　　　
              <input type="checkbox" <?php if(in_array(($phone), is_array($str)?$str:explode(',',$str))): ?>checked="checked"<?php endif; ?>  name="msgfields[]" value="phone"/>
              留言者电话　　　
              <input type="checkbox" <?php if(in_array(($address), is_array($str)?$str:explode(',',$str))): ?>checked="checked"<?php endif; ?> name="msgfields[]" value="address"/>
              留言者地址　　　
              <input type="checkbox" name="msgfields[]" <?php if(in_array(($email), is_array($str)?$str:explode(',',$str))): ?>checked="checked"<?php endif; ?> value="email"/>
              留言者邮箱　　　
              <input type="checkbox" name="msgfields[]" <?php if(in_array(($content), is_array($str)?$str:explode(',',$str))): ?>checked="checked"<?php endif; ?>　 value="content"/>
              留言内容　　　
              <input type="checkbox" name="msgfields[]" <?php if(in_array(($createtime), is_array($str)?$str:explode(',',$str))): ?>checked="checked"<?php endif; ?> value="createtime"　/>
              留言时间　　　
              <input type="checkbox" name="msgfields[]" <?php if(in_array(($qq), is_array($str)?$str:explode(',',$str))): ?>checked="checked"<?php endif; ?>　 value="qq"/>
              留言qq　　　
              <input type="checkbox" name="msgfields[]"  <?php if(in_array(($wechat), is_array($str)?$str:explode(',',$str))): ?>checked="checked"<?php endif; ?>　 value="wechat"/>
              留言微信　　　
              <input type="checkbox" name="msgfields[]" <?php if(in_array(($weibo), is_array($str)?$str:explode(',',$str))): ?>checked="checked"<?php endif; ?>　 value="weibo"/>
              留言微博
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