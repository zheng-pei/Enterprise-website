<?php
namespace System\Controller;
use Think\Controller;
class PicsController extends BackController{
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

        $this->_list(M('Pics'), $map, 'versionid asc,id',true,'sk_pics.id,title,pic,lastedittime,versionname,status','sk_version on sk_pics.versionid=sk_version.id');
        $this->display(); 
      }
     public function add(){
        $versionname=M('Pics')->field('versionid,versionname')->distinct(true)->join('sk_version on sk_version.id=sk_pics.versionid')->select();
        $this->assign('versionname',$versionname);
        $this->display();
     }
      public function edit(){
          $where['sk_pics.id']=$_GET['id'];
          $versionname=M('Pics')->where($where)->field('versionname')->join('sk_version on sk_version.id=sk_pics.versionid')->find();
          $this->assign('versionname',$versionname);
          parent::edit();
    }
    public function update(){
        $m=D('Pics');
        $data['title']=I('post.title'); 
        $data['pic']=I('post.pic');
        $data['status']=I('post.status');
        $where=$_REQUEST['getid'];
        $res=$m->where("id=".$where)->save($data);
        if($res){
         $this->success('修改成功！',U('Pics/index'));
        }else{
         $this->error('修改失败！',U('Pics/index')); 
        }
      }
  
    //添加图片
    public function insert(){
        $_POST['lastedituserid']=$_SESSION[C('USER_AUTH_KEY')];
        $_POST['lastedittime']=time();
        $_POST['lasteditip']=get_client_ip();
        parent::insert(U('Pics/index'));
  }
    
    // 彻底删除
    public function delete(){
       parent::foreverdelete("Pics");
    }

	//是否启用友情链接
	public function changestatus(){
            $map=array();
            $map["id"]=$_GET["id"];
            $result=M("Pics")->where($map)->setField("status", $_GET["status"]);
            unset($_GET["id"]);
            unset($_GET["status"]);
            if($result!==FALSE){
                $this->redirect("Pics/index",$_GET);
                exit;
            }else{
                $this->redirect("Pics/index",$_GET);
                exit;
            }
        }
}