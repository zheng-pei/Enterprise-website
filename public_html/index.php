<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
define('APP_WEB_ROOT',dirname(__FILE__));
define('THINK_PATH',dirname(APP_WEB_ROOT).'/Tpcore/#CORE#/');
define('APP_NAME',dirname(APP_WEB_ROOT).'/WEBSITE/#WEB#/');
define('APP_PATH',dirname(APP_WEB_ROOT).'/WEBSITE/#WEB#/');
define('RUNTIME_PATH',dirname(APP_WEB_ROOT).'/WEBSITE/#CACHE#/');
// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

// 引入ThinkPHP入口文件
require THINK_PATH.'/ThinkPHP.php';

?>
