<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo C('site_name');?>-后台管理登陆</title>
<link href="<?php echo RES;?>/css/login.css" type="text/css" rel="stylesheet" />
</head>

<body>
<div class="main">
  <div class="c1">
    <div class="c2"><img src="<?php echo RES;?>/images/hqlogo.png" /></div>
    <div class="c3">
    <div class="c4">
    <form action="<?php echo U('System/Login/checkLogin');?>" method="post">
    <ul>
    <li><span class="user"><input name="username" type="text" class="username" value="" placeholder="账号"></span></li>
    <li><span class="pass"><input name="password" type="password" class="password" style="" value=""  placeholder="密码" ></span></li>
    <li><input value="登录" type="submit" class="submit">
    </ul>
    </form>
    </div>
    </div>
  </div>
</div>
</body>
</html>