<?php
defined('IN_TS') or die('Access Denied.');

$eventid = intval($_GET['id']);

//活动信息
$strEvent = $new['event']->getOneEvent($eventid);
if(!$strEvent){
	tsNotice("参数错误，活动不存在!");
}

if($strEvent['isaudit'] =='0' && $TS_USER['user']['isadmin']!='1'){
	tsNotice("该活动未通过审核，暂不允许浏览!");
}

//活动地点
$strEvent['PCA'] = $new['event']->getEventPCA('　',$strEvent['province'],$strEvent['city'],$strEvent['area']);

//发起人
$strEvent['user'] = aac('user')->getOneUser($strEvent['userid']);

//处理@用户
$strEvent['content'] = preg_replace("/\[@(.*)\:(.*)]/U","<a href='".tsUrl('user','space',array('id'=>'$2'))." ' rel=\"face\" uid=\"$2\"'>@$1</a>",$strEvent['content']);

//是否已报名
$isEventUser = 0;
if(isset($TS_USER['user']['userid']) && $TS_USER['user']['userid'] != ''){
	$isEventUser = $new['event']->findCount('event_user',array(
		'eventid'=>$strEvent['eventid'],
		'userid'=>$TS_USER['user']['userid']
	));
}
//已报名成员
$arrEventUser = array();
$arrEventUsers = $new['event']->findAll('event_user',array(
	'eventid'=>$strEvent['eventid']
),'addtime desc');
if(is_array($arrEventUsers)){
	foreach($arrEventUsers as $item){
		$arrEventUser[] = aac('user')->getOneUser($item['userid']);
	}
}

//评论
$pagesize = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = $pagesize*($page-1);

$arrEventComment = $new['event']->findAll('event_comment',array(
	'eventid'=>$eventid,
	'status'=>'1'
),'addtime',null,$start.','.$pagesize);
if(is_array($arrEventComment)){
	foreach($arrEventComment as $key=>$item){
		$arrEventComment[$key]['lou'] = $start + $key + 1;
		$arrEventComment[$key]['user'] = aac('user')->getOneUser($item['userid']);
	}
}
$eventCommentNum = $new['event']->findCount('event_comment',array(
	'eventid'=>$eventid,
	'status'=>'1'
));

$url = tsUrl('event','show',array('id'=>$strEvent['eventid'],'page'=>''));
$pageUrl = pagination($eventCommentNum, $pagesize, $page, $url);

$title = $strEvent['title'];

include template("show");