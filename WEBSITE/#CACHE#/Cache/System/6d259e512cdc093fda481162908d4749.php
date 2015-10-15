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

<div id="navigation">
  <div class="container-fluid">
    <div> <a href="#" target="_self" id="brand"><img src="<?php echo RES;?>/images/logo1.png" /></a> </div>
    <ul class='main-nav'>
    <?php if(is_array($menus1)): $i = 0; $__LIST__ = $menus1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li <?php if($i == 1): ?>class='active'<?php endif; ?> data='<?php echo ($vo["id"]); ?>'> <a href="javascript:;" onClick="show(<?php echo ($vo["id"]); ?>);"> <span><?php echo ($vo["title"]); ?></span> </a> </li><?php endforeach; endif; else: echo "" ;endif; ?>   
    </ul>
    <div class="userbox">
      <ul class="box-nav">
        <li> <a href="<?php echo U('System/Index/index');?>" target="_self" title="打开首页"><i><img src="<?php echo RES;?>/images/adminicon.png" /></i><?php echo (getusername($userid)); ?></a> </li>
        <!-- 消息提醒功能 -->
        <li> <a href="<?php echo U('System/Message/index');?>" title="消息提醒" ><i><img src="<?php echo RES;?>/images/adminicon.png" /></i><span>未读留言</span><span id="messages"></span></a> </li>

        <li> <a href="javascript:;" title="修改密码" class="changepwd"><i><img src="<?php echo RES;?>/images/gicon.png" /></i>修改密码</a> </li>
        <li><a  href="javascript:if(confirm('是否要退出?')){this.location.href='<?php echo U('System/Login/logout');?>'};" target="_self"  title="退出"><i><img src="<?php echo RES;?>/images/cicon.png" /></i>退出</a> </li>
      </ul>
    </div>
 
  </div>
</div>
<div class="container-fluid" id="content">
  <div id="left">
        <!--subnav--> 
    <?php if(is_array($menus2)): foreach($menus2 as $pid=>$vo1): if($menus1[$pid]['hassub'] != 1): if(is_array($vo1)): $i = 0; $__LIST__ = $vo1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?><div class="subnav" data="<?php echo ($vo2["pid"]); ?>">
          <div class="subnav-title "> <a href="<?php echo ($vo2["url"]); ?>" class='toggle-subnav'><span><?php echo ($vo2["title"]); ?></span></a> </div>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
     <?php else: ?>
     <div class="subnav" data="<?php echo ($pid); ?>">
          <ul class="nav nav-tabs" id="myTab">
              <?php if(is_array($versionlist)): $verk = 0; $__LIST__ = $versionlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vers): $mod = ($verk % 2 );++$verk;?><li <?php if(($verk) == "1"): ?>class="active"<?php endif; ?>><a href="#version<?php echo ($verk); ?>"  data-toggle="tab"><?php echo ($vers); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <div id="myTabContent" class="tab-content">
           <?php if(is_array($vo1)): $vid = 0; $__LIST__ = $vo1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vov): $mod = ($vid % 2 );++$vid;?><div class="tab-pane fade <?php if(($vid) == "1"): ?>active in<?php endif; ?>" id="version<?php echo ($vid); ?>">
           		<?php if(is_array($vov)): $i = 0; $__LIST__ = $vov;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vov2): $mod = ($i % 2 );++$i;?><div class="subnav-new" style=" margin-bottom:2px;">
                <div class="subnav-title "> <a href="javascript:void(0)" class='toggle-subnav'><span><?php echo ($vov2["title"]); ?></span><i class="arr-right"></i></a> </div>
                <ul class="subnav-menu">
                  <?php if(is_array($vov2["subitem"])): $key3 = 0; $__LIST__ = $vov2["subitem"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo3): $mod = ($key3 % 2 );++$key3;?><li> <a href="<?php echo ($vo3["url"]); ?>" target="mainFrame" class="menu3"><?php echo ($vo3["title"]); ?></a> </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
          </div>
        </div><?php endif; endforeach; endif; ?>

  </div>
  <!--left-->
  <div class="right">
    <div class="main">
      <iframe frameborder="0" id="mainFrame" name="mainFrame" src="##"></iframe>
    </div>
  </div>
</div>

	<div style="clear:both;"></div>
