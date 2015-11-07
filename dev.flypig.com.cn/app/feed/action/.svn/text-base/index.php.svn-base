<?php
defined('IN_TS') or die('Access Denied.');

//adan前台停用
header("HTTP/1.1 404 Not Found");
header("Status: 404 Not Found");
echo 'No APP 404 Page！';
exit;
///

$pagesize = 20;
$page = isset($_GET['page']) ? intval($_GET['page']) : '1';
$url = tsUrl('feed','index',array('page'=>''));
$lstart = ($page-1)*$pagesize;

$arrFeeds = $new['feed']->findAll('feed',null,'addtime desc',null,$lstart.','.$pagesize);

$feedNum = $new['feed']->findCount("feed");
$pageUrl = pagination($feedNum, $pagesize, $page, $url);

if($page > 1){
	$title = '社区动态 - 第'.$page.'页';
}else{
	$title = '社区动态';
}

foreach($arrFeeds as $key=>$item){
	//$data = json_decode($item['data'],true);
	$data = unserialize($item['data']);
	
	if(is_array($data)){
		foreach($data as $key=>$itemTmp){
			$tmpkey = '{'.$key.'}';
			$tmpdata[$tmpkey] = urldecode($itemTmp);
		}
	}
	$arrFeed[] = array(
		'user' => aac('user')->getOneUser($item['userid']),
		'content' => strtr($item['template'],$tmpdata),
		'addtime' => $item['addtime'],
	);
}

$sitekey = $TS_APP['options']['appkey'];
$sitedesc = $TS_APP['options']['appdesc'];

include template('index');