<?php
namespace System\Controller;
use Think\Controller;
class RoleuserController extends BackController{
	public function index(){
            $m=M('Roleuser');
            $data= $m->field('sk_roleuser.id,username,logintime,loginip,sk_roleuser.status,sk_role.rolename')->join('sk_role on sk_roleuser.roleid=sk_role.id')->select();
            $this->assign('list',$data);
            $this->display();
	}

    //是否启用管理员
    public function changestatus(){
            $map=array();
            $map["id"]=$_GET["id"];
            $result=M("Roleuser")->where($map)->setField("status", $_GET["status"]);
            unset($_GET["id"]);
            unset($_GET["status"]);
            if($result!==FALSE){
                $this->redirect("Roleuser/index",$_GET);
                exit;
            }else{
                $this->redirect("Roleuser/index",$_GET);
                exit;
            }
    }
  
        public function add(){        
            $this->getrolelist();
            parent::add();
        }
        public function edit(){ 
            $this->getrolelist();       
            $where['sk_roleuser.id']=$_GET['id'];
            $res = M('Roleuser')->join("sk_role on sk_roleuser.roleid=sk_role.id")->field('username,rolename,sk_roleuser.id,remark,roleid')->where($where)->find();
            $this->assign('res', $res);
            $this->display();
        }
        public function insert(){
            $data['username']=I('post.username');
            $data['password']= md5(md5($_POST['password']));
            $data['status']=I('post.status');
            $data['roleid']=I('post.roleid');
            $data['remark']=I('post.remark');
            $res=M('Roleuser')->add($data);
            if($res){
                $this->success('新增成功！',U('Roleuser/index'));
            }else{
                $this->error('新增失败！',U('Roleuser/index'));
            }
        }

        public function update(){
            parent::update(U('Roleuser/index'));
        }
        public function getrolelist(){
            $rolelist=M("Role")->select();
            $this->assign("rolelist", $rolelist);
        }
        public function delete(){
            parent::foreverdelete();
        }
        //修改密码
        public function changepwd(){
            $oldpwd=M("Roleuser")->find($_SESSION[C('USER_AUTH_KEY')]);
            $oldpassword=md5(md5($_POST['oldpassword']));
            if($oldpassword!=$oldpwd["password"]){
                $this->error("您的原始密码填写不正确");
                exit;
            }else{
                if($_POST['newpassword']!=$_POST['newpassword2']){
                    $this->error("密码及确认密码填写不一致");
                    exit;
                }else{
                    $result=M("Roleuser")->where(array("id"=>$_SESSION[C('USER_AUTH_KEY')]))->setField("password", md5(md5($_POST['newpassword'])));
                    $this->success("密码修改成功");
                    exit;
                }
            }
        }
}
?>