<?php
defined('IN_TS') or die('Access Denied.');
/* 
 * 配置选项
 */

//管理员是否登录
$userid = aac('user')->isAdminLogin();

switch($ts){
	
	case "do":
	    $val['q']=$_POST['q'];
		$val['a']=$_POST['a'];
		$db -> insertArr($val,"".dbprefix."veri");
		break;
}