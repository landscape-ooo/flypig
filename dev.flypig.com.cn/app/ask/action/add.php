<?php
defined('IN_TS') or die('Access Denied.');
// 用户是否登录
$userid = aac('user') -> isLogin();

switch($ts){
	case "":
		//验证权限
		if($TS_APP['options']['iscreate'] != 0 && $TS_USER['user']['isadmin']!=1){
			tsNotice('非法权限！');
		}
		
		$cateid = isset($_GET['cateid']) ? intval($_GET['cateid']) : 0;
		$title = '提新问题';

		//取出分类
		$arrCate = $new['ask']->findAll('ask_cate', array(
			'status'=>1
		));

		include template('add');
		break;
		
	//执行
	case "do":
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
		
		$title = tsClean($_POST['title']);
		$content = htmlClean($_POST['content']);
		
		//form值过滤 判断
		if($title == '' || $content=='') {
			tsNotice('标题、内容不能为空');
		}
		
		//防止用户发布重复内容，调出用户上一次发表的内容
		$strPreAsk = $new['ask']->find('ask', array(
				'userid' => $userid
		), 'askid,title,addtime', 'addtime desc' );
		if($strPreAsk){
			similar_text($strPreAsk['title'], $title, $percent);
			if ($percent >= 90) {
				tsNotice('请不要连续发内容类似的书评！' );
			}
		}
		
		//限制发表内容多长度，默认为5000
		if(mb_strlen($content, 'utf8') > 2000) { 
			tsNotice('最多2000字');
		}
		
		//是否审核
		$isaudit = 0;
		if($TS_APP['options']['isaudit']=='0' || $TS_USER['user']['isadmin']=='1'){
			$isaudit = 1;
		}
		
		$summary = cututf8(t($_POST['content']),'0','250');
		$nowtime = time();
		
		//创建主表数据
		$askid = $new['ask']->create('ask', array(
				'userid' => $userid,
				'title' => $title,
				'summary' => $summary,
				'isaudit' => $isaudit,
				'addtime' => $nowtime,
				'uptime' => $nowtime
		));
		//添加附表数据
		$new['ask']->create('ask_add', array(
			'askid' => $askid,
			'content' => $content
		));
		
		//分类处理
		if (isset($_POST['tag'])){
			foreach ($_POST['tag'] as $val){
				$cateid = intval($val);
				//插入问答分类对应表
				$new['ask']->create('ask_cate_info', array(
					'askid'=>$askid,
					'cateid'=>$cateid
				));
				//更改分类问答数
				$new['ask']->add_cate_one($cateid);
			}
		}
		
		//feed开始
		if($TS_SITE['base']['isfeed']){
			$feed_action = 'ask_add';
			$feed_data = array(
				'link' => tsUrl('ask','show', array('id'=>$askid)),
				'title' => $title,
				'content' => cututf8(t($content),'0','250'),
			);
			aac('feed')->add($userid,$feed_action,$feed_data);
		}
		//feed结束
		
		//index开始
		if(aac('index')->isRun('ask')){
			$index_action = 'ask_list';
			$index_path = $arrUpload['path'] ? $arrUpload['path'] : '';
			$index_pic = $arrUpload['url'] ? 'uploadfile/ask/'.$arrUpload['url'] : '';
			$index_data = array(
				'id' => $askid,
				'title' => $title,
				'userlink' => tsUrl('user','space',array('id'=>$userid)),
				'username' => $TS_USER['user']['username'],
				'link' => tsUrl('ask','show',array('id' => $askid)),
				'path' => $index_path,
				'pic' => $index_pic,
				'content' => cututf8(t($content),'0','250'),
				'time' => $nowtime
			);
			aac('index')->add($userid,$index_action,$index_data);
		}
		//index结束
		
		//对积分进行处理
		aac('user')->doScore($app,$ac,$ts);
			
		
		header('Location: '.tsUrl('ask','show',array('id'=>$askid)));
		break;

}