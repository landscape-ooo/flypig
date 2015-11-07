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
		$arrWhere[] = '`usertype`=2';
		$arrData = join(' AND ',$arrWhere);
		
		$pagesize = 20;
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$start = ($page-1)*$pagesize;
		
		$arrAllUser = $new['user']->findAll('user_info',$arrData,'userid desc',null,$start.','.$pagesize);
		$userNum = $new['user']->findCount('user_info',$arrData);
		
		$url = SITE_URL.'index.php?app=user&ac=admin&mg=majia&ts=list&userid='.$userid.'&username='.$username.'&page=';
		$pageUrl = pagination($userNum, $pagesize, $page, $url);
		
		include template("admin/majia_list");
		
		break;
	
	//添加马甲
	case "add":
		
		include template("admin/majia_add");
		break;
	
	//添加马甲执行
	case "add_do":
		qiMsg('暂停批量创建马甲！');die();
		
		$usernum = intval($_POST['usernum']);
		if($usernum){
			$arrObjUser = array();
			$arrAllBot = $new['user']->findAll('user_bot',array(
				'userid'=>'0',
			),null,null,'0,'.$usernum);
			foreach($arrAllBot as $key=>$value){
				$username = $value['username'];
				$email = "tb_".md5($value['username'])."@flypig.com.cn";
				$usertype = 2;
				$salt = md5(rand());
				
				$userid = $new['user']->create('user',array(
					'pwd'=>md5($salt.$pwd),
					'salt'=>$salt,
					'email'=>$email,
				));
				$nowtime = time();
				//插入用户信息
				$new['user']->create('user_info',array(
					'userid'	=> $userid,
					'usertype'	=>'2',
					'username'	=> $username,
					'email'		=> $email,
					'ip'		=> getIp(),
					'addtime'	=> $nowtime,
					'uptime'	=> $nowtime
				));
				$new['user']->update('user_bot',array(
					'username'=>$username,
				),array(
					'userid'=>$userid,
					'uptime'=>$nowtime
				));
				
			}
		}
		
		header('Location: '.SITE_URL.'index.php?app=user&ac=admin&mg=majia&ts=list');
		break;
	//认领马甲
	case "get_do":
		
		$userid = intval($_GET['userid']);
		
		$strUser = $new['user']->find('user_info',array(
			'usertype'=>'2',
			'userid'=>$userid
		));
		if($strUser['refuserid']>0 && $strUser['refuserid']!=$TS_USER['admin']['userid']){
			qiMsg('已被认领！');
		}else{
			$refuserid = '0';
			if($strUser['refuserid']=='0'){
				$refuserid = $TS_USER['admin']['userid'];
			}
			$strUser = $new['user']->update('user_info',array(
				'userid'=>$userid
			),array(
				'refuserid'=>$refuserid
			));
			qiMsg('操作成功！');
		}
		break;
	
}