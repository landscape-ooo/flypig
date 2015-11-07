<?php
defined('IN_TS') or die('Access Denied.');

// 用户是否登录
$userid = aac('user') -> isLogin();

switch($ts){
	case "":
		$title = '编辑问题';
		
		$askid = intval($_GET['askid']);
		
		//判断问题所有者
		$strAsk = $new['ask']->find('ask', array(
			'askid'=>$askid
		));
		if (!$strAsk){
			tsNotice('该问题不存在或已被删除');
		}
		//获取附表内容
		$strAsk['content'] = $new['ask']->getAskAdd($strAsk['askid']);
		
		//验证权限
		if ($strAsk['userid'] != $userid && $TS_USER['user']['isadmin']!=1){
			tsNotice('无权编辑该问题');
		}
		//取出分类
		$arrCate = $new['ask']->findAll('ask_cate');
		
		//取出该问题分类
		$askCate = $new['ask']->findAll('ask_cate_info', array(
			'askid'=>$askid
		));
		
		include template('edit');
		break;
		
	//编辑执行
	case 'do':
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
		
		$askid = intval($_POST['askid']);
		
		//判断问题所有者
		$strAsk = $new['ask']->find('ask', array(
			'askid'=>$askid
		));
		if (!$strAsk){
			tsNotice('该问题不存在或已被删除');
		}
		//验证权限
		if ($strAsk['userid'] != $userid && $TS_USER['user']['isadmin']!=1){
			tsNotice('无权编辑该问题');
		}
		
		//编辑提交
		$title = tsClean($_POST['title']);
		$content = htmlClean($_POST['content']);
		
		//form值过滤 判断
		if ($title == ''){
			tsNotice('不要这么偷懒嘛，多少请写一点内容哦^_^');
		}
		if (mb_strlen($title, 'utf8') > 64){
			// 限制发表内容多长度，默认为64
			tsNotice('标题很长很长很长很长...^_^');
		}
		if (mb_strlen($content, 'utf8') > 5000){
			// 限制发表内容多长度，默认为5000
			tsNotice('发这么多内容干啥^_^');
		}
		
		//查找是否已存在同名问题
		$isTitle = $new['ask']->findCount('ask','title='.$title.' and askid<>'.$askid);
		if($isTitle>0){
			tsNotice('有重复标题出现哦^_^');
		}
		
		$nowtime = time();
		
		//更新问答表
		$new['ask']->update('ask', array(
			'askid'=>$askid
		), array(
			'title'=>$title,
			'uptime'=>$nowtime
		));
		//更新附表
		$new['ask']->update('ask_add', array(
			'askid'=>$askid
		), array(
			'content'=>$content
		));
		
		//删除先前的分类
		$askCate = $new['ask']->findAll('ask_cate_info', array(
			'askid'=>$askid
		));
		foreach ($askCate as $value){
			//更改分类数
			$new['ask']->reduce_cate_one($value['cateid']);
		}
		$new['ask']->delete('ask_cate_info', array('askid'=>$askid));
		
		//分类处理
		if (isset($_POST['tag'])){
			foreach ($_POST['tag'] as $val){
				$cateid = intval($val);
				//插入问答分类对应表
				$new['ask']->create('ask_cate_info', array('askid'=>$askid, 'cateid'=>$cateid));
				
				//更改分类数
				$new['ask']->add_cate_one($cateid);
			}
		}
		
		header('Location:'.tsUrl('ask','show',array('id'=>$askid)));
		
		break;
}
