<?php
defined ( 'IN_TS' ) or die ( 'Access Denied.' );

// 用户是否登录
$userid = aac('user')->isLogin ();

switch ($ts) {
	// 发布书评
	case "" :
		//验证权限
		if($TS_APP['options']['iscreate'] != 0 && $TS_USER['user']['isadmin']!=1){
			tsNotice('非法权限！');
		}

		$bookid = intval ( $_GET ['bookid'] );
		// 图书数目
		$strBook = aac('book')->find ('book', array (
				'bookid' => $bookid
		));
		if(!$strBook){
			tsNotice('图书不存在！' );
			//header("Location: " . SITE_URL);
			exit ();
		}
		$strBook ['bookname'] = htmlspecialchars(stripslashes($strBook['bookname']));
		if($strBook ['isaudit'] == '0'){
			tsNotice ( '图书目前状态为未审核，不允许写书评！' );
		}

		// 图书会员
		$isBookUser = $new['review']->findCount('book_user', array (
				'userid' => $userid,
				'bookid' => $bookid
		));

		/*
		 // 允许图书成员发帖
		if ($strBook ['ispost'] == 1 && $isBookUser == 0 && $userid != $strBook ['userid']) {
		tsNotice ( "本图书只允许图书成员发书评，请加入图书后再发帖！" );
		}
		// 不允许图书成员发帖
		if ($strBook ['ispost'] == 0 && $userid != $strBook ['userid']) {
		tsNotice ( "本图书只允许图书组长发帖！" );
		}
		*/
		// 书评类型
		$arrBookType = $new['review']->findAll('review_type', array (
				'bookid' => $bookid
		));

		$title = '发布书评';
		// 包含模版
		include template("add");

		break;

		// 执行发布书评
	case "do" :
		//验证权限
		if($TS_APP['options']['iscreate'] != 0 && $TS_USER['user']['isadmin']!=1){
			tsNotice('非法权限！');
		}
		
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
		
		$bookid = intval($_POST['bookid']);
		
		//图书
		$strBook = $new['review']->find('book',array(
			'bookid' => $bookid
		));
		if($strBook['isaudit']=='0'){
			tsNotice('图书还未审核通过，不允许发帖！');
		}
		//获取图书用户
		$strBookUser = $new['review']->find('book_user',array(
			'bookid'=>$bookid,
			'userid'=>$userid
		));
		
		//检测权限
		/* if($strBook['userid']!=$userid && $TS_USER['user']['isadmin']!=1 && $strBookUser['isadmin']!='1'){
			tsNotice('权限错误','',tsUrl('review'),true);
		} */
		
		$title = tsClean($_POST['title']);
		$rating = intval($_POST['rating']);
		$content = htmlClean($_POST['content']);
		
		if($title == '' || $rating == '' || $content == '') {
			tsNotice('标题、评价、内容不允许为空！' );
		}
		
		//防止用户发布重复内容，调出用户上一次发表的内容
		$strPreReview = $new['review']->find('review', array(
				'userid' => $userid
		), 'reviewid,title,addtime', 'addtime desc' );
		if($strPreReview){
			similar_text($strPreReview['title'], $title, $percent);
			if ($percent >= 90) {
				tsNotice('请不要连续发内容类似的书评！' );
			}
		}
		
		$isaudit = '0';
		if($TS_APP['options']['isaudit']=='0' || $strBook['userid']==$userid && $TS_USER['user']['isadmin']=='1' && $strBookUser['isadmin']=='1'){
			$isaudit = '1';
		}
		
		$summary = cututf8(t($_POST['content']),'0','250');
		$nowtime = time();
		
		//创建主表数据
		$reviewid = $new['review']->create('review', array(
			'bookid' => $bookid,
			'userid' => $userid,
			'title' => $title,
			'rating' => $rating,
			'summary' => $summary,
			'isaudit' => $isaudit,
			'addtime' => $nowtime,
			'uptime' => $nowtime
		));
		//添加附表数据
		$new['review']->create('review_add', array(

			'reviewid' => $reviewid,

			'content' => $content

		));
		
		//统计用户发帖数
		$countUserReview = $new['review']->findCount('review', array(
			'userid' => $userid
		));
		//更新用户发书评数
		$new['review']->update('user_info',array(
			'userid' => $userid
		), array (
			'count_review' => $countUserReview
		));
		
		/*
		// 处理@用户名
		if(preg_match_all('/@/', $content, $at )){
		preg_match_all("/@(.+?)([\s|:]|$)/is", $content, $matches);
			
		$unames = $matches [1];
			
		$ns = "'" . implode ( "','", $unames ) . "'";
			
		$csql = "username IN($ns)";
			
		if($unames){

		//$query = $db->fetch_all_assoc ( "select userid,username from " . dbprefix . "user_info where $csql" );
		$query = $new['review']->findAll('user_info',$csql,null,'userid,username');
		foreach($query as $v ){
		$content = str_replace ( '@' . $v ['username'] . '', '[@' . $v ['username'] . ':' . $v ['userid'] . ']', $content );
		$msg_content = '我在书评中提到了你<br />去看看：' . tsUrl( 'review', 'show', array(
				'id' => $reviewid
		));
		aac('message')->sendmsg ( $userid, $v ['userid'], $msg_content );
		}
		$new['review']->update ( 'review', array (
				'reviewid' => $reviewid
		), array (
				'content' => $content
		));
		}
		}
		*/
		
		//处理标签
		$tag = tsClean($_POST['tag']);
		aac('tag')->addTag ( 'review', 'reviewid', $reviewid, $tag );
		
		//对积分进行处理
		aac('user')->doScore($app, $ac, $ts);
		
		//feed开始
		if($TS_SITE['base']['isfeed']){
			$feed_action = 'review_add';
			$feed_data = array(
				'link' => tsUrl('review','show',array('id' => $reviewid)),
				'title' => $title,
				'content' => cututf8(t($content),'0','50')
			);
			aac('feed')->add($userid,$feed_action,$feed_data );
		}
		//feed结束
		
		//index开始
		if(aac('index')->isRun('review')){
			$index_action = 'review_list';
			$index_pic = '';
			if($strBook['path'] && $strBook['photo']){
				$index_pic = 'uploadfile/book/'.$strBook['photo'];
			}
			$index_data = array(
				'id' => $reviewid,
				'title' => $title,
				'userlink' => tsUrl('user','space',array('id'=>$userid)),
				'username' => $TS_USER['user']['username'],
				'link' => tsUrl($app,'show',array('id' => $reviewid)),
				'pic' => $index_pic,
				'content' => cututf8(t($content),'0','250'),
				'time' => $nowtime
			);
			aac('index')->add($userid,$index_action,$index_data);
		}
		//index结束
		
		//QQ分享
		$arrShare = array (
			'content' => $title . '[飞猪网]' . tsUrl('review','show',array('id' => $reviewid))
		);
		doAction('qq_share', $arrShare );
		//微博分享
		doAction('weibo_share', $title . '[ThinkSAAS社区]' . tsUrl('review','show',array('id' => $reviewid)));

		header("Location: " . tsUrl('review','show',array('id' => $reviewid)));
		break;
}
