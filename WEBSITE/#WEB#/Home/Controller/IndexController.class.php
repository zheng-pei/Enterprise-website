<?php
namespace Home\Controller;
use Think\Controller;
// 首页
class IndexController extends CommonController {
    public function index(){
        //根据不同的版本提取相应的内容 
        if($_SESSION['versionid']==1){
            // 提取实验室概况
            $this->lab(1);
            // 提取科研团队内容
            $this->team(7,22);
             // 科研奖励
            $this->prize(3,16);           
          // 提取新闻,项目,开发和交流
            $newslists=$this->textlists(8,23);
            $this->assign(array('newsleft'=>$newslists['a'],'newsright'=>$newslists['b'],'newsname'=>$newslists['catename']));
            $this->assign(array('newspid'=>8,'newscateid'=>23));
            $searchpro=$this->textlists(2,13);
            $this->assign(array('proleft'=>$searchpro['a'],'proright'=>$searchpro['b'],'proname'=>$searchpro['catename']));
            $this->assign(array('propid'=>2,'procateid'=>13));
            $open=$this->textlists(5,19);
            $this->assign(array('openleft'=>$open['a'],'openright'=>$open['b'],'openname'=>$open['catename']));
            $this->assign(array('openpid'=>5,'opencateid'=>19));
            $this->assign('title','首页');
        }else{
              // 提取英文版的内容
            $this->lab(26);
            $this->team(32,47);
            $this->prize(28,41);
            // 提取新闻,项目,开发和交流
            $newslists=$this->textlists(33,48);
            $this->assign(array('newsleft'=>$newslists['a'],'newsright'=>$newslists['b'],'newsname'=>$newslists['catename']));
            $this->assign(array('newspid'=>33,'newscateid'=>48));
            $searchpro=$this->textlists(27,38);
            $this->assign(array('propid'=>27,'procateid'=>38));
            $this->assign(array('proleft'=>$searchpro['a'],'proright'=>$searchpro['b'],'proname'=>$searchpro['catename']));
            $open=$this->textlists(30,44);
            $this->assign(array('openpid'=>30,'opencateid'=>44));
            $this->assign(array('openleft'=>$open['a'],'openright'=>$open['b'],'openname'=>$open['catename']));
            $this->assign('title','Index');
        }
    	$this->assign('i',1);
        $this->display();
    }
// 实验室概况的内容
    public function lab($id){
         // 提取中文版的内容
            $lab=M('Category')->where('id='.$id)->find();
            // 读取简介的信息
            $introduce=M('Category')->where('pid='.$id)->find();
            $cateid=$introduce['id'];
            if($cateid){
               $labinfo=M('Article')->where('cateid='.$cateid)->order('sort desc')->limit(1)->select(); 
            }
            $this->assign(array('lab'=>$lab,'labinfo'=>$labinfo[0]));
    }
    // 提取团队内容
    public function team($pid,$cateid){
        $teamname=M('Category')->where('id='.$pid)->getField('catename',true);
        $this->assign('teamname',$teamname[0]);
        // 团队栏目的子栏目的前4个
        $where['status']=1;
        $where['cateid']=$cateid;
        $teamlists=M('Article')->where($where)->order('id desc,istop desc')->limit(4)->select();
        if(!empty($teamlists)){
            $this->assign(array('teampid'=>$pid,'teamcateid'=>$cateid));
            $this->assign('teamlists',$teamlists);
        }
    }
    // 提取奖励的内容
    public function prize($pid,$cateid){
        $where['id']=$cateid;
        $where['versionid']=$_SESSION['versionid'];
        $prize=M('Category')->where($where)->getField('catename',true);
        $this->assign('prize',$prize['0']);
        $map['status']=1;
        $map['versionid']=$_SESSION['versionid'];
        $map['cateid']=$cateid;
        $prizelists=M('Article')->where($map)->order('id desc,istop desc')->limit(4)->select();
        if(!empty($prizelists)){
            $this->assign(array('prizepid'=>$pid,'prizecateid'=>$cateid));
            $this->assign('prizelists',$prizelists);
        }
    }

    public function textlists($id,$cateid){
        $map1['id']=$id;
        $map1['versionid']=$_SESSION['versionid'];
        $map2['cateid']=$cateid;
        $map2['status']=1;
        $map2['versionid']=$_SESSION['versionid'];
        $newsname=M('Category')->where($map1)->field('catename')->find();
        $newslists=M('Article')->where($map2)->order('id desc,istop desc')->limit(6)->select();
        $newsleft=array();
        $newsright=array();
        foreach ($newslists as $key => $value) {
            if($key<3){
                $newsleft[$key]=$value;
            }else{
                $newsright[$key]=$value;
            }
        }
        return array('a'=>$newsleft,'b'=>$newsright,'catename'=>$newsname['catename']);
    }
}