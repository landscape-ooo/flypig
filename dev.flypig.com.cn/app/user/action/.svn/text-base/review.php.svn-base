<?php 
defined('IN_TS') or die('Access Denied.');

//用户空间
include 'userinfo.php';

$pagesize = 15;
$page = isset($_GET['page']) ? intval($_GET['page']) : '1';
$url = tsUrl('user','review',array('id'=>$strUser['userid'],'page'=>''));
$lstart = ($page-1)*$pagesize;

//查询
$arrReview = $new['user']->findAll('review',array(
	'userid'=>$strUser['userid'],
	'isaudit'=>'1',
	'status'=>'1'
),'addtime desc',null,$lstart.','.$pagesize);

//总数
$reviewNum = $new['user']->findCount('review',array(
	'userid'=>$strUser['userid'],
	'isaudit'=>'1',
	'status'=>'1'
));

//分页
$pageUrl = pagination($reviewNum, $pagesize, $page, $url);

$title = $strUser['username'].'发表的书评';

include template('review');