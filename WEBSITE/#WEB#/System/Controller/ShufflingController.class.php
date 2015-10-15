<?php
namespace System\Controller;
use Think\Controller;
class ShufflingController extends BackController{
    public function _filter(&$map){
      if(isset($_REQUEST["versionid"])&&$_REQUEST["versionid"]!=0){
            $map["versionid"]=$_REQUEST["versionid"];
      }
      if(isset($_REQUEST["title"])&&$_REQUEST["title"]!=''){
            $map["title"]=array('like','%'.$_REQUEST["title"].'%');
      }
    }

    public function index(){
      $map=array();
      $this->_filter($map);

      $this->_list(M('Shuffling'), $map, 'versionid asc,id',true,'sk_shuffling.id,title,pic,versionname,sk_shuffling.createtime,status','sk_version on sk_shuffling.versionid=sk_version.id');
      $this->display(); 
    }
	
    public function changestatus(){
            $map=array();
            $map["id"]=$_GET["id"];
            $result=M("Shuffling")->where($map)->setField("status", $_GET["status"]);
 			unset($_GET["id"]);
            unset($_GET["status"]);
            if($result!==FALSE){
                $this->redirect("Shuffling/index",$_GET);
                exit;
            }else{
                $this->redirect("Shuffling/index",$_GET);
                exit;
            }
        }
        
    public function edit(){
      $where['sk_shuffling.id']=$_GET['id'];
      $versionname=M('Shuffling')->where($where)->field('versionname,pic')->join('sk_version on sk_version.id=sk_shuffling.versionid')->find();
      $this->assign('version',$versionname);
      parent::edit();
    }
    public function update(){
      $data['title']=I('post.title'); 
      $data['pic']=I('post.pic');
      $data['createtime']=time();
      $data['status']=I('post.status');
      $where['id']=$_POST['getid'];
      $res=M('Shuffling')->where($where)->save($data);
      if($res){
        $this->success("修改成功！",U('Shuffling/index'));
      }else{
         $this->error("修改失败！",U('Shuffling/index'));
      }
    }
 

    public function add(){
      $versionname=M('Shuffling')->field('sk_version.versionname,versionid')->distinct(true)->join('sk_version on sk_shuffling.versionid=sk_version.id')->select(); 
      $this->assign('versionname',$versionname);
      parent::add();
    }
    //添加轮播
    public function insert(){
      $_POST['createtime']=time();
      $_POST['createip']=get_client_ip();
      $_POST['userid']=$_SESSION[C('USER_AUTH_KEY')];
      parent::insert(U('Shuffling/index'));
  }
    
    // 彻底删除
    public function delete(){
       parent::foreverdelete("index");
    }
}
