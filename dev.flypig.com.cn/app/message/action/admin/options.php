<?php
defined('IN_TS') or die('Access Denied.');

//管理员是否登录
$userid = aac('user')->isAdminLogin();

switch($ts){
	//基本配置
	case "":
		
		include template("admin/options");
		
		break;
}