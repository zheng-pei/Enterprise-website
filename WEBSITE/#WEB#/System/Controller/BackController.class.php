<?php
namespace System\Controller;
use Think\Controller;
class BackController extends BaseController {
	protected $pid;
	protected function _initialize(){
            parent::_initialize();
             if (!$_SESSION [C('USER_AUTH_KEY')]) {
                    //判断是否登录，然后跳转到登录页面
                   // redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
				    $this->redirect('Login/login');
                    exit;
            }
            $modulename=CONTROLLER_NAME;
            $actionname=ACTION_NAME;
			$this->versionlist=M("version")->getField("id,versionname",true);
			$this->assign("versionlist", $this->versionlist);

            if($this->isauth($_SESSION [C('USER_AUTH_KEY')],$modulename,$actionname)||$modulename=='Index'){
                $this->show_menu();
            }else{
		          $this->error("对不起，您没有操作权限",'',1);
                exit;
            }
            foreach ($_POST as $key => $value) {
                $this->assign($key, $value);
                $_GET[$key]=$value;
            }
            foreach ($_GET as $key => $value) {
                $this->assign($key, $value);
            }     
			$this->assign("userid", $_SESSION [C('USER_AUTH_KEY')]);      
	}
	
	private function show_menu(){
            //正式上线的时候注释语句将会取消
                $unodeids=M("role")->where("id=(select roleid from sk_roleuser where sk_roleuser.id=".$_SESSION [C('USER_AUTH_KEY')].")")->getField("nodes");
				if($unodeids=='all'){
					$unodearr=M("node")->order('sort asc')->select();
				}else{
               		$unodearr=M("node")->where("id in (".$unodeids.")")->order('sort asc')->select();
				}
				foreach($unodearr as $k=>$v){
					if($v['pid']==0){			
						$menuarr[1][$v['id']]=$v;
					}else{
						$v['url']=U($v['modulename']."/".$v['actionname'],$v['params']);
						$menuarr[2][$v['pid']][]=$v;
					}	
				}
				foreach($menuarr[1] as $k1=>$v1){
					if($v1['hassub']==1){
						$columns=M("role")->where("id=(select roleid from sk_roleuser where sk_roleuser.id=".$_SESSION [C('USER_AUTH_KEY')].")")->getField("columns");
						foreach($this->versionlist as $vk=>$vv){
							if($columns=='all'){
								$menuarr[2][$v1['id']][$vk]=M($v1['attachetable'])->field("id,catename as title,pid")->where("pid=0 and versionid=".$vk)->select();	
							}else{
								$menuarr[2][$v1['id']][$vk]=M($v1['attachetable'])->field("id,catename as title,pid")->where("pid=0 and versionid=".$vk." and id in (".$columns.")")->select();		
							}
							foreach($menuarr[2][$v1['id']][$vk] as $k2=>$v2){
								$menuarr[2][$v1['id']][$vk][$k2]["pid"]=$v1['id'];
								$menuarr[2][$v1['id']][$vk][$k2]['subitem'][]=array("title"=>"文章列表","pid"=>$v2['id'],'url'=>U('Article/lists',array('cateid'=>$v2['id'])));
								$menuarr[2][$v1['id']][$vk][$k2]['subitem'][]=array("title"=>"子栏目管理","pid"=>$v2['id'],'url'=>U('Article/subcat',array('cateid'=>$v2['id'])));	
							}
						}
					}
				}
			
            $this->assign("menus1", $menuarr[1]);
            $this->assign("menus2", $menuarr[2]);
	}
        //判断是否有权限
        public function isauth($ukey,$modulename,$actionname){
            $map=array();
            $map["module"]=$modulename;
           // $map["action"]=$actionname;
            // $map["level"]=array('gt',1);
            $map["pid"]=array('neq',0);
            $nodeids=M("node")->where($map)->getField("id");
            $unodeids=M("role")->where("id=(select roleid from sk_roleuser where sk_roleuser.id=".$ukey.")")->getField("nodes");
			if($unodeids=='all'){
				return true;	
			}else{
            $unodeids=",".trim($unodeids,",").",";
				if(strpos($unodeids, ",".$nodeids.",")===FALSE){
					return false;
				}else{
					return true;
				}
			}
        }

   public function success($message,$jumpUrl='',$type=0,$ismodal=0){
		if($type==1){
			parent::success($message,$jumpUrl);
		}else{
                    $data['errno']=0;
                    //$data['tip']=$message;
                    $data['error']=$message;
                    $data['url']=$jumpUrl;
                    if($ismodal==1){
                        $data['modal']=1;
                    }
                    echo json_encode($data);
		}
	}
	public function error($message,$jumpUrl='',$type=0){
		if($type==1){
			parent::error($message,$jumpUrl);
		}else{
                    $data['errno']=1;
                    //$data['tip']=$message;
                    $data['error']=$message;
                    $data['url']=$jumpUrl;
                    echo json_encode($data);
		}
	}
	
}

?>