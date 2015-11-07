<?php
/*
 * 穿越功能
*/
defined('IN_TS') or die('Access Denied.');

//用户是否登录
$from_userid = $new['user']->isLogin();

//记录上次访问地址
$jump = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : tsUrl('home');

//ts
switch($ts){
	
	//穿越
	case "do":
		
		//验证token
		if($_GET['token'] != $_SESSION['token']) {
			tsNotice('非法操作！',null,$jump,true);
		}
		
		//取出穿越者ID
		if(isset($_SESSION['tscover']) && !empty($_SESSION['tscover'])){
			$from_userid = $_SESSION['tscover']['userid'];
		}
		
		//获取穿越者信息
		$from_userData = $new['user']->find('user_info',array(
			'userid'=>$from_userid,
		));
		
		//穿越者session信息
		$from_sessionData = array(
			'userid' => $from_userData['userid'],
			'username' => $from_userData['username'],
			'path' => $from_userData['path'],
			'face' => $from_userData['face'],
			'isadmin' => $from_userData['isadmin'],
			'uptime' => $from_userData['uptime'],
		);
		
		//备份穿越者session
		$_SESSION['tscover'] = $from_sessionData;
		$tscoverUser = $_SESSION['tscover'];
		
		//判断穿越者是否是管理员（即穿越者必须为管理员）
		if($tscoverUser['isadmin']!='1'){
			tsNotice('非法操作！',null,$jump,true);
		}
		
		//获取用户ID
		$to_userid = intval($_GET['userid']);
		
		//获取用户信息，并作判断
		$to_userData = $new['user']->find('user_info',array(
			'userid'=>$to_userid,
		));
		if(!$to_userData){
			tsNotice('用户不存在！',null,$jump,true);
		}
		
		//收集用户session信息
		$to_sessionData = array(
			'userid' => $to_userData['userid'],
			'username' => $to_userData['username'],
			'path' => $to_userData['path'],
			'face' => $to_userData['face'],
			'isadmin' => $to_userData['isadmin'],
			'uptime' => $to_userData['uptime'],
		);
		//穿越
		$_SESSION['tsuser'] = $to_sessionData;
		
		//跳转
		header("Location: ".$jump);
		break;
		
	//恢复原身份
	case "back":
		
		//验证token
		if($_GET['token'] != $_SESSION['token']) {
			tsNotice('非法操作！',null,$jump,true);
		}
		
		//判断是否存在穿越者
		if(!isset($_SESSION['tscover']) || empty($_SESSION['tscover'])){
			unset($_SESSION['tsuser']);
			unset($_SESSION['tsadmin']);
			tsNotice('不存在穿越者！',null,$jump,true);
		}
		//权限临时解决方案
		//判断覆盖者用户是否是管理员（即穿越者必须为管理员）
		$tscoverUser = $_SESSION['tscover'];
		if($tscoverUser['isadmin']!='1'){
			tsNotice('非法操作！',null,$jump,true);
		}
		
		//还原
		$_SESSION['tsuser'] = $_SESSION['tscover'];
		
		//销毁穿越者session
		unset($_SESSION['tscover']);
		
		//跳转
		header("Location: ".$jump);
		break;
		
}