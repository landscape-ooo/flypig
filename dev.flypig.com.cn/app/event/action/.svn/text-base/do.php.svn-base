<?php
defined('IN_TS') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch($ts){
		
	//活动审核 
	case "isaudit":
		//验证权限
		if($TS_USER['user']['isadmin'] != '1'){
			tsNotice("非法操作，请返回！");
		}
		
		$eventid = intval($_GET['eventid']);
		$strEvent = $new['event']->find('event',array(
			'eventid'=>$eventid
		));
		if(!$strEvent){
			tsNotice("活动不存在，请返回！",null,tsUrl('event'),true);
		}
		//审核
		if($strEvent['isaudit']=='0'){
			$isaudit = '1';
			
			//审核通过
			$new['event']->update('event',array(
				'eventid'=>$strEvent['eventid']
			),array(
				'isaudit'=>$isaudit
			));
			
			//更新分类活动数
			$new['event']->update('event_cate',array(
				'cateid'=>$strEvent['cateid']
			),array(
				"`count_event` = `count_event`+1"
			));
			
			if($TS_USER['user']['userid'] != $strEvent['userid']){
				//message开始
				$msg_userid = '0';
				$msg_touserid = $strEvent['userid'];
				$msg_content = '你发布的活动：《'.$strEvent['title'].'》已经通过审核!快去看看吧 <br />'.SITE_URL.'index.php?app=event&ac=show&eventid='.$eventid;
				aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
				//message结束
			}
			
		//取消审核
		}else{
			$isaudit = '0';
			//审核通过
			$new['event']->update('event',array(
				'eventid'=>$strEvent['eventid']
			),array(
				'isaudit'=>$isaudit
			));
			//更新分类活动数
			$new['event']->update('event_cate',array(
				'cateid'=>$strEvent['cateid']
			),array(
				"`count_event` = `count_event`-1"
			));
		}
		tsNotice("操作成功！",null,tsUrl('event','show',array('id'=>$eventid)),true);
		break;
		
	//删除活动 
	case "del":
		if($TS_USER['user']['isadmin'] != '1'){
			tsNotice("非法操作，请返回！",null,tsUrl('event'),true);
		}
		
		$eventid = intval($_GET['eventid']);
		
		$strEvent = $new['event']->find('event',array(
			'eventid'=>$eventid
		));
		if(!$strEvent){
			tsNotice("活动不存在，请返回！",null,tsUrl('event'),true);
		}
		
		//删除数据以及缓存
		rmrf('cache/event');//删除海报缓存
		unlink("uploadfile/event/".$strEvent['path']."/".$eventid.".jpg");//删除原始海报
		$new['event']->delete('event',array(
			'eventid'=>$eventid
		));
		$new['event']->delete('event_comment',array(
			'eventid'=>$eventid
		));
		$new['event']->delete('event_user',array(
			'eventid'=>$eventid
		));
		
		//更新活动分类统计
		$curCateNum = $new['event']->findCount('event',array(
			'cateid'=>$strEvent['cateid'],
			'isaudit'=>'1'
		));
		$new['event']->update('event_cate',array(
			'cateid'=>$strEvent['cateid']
		),array(
			'count_event'=>$curCateNum
		));
		
		//删除首页推送数据
		aac('index')->del('event_list',$eventid);
		
		tsNotice("操作成功！",null,tsUrl('event'),true);
		break;
		
}
