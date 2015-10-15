<?php
namespace System\Controller;
use System\Controller;
class ConfigController extends BackController{
    public function index(){
        $list=M('Version')->field('versionname,id')->order('id asc')->select();
        $this->assign('list',$list);
        $this->display();
    }
    //保存配置
    public function saveconfig() {
        $where['versionid'] = $_POST['versionid'];
        foreach ($_POST as $key => $value) {
            if ($key != 'versionid') {
                $data['fieldvalue'] = $value;
            }
            $where['fieldname'] = $key;
            M('Config')->where($where)->save($data); 
        }
        echo "保存成功！";
    }
    public function versioninfo(){
        $id=$_POST['id'];
        $res=M('Config')->where('versionid='.$id)->order('id asc')->select();
        echo json_encode($res);
    }
}
