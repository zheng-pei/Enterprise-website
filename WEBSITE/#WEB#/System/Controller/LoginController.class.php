<?php
namespace System\Controller;
use Think\Controller;
class LoginController extends BaseController {
	public function login(){

		$this->display("index");	
    }
    // 登录检测
    public function checkLogin() {
		
        if(empty($_POST['username'])) {
            $this->error('帐号错误！');
            exit;
        }elseif (empty($_POST['password'])){
            $this->error('密码必须！');
            exit;
        }
       
        //生成认证条件
        $map            =   array();
        // 支持使用绑定帐号登录
        $map['username']	= $_POST['username'];
        $map["status"]	= array('eq',1);

//判断用户名 是否存在
        $flaguser=M('roleuser');
        $n=$flaguser->where($map)->count();
        if($n==0){
            $this->error('用户名不存在,或已禁用');
            exit;
        }

        $password=md5(md5($_POST['password']));
        $map2['username']	= $_POST['username'];
        $map2["status"]	= array('eq',1);
        $map2["password"]	= $password;
        $m=$flaguser->where($map2)->count();
        if($m==0){
            $this->error('密码错误!');
            exit;
        }

        $userid=$flaguser->where($map)->field('id')->select();
        $userid=$userid[0]['id'];
        $_SESSION[C('USER_AUTH_KEY')]	=	$userid;

        $ip		=	get_client_ip();
        $time	=	time();
        $data['id']=$userid;
        $data['logintime']=$time;
        $data['loginip']=$ip;
        $flaguser->save($data);
		$logarr=array();
		$logarr["userid"]=$userid;
		$logarr["optype"]=1;
		$logarr["opcontent"]="管理员(".$_POST['username'].")于".date("Y-m-d H:i:s",$time)."登录了系统";
		$logarr["opip"]=$ip;
		$logarr["optime"]=$time;
		M("Userlog")->add($logarr);
        $this->redirect('Index/index');
        //$this->success('登陆成功!',U('Index/index'));
         
    }

    //用户登出
    public function logout() {
        if(isset($_SESSION[C('USER_AUTH_KEY')])) {
            unset($_SESSION[C('USER_AUTH_KEY')]);
            unset($_SESSION);
            session_destroy();
            $this->redirect('Login/login');
        }else {
            $this->redirect('Login/login');
        }
    }
}
?>