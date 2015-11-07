<?php
defined('IN_TS') or die('Access Denied.');

//活跃会员
$arrHotUser = aac('user')->getHotUser(16);

//最新会员
$arrNewUser = aac('user')->getNewUser(8);

//推荐图书列表
$arrRecommendBook = $new['book']->getRecommendBook(16);
//最新10个图书
$arrNewBook = $new['book']->getNewBook(10);


//最新书评
$arrNewReviews = $new['book']->findAll('review',array(
	'isaudit'=>0,
),'uptime desc',null,30);

foreach($arrNewReviews as $key=>$item){
	$arrReview[] = $item;
	$arrReview[$key]['title']=htmlspecialchars($item['title']);
	$arrReview[$key]['user'] = aac('user')->getOneUser($item['userid']);
	$arrReview[$key]['book'] = aac('book')->getOneBook($item['bookid']);
}

//最新标签
$arrTag = $new['book']->findAll('tag',null,'count_review desc',null,30);

//社区精华帖
$arrPosts = $new['book']->findAll('review',array(
	'isposts'=>1,
),'uptime desc',null,15);

$title = '随便看看';
include template("explore");