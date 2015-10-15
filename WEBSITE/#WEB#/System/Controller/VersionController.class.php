<?php
namespace System\Controller;
use Think\Controller;
class VersionController extends BackController{
	public function index(){
		$m=M('Version');
		$data=$m->order('id asc')->select();
		if($data){
			$this->assign('list',$data);
          $this->display();
		}else{
			$this->display();
		}
	}
	public function add(){
		$this->display();
	}
	// 保存你添加的网站语言的数据
	public function save(){
		parent::insert(U('Version/index'));
	}
	public function edit(){
		parent::edit();
	}
	public function update(){
		$m=D('Version');
		if(isset($_REQUEST)){
			$data['createuserid']=$_SESSION[C('USER_AUTH_KEY')]; 
	        $data['createtime']=time();
	        $data['remark']=I('post.remark'); 
	        $data['url']=I('post.url'); 
	        $res=$m->where('id='.$_REQUEST['versionid'])->save($data);
		}
	
        if($res){
        	$this->success('修改成功！',U('Version/index'));
        }else{
        	$this->error("保存失败！",U('Version/index'));
        }

	}


	 // 彻底删除
    public function delete(){
       parent::foreverdelete("Version");
    }

}