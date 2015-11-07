<?php 
defined('IN_TS') or die('Access Denied.');
//用户是否登录
$userid = aac('user')->isLogin();
switch($ts){
	//添加评论
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
		$content = htmlClean($_POST['content']);
		
		/*
		//过滤内容开始
		if($TS_USER['user']['isadmin']==0){
			aac('system')->antiWord($content);
		}
		//过滤内容结束
		*/
		
		if($content==''){
			tsNotice('没有任何内容是不允许你通过滴^_^');
		}
		$nowtime = time();
		//添加评论
		$commentid = $new['review']->create('review_comment',array(
			'reviewid'=>$reviewid,
			'userid'=>$userid,
			'addtime'=>$nowtime,
			'uptime'=>$nowtime
		));
		if($commentid){
			$new['review']->create('review_comment_add',array(
				'commentid'=>$commentid,
				'content'=>$content
			));
		}
		//统计评论数
		$count_comment = $new['review']->findCount('review_comment',array(
			'reviewid'=>$reviewid,
			'status'=>'1'
		));
		
		//更新书评最后回应时间和评论数
		$new['review']->update('review',array(
			'reviewid'=>$reviewid,
		),array(
			'count_comment'=>$count_comment,
			'uptime'=>time()
		));
		
		//对积分进行处理
		aac('user')->doScore($app,$ac,$ts);
		
		//发送系统消息(通知楼主有人回复他的书评啦)
		$strReview = $new['review']->find('review',array(
			'reviewid'=>$reviewid,
		));
		if($strReview['userid'] != $TS_USER['user']['userid']){
			$msg_userid = '0';
			$msg_touserid = $strReview['userid'];
			$msg_content = '你的书评：《'.$strReview['title'].'》新增一条评论，快去看看给个回复吧^_^ <br />'.tsUrl('review','show',array('id'=>$reviewid));
			aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
		}
		
		//对积分进行处理
		aac('user')->doScore($app,$ac,$ts,$strReview['userid'],'2');
		
		//feed开始
		if($TS_SITE['base']['isfeed']){
			$feed_action = 'review_comment_add';
			$feed_data = array(
				'link' => tsUrl('review','show',array('id'=>$reviewid)),
				'title' => $strReview['title'],
				'content' => cututf8(t($content),'0','50'),
			);
			aac('feed')->add($userid,$feed_action,$feed_data);
		}
		//feed结束
		
		//QQ分享
		$arrShare = array(
			'content'=>tsClean($content).'[飞猪网社区]'.tsUrl('review','show',array('id'=>$reviewid)),
		);
		doAction('qq_share',$arrShare);
		//微博分享
		doAction('weibo_share',tsClean($content).'[飞猪网社区]'.tsUrl('review','show',array('id'=>$reviewid)));
		
		header("Location: ".tsUrl('review','show',array('id'=>$reviewid)));
		break;
		
	//删除评论
	case "___________________________delete":
		
		$commentid = intval($_GET['commentid']);
		//获取该评论信息
		$strComment = $new['review']->find('review_comment',array(
			'commentid'=>$commentid,
		));
		//获取关联书评信息
		$strReview = $new['review']->find('review',array(
			'reviewid'=>$strComment['reviewid'],
		));
		//获取关联图书信息
		$strBook = $new['review']->find('book',array(
			'bookid'=>$strReview['bookid'],
		));
		//验证权限
		if($strReview['userid']==$userid || $strBook['userid']==$userid || $TS_USER['user']['isadmin']==1 || $strComment['userid']==$userid){
			
			$new['review']->delComment($commentid);
			
			//统计评论数
			$count_comment = $new['review']->findCount('review_comment',array(
				'reviewid'=>$strReview['reviewid'],
			));
			
			//更新书评最后回应时间和评论数			
			$new['review']->update('review',array(
				'reviewid'=>$strReview['reviewid'],
			),array(
				'count_comment'=>$count_comment,
			));
			
			//扣除用户相应的积分，删除评论扣2分
			aac('user')->delScore($strComment['userid'],'删除书评评论',2);
			
		}
		
		//跳转回到书评页
		header("Location: ".tsUrl('review','show',array('id'=>$strComment['reviewid'])));
		break;
		
}