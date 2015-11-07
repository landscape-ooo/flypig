<?php 
defined('IN_TS') or die('Access Denied.');

//全站通用调用数据

//获取马甲用户
$majia_refuserid = null;
if(isset($TS_USER['user']['isadmin']) && $TS_USER['user']['isadmin']=='1'){
	$majia_refuserid = intval($TS_USER['user']['userid']);
}
if(isset($_SESSION['tscover']) && !empty($_SESSION['tscover'])){
	$majia_refuserid = intval($_SESSION['tscover']['userid']);
}
$tsMajiaUser = aac('user')->getMajiaUser($majia_refuserid);
//$tsMajiaUser = aac('user')->getMajiaUser();
///
