<?php
namespace Home\Controller;
use Think\Controller;
// 实验新闻
class NewsController extends CommonController {
    // 新闻的详细内容
    public function news(){
    	$pid=isset($_GET['pid']) ? $_GET['pid'] : 1;
		$cateid=isset($_GET['cateid']) ? $_GET['cateid'] : 1;
		$_SESSION['pid'] = $pid;
		$_SESSION['cateid'] = $cateid;
        parent::leftmenu();
        parent::inner_news();
    	$this->display();
    }
}