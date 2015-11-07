<?php
defined('IN_TS') or die('Access Denied.');

$userid = aac('user')->isLogin(false);

switch($ts){
	
	//编辑评论提交
	case "submitEditComment":
		//用户是否登录
		if(!$userid){
			echo jsonAjax('0','未登陆，请先登陆',array(
				'url'=>tsUrl('user','login')
			));
			exit;
		}
		$commentid = intval($_POST['commentid']);
		$content = tsClean($_POST['content']);
		if($content == ''){
			echo jsonAjax('0', '内容不能为空');
			exit();
		}
		if(mb_strlen($content, 'utf8') > 2000){
			echo jsonAjax('0', '字数超过2000限制');
			exit();
		}
		//判断该评论的所有者
		$strComment = $new['event']->find('event_comment', array(
			'commentid'=>$commentid
		));
		if(!$strComment){
			echo jsonAjax('0', '评论不存在');
			exit();
		}
		if($strComment['userid']!=$userid && $TS_USER['user']['isadmin']!='1'){
			echo jsonAjax('0', '权限错误');
			exit();
		}
		$res = $new['event']->update('event_comment',array(
			'commentid'=>$commentid
		), array(
			'content'=>$content
		));
		if($res){
			echo jsonAjax('1', '修改成功', $content);
			exit();
		}
		break;
		
	//删除评论
	case "deleteComment":
		//用户是否登录
		if(!$userid){
			echo jsonAjax('0','未登陆，请先登陆',array(
				'url'=>tsUrl('user','login')
			));
			exit;
		}
		$commentid = intval($_POST['commentid']);
		//判断该评论的所有者
		$strComment = $new['event']->find('event_comment', array(
			'commentid'=>$commentid
		));
		if(!$strComment){
			echo jsonAjax('0', '评论不存在');
			exit();
		}
		if($strComment['userid']!=$userid && $TS_USER['user']['isadmin']!='1'){
			echo jsonAjax('0', '权限错误');
			exit();
		}
		//假删除
		$new['event']->update('event_comment', array(
			'commentid'=>$commentid
		),array(
			'status'=>'0'
		));
		$new['event']->delete('event_comment_do', array(
			'commentid'=>$commentid
		));
		
		//评论数-1
		$new['event']->updateCommentCnt($strComment['eventid'], -1);
		
		echo jsonAjax('1','操作成功');
		break;
	
	//取消参加活动
	case "cancel":
		//用户是否登录
		if(!$userid){
			echo jsonAjax('0','未登陆，请先登陆',array(
				'url'=>tsUrl('user','login')
			));
			exit;
		}
		$eventid = intval($_POST['id']);
		
		//查询
		$isUser = $new['event']->findCount('event_user',array(
			'eventid'=>$eventid,
			'userid'=>$userid
		));
		if(!$isUser){
			echo jsonAjax('2','未曾报名');
			exit;
		}
		
		//删主表
		$new['event']->delete('event_user',array(
			'eventid'=>$eventid,
			'userid'=>$userid
		));
		
		//统计
		$numUser = $new['event']->findCount('event_user',array(
			'eventid'=>$eventid
		));
		//更新活动表
		$new['event']->update('event',array(
			'eventid'=>$eventid
		),array(
			'count_user'=>$numUser
		));
		
		//对积分进行处理
		aac('user')->doScore($app,$ac,$ts);
		
		echo jsonAjax('1','取消成功');
		break;
		
	//参加活动
	case "join":
		//用户是否登录
		if(!$userid){
			echo jsonAjax('0','未登陆，请先登陆',array(
				'url'=>tsUrl('user','login')
			));
			exit;
		}
		$eventid = intval($_POST['id']);
		
		//查询
		$isUser = $new['event']->findCount('event_user',array(
			'eventid'=>$eventid,
			'userid'=>$userid
		));
		if($isUser){
			echo jsonAjax('2','已报名');
			exit;
		}
		
		//添加主表
		$addtime = $_SERVER['REQUEST_TIME'];
		$joinid = $new['event']->create('event_user',array(
			'eventid'=>$eventid,
			'userid'=>$userid,
			'addtime'=>$addtime
		));
		
		//统计
		$numUser = $new['event']->findCount('event_user',array(
			'eventid'=>$eventid
		));
		//更新活动表
		$new['event']->update('event',array(
			'eventid'=>$eventid
		),array(
			'count_user'=>$numUser
		));
		
		//对积分进行处理
		aac('user')->doScore($app,$ac,$ts);
		
		echo jsonAjax('1','加入成功');
		break;
		

}