</div>

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="changepass" action="" method="post" class="form-horizontal form-validate">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><i class="icon-table"></i>修改密码</h4>
        </div>
        <div class="modal-body">
          <div class="row-fluid"> 
          	<div class="box-content">
              	<div class="control-group">
                    <label for="oldpassword" class="control-label">原始密码：</label>
                    <div class="controls">
                        <input name="oldpassword" id="oldpassword" type="password"  class="input-medium" placeholder="" />
                        <span class="help-inline"></span>
                     </div>
                </div>
                <div class="control-group">
                    <label for="newpassword" class="control-label">新密码：</label>
                    <div class="controls">
                        <input name="newpassword" id="newpassword" type="password" data-rule-required="true" class="input-medium" placeholder="" />
                        <span class="help-inline"></span>
                     </div>
                </div>
          	    <div class="control-group">
                    <label for="newpassword2" class="control-label">确认密码：</label>
                    <div class="controls">
                        <input name="newpassword2" id="newpassword2" type="password" data-rule-required="true" class="input-medium" placeholder="" />
                        <span class="help-inline"></span>
                     </div>
                </div>
               
             </div>
        </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="changepwd();">确定</button>
        </div>
      </form>
      
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
<script>
	  window.setInterval("getmessageNum()", 1000);
    function getmessageNum(){
      $.ajax({
      url: "<?php echo U('Index/messages');?>",
      type: "GET",
      data:{id:1},
      success: function(data){
        var json=eval('('+data+')');
        var count=json.length;
        console.log(json.length);
        $("#messages").html("(<font color='red'>"+count+"</font>)");
         }
     });
  }
		$(document).ready(function(){			
			var mrpid=$(".main-nav li").eq(0).attr('data');
			$("#left .subnav[data='"+mrpid+"']").show();
			//$("#left .subnav[data='"+mrpid+"']").eq(0).children('.subnav-menu').show();
			var default_url=$("#left .subnav[data='"+mrpid+"']:eq(0) .subnav-menu li:eq(0) a:eq(0)").attr('href');
			$('#mainFrame').attr('src',default_url);
			var authu=false;
						if(authu){
				$("#myauthModal").modal("show");
			}
			
			// 绑定菜单提示语切换
			$('#menu-handle').click(function(){
				switchMenu(this);
			});

			// 设置皮肤色
			P.skn();
			$(".changepwd").on("click",function(){
				$("#oldpassword").val('');
				$("#newpassword").val('');
				$("#newpassword2").val('');
				$("#myModal").modal("show");	
			});
			
			
		});

		function switchMenu(obj){
			if('隐藏菜单' == $(obj).attr('title')){
				$(obj).attr('title', '显示菜单');
			}else{
				$(obj).attr('title', '隐藏菜单');
			}
		}

		function show(i){
			$("#left .subnav").hide();
			$("#left .subnav[data='"+i+"']").show();
			$(".main-nav li").removeClass("active");
			$(".main-nav li[data='"+i+"']").addClass("active");
			$("#left .subnav[data='"+i+"']").find('.subnav-menu').hide();
			$("#left .subnav[data='"+i+"']").eq(0).find('.subnav-menu').show();
			if($("#left .subnav[data='"+i+"'] .subnav-new").length>0){
				$("#left .subnav[data='"+i+"'] .tab-content .subnav-menu").hide();
				$("#left .subnav[data='"+i+"'] .tab-content .subnav-menu").eq(0).show();
				$("#left .subnav[data='"+i+"'] .tab-content .subnav-menu li").eq(0).addClass("active");
				}
			if($("#left .subnav[data='"+i+"']:eq(0) .subnav-menu li").length>0){
				
			var default_url=$("#left .subnav[data='"+i+"']:eq(0) .subnav-menu li:eq(0) a:eq(0)").attr('href');
			}else{
				var default_url=$("#left .subnav[data='"+i+"']:eq(0) a:eq(0)").attr('href');
			}
			$('#mainFrame').attr('src',default_url);
		}
		show(1);
		$(function(){
			$("#mainFrame").load(function() {
                $("#mainFrame").contents().find("body").css("min-width","inherit"); //min-width没有auto的属性值！
            });
	   // $("#mainFrame").contents().find("body").css("min-height","auto"); //.contents()前对象仅可为iframe
		})
		
		function changepwd(){
			$('#myModal .help-inline').text('');
			if($('#oldpassword').val()==''){
				$('#oldpassword').focus();
				$('#oldpassword').next(".help-inline").text('请输入原始密码');	
			}else if($('#newpassword').val()==''){
				$('#newpassword').focus();
				$('#newpassword').next(".help-inline").text('请输入新密码');	
			}else if($('#newpassword2').val()==''){
				$('#newpassword2').focus();
				$('#newpassword2').next(".help-inline").text('请输入确认密码');	
			}else if($('#newpassword').val()!=$('#newpassword2').val()){
				$('#newpassword2').focus();
				$('#newpassword2').next(".help-inline").text('确认密码与新密码不一致');	
			}else{
				$('#myModal').modal("hide");
				$.post("<?php echo U('Roleuser/changepwd');?>",$("#changepass").serialize(),function(data){
					if(data.errno){
						alert(data.error);
					}else{
						alert(data.error);
						location.reload();	
					}
				},"json");
			}
		}

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