<?php
defined('IN_TS') or die('Access Denied.');

// 用户是否登录
$userid = aac('user') -> isLogin();

switch($ts){
	//编辑
	case "":
		$eventid = intval($_GET['eventid']);
		
		//活动信息
		$strEvent = $new['event']->getOneEvent($eventid);
		if(!$strEvent){
			tsNotice('该活动不存在');
		}
		//判断问题所有者
		if ($strEvent['userid'] != $userid && $TS_USER['user']['isadmin']!=1){
			tsNotice('无权编辑该活动');
		}
		
		//取出分类
		$arrCate = $new['event']->findAll('event_cate', array(
			'status'=>'1'
		));
		
		//取出该问题分类
		$eventCate = $new['event']->getOneCate($eventid);
		
		//调出省份数据
		$province = $new['event']->findAll('area_province');
		
		//活动地点
		$strEvent['PCA'] = $new['event']->getEventPCA('　',$strEvent['province'],$strEvent['city'],$strEvent['area']);
		
		$title = '编辑活动信息';
		include template("edit");
		break;
		
	//编辑执行
	case "do":
		$eventid = intval($_POST['eventid']);
		//活动信息
		$strEvent = $new['event']->getOneEvent($eventid);
		if(!$strEvent){
			tsNotice('该活动不存在');
		}
		if ($strEvent['userid'] != $userid && $TS_USER['user']['isadmin']!=1){
			tsNotice('无权编辑该问题');
		}
		//数据
		$title = tsClean($_POST['title']);
		$cateid = intval($_POST['cateid']);
		$time_start = tsClean($_POST['time_start']);
		$time_end = tsClean($_POST['time_end']);
		$province = intval($_POST['sel_province']);
		$city = intval($_POST['sel_city']);
		$area = intval($_POST['sel_area']);
		$address = tsClean($_POST['address']);
		$content = htmlClean($_POST['content']);
		
		if($title=='' || $cateid=='' || $time_start=='' || $content==''){
			tsNotice("请完善活动必填信息！");
		}
		//待更新数据
		$eventData = array(
			'title' => $title,
			'cateid' => $cateid,
			'time_start' => $time_start,
			'time_end' => $time_end,
			'address' => $address,
			'content' => $content
		);
		//由于增加了审核机制.重新编辑活动将需要重新审核
		if($TS_APP['options']['isaudit']!='0' && $TS_USER['user']['isadmin']!='1'){
			$topicData['isaudit'] = '0';
		}
		//地点更新
		if(!empty($province) || !empty($city) || !empty($area)){
			$eventData['province'] = $province;
			$eventData['city'] = $city;
			$eventData['area'] = $area;
		}
		//更新数据
		$new['event']->update('event',array(
			'eventid'=>$eventid,
		),$eventData);
		
		//如果原数据为已审核，则原分类活动数-1
		if($strEvent['isaudit']=='1'){
			$new['event']->update('event_cate',array(
				'cateid'=>$strEvent['cateid']
			),array(
				"`count_event` = `count_event`-1"
			));
		}
		
		//上传
		if($_FILES['photo']){
			$arrUpload = tsUpload($_FILES['photo'],$eventid,'event',array('jpg','gif','png'));
			if($arrUpload){
				rmrf('cache/event');
				$new['event']->update('event',array(
					'eventid'=>$eventid
				),array(
					'path'=>$arrUpload['path'],
					'photo'=>$arrUpload['url']
				));
			}
		}
		
		//feed开始
		if($TS_SITE['base']['isfeed']){
			$feed_action = 'event_edit';
			$feed_data = array(
				'link' => tsUrl('event','show', array('id'=>$eventid)),
				'title' => $title,
				'content' => cututf8(t($content),'0','50'),
			);
			aac('feed')->add($userid,$feed_action,$feed_data);
		}
		//feed结束
		
		header("Location: ".tsUrl('event','show',array('id'=>$eventid)));
		break;
		
}
