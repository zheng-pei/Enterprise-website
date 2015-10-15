<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {

    public function _initialize(){
        foreach ($_REQUEST as $key => $value) {
            $this->assign($key, $value);
        }
        // 判断是否有get
        if(!empty($_GET['versionid'])){          
            $_SESSION['versionid']=$_GET['versionid'];
        }else{
             $_SESSION['versionid']=1;
        }
        $this->header();
        $this->lunbo();
        $this->static_pic();
    }

// 全站搜索
    public function search(){
        $keyword = $_REQUEST['keyword'];
        if(!empty($keyword)){
             // 对文章的标题进行搜索
            $map['title|content']=array('like','%'.$keyword.'%');
            $map['status']=1;
            $map['versionid']=$_SESSION['versionid'];
            $count=M('Article')->where($map)->count();
            $Page=new \Think\Page($count,10);
            $Page->parameter['versionid'] =  $_SESSION['versionid'];
            $Page->parameter['keyword'] = $keyword;
            $show=$Page->show();
            $res=M('Article')->where($map)->order('istop desc,id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
            // 查找所属的pid
            foreach ($res as $key => $value) {
                $cateid=$value['cateid'];
                $pid=M('Category')->where('id='.$cateid)->field('pid')->find();
                $pid=$pid['pid'];
                $res[$key]['pid']=$pid;
            }
            // echo M('Article')->getLastSql();
        }
          $this->assign('page',$show);// 赋值分页输出
        // 判断搜索结果是否为空
        if($count > 0){
            // 调用keyword_replace()函数，来将你输入的关键字要以红色显示在标题内
            $res = $this->keyword_replace($res, $keyword, "<font color='red'>".$keyword.'</font>');
            $this->assign("res", $res);   
        }else{
            // 其实就是分配给前台的数据res=0
            $this->assign("res", "0");
        }  
        $this->assign('keyword',$keyword);
        $this->display('Public:search');
    }
   
    public function keyword_replace($res, $keyword, $value){
        // 构建匹配的正则式 (keyword中包含中文时，必须使用u  u表示使用utf-8编码)
        $keyword = "/$keyword/u";
        // 循环进行匹配和替换
        for ($i = 0; $i < count($res); $i++) { 
            $str = $res[$i]['title'];
            $res[$i]['title'] = preg_replace($keyword, $value, $str);
        }
        return $res;
    }

    public function header(){

        $this->assign('versionid',$_SESSION['versionid']);
        $column=M('Category');
        $where['pid']=0;
        $where['versionid']=$_SESSION['versionid'];
         // 取一级栏目
        $list=$column->field('sk_category.id,catename')->order('id,sort asc')->where($where)->select();
        //取二级栏目
        foreach ($list as $key => $value) {
            $where['pid']=$value['id']; 
            $res=$column->where($where)->order('sort asc')->select();
            $list[$key]['sub'] = $res;
        }
        // 读取对应版本的内容
        $map1['title']='网站关键字';
        $map1['fieldname']='keyword';
        $map1['versionid']=$_SESSION['versionid'];
        $map2['title']='网站描述';
        $map2['fieldname']='des';
        $map2['versionid']=$_SESSION['versionid'];
        $keyword=M('Config')->where($map1)->getField('fieldvalue','true');
        $description=M('Config')->where($map2)->getField('fieldvalue','true');
        $this->assign(array('keywords'=>$keyword,'description'=>$description));
        $this->assign('list', $list);        
         // logo图片
        $map3['title']=array('like','%logo%');
        $map3['status']=1;
        $map3['versionid']=$_SESSION['versionid'];
        $logo=M('Pics')->where($map3)->order('id desc')->limit(1)->find();
        $this->assign('logo',$logo['pic']);   
    }

    // 静态banner图片
    public function static_pic(){
        // 给每个栏目分配一张静态图片
        $map['versionid']=$_SESSION['versionid'];
        $map['status']=1;
        $map['title']=array('like','%静%');
        $pics=M('Pics')->where($map)->order('id desc')->limit(9)->select();
        $this->assign('pid',$_SESSION['pid']); 
        $this->assign('pics',$pics);
    }

    // 轮播图片
    public function lunbo(){
        $map['status']=1;
        $map['versionid']=$_SESSION['versionid'];
        $shuffling=M('shuffling')->where($map)->order('createtime desc')->limit(4)->select();
        $this->assign('lunbo',$shuffling);
    }

      // 公共模板文件leftmenu
    public function leftmenu(){
        $map['id']=$_SESSION['pid'];
        $map['versionid']=$_SESSION['versionid'];
        // 一级栏目
        $pidcolumn=M('Category')->where($map)->field('catename')->find();
        // dump($pidcolumn);
        $where['versionid']=$_SESSION['versionid'];
        $where['pid']=$_SESSION['pid'];
        $subcolumn=M('Category')->where($where)->field('id,catename')->order('id asc,sort desc')->select();
        $this->assign('pidcolumn',$pidcolumn);
        $this->assign('subcolumn', $subcolumn); 
        $this->assign('pid',$_SESSION['pid']);  
        $this->assign('cateid',$_SESSION['cateid']);  
    }

// 用于直接点击某个栏目后显示内容页面
    public function content(){
        $pid=$_GET['pid'];
        $cateid=$_GET['cateid'];
        // 若点击一级栏目
        if($pid==$cateid){
            // 默认获取第一个id栏目的右边的内容页
            $subid=M('Category')->where('pid='.$pid)->field('id,columnmodel')->find();
            $where['cateid']=$subid['id'];
            $where['status']=1;
            $where['versionid']=$_SESSION['versionid'];
            $con=M('Article')->where($where)->order('createtime desc,id desc')->field('title,content,isstrong,color,pics')->find();
           // 如果是图集内容，比如证书展示
                if($subid['columnmodel']==3){ 
                    $pics=$con['pics'];
                    $pics=htmlspecialchars_decode($pics);
                    $pics=json_decode($pics); 
                    $this->assign('pics',$pics);
                }
            $this->assign('columnmodel',$subid['columnmodel']);
            $this->assign('article_title',$con['title']);
            $this->assign('isstrong',$con['isstrong']);
            $this->assign('color',$con['color']);
            $this->assign('content',$con['content']); 

        }else{
            $where['cateid']=$cateid;
            $where['status']=1;
            $subcolumn=M('Category')->where('id='.$cateid)->getField('columnmodel','true');
            $m=M('Article')->where($where)->field('title,content,isstrong,color,pics')->order('id desc,createtime desc')->find();
           
            // 实验概况栏目都是内容页，没有列表页
             // 如果是图集内容，比如证书展示
                if($subcolumn['columnmodel']==3){ 
                    $pics=$m['pics'];
                    $pics=htmlspecialchars_decode($pics);
                    $pics=json_decode($pics); 
                    $this->assign('pics',$pics);
                }
            $this->assign('columnmodel',$subcolumn);
            $this->assign('article_title',$m['title']);
            $this->assign('isstrong',$m['isstrong']);
            $this->assign('color',$m['color']);
            $this->assign('content',$m['content']); 
        } 
    }

// 新闻图文列表
public function news_lists(){
        $pid=$_GET['pid'];
        $cateid=$_GET['cateid'];
        $this->contentlists($pid,$cateid);
}


       // 通用的列表页面的内容读取
public function contentlists($pid,$cateid){
        $pid=$pid;
        $cateid=$cateid;
            if($pid==$cateid){
                $where['versionid']=$_SESSION['versionid'];
                $where['pid']=$pid;
                // 默认输出第一个子栏目的对应的列表
                $news1=M('Category')->where($where)->field('id,catename')->limit(1)->find();
                $map['status']=1;
                $map['cateid']=$news1['id'];
                $map['versionid']=$_SESSION['versionid'];
                 // 分配给列表的链接参数
                $this->assign('cateid',$news1['id']);
                $this->assign('catename',$news1['catename']);
                // 调用分页的函数
                $count=M('Article')->where($map)->count();
                $this->_list($count,$map);
            }else{
                $map2['status']=1;
                 // 左侧栏目的id
                $map2['cateid']=$cateid;
                $map2['versionid']=$_SESSION['versionid'];
                $news=M('Category')->where('id='.$cateid)->field('catename')->find();
                $this->assign('catename',$news['catename']);
                 // 调用分页的函数
                $count=M('Article')->where($map2)->count();
                $this->_list($count,$map2);
            }            
        } 

    // 分页的函数
    Public function _list($count,$map){
        if($count>0){
            $Page=new \Think\Page($count,4);
            $Page->parameter['pid'] = $_SESSION['pid'];
            $Page->parameter['cateid'] = $_SESSION['cateid'];
            $Page->parameter['versionid'] = $_SESSION['versionid'];
            $allpage=intval(ceil($count/4));//总的页数
            $show=$Page->show();
            $lists = M('Article')->where($map)->limit($Page->firstRow.','.$Page->listRows)->order('istop desc,id desc')->select();
            if($_SESSION['pid']==2||$_SESSION['pid']==27){
                // 获取当前页码
                $current_p=$_SESSION['p'];
                for($j=1;$j<=$allpage;$j++){
                    if($current_p==$j){
                        foreach ($lists as $key => $value) {
                            // 存放的是起始页
                            $value['code']=($j-1)*4+$key+1;
                            $lists[$key]['code']=$value['code'];
                        }
                        break;
                    }                     
                }                       
            }   
        }
        $this->assign('lists', $lists);
        $this->assign('page',$show);// 赋值分页输出
        // 把栏目的名称分配给页面
        // $this->assign('count',$count);     
    }

    // 用于点击列表后显示文章的内容
    public function inner_news(){
        if(isset($_GET['id'])){
            $id=$_GET['id'];
            $pid=$_GET['pid'];
            $cateid=$_GET['cateid'];
            $map['id']=$cateid;
            $map['versionid']=$_SESSION['versionid'];
            $columnmodel=M('Category')->where($map)->getField('columnmodel','true');
            //  浏览量 +1
            $data['hits'] = array('exp','hits + 1');
            M('Article')->where("id =".$id)->save($data);
            $where['id']=$id;
            $where['status']=1;
            $where['cateid']=$_GET['cateid'];
            $where['versionid']=$_SESSION['versionid'];
            $article=M('Article')->where($where)->field('id,title,subtitle,content,createtime,source,color,hits,isstrong,pics')->limit(1)->find();
            $this->assign('article',$article);
            
          // 如果是图集内容，比如证书展示
            if($columnmodel==3){ 
                $pics=$article['pics'];
                $pics=htmlspecialchars_decode($pics);
                $pics=json_decode($pics); 
                $this->assign('pics',$pics);
            }
                // 上一篇
            $where1['id']=array('lt',$id);
            $where1['status']=1;
            $where1['cateid']=$cateid;
            $where1['versionid']=$_SESSION['versionid'];
            $res1=M('Article')->where($where1)->order('id desc')->field('id,title,subtitle,content,createtime,source,color,hits,isstrong,pics')->limit(1)->find(); 
            if ($res1) {
                $this->assign('prev', $res1['id']);
                $this->assign('prev_title', $res1['title']);
                $this->assign('prev_color',$res1['color']);
            } else{
                $this->assign('prev', 0);
            }
            // 下一篇
            $where2['id']=array('gt',$id);
            $where2['status']=1;
            $where2['cateid']=$cateid;
            $where2['versionid']=$_SESSION['versionid'];
            $res2=M('Article')->where($where2)->order('id asc')->field('id,title,subtitle,content,createtime,source,color,hits,isstrong,pics')->limit(1)->find();      
            if ($res2) {
                $this->assign('next', $res2['id']);
                $this->assign('next_title', $res2['title']);
                $this->assign('next_color',$res2['color']);
            } else{
                $this->assign('next', 0);
            }
            $this->assign('columnmodel',$columnmodel);
            $this->assign(array('pid'=>$pid,'cateid'=>$cateid));
        }    
    }
}