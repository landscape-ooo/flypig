<?php 
defined('IN_TS') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch($ts){

	//我的图书发言
	case "review":
	
		$arrReviews = $db->fetch_all_assoc("select * from ".dbprefix."review where userid='".$TS_USER['user']['userid']."' order by addtime desc limit 30");
		foreach($arrReviews as $key=>$item){
			$arrReview[] = $item;
			$arrReview[$key]['title'] = htmlspecialchars($item['title']);
			$arrReview[$key]['user'] = aac('user')->getOneUser($item['userid']);
			$arrReview[$key]['book'] = aac('book')->getOneBook($item['bookid']);
		}

		$title = '我的图书发言';

		include template("my_review");
	
		break;
		
	//我回复的书评 
	case "reply":
		
		$myReviews = $db->fetch_all_assoc("select reviewid from ".dbprefix."review_comment where userid='".$TS_USER['user']['userid']."' book by reviewid order by addtime desc limit 30");


		foreach($myReviews as $item){

			$strReview = $db->once_fetch_assoc("select * from ".dbprefix."review where reviewid = '".$item['reviewid']."'");
			$arrReviews[] = $strReview;
			
		}

		foreach($arrReviews as $key=>$item){
			$arrReview[] = $item;
			$arrReview[$key]['title'] = htmlspecialchars($item['title']);
			$arrReview[$key]['user'] = aac('user')->getOneUser($item['userid']);
			$arrReview[$key]['book'] = aac('book')->getOneBook($item['bookid']);
		}

		$title='我最近回应的书评';

		include template("my_reply");
		
		break;
		
	//我收藏的书评 
	case "collect":
		
		$arrCollect = $db->fetch_all_assoc("select * from ".dbprefix."review_collect where userid='".$userid."' order by addtime desc limit 30");

		foreach($arrCollect as $item){

			$strReview = $db->once_fetch_assoc("select * from ".dbprefix."review where reviewid = '".$item['reviewid']."'");
			$arrReviews[] = $strReview;
			
		}

		foreach($arrReviews as $key=>$item){
			$arrReview[] = $item;
			$arrReview[$key]['title'] = htmlspecialchars($item['title']);
			$arrReview[$key]['user'] = aac('user')->getOneUser($item['userid']);
			$arrReview[$key]['book'] = aac('book')->getOneBook($item['bookid']);
		}

		$title = '我收藏的书评';

		include template("my_collect");
		
		break;
}