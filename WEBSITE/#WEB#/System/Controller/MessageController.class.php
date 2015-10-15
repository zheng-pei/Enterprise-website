<?php
namespace System\Controller;
use Think\Controller;
class MessageController extends BackController{

	public function _filter(&$map){
        if(isset($_REQUEST["versionid"])&&$_REQUEST["versionid"]!=0){
            $map["versionid"]=$_REQUEST["versionid"];
        }
        if(isset($_REQUEST["username"])&&$_REQUEST["username"]!=''){
            $map["username"]=array('like','%'.$_REQUEST["username"].'%');
        }
        if(isset($_REQUEST["isread"])&&$_REQUEST["isread"]!=''){
            $map["isread"]=$_REQUEST["isread"];
        }
    }

	public function index(){
		$map=array();
      	$this->_filter($map);
        $this->_list(M('Message'), $map, '',true,'sk_message.id,username,sex,phone,address,email,sk_message.createtime,isreply,status,isread');
		$this->display();
	}
// 用来查看用户提交的信息
	public function detail(){
		$id=$_GET['id'];
        //保存已经查看的留言
        $data['isread']=1;
        M('Message')->where('id='.$id)->save($data);
		$res=M('Message')->field('username,sex,phone,address,email,createtime,content')->find($id);
		$this->assign('message',$res);
		$this->display();
	}

    public function leave_message(){
        $map['sk_message.id']=$_GET['id'];
        // 查找用户的信息
        $userinfo=M('Message')->where($map)->find();
        // 查找回复的内容
        $map1['sk_messagereply.messageid']=intval($_GET['id']);
        $replycontent=M('Messagereply')->where($map1)->find();
          // 查找回复人
        $where['id']=$_SESSION[C('USER_AUTH_KEY')];
        $replyman=M('Roleuser')->where($where)->field('username')->find();
        $this->assign('info',$userinfo);
        $this->assign('id',$_GET['id']);
        $this->assign('replyman',$replyman);
        $this->assign('replycontent',$replycontent['replycontent']);
        $this->display();
    }

    public function save(){
        $data['messageid']=I('post.id',0,'intval');
        $data['createtime']=time();
        $data['createip']=get_client_ip();
        $data['userid']=$_SESSION[C('USER_AUTH_KEY')];
        $data['replycontent']=I('post.replycontent','','strip_tags');
        // 查找留言messageid
        $map['messageid']=$_GET['id'];
        $id=M('Messagereply')->where($map)->getField('id',true);
        $where['id']=$id[0];
        $res=M('Messagereply')->where($where)->save($data);
        if($res){
             //如果有留言回复，则将该用户的状态变成回复
                if($data['replycontent']!=''){
                    $data1['isreply']=1;
                    $map['id']=I('post.id',0,'intval');
                    M('Message')->where($map)->save($data1);
                }
           $this->success('保存成功！',U('Message/index'));
        }else{
          $this->redirect('保存失败！',U('Message/index'));
        }
    }
}