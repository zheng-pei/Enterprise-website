<?php
namespace System\Controller;
use Think\Controller;
class DownloadController extends BackController{

	 public function _filter(&$map){
      if(isset($_REQUEST["versionid"])&&$_REQUEST["versionid"]!=0){
            $map["versionid"]=$_REQUEST["versionid"];
      }
       if(isset($_REQUEST["title"])&&$_REQUEST["title"]!=''){
            $map["title"]=array('like','%'.$_REQUEST["title"].'%');
      }
     }
      /**
	 * 下载资源列表
	 */
	public function lists(){
		$map=array();
        $this->_filter($map);

        $this->_list(M('Download'), $map,'versionid asc,id',true,'sk_download.id id,title,sk_download.url,sk_download.createtime,download_times,versionname','sk_version on sk_download.versionid=sk_version.id');
        $this->display(); 
    }
	/**
	 * 上传"下载资源"
	 */
	public function up(){
		$this->display();
	}
	/**
	 * 添加资源的上传
	 */
	public function insert(){
		$_POST['createtime']=time();
		// $_POST['filename']=
		parent::insert(U('Download/lists'));
	}

	
	/**
	 * 修改下载资源信息
	 */
	public function edit(){
		$id=I('get.id');
		$res=M('Download')->field('sk_download.id id,versionname,title,sk_download.url,sk_download.createtime,download_times')->where("sk_download.id=".$id)->join("sk_version on sk_version.id=sk_download.versionid")->find();
		if($res){
			$this->assign('vo',$res);
		}
		$this->display();	
	}

	/**
	 * 实现"下载资源"信息的修改
	 */
	public function update(){
		$data['createtime']= time();
		$data['title']=I('post.title');
		$data['url']=I('post.url');
		$where['id']=$_POST['getid'];
		$res=M('Download')->where($where)->save($data);
		if($res){
			$this->success('编辑成功！',U('Download/lists'));
		}else{
			$this->error('编辑失败！',U('Download/lists'));
		}	
	}
	public function delete(){
		parent::foreverdelete('lists');
	}
	
}