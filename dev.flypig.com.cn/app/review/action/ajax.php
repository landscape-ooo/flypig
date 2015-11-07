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
			exit();
		}
		
		$commentid = intval($_POST['commentid']);
		//查询该评论信息
		$strComment = $new['review']->find('review_comment', array(
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
		//过滤内容
		$content = htmlClean($_POST['content']);
		if($content == ''){
			echo jsonAjax('0', '内容不能为空');
			exit();
		}
		if(mb_strlen($content, 'utf8') > 2000){
			echo jsonAjax('0', '字数超过2000限制');
			exit();
		}
		
		//更新
		$res = $new['review']->update('review_comment_add',array(
			'commentid'=>$commentid
		), array(
			'content'=>$content
		));
		
		echo jsonAjax('1', '修改成功', htmlShow($content));
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
		$strComment = $new['review']->find('review_comment', array(
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
		$new['review']->update('review_comment', array(
			'commentid'=>$commentid
		),array(
			'status'=>'0'
		));
		$new['review']->delete('review_comment_do', array(
			'commentid'=>$commentid
		));
		
		//评论数-1
		$new['review']->updateCommentCnt($strComment['reviewid'], -1);
		
		echo jsonAjax('1','操作成功');
		break;
		
	//收藏(喜欢)书评
	case "collect":
		//用户是否登录
		if(!$userid){
			echo jsonAjax('0','未登陆，请先登陆',array(
				'url'=>tsUrl('user','login')
			));
			exit;
		}
		
		$reviewid = intval($_POST['reviewid']);
		if(!$reviewid){
			echo jsonAjax('2','参数错误');
			exit;
		}
		$strReview = $new['review']->find('review',array(
			'reviewid'=>$reviewid,
		));
		if(!$strReview){
			echo jsonAjax('2','书评不存在');
			exit;
		}
		$collectNum = $new['review']->findCount('review_collect',array(
			'userid'=>$userid,
			'reviewid'=>$reviewid,
		));
		if($userid == $strReview['userid']){
			echo jsonAjax('2','自己不能喜欢自己的书评哦');
			exit;
		}elseif($collectNum > 0){
			echo jsonAjax('2','你已经喜欢过本帖啦，请不要再次喜欢');
			exit;
		}else{
			$new['review']->create('review_collect',array(
				'userid'=>$userid,
				'reviewid'=>$reviewid,
				'addtime'=>time(),
			));
			$new_count_love = intval($strReview['count_love'])+1;
			$new['review']->update('review',array(
				'reviewid'=>$reviewid,
			),array(
				'count_love'=>intval($strReview['count_love'])+1,
			));
			
			//对积分进行处理
			aac('user')->doScore($app,$ac,$ts);
			
			echo jsonAjax('1','操作成功');
			exit;
		}
		
		break;
}