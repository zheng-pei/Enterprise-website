<?php
namespace System\Controller;
use Think\Controller;
class CategoryController extends BackController{

    public function index(){
        $column=M('Category');
        $where['pid']=0; 
        if(isset($_POST['versionid'])&&($_POST['versionid'])!=0){
              $versionid=$_POST['versionid'];
              $where['versionid']=array('eq',$versionid); 
         }
         // 取一级栏目
        $list=$column->field('sk_category.id,catename,pic,columnmodel,versionid,versionname,sort')->order('versionid asc,id,sort asc')->where($where)->join('sk_version on sk_version.id=sk_category.versionid')->select();
        //取二级栏目
        foreach ($list as $key => $value) {
        	$where['pid']=$value['id']; 
        	$res=$column->where($where)->order('versionid asc,sort asc')->select();
        	$list[$key]['sub'] = $res;
        }
  
        $this->assign('list',$list);
        $this->display();
    }
	public function edit(){
    $where['sk_category.id']=$_GET['id'];
    $versionname=M('Category')->where($where)->field('versionname')->join('sk_version on sk_version.id=sk_category.versionid')->find();
    $this->assign('version',$versionname);
    parent::edit();
	}
	public function add (){
    $m=D('Category');
    $versionname= $m->field('versionid,sk_version.versionname')->distinct(true)->join('sk_version on sk_category.versionid=sk_version.id')->select(); 
    $where['pid']=0;
    $pidcolumn=$m->where($where)->select();
    $this->assign('pidcolumn',$pidcolumn);
    $this->assign('versionname',$versionname);
		$this->display();
	}
  public function insert(){
    parent::insert(U('Category/index'));
  }
	public function update(){
    $m=D('Category');
    if(isset($_POST)){
      $data['catename']=I('post.catename'); 
      $data['pic']=I('post.pic');
      $data['columnmodel']=I('post.columnmodel');
      $data['remark']=I('post.remark');
      $data['sort']=I('post.sort',0,'intval');
      $where=$_POST['id'];
      $res=$m->where("id=".$where)->save($data);
      if($res){
        $this->success("修改成功！",U('Category/index'));
      }else{
         $this->error("修改失败！",U('Category/index'));
      }
    }
  }
}