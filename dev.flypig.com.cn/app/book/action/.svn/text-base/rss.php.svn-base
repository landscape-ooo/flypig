<?php
defined('IN_TS') or die('Access Denied.');
//RSS输出
$bookid = intval($_GET['bookid']);
$strBook = $new['book']->find('book',array(
	'bookid'=>$bookid,
));

$arrReview = $new['book']->findAll('review',array(
	'bookid'=>$bookid,
),'addtime desc',null,30);

foreach($arrReview as $key=>$item){
	$arrReview[$key]['title'] = htmlspecialchars($item['title']);
	$arrReview[$key]['content'] = htmlspecialchars($item['content']);
}

$pubdate = time();
header( 'Content-Type:text/xml');
include template("rss");