<?php
defined('IN_TS') or die('Access Denied.');

//如果有图书ID的书评列表页
$bookid = isset($_GET['bookid']) ? intval($_GET['bookid']) : 0;
if(!empty($bookid)){
	$arrBook = aac('book')->getOneBook($bookid);
	if(!$arrBook){
		header("HTTP/1.1 404 Not Found");
		header("Status: 404 Not Found");
		$title = '404';
		include pubTemplate("404");
		exit;
	}
	$bookname = $arrBook['bookname'];
}

//推荐的图书
$arrRecommendBook = aac('book')->getRecommendBook(4);

//最新10个图书
$arrNewBook = aac('book')->getNewBook(4);

//热门书评
$arrHotReview = $new['review']->findAll('review',array(
		'isaudit'=>'1',
		'status'=>'1'
	),'count_comment desc','bookid,reviewid,title,count_comment',4);
foreach($arrHotReview as $key=>$item){
	$arrHotReview[$key]['title'] = htmlspecialchars($item['title']);
	$arrHotReview[$key]['book'] = aac('book')->getOneBook($item['bookid']);
}

$pagesize = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$lstart = ($page-1)*$pagesize;

$url = tsUrl('review','index',array('page'=>''));

//获取书评
if(!empty($bookid)){
	$arrReview = $new['review']->findAll('review',array(
		'bookid'=>$bookid,
		'isaudit'=>'1',
		'status'=>'1'
	),'istop desc,uptime desc',null,$lstart.','.$pagesize);
}else{
	$arrReview = $new['review']->findAll('review',array(
		'isaudit'=>'1',
		'status'=>'1'
	),'istop desc,uptime desc',null,$lstart.','.$pagesize);
}
if(is_array($arrReview)){
	foreach($arrReview as $key=>$item){
		$arrReview[$key]['title'] = htmlspecialchars($item['title']);
		$arrReview[$key]['user'] = aac('user')->getOneUser($item['userid']);
		$arrReview[$key]['book'] = aac('book')->getOneBook($item['bookid']);
	}
}

//书评总数
if(!empty($bookid)){
	$reviewNum = $new['review']->findCount('review',array(
		'bookid'=>$bookid,
		'isaudit'=>'1',
		'status'=>'1'
	));
}else{
	$reviewNum = $new['review']->findCount('review',array(
		'isaudit'=>'1',
		'status'=>'1'
	));
}

//分页
$pageUrl = pagination($reviewNum, $pagesize, $page, $url);

$title = '书评列表';

if ($TS_CF ['mobile'])
	$sitemb = tsUrl ( 'moblie', 'review' );

$toprelation_share=$new['review']->getFriendVisitlist();
$myreview_list= $new['review']->getMyToplist();
include template("index");