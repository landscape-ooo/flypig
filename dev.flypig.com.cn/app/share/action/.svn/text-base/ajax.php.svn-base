<?php 
defined('IN_TS') or die('Access Denied.');

switch($ts){
	
	//收藏(喜欢)分享
	case "collect":
		//用户是否登录
		$userid = intval($TS_USER['user']['userid']);
		if(!$userid){
			echo jsonAjax('0','未登陆，请先登陆',array(
				'url'=>tsUrl('user','login')
			));
			exit;
		}
		
		$shareid = intval($_POST['shareid']);
		if(!$shareid){
			echo jsonAjax('2','参数错误');
			exit;
		}
		$strShare = $new['share']->find('share',array(
			'shareid'=>$shareid,
		));
		if(!$strShare){
			echo jsonAjax('2','分享不存在');
			exit;
		}
		$collectNum = $new['share']->findCount('share_collect',array(
			'userid'=>$userid,
			'shareid'=>$shareid,
		));
		if($userid == $strShare['userid']){
			echo jsonAjax('2','自己不能喜欢自己的分享哦');
			exit;
		}elseif($collectNum > 0){
			echo jsonAjax('2','你已经喜欢过本帖啦，请不要再次喜欢');
			exit;
		}else{
			$new['share']->create('share_collect',array(
				'userid'=>$userid,
				'shareid'=>$shareid,
				'addtime'=>time(),
			));
			$new_count_love = intval($strShare['count_love'])+1;
			$new['share']->update('share',array(
				'shareid'=>$shareid,
			),array(
				'count_love'=>intval($strShare['count_love'])+1,
			));
			echo jsonAjax('1','操作成功');
			exit;
		}
		
		break;
}