<?php 
defined('IN_TS') or die('Access Denied.');

//用户空间
include 'userinfo.php';

$pagesize = 15;
$page = isset($_GET['page']) ? intval($_GET['page']) : '1';
$url = tsUrl('user','event',array('id'=>$strUser['userid'],'page'=>''));
$lstart = ($page-1)*$pagesize;

//查询
$arrEvent = $new['user']->findAll('event',array(
	'userid'=>$strUser['userid'],
	'isaudit'=>'1',
	'status'=>'1'
),'addtime desc',null,$lstart.','.$pagesize);

//总数
$eventNum = $new['user']->findCount('event',array(
	'userid'=>$strUser['userid'],
	'isaudit'=>'1',
	'status'=>'1'
));

//分页
$pageUrl = pagination($eventNum, $pagesize, $page, $url);

$title = $strUser['username'].'发起的活动';

include template('event');