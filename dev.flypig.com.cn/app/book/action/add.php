<?php
//创建图书
defined('IN_TS') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch($ts){
	
	case "":
		//验证权限
		if($TS_APP['options']['iscreate'] != 0 && $TS_USER['user']['isadmin']!=1){
			tsNotice('非法操作！');
		}
		
		//先判断加入多少个图书啦 
		$userBookNum = $new['book']->findCount('book_user',array(
			'userid'=>$userid
		));
		
		if($userBookNum >= $TS_APP['options']['joinnum'] && $TS_USER['user']['isadmin']==0){
			tsNotice('你加入的图书总数已经到达'.$TS_APP['options']['joinnum'].'个，不能再创建图书！');
		}
		
		$title = '创建图书';
		include template("add");
		break;
	
	//执行创建图书
	case "do":
		//验证权限
		if($TS_APP['options']['iscreate'] != 0 && $TS_USER['user']['isadmin']!=1){
			tsNotice('非法操作！');
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
		
		if(intval($_POST['grp_agreement']) != 1){
			tsNotice('不同意社区指导原则是不允许创建图书的！');
		}
		
		$bookname = tsClean($_POST['bookname']);
		$description = tsClean($_POST['description']);
		
		if($bookname=='' || $description=='') {
			tsNotice('图书名称和介绍不能为空！');
		}
		
		//过滤内容开始
		//aac('system')->antiWord($bookname);
		//aac('system')->antiWord($description);
		//过滤内容结束
		
		//配置文件是否需要审核
		$isaudit = intval($TS_APP['options']['isaudit']);
		if($TS_USER['user']['isadmin']!=1){
			$isaudit = 0;
		}
		
		$isBook = $new['book']->findCount('book',array(
			'bookname'=>$bookname,
		));
		
		if($isBook > 0) {
			tsNotice("图书名称已经存在，请更换其他图书名称！");
		}
		
		$nowtime = time();
		$bookid = $new['book']->create('book',array(
			'userid'	=> $userid,
			'bookname'	=> $bookname,
			'description'	=> $description,
			'isaudit'	=> $isaudit,
			'status'	=> '1',
			'addtime'	=> $nowtime,
			'uptime'	=> $nowtime
		));
		
		//上传
		$arrUpload = tsUpload($_FILES['picfile'],$bookid,'book',array('jpg','gif','png'));
		if($arrUpload){
			$new['book']->update('book',array(
				'bookid'=>$bookid,
			),array(
				'path'=>$arrUpload['path'],
				'photo'=>$arrUpload['url'],
			));
		}
		
		//绑定成员
		$new['book']->create('book_user',array(
			'userid'=>$userid,
			'bookid'=>$bookid,
			'isfounder'=>1,
			'addtime'=>$nowtime
		));
		
		//更新用户关注图书数
		$count_book = $new['book']->findCount('book_user',array(
			'userid'=>$userid,
		));
		$new['book']->update('user_info',array(
			'userid'=>$userid,
		),array(
			'count_book'=>$count_book,
		));
		
		//更新图书关注人数
		$new['book']->update('book',array(
			'bookid'=>$bookid,
		),array(
			'count_user'=>'1'
		));
		
		//index开始
		if(aac('index')->isRun('book')){
			$index_action = 'book_list';
			$index_path = $arrUpload['path'] ? $arrUpload['path'] : '';
			$index_pic = $arrUpload['url'] ? 'uploadfile/book/'.$arrUpload['url'] : '';
			$index_data = array(
				'id' => $bookid,
				'title' => $bookname,
				'userlink' => tsUrl('user','space',array('id'=>$userid)),
				'username' => $TS_USER['user']['username'],
				'link' => tsUrl('book','show',array('id' => $bookid)),
				'path' => $index_path,
				'pic' => $index_pic,
				'content' => cututf8(t($description),'0','250'),
				'time' => $nowtime
			);
			aac('index')->add($userid,$index_action,$index_data);
		}
		//index结束
		
		header("Location: ".tsUrl('book','show',array('id'=>$bookid)));
		break;
	
}