<?php
namespace System\Controller;
use Think\Controller;
class MessageconfigController extends BackController{

	public function set(){
		$arr=M('Messageconfig')->where('id=1')->find();
		$str=$arr['messagefields'];
		$this->assign(array('username'=>'username','sex'=>'sex','phone'=>'phone','address'=>'address','email'=>'email','content'=>'content','createtime'=>'createtime','qq'=>'qq','wechat'=>'wechat','weibo'=>'weibo'));
		$this->assign('str',$str);
		$this->display();
	}
	public function filterwords(){
		$res=M('Messageconfig')->select();
		if(!empty($res)){
			$this->assign('vo',$res[0]);
		}
		$this->display();
	}

	// 留言字段的设置
	public function update(){

		$data=$_POST['msgfields'];
		$str=implode(',', $data);
		$this->assign('data',$data);
		$this->assign('str',$str);
		$res=M('Messageconfig')->where('id=1')->save(array('messagefields'=>$str));
		if($res){
				$this->success('保存成功！',U('Messageconfig/set'));
			}else{
				$this->error('保存失败！',U('Messageconfig/set'));
		}
	}
	// 保存敏感词
	public function save(){
		$data['filterwords']=I('post.content');
		if(!empty($data)){
			$res=M('Messageconfig')->where("id=1")->save($data);
			if($res){
				$this->success('保存成功！',U('Messageconfig/filterwords'));
			}else{
				$this->error('保存失败！',U('Messageconfig/filterwords'));
			}
			
		}
	}
}