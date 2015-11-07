<?php
defined ( 'IN_TS' ) or die ( 'Access Denied.' );

//用户是否登录
$userid = aac('user')->isLogin();

switch ($ts) {
	// 发布分享
	case "" :
		//验证权限
		if($TS_APP['options']['iscreate']!='0' && $TS_USER['user']['isadmin']!='1'){
			tsNotice('非法权限！');
		}
		
		$cateid = isset($_GET['cateid']) ? intval($_GET['cateid']) : 0;
		
		//取出分类
		$arrCate = $new['share']->findAll('share_cate', array(
			'userid'=>$userid,
			'status'=>'1'
		));
		
		$title = '发布分享';
		// 包含模版
		include template("add");
		break;
	
	// 执行发布分享
	case "do" :
		//验证权限
		if($TS_APP['options']['iscreate']!='0' && $TS_USER['user']['isadmin']!='1'){
			tsNotice('非法权限！');
		}
		
		//验证token
		if(!isset($_POST['token']) || $_POST['token'] != $_SESSION['token']) {
			tsNotice('非法操作！');
		}
		//验证码
		if($TS_SITE['base']['isauthcode']){
			$authcode = isset($_POST['authcode']) ? strtolower($_POST['authcode']) : '';
			if ($authcode != $_SESSION ['verify']) {
				tsNotice("验证码输入有误，请重新输入！" );
			}
		}
		
		$title = tsClean($_POST['title']);
		$content = htmlClean($_POST['content']);
		if($title=='' || $content==''){
			tsNotice("标题、内容不能为空！");
		}
		
		$cateid = intval($_POST['cateid']);
		$summary = cututf8(t($_POST['content']),'0','250');
		$nowtime = time();
		
		//是否审核
		$isaudit = '0';
		if($TS_APP['options']['isaudit']=='0' || $TS_USER['user']['isadmin']=='1'){
			$isaudit = '1';
		}
		
		/*
		if($TS_USER['user']['isadmin']=='0'){
			aac('system')->antiWord($title);
			aac('system')->antiWord($content);
		}

		*/
		
		//入库
		$shareid = $new['share']->create('share', array(
			'userid' => $userid,
			'title' => $title,
			'cateid' => $cateid,
			'summary' => $summary,
			'isaudit' => $isaudit,
			'addtime' => $nowtime,
			'uptime' => $nowtime
		));
		if(!$shareid){
			tsUrl('添加错误');
		}
		//内容表
		$new['share']->create('share_add', array(
			'shareid' => $shareid,
			'content' => $content
		));
		
		//更新分类分享数
		if($isaudit == '1'){
			$new['share']->update('share_cate',array(
				'userid'=>$userid,
				'cateid'=>$cateid
			),array(
				'`count_share` = `count_share`+1'
			));
		}
		
		//上传头图
		if($_FILES['photo']){
			$arrUpload = tsUpload($_FILES['photo'],$shareid,'share',array('jpg','gif','png'));
			if($arrUpload){
				$new['share']->update('share',array(
					'shareid'=>$shareid,
				),array(
					'path'=>$arrUpload['path'],
					'photo'=>$arrUpload['url']
				));
			}
		}
		
		//feed开始
		if($TS_SITE['base']['isfeed']){
			$feed_action = 'share_add';
			$feed_data = array(
				'id' => $shareid,
				'pic' => 'uploadfile/share/'.$arrUpload['url'],
				'link' => tsUrl('share','show', array('id'=>$shareid)),
				'title' => $title,
				'content' => cututf8(t($content),'0','250'),
			);
			aac('feed')->add($userid,$feed_action,$feed_data);
		}
		//feed结束
		
		//index开始
		if(aac('index')->isRun('share')){
			$index_action = 'share_list';
			$index_pic = '';
			if($arrUpload['path'] && $arrUpload['url']){
				$index_pic = 'uploadfile/share/'.$arrUpload['url'];
			}
			$index_data = array(
				'id' => $shareid,
				'title' => $title,
				'userlink' => tsUrl('user','space',array('id'=>$userid)),
				'username' => $TS_USER['user']['username'],
				'link' => tsUrl('share','show',array('id' => $shareid)),
				'pic' => $index_pic,
				'content' => cututf8(t($content),'0','250'),
				'time' => $nowtime
			);
			aac('index')->add($userid,$index_action,$index_data);
		}
		//index结束
		
		header("Location: ".tsUrl('share','show',array('id'=>$shareid)));
		break;
		
}
