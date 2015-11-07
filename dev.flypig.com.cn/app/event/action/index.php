<?php 
defined('IN_TS') or die('Access Denied.');

//活动分类数据
$arrEventCate = $new['event']->findAll('event_cate', array(
	'status'=>'1'
));

//有分类ID请求
$catename = '';
$cateid = isset($_GET['cateid']) ? intval($_GET['cateid']) : 0;
if(!empty($cateid)){
	$strCate = $new['event']->getOneCate($cateid);
	if(!$strCate){
		header("Location: ".tsUrl('event'));
		exit;
	}
	$catename = $strCate['catename'];
}

//分页处理
$pagesize = 12;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$lstart = $pagesize * ($page-1);
$url = tsUrl('event','index',array('page'=>''));

//获取活动
if(!empty($cateid)){
	$arrEvent = $new['event']->findAll('event', array(
		'cateid'=>$cateid,
		'isaudit'=>'1',
		'status'=>'1'
	),'addtime desc', null, $lstart.','.$pagesize);
}else{
	$arrEvent = $new['event']->findAll('event', array(
		'isaudit'=>'1',
		'status'=>'1'
	),'addtime desc', null, $lstart.','.$pagesize);
}

//数据完善
foreach($arrEvent as $key => $item){
	
	//添加及格式化数据
	$arrEvent[$key] = $new['event']->getOneEvent($item['eventid']);
	
	//活动类型
	$tmpEventCate = $new['event']->getOneCate($item['cateid']);
	$arrEvent[$key]['catename'] = $tmpEventCate['catename'];
	
	//活动地点
	$arrEvent[$key]['PCA'] = $new['event']->getEventPCA('　',$item['province'],$item['city'],$item['area']);
}

//总数
$eventNumAll = $new['event']->findCount('event',array(
	'isaudit'=>'1',
	'status'=>'1'
));
if(!empty($cateid)){
	$eventNum = $new['event']->findCount('event',array(
		'cateid'=>$cateid,
		'isaudit'=>'1',
		'status'=>'1'
	));
}else{
	$eventNum = $eventNumAll;
}

//分页
$pageUrl = pagination($eventNum, $pagesize, $page, $url);

$title = $catename;

include template("index");