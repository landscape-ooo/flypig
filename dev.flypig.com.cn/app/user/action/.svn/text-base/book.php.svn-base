<?php 
defined('IN_TS') or die('Access Denied.');

//用户空间
include 'userinfo.php';

$pagesize = 15;
$page = isset($_GET['page']) ? intval($_GET['page']) : '1';
$url = tsUrl('user','book',array('id'=>$strUser['userid'],'page'=>''));
$lstart = ($page-1)*$pagesize;

//查询
$arrBook = $new['user']->findAll('book',array(
	'userid'=>$strUser['userid'],
	'isaudit'=>'1',
	'status'=>'1'
),'addtime desc',null,$lstart.','.$pagesize);

//总数
$bookNum = $new['user']->findCount('book',array(
	'userid'=>$strUser['userid'],
	'isaudit'=>'1',
	'status'=>'1'
));

//分页
$pageUrl = pagination($bookNum, $pagesize, $page, $url);

$title = $strUser['username'].'创建的图书';

include template('book');