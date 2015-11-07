<?php
defined('IN_TS') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch($ts){

	//编辑书评
	case "":
		$reviewid = intval($_GET['reviewid']);

		if($reviewid == 0){
			tsNotice('参数错误','',tsUrl('review'),true);
		}

		//主表
		$strReview = $new['review']->find('review', array(
				'reviewid'=>$reviewid
		));
		if(!$strReview){
			tsNotice('书评不存在','',tsUrl('review'),true);
		}
		$strReview['title'] = htmlspecialchars($strReview['title']);

		//附表
		$strReview['content'] = '';
		$strReviewAdd = $new['review']->find('review_add', array(
				'reviewid'=>$reviewid
		));
		if($strReviewAdd){
			$strReview['content'] = htmlspecialchars($strReviewAdd['content']);
		}

		//获取书评关联图书
		$strBook = $new['review']->find('book',array(
				'bookid'=>$strReview['bookid']
		));
		if(!$strBook){
			tsNotice('述评关联图书不存在','',tsUrl('review'),true);
		}
		//获取图书用户
		$strBookUser = $new['review']->find('book_user',array(
				'bookid'=>$strReview['bookid'],
				'userid'=>$userid
		));

		if($strReview['userid']!=$userid && $strBook['userid']!=$userid && $TS_USER['user']['isadmin']!=1 && $strBookUser['isadmin']!='1'){
			tsNotice('权限错误','',tsUrl('review','show',array('id'=>$reviewid)),true);
		}
		//找出TAG
		$arrTags = aac('tag')->getObjTagByObjid('review', 'reviewid', $reviewid);
		foreach($arrTags as $key=>$item){
			$arrTag[] = $item['tagname'];
		}
		$strReview['tag'] = array_to_str($arrTag);

		$title = '编辑书评';
		include template("edit");
		break;

		//编辑书评执行
	case "do":

		//验证token
		if(!isset($_POST['token']) || $_POST['token'] != $_SESSION['token']) {
			tsNotice('非法操作！');
		}
		//验证码
		if ($TS_SITE['base']['isauthcode']){
			$authcode = isset($_POST['authcode']) ? strtolower($_POST['authcode']) : '';
			if ($authcode != $_SESSION ['verify']) {
				tsNotice("验证码输入有误，请重新输入！" );
			}
		}

		$reviewid = intval($_POST['reviewid']);
		if(empty($reviewid)){
			tsNotice("参数错误!");
		}
		
		$title = tsClean($_POST['title']);
		$rating = intval($_POST['rating']);
		$content = htmlClean($_POST['content']);
		
		if($title == '' || $rating == '' || $content == '') {
			tsNotice('标题、评价、内容不允许为空！' );
		}
		
		//检测书评数据
		$strReview = $new['review']->find('review',array(
				'reviewid' => $reviewid
		));
		if(!$strReview){
			tsNotice('书评不存在');
		}
		
		//获取书评关联图书
		$strBook = $new['review']->find('book',array(
			'bookid'=>$strReview['bookid']
		));
		if(!$strBook){
			tsNotice('述评关联图书不存在','',tsUrl('review'),true);
		}
		//获取图书用户
		$strBookUser = $new['review']->find('book_user',array(
			'bookid'=>$strReview['bookid'],
			'userid'=>$userid
		));
		
		//检测权限
		if($strReview['userid']!=$userid && $strBook['userid']!=$userid && $TS_USER['user']['isadmin']!=1 && $strBookUser['isadmin']!='1'){
			tsNotice('权限错误','',tsUrl('review','show',array('id'=>$reviewid)),true);
		}
		
		//收集其它数据
		$summary = cututf8(t($_POST['content']),'0','250');
		$nowtime = time();
		
		/*
		 if($TS_USER['user']['isadmin']=='0'){
		aac('system')->antiWord($title);
		aac('system')->antiWord($content);
		}
		*/
		
		$isaudit = '0';
		if($TS_APP['options']['isaudit']=='0' || $strBook['userid']==$userid && $TS_USER['user']['isadmin']=='1' && $strBookUser['isadmin']=='1'){
			$isaudit = '1';
		}
		
		//更新主表
		$new['review']->update('review',array(
			'reviewid' => $reviewid
		),array(
			'title' => $title,
			'rating' => $rating,
			'summary' => $summary,
			'isaudit' => $isaudit,
			'uptime' => $nowtime
		));
		//内容表
		$new['review']->replace('review_add',array(
			'reviewid' => $reviewid
		),array(
			'reviewid' => $reviewid,
			'content' => $content
		));
		
		//处理标签
		$tag = tsClean($_POST['tag']);
		if($tag){
			aac('tag')->delIndextag('review','reviewid',$reviewid);
			aac('tag')->addTag('review', 'reviewid', $reviewid, $tag);
		}
		
		//feed开始
		if($TS_SITE['base']['isfeed']){
			$feed_action = 'review_edit';
			$feed_data = array(
				'link' => tsUrl('review','show',array('id' => $reviewid)),
				'title' => $title,
				'content' => cututf8(t($content),'0','250')
			);
			aac('feed')->add($userid,$feed_action,$feed_data );
		}
		//feed结束
		
		/*
		//index开始
		if(aac('index')->isRun($app)){
			$index_action = 'review_list';
			$index_path = $strBook['path'] ? $strBook['path'] : '';
			$index_pic = $strBook['photo'] ? 'uploadfile/book/'.$strBook['photo'] : '';
			$index_data = array(
				'id' => $reviewid,
				'title' => $title,
				'userlink' => tsUrl('user','space',array('id'=>$userid)),
				'username' => $TS_USER['user']['username'],
				'link' => tsUrl($app,'show',array('id' => $reviewid)),
				'path' => $index_path,
				'pic' => $index_pic,
				'content' => cututf8(t($content),'0','250'),
				'time' => $nowtime
			);
			aac('index')->add($userid,$index_action,$index_data);
		}
		//index结束
		*/
		
		header("Location: ".tsUrl('review','show',array('id'=>$reviewid)));
		break;

}