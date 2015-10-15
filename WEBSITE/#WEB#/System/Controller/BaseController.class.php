<?php
namespace System\Controller;
use Think\Controller;
class BaseController extends Controller {
	protected function _initialize()
    {
        define('STATICS', './static/');
        define('RES',  './static/System');
      //  $this->assign('action', $this->getActionName());
       
    }
	
	 public function index($name="") {
		if(empty($name)){
        	$name = CONTROLLER_NAME;
		}
		
        //列表过滤器，生成查询Map对象
        $map = $this->_search($name);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }

        
        $model = D($name);
        if (!empty($model)) {
            $this->_list($model, $map);
        }
        $this->display();
        return;
    }
	
	 public function relationindex($name=""){
        if(empty($name)){
        	$name = CONTROLLER_NAME;
		}
		
        //列表过滤器，生成查询Map对象
        $map = $this->_search($name);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }


        $model = D($name);
        if (!empty($model)) {
            $this->_relationlist($model, $map);
        }
        $this->display();
        return;
    }
    /**
      +----------------------------------------------------------
     * 取得操作成功后要返回的URL地址
     * 默认返回当前模块的默认操作
     * 可以在action控制器中重载
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @return string
      +----------------------------------------------------------
     * @throws ThinkExecption
      +----------------------------------------------------------
     */
    function getReturnUrl() {
        return __URL__ . '?' . C('VAR_MODULE') . '=' . MODULE_NAME . '&' . C('VAR_ACTION') . '=' . C('DEFAULT_ACTION');
    }

    /**
      +----------------------------------------------------------
     * 根据表单生成查询条件
     * 进行列表过滤
      +----------------------------------------------------------
     * @access protected
      +----------------------------------------------------------
     * @param string $name 数据对象名称
      +----------------------------------------------------------
     * @return HashMap
      +----------------------------------------------------------
     * @throws ThinkExecption
      +----------------------------------------------------------
     */
    protected function _search($name = '') {
        //生成查询条件
        if (empty($name)) {
            $name =CONTROLLER_NAME;
        }
        $name = CONTROLLER_NAME;
        $model = D($name);
        $map = array();
        foreach ($model->getDbFields() as $key => $val) {
            if (isset($_REQUEST [$val]) && $_REQUEST [$val] != ''&&!empty($_REQUEST [$val])) {
                $map [$val] = $_REQUEST [$val];
            }
        }
        return $map;
    }

    /**
      +----------------------------------------------------------
     * 根据表单生成查询条件
     * 进行列表过滤
      +----------------------------------------------------------
     * @access protected
      +----------------------------------------------------------
     * @param Model $model 数据对象
     * @param HashMap $map 过滤条件
     * @param string $sortBy 排序
     * @param boolean $asc 是否正序
      +----------------------------------------------------------
     * @return void
      +----------------------------------------------------------
     * @throws ThinkExecption
      +----------------------------------------------------------
     */
    protected function _list($model, $map, $sortBy = '', $asc = false,$fields="*",$joinstr='',$cateid) {
        //排序字段 默认为主键名
        if (isset($_REQUEST ['_order'])&&!empty($_REQUEST ['_order'])) {
            $order = $_REQUEST ['_order'];
        } else {
            $order = !empty($sortBy) ? $sortBy : $model->getPk();
        }
        //接受 sost参数 0 表示倒序 非0都 表示正序
       if (isset($_REQUEST ['_sort'])) {
            $sort = $_REQUEST ['_sort'] ? $_REQUEST ['_sort']  : 'asc';
        } else {
            $sort = $asc ? 'asc' : 'desc';
        }
     
        //取得满足条件的记录数
        $count = $model->where($map)->count($model->getPk());
       // echo $model->getlastsql();
        if ($count > 0) {
        
            //创建分页对象
            if (!empty($_REQUEST ['pagesize'])) {
                $listRows = $_REQUEST ['pagesize'];
            } else {
                $listRows = 10;
            }

            $p = new \Think\Page($count, $listRows);
            $p->parameter['cateid'] =  $cateid;

            //分页查询数据
            if($fields=="*"){
                if(!empty($joinstr))
                {
                    $voList = $model->where($map)->join($joinstr)->order( $order . " " . $sort)->limit($p->firstRow . ',' . $p->listRows)->select();
                }else{
                    $voList = $model->where($map)->order( $order . " " . $sort)->limit($p->firstRow . ',' . $p->listRows)->select();
                }
            }else{
              if(!empty($joinstr))
              {

                $voList = $model->field($fields)->join($joinstr)->where($map)->order( $order . " " . $sort)->limit($p->firstRow . ',' . $p->listRows)->select();
              }else{
                $voList = $model->field($fields)->where($map)->order( $order . " " . $sort)->limit($p->firstRow . ',' . $p->listRows)->select();
              }
            }

            
            //分页显示
            $page = $p->show();
            //列表排序显示
            $sortImg = $sort; //排序图标
            $sortAlt = $sort == 'desc' ? '升序排列' : '倒序排列'; //排序提示
            $sort = $sort == 'desc' ? 1 : 0; //排序方式
            //模板赋值显示
            $this->assign('list', $voList);
            $this->assign('sort', $sort);
            $this->assign('order', $order);
            $this->assign('sortImg', $sortImg);
            $this->assign('sortType', $sortAlt);
            $this->assign("page", $page);
        }         
        cookie('_currentUrl_', __SELF__);
  
       // return;
    }
	 protected function _relationlist($model, $map, $sortBy = '', $asc = false) {

        //排序字段 默认为主键名
        if (isset($_REQUEST ['_order'])) {
            $order = $_REQUEST ['_order'];
        } else {
            $order = !empty($sortBy) ? $sortBy : $model->getPk();
        }
        //排序方式默认按照倒序排列
        //接受 sost参数 0 表示倒序 非0都 表示正序

        if (isset($_REQUEST ['_sort'])) {
            $sort = $_REQUEST ['_sort'] ? $_REQUEST ['_sort'] : 'asc';
        } else {
            $sort = $asc ? 'asc' : 'desc';
        }
//        echo $sort;
        //取得满足条件的记录数
        $count = $model->relation(true)->where($map)->count('id');
//          echo $model->relation(true)->getLastSql();
        $this->assign("totalcount", $count);
        if ($count > 0) {
           // import("@.ORG.Util.Page");
            //创建分页对象
            if (!empty($_REQUEST ['listRows'])) {
                $listRows = $_REQUEST ['listRows'];
            } else {
                $listRows =10;
            }
	    $p = new \Think\Page($count, $listRows);
			
            //分页查询数据
 
            $voList = $model->relation(true)->where($map)->order( $order . " " . $sort)->limit($p->firstRow . ',' . $p->listRows)->select();

            //分页显示
            $page = $p->show();
            //列表排序显示
            $sortImg = $sort; //排序图标
            $sortAlt = $sort == 'desc' ? '升序排列' : '倒序排列'; //排序提示
            $sort = $sort == 'desc' ? 1 : 0; //排序方式
            //模板赋值显示
            //var_dump($voList);
            $this->assign('list', $voList);
            $this->assign('sort', $sort);
            $this->assign('order', $order);
            $this->assign('sortImg', $sortImg);
            $this->assign('sortType', $sortAlt);
            $this->assign("page", $page);
        }
        cookie('_currentUrl_', __SELF__);
        return;
    }
    function insert($url="") {
        $name = CONTROLLER_NAME;
        $model = D($name);
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        //保存当前数据对象
        $list = $model->add();
        if ($list !== false) { //保存成功
            $this->success('新增成功!',$url);
        } else {
            //失败提示
            $this->error('新增失败!');
        }
    }

    function read() {
        $this->edit();
    }

    function edit($tpl="",$name="") {
		if(empty($name)){
        $name = CONTROLLER_NAME;
		}
        $model = M($name);
        $id = $_REQUEST [$model->getPk()];
        $vo = $model->find($id);
        $this->assign('vo', $vo);
        $this->display($tpl);
    }

    function update($url="") {
        $name = CONTROLLER_NAME;
        $model = D($name);
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        // 更新数据
        $list = $model->save();
        if (false !== $list) {
            //成功提示
            $this->success('编辑成功!',$url);

        } else {
            //错误提示
            $this->error('编辑失败!');
        }
    }

    /**
      +----------------------------------------------------------
     * 默认删除操作
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @return string
      +----------------------------------------------------------
     * @throws ThinkExecption
      +----------------------------------------------------------
     */
    public function delete($a="index",$name="") {                
        //删除指定记录
        if($name==""){
        $name = CONTROLLER_NAME;
        }
        $model = M($name);
        if (!empty($model)) {
            $pk = $model->getPk();
            $id = $_REQUEST [$pk];
            if (isset($id)) {
                $condition = array($pk => array('in', $id));
                $list = $model->where($condition)->setField('is_delete', 1);
                if ($list !== false) {
                    $this->_after_delete();
                    $this->redirect(CONTROLLER_NAME."/".$a);
                } else {
                    $this->error('删除失败！');
                }
            } else {
                $this->error('非法操作');
            }
        }
    }

    public function foreverdelete($a="index",$name="",$label="") {
        //删除指定记录
        if($name==""){
        $name = CONTROLLER_NAME;
        }
        $model = D($name);
        if (!empty($model)) {
            $pk = $model->getPk();
            $id = $_REQUEST [$pk];

            if (isset($id)) {
                $condition = array($pk => array('in',$id));
                if (false !== $model->where($condition)->delete()) {
                    $this->_after_foreverdelete($label);
                   $this->redirect(CONTROLLER_NAME."/".$a);
                } else {
                    $this->error('删除失败！');
                }
            } else {
                $this->error('非法操作');
            }
        }
        $this->forward();
    }

    public function clear() {
        //删除指定记录
        $name = CONTROLLER_NAME;
        $model = D($name);
        if (!empty($model)) {
            if (false !== $model->where('status=1')->delete()) {
                $this->success(L('_DELETE_SUCCESS_'),$this->getReturnUrl());
            } else {
                $this->error(L('_DELETE_FAIL_'));
            }
        }
        $this->forward();
    }

    /**
      +----------------------------------------------------------
     * 默认禁用操作
     *
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @return string
      +----------------------------------------------------------
     * @throws FcsException
      +----------------------------------------------------------
     */
    public function forbid() {
        $name = CONTROLLER_NAME;
        $model = D($name);
        $pk = $model->getPk();
        $id = $_REQUEST [$pk];
        $condition = array($pk => array('in', $id));
        $list = $model->where($condition)->setField("status",0);
        if ($list !== false) {
            //$this->success('状态禁用成功',$this->getReturnUrl());
            $this->redirect($name."/index");
        } else {
            $this->error('状态禁用失败！');
        }
    }

    public function checkPass() {
        $name = CONTROLLER_NAME;
        $model = D($name);
        $pk = $model->getPk();
        $id = $_GET [$pk];
        $condition = array($pk => array('in', $id));
        if (false !== $model->checkPass($condition)) {
            $this->success('状态批准成功！',$this->getReturnUrl());
        } else {
            $this->error('状态批准失败！');
        }
    }

    public function recycle() {
        $name = CONTROLLER_NAME;
        $model = D($name);
        $pk = $model->getPk();
        $id = $_GET [$pk];
        $condition = array($pk => array('in', $id));
        if (false !== $model->where($condition)->setField("status",1)) {
            $this->redirect($name."/index");
        } else {
            $this->error('状态还原失败！');
        }
    }

    public function recycleBin() {
        $map = $this->_search();
        $map ['status'] = - 1;
        $name = CONTROLLER_NAME;
        $model = D($name);
        if (!empty($model)) {
            $this->_list($model, $map);
        }
        $this->display();
    }

    /**
      +----------------------------------------------------------
     * 默认恢复操作
     *
      +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @return string
      +----------------------------------------------------------
     * @throws FcsException
      +----------------------------------------------------------
     */
    function resume() {
        //恢复指定记录
        $name = CONTROLLER_NAME;
        $model = D($name);
        $pk = $model->getPk();
        $id = $_GET [$pk];
        $condition = array($pk => array('in', $id));
        if (false !== $model->resume($condition)) {
            $this->success('状态恢复成功！',$this->getReturnUrl());
        } else {
            $this->error('状态恢复失败！');
        }
    }

    function saveSort() {
        $seqNoList = $_POST ['seqNoList'];
        if (!empty($seqNoList)) {
            //更新数据对象
            $name = CONTROLLER_NAME;
            $model = D($name);
            $col = explode(',', $seqNoList);
            //启动事务
            $model->startTrans();
            foreach ($col as $val) {
                $val = explode(':', $val);
                $model->id = $val [0];
                $model->sort = $val [1];
                $result = $model->save();
                if (!$result) {
                    break;
                }
            }
            //提交事务
            $model->commit();
            if ($result !== false) {
                //采用普通方式跳转刷新页面
                $this->success('更新成功');
            } else {
                $this->error($model->getError());
            }
        }
    }
   
   public function _after_update($name=""){
       if($name==""){
        $name=CONTROLLER_NAME;
        }
       $data=array();
       $data["userid"]=$_SESSION[C('USER_AUTH_KEY')];
       $data['opmodule']=$name;
       $data["opcontent"]='管理员于'.date("Y-m-d H:i:s",time())."编辑".$name."操作";
       $data["optime"]=time();
       $data["opip"]=get_client_ip();
	     $data['optype']=3;
       M("Userlog")->add($data);
    }
    public function _after_insert($name=""){
       if($name==""){
        $name=CONTROLLER_NAME;
       }
       $data=array();
       $data["userid"]=$_SESSION[C('USER_AUTH_KEY')];
       $data['opmodule']=$name;
       $data["opcontent"]='管理员于'.date("Y-m-d H:i:s",time())."添加".$name."操作";
       $data["optime"]=time();
       $data['optype']=3;
       $data["opip"]=get_client_ip();
       M("Userlog")->add($data);

    }
    public function _after_delete($name=""){
       if($name==""){
        $name=CONTROLLER_NAME;
        }
       $data=array();
       $data["userid"]=$_SESSION[C('USER_AUTH_KEY')];
       $data['opmodule']=$name;
       $data["opcontent"]='管理员于'.date("Y-m-d H:i:s",time())."更改".$name."状态操作";
       $data["optime"]=time();
       $data['optype']=3;
       $data["opip"]=get_client_ip();
       M("Userlog")->add($data);
    }
    public function _after_foreverdelete($name=""){
        if($name==""){
            $name=CONTROLLER_NAME;
       }
       $data=array();
       $data["userid"]=$_SESSION[C('USER_AUTH_KEY')];
       $data['opmodule']=$name;
       $data["opcontent"]='管理员于'.date("Y-m-d H:i:s",time())."永久删除".$name."记录操作";
       $data["optime"]=time();
       $data['optype']=3;
       $data["opip"]=get_client_ip();
       M("Userlog")->add($data);

    }
   public function changestatus($name=""){
        if($name==""){
        $name = CONTROLLER_NAME;
        }
        $model = D($name);
        $pk = $model->getPk();
        $id = $_GET [$pk];
        $condition = array($pk => array('in', $id));
         if (false !== $model->where($condition)->setField("status",$_GET['status'])) {
             $this->_after_changestatus();
            $this->redirect(CONTROLLER_NAME."/lists");
        } else {
            $this->error('状态更改失败！');
        }
   }
   public function _after_changestatus($name=""){
       if($name==""){
        $name = CONTROLLER_NAME;
        }
       $data=array();
       $data["userid"]=$_SESSION[C('USER_AUTH_KEY')];
       $data['opmodule']=$name;
       $data["opcontent"]='管理员于'.date("Y-m-d H:i:s",time()).$name."操作";
       $data["optime"]=time();
       $data['optype']=3;
       $data["opip"]=get_client_ip();
       M("Userlog")->add($data);
    }
    //javascript 跳转方式
    public function script_tiaozhuan($url){
        echo "<script>location.href='".$url."';exit;</script>";
    }
    //上传文件 5242880=5M
    public function uploadone($maxsize=5242880,$ext=array('jpg', 'png', 'gif'),$savepath='./Uploads/images/'){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     $maxsize ;// 设置附件上传大小
        $upload->exts      =    $ext;// 设置附件上传类型
        $upload->rootPath  =     './';
        $upload->savePath  =     $savepath; // 设置附件上传（子）目录
        $upload->saveName = array('uniqid','');
        // 上传文件 
        $info   =   $upload->uploadOne($_FILES['fontfile']);
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
            exit;
        }else{// 上传成功
            return $info["savepath"].$info["savename"];
        }
    }
    //上传多个文件
    public function uploadfiles($maxsize=5242880,$ext=array('jpg', 'png', 'gif'),$savepath='./Uploads/images/'){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     $maxsize ;// 设置附件上传大小
        $upload->exts      =    $ext;// 设置附件上传类型
        $upload->rootPath  =     './';
        $upload->savePath  =     $savepath; // 设置附件上传（子）目录
        $upload->saveName = array('uniqid','');
        // 上传文件 
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
            exit;
        }else{// 上传成功
            return $info;
        }
    }
  
    public function daochu($elist,$label,$filename){
         header("Content-Type: text/csv");
         header("Content-Disposition: attachment; filename=".$filename);
         header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
         header('Expires:0'); 
         header('Pragma:public');
            
         $astr=implode(",",$label)." \r\n";
         foreach($elist as $k=>$v){
            $astr.= implode(",",$v)." \r\n";
         }
         //$astr=iconv("utf-8","gb2312",$astr);
         $astr="\xEF\xBB\xBF".$astr;
         echo $astr;         
    }
	//上传文件
	public function uploads(){
		if (!empty($_FILES)) {
		$upload = new \Think\Upload();
		//设置上传文件大小
		$upload->maxSize = 3292200;
		//设置上传文件类型
		$upload->exts = explode(',','jpg,gif,png,jpeg');
		//设置附件上传目录
		$upload->rootPath="./";
		$upload->savePath = './Uploads/upsimage/';
		//设置需要生成缩略图，仅对图像文件有效
		$upload->thumb = false;
		//设置上传文件规则
		$upload->saveName = array('uniqid','');
		$info=$upload->upload();
		if (!$info) {
			//捕获上传异常
			echo $upload->getErrorMsg();
		}else{
			//取得成功上传的文件信息
			$uploadList = $info;
			$result['result']="SUCCESS";
			$result['image']=$uploadList;
			foreach($uploadList as $k=>$v){
			$result['image']['id']=$k;
			$result['image']['thm_url']=$uploadList[$k]['savepath']."m_".$uploadList[$k]['savename'];
			$result['image']['title']=str_replace('.'.$uploadList[$k]['extension'],'',$uploadList[$k]['name']);
			$result['image']['url']=$uploadList[$k]['savepath'].$uploadList[$k]['savename'];
			}
			echo json_encode($result);
		}

		}

    }
}