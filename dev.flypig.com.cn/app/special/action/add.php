<?php
defined('IN_TS') or die('Access Denied.');
// 用户是否登录
$userid = aac('user') -> isLogin();

switch($ts){
	case '':
		//验证权限
		if($TS_APP['options']['iscreate'] != 0 && $TS_USER['user']['isadmin']!=1){
			tsNotice('非法权限！');
		}
		
		$cateid = isset($_GET['cateid']) ? intval($_GET['cateid']) : 0;
		
		//取出分类
		$arrCate = $new['special']->findAll('special_cate', array(
			'status'=>1
		));
		
		$title = '发布专题';
		include template('add');
		
		break;
		
	//发布专题执行
	case 'do':
		
		//验证权限
		if($TS_APP['options']['iscreate'] != '0' && $TS_USER['user']['isadmin']!='1'){
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
		$cateid = intval($_POST['cateid']);
		$linkurl = tsClean($_POST['linkurl']);
		$content = tsClean($_POST['content']);
		
		if($title=='' || $cateid=='' || $linkurl=='' || $content==''){
			tsNotice("请完善专题必填信息！");
		}
		
		//是否审核
		$isaudit = '0';
		if($TS_APP['options']['isaudit']=='0' || $TS_USER['user']['isadmin']=='1'){
			$isaudit = '1';
		}
		
		$nowtime = time();
		$specialData = array(
			'userid' => $userid,
			'title' => $title,
			'cateid' => $cateid,
			'linkurl' => $linkurl,
			'content' => $content,
			'isaudit' => $isaudit,
			'addtime' => $nowtime
		);
		
		//入库
		$specialid = $new['special']->create('special', $specialData);
		
		//更新分类专题数
		if($isaudit == '1'){
			$new['special']->update('special_cate',array(
				'cateid'=>$cateid,
			),array(
				'`count_special` = `count_special`+1'
			));
		}
		//上传海报
		$arrUpload = tsUpload($_FILES['photo'],$specialid,'special',array('jpg','gif','png'));
		if($arrUpload){
			$new['special']->update('special',array(
				'specialid'=>$specialid,
			),array(
				'path'=>$arrUpload['path'],
				'photo'=>$arrUpload['url'],
			));
		}
		
		//feed开始
		if($TS_SITE['base']['isfeed']){
			$feed_action = 'special_add';
			$feed_data = array(
				'link' => tsUrl('special','show', array('id'=>$specialid)),
				'title' => $title,
				'content' => cututf8(t($content),'0','250'),
			);
			aac('feed')->add($userid,$feed_action,$feed_data);
		}
		//feed结束
		
		//index开始
		if(aac('index')->isRun('special')){
			$index_action = 'special_list';
			$index_pic = '';
			if($arrUpload['path'] && $arrUpload['url']){
				$index_pic = 'uploadfile/special/'.$arrUpload['url'];
			}
			$index_data = array(
				'id' => $specialid,
				'title' => $title,
				'userlink' => tsUrl('user','space',array('id'=>$userid)),
				'username' => $TS_USER['user']['username'],
				'link' => tsUrl('special','show',array('id' => $specialid)),
				'pic' => $index_pic,
				'content' => cututf8(t($content),'0','250'),
				'time' => $nowtime
			);
			aac('index')->add($userid,$index_action,$index_data);
		}
		//index结束
		
		//对积分进行处理
		aac('user')->doScore($app,$ac,$ts);
			
		
		
		header("Location: ".tsUrl('special'));
		break;

}
