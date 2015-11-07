<?php
defined('IN_TS') or die('Access Denied.');

//管理员是否登录
$userid = aac('user')->isAdminLogin();

/* 
 * 配置选项
 */
switch($ts){
	//基本配置
	case "":
		
		include template("admin/options");
		
		break;
}