<?php
defined('IN_TS') or die('Access Denied.');

//图书内容页

$bookid = intval($_GET['id']);

$bookNum = $new['book']->findCount('book',array(
	'bookid'=>$bookid,
));

if($bookNum == 0) {
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	$title = '404';
	include pubTemplate("404");
	exit;
}

//图书信息
$strBook = $new['book']->getOneBook($bookid);

//推荐图书
$arrRecommendBook = $new['book']->getRecommendBook(8);

//图书是否需要审核
if($strBook['isaudit']=='0'){
	
	include template("book_isaudit");
	
}elseif($strBook['status']=='0'){//图书是否显示
	
	include template("book_isshow");
	
}elseif($strBook['isopen']=='0' && $isBookUser=='0'){//是否开放访问
	
	include template("book_isopen");
	
}else{
	
	//组长信息
	$strLeader = aac('user')->getOneUser($strBook['userid']);
	
	//判断会员是否加入该图书
	$isBookUser = 0;
	if(intval($TS_USER['user']['userid'])){
		$strUser = aac('user')->getOneUser(intval($TS_USER['user']['userid']));
		$isBookUser = $new['book']->findCount('book_user',array(
			'userid'=>intval($TS_USER['user']['userid']),
			'bookid'=>$bookid,
		));
	}

	//获取类别数据
	$arrCate = $new['book']->getCateList();
	//获取作者数据
	$arrAuthor = $new['book']->getAuthorList();
	//获取出版社数据
	$arrPubhouse = $new['book']->getPubhouseList();
	//获取出版商数据
	$arrCompany = $new['book']->getCompanyList();

	//格式化描述
	$strBook['description'] = cututf8(tt($strBook['description']),0,110);
	$strBook['awardsrecord'] = str_replace(array("\r\n","\n","\r"),"<br>",$strBook['awardsrecord']);
	//作者
	$arrBookAuthor = $new['book']->getOneBookAuthor($bookid);
	//格式化作者
	$strBook['author'] = formatAuthor($arrAuthor,$arrBookAuthor);
	//格式化出版社
	$strBook['pubhouse'] = $arrPubhouse[$strBook['pubhouse']]['puname'];
	//格式化出版商
	$strBook['company'] = $arrCompany[$strBook['company']]['coname'].($arrCompany[$strBook['company']]['conickname'] ? '（'.$arrCompany[$strBook['company']]['conickname'].'）' : '');
	
	//获取本书类别
	$strBook['bookcate'] = $new['book']->getOneBookCate($bookid);
	//格式化类别输出
	$formatCate_tmp = formatCate($arrCate,$strBook['bookcate']);
	foreach($formatCate_tmp as $k=>$v){
		$strBook[$k] = $v;
	}
	
	//获取内页图片
	$strBook['bookphoto'] = $new['book']->getOneBookPhoto($bookid);
	
	//获取图书附加信息
	$bookAdd = $new['book']->getOneBookAdd($bookid);
	$strBook['bookadd1'] = stripslashes($bookAdd[1]['content']); //内容简介
	$strBook['bookadd2'] = stripslashes($bookAdd[2]['content']); //专家推荐
	$strBook['bookadd3'] = stripslashes($bookAdd[3]['content']); //图画赏析
	
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$pagesize = 10;
	$lstart = ($page-1)*$pagesize;
	
	$url = tsUrl('book','show',array('id'=>$bookid,'page'=>''));
	
	//统计需要审核的书评
	$count_review_audit = $new['book']->findCount('review', array (
		'bookid' => $bookid,
		'isaudit' => '0' 
	));
	
	//获取推荐书评
	$arrReviews = $new['book']->findAll('review',array(
		'bookid' => $bookid,
		'isaudit' => '1',
	),'istop desc,uptime desc',null,$lstart.','.$pagesize);
	if(is_array($arrReviews)){
		foreach($arrReviews as $key=>$item){
			$arrReview[] = $item;
			$arrReview[$key]['title'] = htmlspecialchars($item['title']);
			$arrReview[$key]['user'] = aac('user')->getOneUser($item['userid']);
			$arrReview[$key]['book'] = aac('book')->getOneBook($item['bookid']);
		}
	}
	
	//书评总数
	$reviewNum = $new['book']->findCount('review',array(
		'bookid'=>$bookid,
		'isaudit'=>1,
		'status'=>1,
	));
	
	$pageUrl = pagination($reviewNum, $pagesize, $page, $url);
	
	//图书会员
	$bookUser = $new['book']->findAll('book_user',array(
		'bookid'=>$bookid,
	),'addtime desc',null,8);
	
	if(is_array($bookUser)){
		foreach($bookUser as $item){
			$strUser = aac('user')->getOneUser($item['userid']);
			if($strUser){
				$arrBookUser[] = $strUser;
			}else{
				$new['book']->delete('book_user',array(
					'userid'=>$item['userid'],
					'bookid'=>$bookid,
				));
			}
		}
	}
	//判断do类型
	$strBook['dotype'] = '';
	if(!empty($TS_USER['user']['userid'])){
		$strBookDo = $new['book']->find('book_do',array(
			'userid'=>$TS_USER['user']['userid'],
			'bookid'=>$bookid
		));
		if($strBookDo){
			$strBook['dotype'] = $strBookDo['type'];
		}
	}
	
	$title = $strBook['bookname'];
	
	if($page > 1){
		$title = $strBook['bookname'].' - 第'.$page.'页';
	}
	
	if($TS_CF['mobile']) $sitemb = tsUrl('moblie','book',array('ts'=>'show','bookid'=>$strBook['bookid']));
	
	include template("show");
	
}