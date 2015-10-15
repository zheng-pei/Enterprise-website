<?php
namespace System\Controller;
use Think\Controller;
class RoleController extends BackController{
    public $nodelist=array();
    
    public function index(){
	   parent::index("Role");
    }
    public function add(){
        $this->getnodelist();
        $this->display();
    }
 
    // 增加角色的节点
    public function insert(){
			if(!empty($_POST["node"])){
				$nodearr=$_POST["node"];
				foreach($_POST["node"] as $k=>$v){
					$pid=M("node")->where("id=".$v)->getField("pid");
					if($pid!=0&&!in_array($pid,$nodearr)){
						$nodearr[]=$pid;
					}
				}
			}
			
            if(!empty($_POST['content'])){
                $_POST['columns']='all';
				$nodearr[]=$_POST["content"];
            }else{
				if(!empty($_POST['pid_column'])){
					$nodearr[]=	M("node")->where("hassub=1")->getField("id");
				}
                 $_POST['columns']=implode(",", $_POST['pid_column']);     
            }
		   $_POST['nodes']= implode(",", $nodearr);
		   parent::insert(U('Role/index'));
            
    }

    public function edit(){
		$this->getnodelist();
		$selnodes=$this->getselnodes($_GET["id"]);
        $this->assign("selnodes",$selnodes);
		$selcate=$this->getselcate($_GET["id"]);
        $this->assign("selcate",$selcate);
		parent::edit();
    }

    // 对角色表更新
    public function update(){
		if(!empty($_POST["node"])){
				$nodearr=$_POST["node"];
				foreach($_POST["node"] as $k=>$v){
					$pid=M("node")->where("id=".$v)->getField("pid");
					if($pid!=0&&!in_array($pid,$nodearr)){
						$nodearr[]=$pid;
					}
				}
			}
			
            if(!empty($_POST['content'])){
                $_POST['columns']='all';
				$nodearr[]=$_POST["content"];
            }else{
				if(!empty($_POST['pid_column'])){
					$nodearr[]=	M("node")->where("hassub=1")->getField("id");
				}
                 $_POST['columns']=implode(",", $_POST['pid_column']);     
            }
		   $_POST['nodes']= implode(",", $nodearr);
        parent::update(U('Role/index'));
    }

	public function getnodelist(){
		$node=M('node');
        $map=array();
        $map["pid"]=0;
        $map["hassub"]=0;
        $nodelist=$node->where($map)->order('id asc')->select();
        // dump($nodelist);
        //没有内容管理的父节点下的子节点
        foreach($nodelist as $k=>$v){
            $childids=$node->where('pid='.$v['id'])->getField("id",true);
            if($childids){
                $v['nodeids']=  implode(",", $childids);
                $where['id']=array('in', $v['nodeids']);
                $v['subnode']=$node->where($where)->field('id,title')->select(); 
                $this->nodelist[]=$v;
            }       
        }
        // 获取内容管理的节点id
        $condition['hassub']='1';
        $content_node=$node->field('id,title')->where($condition)->find();
        if($content_node){
            $map1["pid"]=0;
            // 一级栏目
            $pid_column=M('Category')->where($map1)->order('versionid asc,id asc')->select();
        
            $this->assign('content',$content_node);
            $this->assign('columnlist',$pid_column);
        }
      
        $this->assign('list',$this->nodelist);
	}

	public function getselnodes($roleid){
        $nodes=M("role")->where("id=".$roleid)->getField("nodes");
        if($nodes=="all"){
             $selnodes=M("node")->where(1)->getField("id",true);
        }elseif($nodes!=""){
             $selnodes=array_filter(explode(",",$nodes));
        }
        return $selnodes;
    }
	public function getselcate($roleid){
		$nodes=M("role")->where("id=".$roleid)->getField("columns");
		if($nodes=="all"){
             $selnodes=M("category")->where("pid=0")->getField("id",true);
        }elseif($nodes!=""){
             $selnodes=array_filter(explode(",",$nodes));
        }
        return $selnodes;
	}
}
    
