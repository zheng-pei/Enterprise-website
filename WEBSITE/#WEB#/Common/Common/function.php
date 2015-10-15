<?php
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true){
      $str=\Org\Util\String::msubstr($str, $start, $length, $charset, $suffix);
      return $str;
   }
function isAndroid(){
	if(strstr($_SERVER['HTTP_USER_AGENT'],'Android')) {
		return 1;
	}
	return 0;
}
function object_array($array){
     if(is_object($array)){
         $array = (array)$array;
     }
      if(is_array($array)){
           foreach($array as $key=>$value){
               $array[$key] = object_array($value);
           }
      }
      return $array;
}
function getWeek($riqi){
    $weekarray=array("日","一","二","三","四","五","六");
    $w=date("w",strtotime($riqi));
    return $weekarray[$w];
}

function leavedays($ntime){
	$leavesecond=$ntime-time();
	$leaveday=floor($leavesecond/86400);
	echo $leaveday;
}

//正整数显示＋
function iszheng($scores){
	if($scores>0){
		return '+'.$scores;	
	}else{
		return $scores;	
	}
}

//随机字符串
function generate_password( $length = 6 ,$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') {
// 密码字符集，可任意添加你需要的字符
//$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

$password = '';
for ( $i = 0; $i < $length; $i++ ) 
{
$password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
}

return $password;
}
function strinarray($id,$str){
    $arr=  explode(",", $str);
    if(in_array($id, $arr)){
        return 1;
    }else{
        return 0;
    }
}

//获得商家名称
function getbsidname($bsid){
  return M("business")->where("id=".$bsid)->getField("name");

}

//获得卡券名称
function getcardtype($type){
  if($type==1){
    return "代金券";
  }elseif($type==2){
    return "折扣券";
  }elseif($type==3){
    return "礼品券";
  }else{
    return "平台代金券";
  }
}

//获得后台管理员名称
function getusername($user){
  return M("roleuser")->where("id='".$user."'")->getField("username");
}

//获得状态名称
function getstatus($status){
  if($status==1){
    return "启用";
  }else{
    return "禁用";
  }
}



function getbslevel($level){
    if($level<=1&&0<=$level){
      return "1级";
    }elseif ($level<=2&&1<$level) {
      return "2级";
    }elseif ($level<=3&&2<$level) {
      return "3级";
    }elseif ($level<=4&&3<$level) {
      return "4级";
    }else{
      return "5级";
    }
}
function getnum($mname,$fieldname,$value,$fuhao){
    $model=M($mname);
    foreach($fieldname as $k=>$v){
        $map[$v]=array($fuhao[$k],$value[$k]);
    }
    return $model->where($map)->count();
}

function gettips($table,$field,$vid){
	$map=array();
	$map["table"]=$table;
	$map["fieldname"]=$field;
	$map["versionid"]=$vid;

	return M("labelinfo")->where($map)->getField("remark");	
}
?>