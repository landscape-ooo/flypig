<?php
defined('IN_TS') or die('Access Denied.');
//用户是否登录
$userid = aac('user')->isLogin();

switch($ts){

	//添加评论
	case "add":

		$askid = intval($_POST['askid']);//问题id

		$content = htmlClean($_POST['content']);
		if ($content == ''){
			tsNotice('没有任何内容是不允许你通过滴^_^');
		}
		// 限制发表内容多长度，默认为5000
		if (mb_strlen($content, 'utf8') > 2000){
			tsNotice('内容最多2000字');
		}
		
		//查询该问题是否被当前用户回复过
		$iscomment = $new['ask']->find('ask_comment', array(
			'userid'=>$userid,
			'askid'=>$askid,
			'status'=>'1'
		));
		if ($iscomment){
			tsNotice('每个问题每人仅能回答一次，如需更新请直接修改^_^');
		}
		
		//查看问题是否关闭
		$strAsk = $new['ask']->find('ask', array('askid'=>$askid));
		if ($strAsk['isopen'] == '0'){
			tsNotice('该问题已关闭^_^');
		}
		
		$nowtime = time();
		//创建主表数据
		$commentid = $new['ask']->create('ask_comment', array(
			'askid'=>$askid,
			'userid'=>$userid,
			'addtime'=>$nowtime,
			'uptime'=>$nowtime
		));
		if($commentid){
			//添加附表
			$new['ask']->create('ask_comment_add', array(
				'commentid'=>$commentid,
				'content'=>$content
			));
		}
		
		//计入答案数
		$new['ask']->add_ask_one($askid);
		
		//对积分进行处理
		aac('user')->doScore($app,$ac,$ts);
		
		//发送系统消息(通知楼主有人回复他的问题)
		if($strAsk['userid'] != $userid){
			$msg_userid = '0';
			$msg_touserid = $strAsk['userid'];
			$msg_content = '你的问题：'.$strAsk['title'].'新增一条答案，快去看看给个回复吧^_^ <br />'.tsUrl('ask','show',array('id'=>$askid));
			aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
		}

		//计入用户积分 回复加1分
		$new['ask']->add_userscore_one($userid);

		//加入先前的排序参数
		header('Location:'.tsUrl('ask','show',array('id'=>$askid)));
		
		break;
}