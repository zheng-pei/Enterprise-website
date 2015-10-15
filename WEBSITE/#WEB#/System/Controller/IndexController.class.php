<?php
namespace System\Controller;
use Think\Controller;
class IndexController extends BackController {
    public function index(){
        // $map['isread']=array('neq',1);
        // $noread=M('Message')->where($map)->count();
        // $this->assign('noread',$noread);
		$this->assign("userid", $_SESSION [C('USER_AUTH_KEY')]);
        $this->display();
    }
    public function messages(){
    	if($_GET['id']==1){
    		$map['isread']=array('neq',1);
	        $noread=M('Message')->where($map)->select();
	        echo json_encode($noread);
    	}
    	
    }
}