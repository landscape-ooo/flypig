<?php
defined('IN_TS') or die('Access Denied.');

//管理员是否登录
$userid = aac('user')->isAdminLogin();

switch($ts){
	
	//用户列表
	case "list":
		
		$userid = intval($_GET['userid']);
		$username = tsFilter($_GET['username']);
		
		$arrWhere = array();
		if($userid > 0){
			$arrWhere[] = '`userid`='.$userid;
		}
		if($username != ''){
			$arrWhere[] = "`username` like '%".$username."%'";
		}
		$arrWhere[] = '`isadmin`=1';
		$arrData = join(' AND ',$arrWhere);
		
		$pagesize = 20;
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$start = ($page-1)*$pagesize;
		
		$arrAllUser = $new['user']->findAll('user_info',$arrData,'userid desc',null,$start.','.$pagesize);
		$userNum = $new['user']->findCount('user_info',$arrData);
		
		$url = SITE_URL.'index.php?app=user&ac=admin&mg=admin&ts=list&userid='.$userid.'&username='.$username.'&page=';
		$pageUrl = pagination($userNum, $pagesize, $page, $url);
		
		include template("admin/admin_list");
		
		break;
	
}