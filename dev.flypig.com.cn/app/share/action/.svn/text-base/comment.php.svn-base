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
		
		$shareid = intval($_POST['shareid']);
		$content = htmlClean($_POST['content']);
		
		//过滤内容开始
		if($TS_USER['user']['isadmin']==0){
			aac('system')->antiWord($content);
		}
		//过滤内容结束
		
		if($content==''){
			tsNotice('没有任何内容是不允许你通过滴^_^');
		}
		//添加评论
		$commentid = $new['share']->create('share_comment',array(
			'shareid'	=> $shareid,
			'userid'	=> $userid,
			'content'	=> $content,
			'addtime'=> time(),
		));
		
		//统计评论数
		$count_comment = $new['share']->findCount('share_comment',array(
			'shareid'=>$shareid,
		));
		
		//更新分享最后回应时间和评论数
		$new['share']->update('share',array(
			'shareid'=>$shareid,
		),array(
			'count_comment'=>$count_comment,
			'uptime'=>time(),
		));
		
		//对积分进行处理
		aac('user')->doScore($app,$ac,$ts);
		
		//发送系统消息(通知楼主有人回复他的分享啦)			
		$strShare = $new['share']->find('share',array(
			'shareid'=>$shareid,
		));
		if($strShare['userid'] != $TS_USER['user']['userid']){
			$msg_userid = '0';
			$msg_touserid = $strShare['userid'];
			$msg_content = '你的分享：《'.$strShare['title'].'》新增一条评论，快去看看给个回复吧^_^ <br />'
										.tsUrl('share','show',array('id'=>$shareid));
			aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
		}
		
		//对积分进行处理
		aac('user')->doScore($app,$ac,$ts,$strShare['userid'],'2');
		
		//feed开始
		if($TS_SITE['base']['isfeed']){
			$feed_action = 'share_comment_add';
			$feed_data = array(
				'link' => tsUrl('share','show',array('id'=>$shareid)),
				'title' => $strShare['title'],
				'content' => cututf8(t($content),'0','50'),
			);
			aac('feed')->add($userid,$feed_action,$feed_data);
		}
		//feed结束
		
		//QQ分享
		$arrShare = array(
			'content'=>t($content).'[ThinkSAAS社区]'.tsUrl('share','show',array('id'=>$shareid)),
		);
		doAction('qq_share',$arrShare);
		//微博分享
		doAction('weibo_share',t($content).'[ThinkSAAS社区]'.tsUrl('share','show',array('id'=>$shareid)));
		
		header("Location: ".tsUrl('share','show',array('id'=>$shareid)));
		break;
		
	//删除评论
	case "delete":
		
		$commentid = intval($_GET['commentid']);
		//获取该评论信息
		$strComment = $new['share']->find('share_comment',array(
			'commentid'=>$commentid,
		));
		if(!$strComment){
			tsNotice('评论不存在，参数错误');
		}
		//验证权限
		if($strComment['userid']!=$userid && $TS_USER['user']['isadmin']!='1'){
			tsNotice('权限错误');
		}
		
		$new['share']->delComment($commentid);
		
		//统计评论数
		$count_comment = $new['share']->findCount('share_comment',array(
			'shareid'=>$strComment['shareid'],
		));
		
		//更新分享最后回应时间和评论数
		$new['share']->update('share',array(
			'shareid'=>$strComment['shareid'],
		),array(
			'count_comment'=>$count_comment,
		));
		
		//扣除用户相应的积分，删除评论扣2分
		aac('user')->delScore($strComment['userid'],'删除分享评论',2);
		
		//跳转回到分享页
		header("Location: ".tsUrl('share','show',array('id'=>$strComment['shareid'])));
		break;
		
}