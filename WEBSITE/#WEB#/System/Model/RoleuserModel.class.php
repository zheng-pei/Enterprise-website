<?php
namespace Model;
use Think\Model;
    class RoleuserModel extends Model{
        protected $_validate = array(
            array('username','','帐号名称已经存在！',Model::MUST_VALIDATE,'unique',Model:: MODEL_BOTH),
        );      
    }
?>