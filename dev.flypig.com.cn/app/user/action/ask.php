<?php 
defined('IN_TS') or die('Access Denied.');

//用户空间
include 'userinfo.php';

$pagesize = 15;
$page = isset($_GET['page']) ? intval($_GET['page']) : '1';
$url = tsUrl('user','ask',array('id'=>$strUser['userid'],'page'=>''));
$lstart = ($page-1)*$pagesize;

//查询
$arrAsk = $new['user']->findAll('ask',array(
	'userid'=>$strUser['userid'],
	'isaudit'=>'1',
	'status'=>'1'
),'addtime desc',null,$lstart.','.$pagesize);

//总数
$askNum = $new['user']->findCount('ask',array(
	'userid'=>$strUser['userid'],
	'isaudit'=>'1',
	'status'=>'1'
));

//分页
$pageUrl = pagination($askNum, $pagesize, $page, $url);

$title = $strUser['username'].'发布的问答';

include template('ask');