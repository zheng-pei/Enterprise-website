<?php
namespace System\Controller;
use Think\Controller;
class ArticleController extends BackController{

    public function _filter(&$map){
        if(isset($_REQUEST["catename"])&&$_REQUEST["catename"]!=0){
            $map["sk_article.cateid"]=$_REQUEST["catename"];
        }
        if(isset($_REQUEST["title"])&&$_REQUEST["title"]!=''){
            $map["title"]=array('like','%'.$_REQUEST["title"].'%');
        }
        if(isset($_REQUEST["source"])&&$_REQUEST["source"]!=''){
            $map["source"]=array('like','%'.$_REQUEST["source"].'%');
        }
        if(isset($_REQUEST["status"])&&$_REQUEST["status"]!=''){
            $map["status"]=$_REQUEST["status"];
        }
    }

    public function lists(){
       $map=array();
       $cateid=$_REQUEST["cateid"];
       if($cateid){
            $catearr=M('Category')->where("pid=".$_REQUEST["cateid"])->getField("id",true);
         // 查询子栏目
       
            if(!empty($catearr)){
                $map["sk_article.cateid"]=array("in",$catearr);
            }else{
                $map["sk_article.cateid"]= $_REQUEST["cateid"];
            }
            $subcolumn=M('Category')->where("pid=".$_REQUEST["cateid"])->getField("id,catename",true);
               if(!empty($subcolumn)){
                $this->assign('subcolumn', $subcolumn);
               }
       }
       $this->_filter($map);
       $this->_list(M('article'), $map, '',true,'sk_article.id id,sk_article.cateid cateid,title,catename,sk_article.pic,hits,source,author,createtime,status','sk_category on sk_category.id=sk_article.cateid',$cateid);
       $this->display();   
    }


    public function subcat(){
        // 获取一级栏目的id
          if($_REQUEST["cateid"]){
            $pidlist=M('Category')->where("id=".$_REQUEST['cateid'])->field('id,catename,pic')->select();
            $catearr=M('Category')->where("pid=".$_REQUEST["cateid"])->field("id,catename,pic")->select();
            // dump($catearr);
            // 获取当前一级栏目的子栏目的所以id取值
            $sub_id=M('Category')->where("pid=".$_REQUEST["cateid"])->getField("id",true);
            $res=implode(',',$sub_id);
            // 子栏目存在
                if(!empty($catearr)){
                    $map['sk_article.cateid']=array('in',$res);
                    // 获取一级栏目下二级栏目下的所有的文章数量
                    $count1=M('Article')->where($map)->count();
                    for($i=0;$i<count($catearr);$i++){
                     //在对应的二级栏目里面添加一个栏目的数量的数组
                        $subid[$i]=$catearr[$i]['id'];
                        $map2['sk_article.cateid']=array('in',$subid[$i]);
                        $count2[$i]['count']=M('Article')->where($map2)->count();
                        $catearr[$i]['num'] = $count2[$i]['count'];
                    }
                    $this->assign('count',$count1);
                    $this->assign('sublist',$catearr);
                }else{
                     $map['sk_article.cateid']=array('in',$_REQUEST["cateid"]);
                    // 获取一级栏目下的所有的文章数量
                    $count=M('Article')->where($map)->count();
                    $this->assign('count',$count);
                }
            }
        $this->display();
       
    }

    public function add(){

        $map['id']=$_REQUEST['scateid'];
        $res=M('Category')->field('columnmodel,catename,id cateid,versionid')->where($map)->find();
        $this->assign('cateid',$_GET['cateid']);
        $this->assign('column',$res);
		$this->getcategorylist($res['versionid']);
        $this->display();
    }
    // 编辑文章保存
    public function update(){
       
		if(!empty($_POST["phout_url"])){
			foreach($_POST["phout_url"] as $k=>$v){
				$imagearr[$k][]=$v;
				$imagearr[$k][]=$_POST['imagestitle'][$k];
				$imagearr[$k][]=$_POST['imagestexts'][$k];
			}
            // dump(json_encode($imagearr));
			$_POST["pics"]=urldecode(json_encode($imagearr));
		}
        $_POST['cateid']=$_POST['subcateid'];
		$_POST['lastedittime']=time();
		$_POST['createuserid']=$_SESSION[C('USER_AUTH_KEY')];
		parent::update(U('Article/lists',array('cateid'=>$_REQUEST['cate_id'])));
        
    }
    // 添加文章
    public function insert(){
		$_POST['createtime']=time();
        $_POST['lastedittime']=time();
        $id=$_SESSION[C('USER_AUTH_KEY')];
        $lastedituser=M('Roleuser')->where('id='.$id)->field('username')->find();
        $_POST['lastedituser']=$lastedituser['username'];
		if(!empty($_POST["phout_url"])){
			foreach($_POST["phout_url"] as $k=>$v){
				$imagearr[$k][]=$v;
				$imagearr[$k][]=$_POST['imagestitle'][$k];
				$imagearr[$k][]=$_POST['imagestexts'][$k];
			}
			$_POST["pics"]=json_encode($imagearr);
			
		}
		$_POST['createuserid']=$_SESSION[C('USER_AUTH_KEY')];
		parent::insert(U('Article/lists',array('cateid'=>$_REQUEST['cate_id'])));
      
    }
   
    public function edit(){
		$vo = M("article")->find($_GET['id']);
		$vo["piclist"]=json_decode(htmlspecialchars_decode($vo['pics']));
        $this->assign('vo', $vo);
		$map['id']=$vo['cateid'];
        $res=M('Category')->field('columnmodel,catename,id cateid,versionid')->where($map)->find();
        $this->assign('column',$res);
		$this->getcategorylist($res['versionid']);
        // 获取当前文章的id
        $this->display();
    }
    public function delete(){
         parent::foreverdelete(U('Article/lists',array('cateid'=>$_GET['cateid'])));
    }

    //是否发布文章
    public function changestatus(){
            $map=array();
            $map["id"]=$_GET["id"];
            $result=M("Article")->where($map)->setField("status", $_GET["status"]);
            unset($_GET["id"]);
            unset($_GET["status"]);
            if($result!==FALSE){
                $this->redirect("Article/lists",$_GET);
                exit;
            }else{
                $this->redirect("Article/lists",$_GET);
                exit;
            }
    }
	// 栏目列表，一级栏目和二级栏目
	public function getcategorylist($versionid){
		$catearr=M("category")->where("pid=0 and versionid=".$versionid)->select();
		foreach($catearr as $k=>$v){
			$subcat=M("category")->where("pid=".$v["id"])->select();
			$catearr[$k]["subcat"]=$subcat;
		}
		$this->assign("catearr",$catearr);
	}
}