<?php 
defined('IN_TS') or die('Access Denied.');

$name = urldecode(tsFilter($_GET['id']));

//$name=mb_convert_encoding($name,'UTF-8', 'GB2312'); 

$tagid = aac('tag')->getTagId(t($name));

if($tagid==0){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	$title = '404';
	include pubTemplate("404");
	exit;
}

$strTag = $new['book']->find('tag',array(
	'tagid'=>$tagid,
));

$strTag['tagname'] = htmlspecialchars($strTag['tagname']); 

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$url = tsUrl('book','tag',array('id'=>urlencode($name),'page'=>''));

$lstart = $page*30-30;

$arrTagId = $new['book']->findAll('tag_review_index',array(
	'tagid'=>$tagid,
),null,null,$lstart.',30');

foreach($arrTagId as $item){
	$strReview = $new['book']->find('review',array(
		'reviewid'=>$item['reviewid'],
	));
	if($strReview==''){
		$new['book']->delete('tag_review_index',array(
			'reviewid'=>$item['reviewid'],
			'tagid'=>$item['tagid'],
		));
	}
	
	if($strReview){
		$arrReviews[] = $strReview;
	}
}

$arrTagIds = $new['book']->findAll('tag_review_index',array(
	'tagid'=>$tagid,
));
foreach($arrTagIds as $item){
	$strReview = $new['book']->find('review',array(
		'reviewid'=>$item['reviewid'],
	));
	if($strReview==''){
		$new['book']->delete('tag_review_index',array(
			'reviewid'=>$item['reviewid'],
			'tagid'=>$item['tagid'],
		));
	}
}

aac('tag')->countObjTag('review',$tagid);

$reviewNum = $new['book']->findCount('tag_review_index',array(
	'tagid'=>$tagid,
));

$pageUrl = pagination($reviewNum, 30, $page, $url);

foreach($arrReviews as $key=>$item){
	$arrReview[] = $item;
	$arrReview[$key]['title'] = htmlspecialchars($item['title']);
	$arrReview[$key]['user'] = aac('user')->getOneUser($item['userid']);
	$arrReview[$key]['book'] = $new['book']->getOneBook($item['bookid']);
}

//热门tag
$arrTag = $new['book']->findAll('tag',null,'count_review desc',null,30);

$sitekey = $strTag['tagname'];
$title = $strTag['tagname'];

include template("tag");