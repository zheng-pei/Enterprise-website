<?php
namespace Home\Controller;
use Think\Controller;
// 显示文章列表的控制器
class ArticleController extends CommonController {
	public function lists(){
		// 获取分页的页码
		$_SESSION['p']=isset($_GET['p']) ? $_GET['p'] : 1;
		$pid=isset($_GET['pid']) ? $_GET['pid'] : 1;
		$cateid=isset($_GET['cateid']) ? $_GET['cateid'] : 1;
		$_SESSION['pid'] = $pid;
		$_SESSION['cateid'] = $cateid;
		$map['versionid']=$_SESSION['versionid'];
		$map['id']=$pid;
		$pidcolumn=M('Category')->where($map)->find();
		// 分配栏目的名称作为网页的标题
        $this->assign('title',$pidcolumn['catename']);
		parent::leftmenu();
		parent::static_pic();
		//实验室主任列表，左图右文字
		if($cateid==12||$cateid==37){
			parent::news_lists();
			$this->display('Lab:zurenlists');
			exit;
		}
		// 团队列表，左图右文字
		if($pid==7||$pid==32){
			parent::news_lists();
			$this->display('Team:teamlists');
			exit;
		}
		// 论文列表
		if($cateid==15||$cateid==40){
			parent::news_lists();
			$this->display('Searchfruit:lunwen');
			exit;
		}
		// 奖励列表
		if($cateid==16||$cateid==41){
			parent::news_lists();
			$this->display('Searchfruit:jiangli');
			exit;
		}
		// 代表成果列表
		if($cateid==17||$cateid==42){
			parent::news_lists();
			$this->display('Searchfruit:fruit');
			exit;
		}
		// 近期项目，开放课题设置的列表
		if($pid==3||$cateid==14||$cateid==20||$pid==28||$cateid==39||$cateid==45){
			parent::news_lists();
			$this->display('Searchfruit:keyanxm');
			exit;
		}
		// 显示项目列表
		if($pid==2||$pid==27){
			parent::news_lists();
			$this->display('Searchpro:xiangmu');
			exit;
		}
		// 直接是内容页，有图集内容，文章内容，图文内容
		if($pid==1||$pid==4||$pid==6||$pid==9||$pid==26||$pid==29||$pid==6||$pid==31||$pid==34){			
			parent::content();
			$this->display('Public:content');
			exit;
		}
		//显示新闻列表，国内外交流，左边文字，右边图片
		if($pid==5||$pid==8||$pid==30||$pid==33){
			parent::news_lists();
			$this->display('News:newslists');
			exit;
		}
		$this->assign('pid',$_SESSION['pid']);
	}
}