<?php
namespace System\Controller;
use Think\Controller;
class MessagereplyController extends BackController{

	public function _filter(&$map){
        if(isset($_REQUEST["versionid"])&&$_REQUEST["versionid"]!=0){
            $map["versionid"]=$_REQUEST["versionid"];
        }
        if(isset($_REQUEST["username"])&&$_REQUEST["username"]!=''){
            $map["username"]=array('like','%'.$_REQUEST["username"].'%');
        }
         if(isset($_REQUEST["isreply"])&&$_REQUEST["isreply"]!=''){
            $map["isreply"]=$_REQUEST["isreply"];
        }
    }

	public function index(){
		    $map=array();
      	$this->_filter($map);
      	$where['id']=$_SESSION[C('USER_AUTH_KEY')];
      	$replyman=M('Roleuser')->where($where)->find();
      	$this->assign('replyman',$replyman);
        $this->_list(M('Messagereply'), $map, '',true,'sk_messagereply.id,messageid,sk_message.id userid,sk_message.isreply,sk_message.username,sk_message.createtime','sk_message on sk_message.id=sk_messagereply.messageid');
	    $this->display();
	}

	public function detail(){
		$map['sk_messagereply.id']=$_GET['id'];
        $username=M('Messagereply')->where($map)->field('username,content,replycontent,sex,email,phone,address,sk_message.createtime leavemessage_time,sk_messagereply.createtime reply_time')->join('sk_message on sk_message.id=sk_messagereply.messageid')->find();
        $where['id']=$_SESSION[C('USER_AUTH_KEY')];
        $replyman=M('Roleuser')->where($where)->field('username')->find();
        $this->assign('info',$username);
        $this->assign('replyman',$replyman);
        $this->display();
	}

}