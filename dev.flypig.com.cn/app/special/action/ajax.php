<?php
defined('IN_TS') or die('Access Denied.');

//用户是否登录
$userid = intval($TS_USER['user']['userid']);
if($userid==0){
	echo jsonAjax('0','未登陆，请先登陆',array(
		'url'=>tsUrl('user','login')
	));
	exit;
}

switch($ts){
	
	//取消参加专题
	case "cancel":
		$specialid = intval($_POST['id']);
		
		//查询
		$isUser = $new['special']->findCount('special_user',array(
			'specialid'=>$specialid,
			'userid'=>$userid
		));
		if(!$isUser){
			echo jsonAjax('2','未曾报名');
			exit;
		}
		
		//删主表
		$new['special']->delete('special_user',array(
			'specialid'=>$specialid,
			'userid'=>$userid
		));
		
		//统计
		$numUser = $new['special']->findCount('special_user',array(
			'specialid'=>$specialid
		));
		//更新专题表
		$new['special']->update('special',array(
			'specialid'=>$specialid
		),array(
			'count_user'=>$numUser
		));
		
		echo jsonAjax('1','取消成功');
		break;
		
	//参加专题
	case "join":
		$specialid = intval($_POST['id']);
		
		//查询
		$isUser = $new['special']->findCount('special_user',array(
			'specialid'=>$specialid,
			'userid'=>$userid
		));
		if($isUser){
			echo jsonAjax('2','已报名');
			exit;
		}
		
		//添加主表
		$addtime = $_SERVER['REQUEST_TIME'];
		$joinid = $new['special']->create('special_user',array(
			'specialid'=>$specialid,
			'userid'=>$userid,
			'addtime'=>$addtime
		));
		
		//统计
		$numUser = $new['special']->findCount('special_user',array(
			'specialid'=>$specialid
		));
		//更新专题表
		$new['special']->update('special',array(
			'specialid'=>$specialid
		),array(
			'count_user'=>$numUser
		));
		
		echo jsonAjax('1','加入成功');
		break;
		

}
