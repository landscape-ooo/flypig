<?php
defined('IN_TS') or die('Access Denied.');
// 用户是否登录
$userid = aac('user') -> isLogin();

switch($ts){
	case '':
		//验证权限
		if($TS_APP['options']['iscreate']!='0' && $TS_USER['user']['isadmin']!='1'){
			tsNotice('非法权限！');
		}
		
		$cateid = isset($_GET['cateid']) ? intval($_GET['cateid']) : 0;
		
		//取出分类
		$arrCate = $new['event']->findAll('event_cate', array(
			'status'=>'1'
		));
		
		//调出省份数据
		$province = $new['event']->findAll('area_province');
		
		$title = '发布活动';
		include template('add');
		
		break;
		
	//发布活动执行
	case 'do':
		//验证权限
		if($TS_APP['options']['iscreate']!='0' && $TS_USER['user']['isadmin']!='1'){
			tsNotice('非法权限！');
		}
		
		//验证token
		if(!isset($_POST['token']) || $_POST['token'] != $_SESSION['token']) {
			tsNotice('非法操作！');
		}
		//验证码
		if ($TS_SITE['base']['isauthcode']){
			$authcode = isset($_POST['authcode']) ? strtolower($_POST['authcode']) : '';
			if ($authcode != $_SESSION ['verify']) {
				tsNotice("验证码输入有误，请重新输入！" );
			}
		}
		
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
		//是否审核
		$isaudit = '0';
		if($TS_APP['options']['isaudit']=='0' || $TS_USER['user']['isadmin']=='1'){
			$isaudit = '1';
		}
		
		$eventData = array(
			'userid' => $userid,
			'title' => $title,
			'cateid' => $cateid,
			'time_start' => $time_start,
			'time_end' => $time_end,
			'province' => $province,
			'city' => $city,
			'area' => $area,
			'address' => $address,
			'content' => $content,
			'isaudit' => $isaudit,
			'addtime' => time()
		);
		//入库
		$eventid = $new['event']->create('event', $eventData);
		$new['event']->create('event_user', array(
			'userid'=>$userid,
			'eventid'=>$eventid
		));
		//更新分类活动数
		if($isaudit == '1'){
			$new['event']->update('event_cate',array(
				'cateid'=>$cateid,
			),array(
				'`count_event` = `count_event`+1'
			));
		}
		//上传海报
		$arrUpload = tsUpload($_FILES['photo'],$eventid,'event',array('jpg','gif','png'));
		if($arrUpload){
			$new['event']->update('event',array(
				'eventid'=>$eventid,
			),array(
				'path'=>$arrUpload['path'],
				'photo'=>$arrUpload['url'],
			));
		}
		
		//对积分进行处理
		aac('user')->doScore($app,$ac,$ts);
		
		//feed开始
		if($TS_SITE['base']['isfeed']){
			$feed_action = 'event_add';
			$feed_data = array(
				'link' => tsUrl('event','show', array('id'=>$eventid)),
				'title' => $title,
				'content' => cututf8(t($content),'0','250'),
			);
			aac('feed')->add($userid,$feed_action,$feed_data);
		}
		//feed结束
		
		//index开始
		if(aac('index')->isRun('event')){
			$index_action = 'event_list';
			$index_pic = '';
			if($arrUpload['path'] && $arrUpload['url']){
				$index_pic = 'uploadfile/event/'.$arrUpload['url'];
			}
			$index_data = array(
				'id' => $eventid,
				'title' => $title,
				'userlink' => tsUrl('user','space',array('id'=>$userid)),
				'username' => $TS_USER['user']['username'],
				'link' => tsUrl('event','show',array('id' => $eventid)),
				'pic' => $index_pic,
				'content' => cututf8(t($content),'0','250'),
				'time' => $nowtime
			);
			aac('index')->add($userid,$index_action,$index_data);
		}
		//index结束
		
		header("Location: ".tsUrl('event','show',array('id'=>$eventid)));
		break;
	
}
