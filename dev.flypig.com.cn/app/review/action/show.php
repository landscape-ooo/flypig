<?php
defined('IN_TS') or die('Access Denied.');

$reviewid = intval($_GET['id']);

$strReview = $new['review']->find('review',array(
	'reviewid'=>$reviewid,
));
if(!$strReview){
	tsNotice('参数错误，书评不存在', null, tsUrl('review'), true);
}
//书评审核 
if($strReview['isaudit']=='0' && $TS_USER['user']['isadmin']!='1'){
	tsNotice('书评还在审核中，审核后显示');
}

//附表数据
$strReview['content'] = '';
$strReviewAdd = $new['review']->find('review_add',array(
	'reviewid'=>$reviewid,
));
if($strReviewAdd){
	$strReview['content'] = $strReviewAdd['content'];
}

//获取该书评关联的图书信息
$strBook = $new['review']->find('book', array(
	'bookid' => $strReview['bookid'],
));

//判断会员是否关注该图书
$strBookUser = '';
if(intval($TS_USER['user']['userid'])){
	$strBookUser = $new['review']->find('book_user',array(
		'userid'=>intval($TS_USER['user']['userid']),
		'bookid'=>$strReview['bookid'],
	));
}

//@用户功能处理
//$strReview['content'] = preg_replace("/\[@(.*)\:(.*)]/U","<a href='".tsUrl('user','space',array('id'=>'$2'))." ' rel=\"face\" uid=\"$2\"'>@$1</a>",$strReview['content']);

//最新书评
$newReview = $new['review']->findAll('review',array(
	'isaudit'=>'1',
	'status'=>'1'
),'addtime desc',null,5);

//7天内的热门书评
$arrHotReview = $new['review']->getHotDayReview(7, 5);

//谁喜欢（收藏）了这篇书评
$arrCollectUser = $new['review']->getCollectUser($reviewid);

//书评标签
$strReview['tags'] = aac('tag')->getObjTagByObjid('review', 'reviewid', $reviewid);

//书评作者用户信息
$strReview['user'] = aac('user')->getOneUser($strReview['userid']);

//把标签作为关键词
if($strReview['tags']){
	foreach($strReview['tags'] as $key=>$item){
		$arrTag[] = $item['tagname'];
	}
	$sitekey = array_to_str($arrTag);
}
//标题
$title = $strReview['title'];

//评价
if($strReview['rating']){
	$tmp_str = "";
	switch($strReview['rating']){
		case "40":
			$ratingvalue = 20;
			$ratingtitle = "很差";
			break;
		case "50":
			$ratingvalue = 40;
			$ratingtitle = "较差";
			break;
		case "60":
			$ratingvalue = 60;
			$ratingtitle = "还行";
			break;
		case "80":
			$ratingvalue = 80;
			$ratingtitle = "推荐";
			break;
		case "90":
			$ratingvalue = 100;
			$ratingtitle = "力荐";
			break;
		default:
			break;
	}
	$tmp_str .= "<span class=\"com-star-level\" title=\"".$ratingtitle."\">\r\n";
	$tmp_str .= "  <span style=\"width: ".$ratingvalue."%;\"></span>\r\n";
	$tmp_str .= "</span>（".$ratingtitle."）\r\n";
	$strReview['rating'] = $tmp_str;
}

//评论分页开始
$pagesize = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; 
$url = tsUrl('review', 'show', array('id' => $reviewid, 'page' => ''));
$start = ($page-1)*$pagesize;

//查询评论
$arrComment = $new['review']->findAll('review_comment',array(
	'reviewid'=>$reviewid,
	'status'=>'1'
),'addtime asc',null,$start.','.$pagesize);
//补充数据
foreach($arrComment as $key => $item){
	$arrReviewComment[] = $item;
	$arrReviewComment[$key]['content'] = $new['review']->getCommentAdd($item['commentid']);
	$arrReviewComment[$key]['lou'] = $start + $key + 1;
	$arrReviewComment[$key]['user'] = aac('user')->getOneUser($item['userid']);
	//@用户功能处理
	//$arrReviewComment[$key]['content'] = preg_replace("/\[@(.*)\:(.*)]/U","<a href='".tsUrl('user','space',array('id'=>'$2'))." ' rel=\"face\" uid=\"$2\"'>@$1</a>",$arrReviewComment[$key]['content']);	
}
//总数
$commentNum = $new['review']->findCount('review_comment',array(
	'reviewid'=>$reviewid,
	'status'=>'1'
));
//分页
$pageUrl = pagination($commentNum, $pagesize, $page, $url); 

//增加浏览次数
$new['review']->update('review', array(
	'reviewid' => $reviewid,
), array(
	'count_view' => $strReview['count_view'] + 1,
));

if($TS_CF['mobile']){
	$sitemb = tsUrl('moblie','review',array('ts'=>'show','reviewid'=>$reviewid));
}

include template('show');