<?php
namespace System\Controller;
use Think\Controller;
class FriendlinkController extends BackController{
    public function _filter(&$map){
      if(isset($_REQUEST["versionid"])&&$_REQUEST["versionid"]!=0){
            $map["versionid"]=$_REQUEST["versionid"];
      }
      if(isset($_REQUEST["showtype"])&&$_REQUEST["showtype"]!=0){
            $map["showtype"]=$_REQUEST["showtype"];
      }
      if(isset($_REQUEST["title"])&&$_REQUEST["title"]!=''){
            $map["title"]=array('like','%'.$_REQUEST["title"].'%');
      }
    }

    public function index(){
      $map=array();
      $this->_filter($map);
      $this->_list(M('Friendlink'), $map, 'versionid asc,id',true,'sk_friendlink.id,title,showtype,sk_friendlink.url,pic,sk_friendlink.createtime,versionname,status','sk_version on sk_friendlink.versionid=sk_version.id');
      $this->display(); 
	  
    }
      
    public function edit(){
        $where['sk_friendlink.id']=$_GET['id'];
        $versionname=M('Friendlink')->where($where)->field('versionname')->join('sk_version on sk_version.id=sk_friendlink.versionid')->find();
        $this->assign('versionname',$versionname);
        parent::edit();
    }

    public function add(){

      $versionname=M('Friendlink')->field('versionid,versionname')->distinct(true)->join('sk_version on sk_version.id=sk_friendlink.versionid')->select();
      $this->assign('versionname',$versionname);
      $this->display();
    }
    public function update(){
      $m=D('Friendlink');
        $data['title']=I('post.title'); 
        $data['pic']=I('post.pic');
        $data['url']=I('post.url');
        $data['showtype']=I('post.showtype');
        $data['status']=I('post.status');
        $where=$_REQUEST['getid'];
        $res=$m->where("id=".$where)->save($data);
        if($res){
          $this->success('修改成功！',U('Friendlink/index'));
        }else{
         $this->error('修改失败！',U('Friendlink/index'));
        }
    }
 
    //添加友情链接
    public function insert(){
      $_POST['createtime']=time();
      $_POST['createip']=get_client_ip();
      $_POST['userid']=$_SESSION[C('USER_AUTH_KEY')];
      parent::insert(U('Friendlink/index'));
  }
    
    // 彻底删除
    public function delete(){
       parent::foreverdelete("Friendlink");
    }

	//是否启用友情链接
	public function changestatus(){
            $map=array();
            $map["id"]=$_GET["id"];
            $result=M("Friendlink")->where($map)->setField("status", $_GET["status"]);
            unset($_GET["id"]);
            unset($_GET["status"]);
            if($result!==FALSE){
                $this->redirect("Friendlink/index",$_GET);
                exit;
            }else{
                $this->redirect("Friendlink/index",$_GET);
                exit;
            }
        }
}