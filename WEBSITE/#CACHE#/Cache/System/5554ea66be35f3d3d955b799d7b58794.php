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

<body>
<div id="main">
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="box">
          <div class="box-title">
            <div class="span10">
              <h3> <i class="icon-edit"></i>
                网站的设置
              </h3>
            </div>
            <div class="span2"></div>
          </div>
          <div class="box-content">
            <form action="<?php echo U('Config/saveconfig');?>" method="post" id="form1" class="form-horizontal form-validate" enctype="multipart/form-data" >
              <div class="control-group"> 
                <div class="controls">
                <label for="versionid" class="control-label">语言版本：</label>
                 <select name="versionid" id="versionid" onchange="changeversion();">
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["versionname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
              </select>
               </div>
              </div>
              <div class="control-group" id="v1" >  
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
<script type="text/javascript">
function changeversion(){
  var id=$('#versionid').val();
  $.ajax({
    url:"<?php echo U('Config/versioninfo');?>",
    type:'post',
    data:{id:id},
    success:function(data){
      var json = eval('(' + data + ')');
      // 清空div里面的数据
      $('#v1').html('');
      var str="";
      // alert(json.length);
      for(var i=0;i<json.length;i++){
        if((json[i]['showtype'])==1){
          str+=" <div class='controls'> <label class='control-label' for='content'>"+json[i]['title']+" </label><input name='"+json[i]['fieldname']+"' type='text' class='input-large' data-rule-required='true' value='"+json[i]['fieldvalue']+"' /> <span class='maroon'>*"+json[i]['tips']+"</span> </div>";
        }
        if((json[i]['showtype'])==2){
          str+=" <div class='controls'> <label class='control-label' for='content'>"+json[i]['title']+" </label><input name='"+json[i]['fieldname']+"' type='url' class='input-large' data-rule-required='true' value='"+json[i]['fieldvalue']+"' /> <span class='maroon'>*"+json[i]['tips']+"</span> </div>";
        }
         if((json[i]['showtype'])==3){
          str+=" <div class='controls'> <label class='control-label' for='content'>"+json[i]['title']+" </label><textarea name='"+json[i]['fieldname']+"'  rows='8' cols='10' class='input-xlarge' style='width:300px;resize:none' data-rule-required='true'> "+json[i]['fieldvalue']+"</textarea> <span class='maroon'>*"+json[i]['tips']+"</span> </div>";
        }
      }
      $('#v1').html(str);
    }
  });
}
changeversion();
</script>
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