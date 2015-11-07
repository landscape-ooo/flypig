<?php
defined('IN_TS') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch($ts){
	
	//添加评论 
	case "add":
		$eventid = intval($_POST['eventid']);
		$content = htmlClean($_POST['content']);
		
		if(empty($content)){
			tsNotice('没有任何内容是不允许你通过滴^_^');
		}
		$arrData = array(
			'eventid' => $eventid,
			'userid' => $userid,
			'content' => $content,
			'addtime' => time()
		);
		$commentid = $new['event']->create('event_comment',$arrData);
		//统计评论数
		$count_comment = $new['event']->findCount('event_comment',array(
			'eventid'=>$eventid,
			'status'=>'1'
		));
		
		//更新书评最后回应时间和评论数
		$new['event']->update('event',array(
			'eventid'=>$eventid,
		),array(
			'count_comment'=>$count_comment,
			'uptime'=>time(),
		));
		
		//对积分进行处理
		aac('user')->doScore($app,$ac,$ts);
		
		//发送系统消息(通知活动组织者有人回复他的活动啦)
		$strEvent = $new['event']->find('event',array(
			'eventid'=>$eventid
		));
		if($strEvent['userid'] != $userid){
			$msg_userid = '0';
			$msg_touserid = $strEvent['userid'];
			$msg_content = '你发布的活动：《'.$strEvent['title'].'》有一条新评论，快去看看吧 <br />'.SITE_URL.'index.php?app=event&ac=show&eventid='.$eventid;
			aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
		}
		
		//feed开始
		if($TS_SITE['base']['isfeed']){
			$feed_action = 'event_comment_add';
			$feed_data = array(
				'link' => tsUrl('event','show', array('id'=>$eventid)),
				'title' => $title,
				'content' => cututf8(t($content),'0','50'),
			);
			aac('feed')->add($userid,$feed_action,$feed_data);
		}
		//feed结束
		
		header("Location: ".tsUrl('event','show',array('id'=>$eventid)));
		break;
		
}
