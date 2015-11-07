<?php 
defined('IN_TS') or die('Access Denied.');

switch($ts){
	
	//批量上传图片
	case "do":
		//用户是否登录
		//$userid = aac('user')->isLogin(false);
		//uploadify导致session失效
		
		$addtime = intval($_POST['addtime']);
		$bookid = intval($_POST['bookid']);
		
		$verifyToken = md5('unique_salt' . $addtime);
		
		//图书信息
		$strBook = $new['book']->find('book',array(
			'bookid'=>$bookid,
		));
		if($bookid==0 || $addtime==0 || $_POST['tokens'] != $verifyToken || $strBook==''){
			echo 000000;exit;
		}
		
		$userid = $strBook['userid'];
		$locationid = aac('user')->getLocationId($userid);
		
		//图书用户
		$strBookUser = $new['book']->find('book_user',array(
			'userid'=>$userid,
			'bookid'=>$bookid,
		));
		
		//权限限制
		if($TS_USER['user']['isadmin'] != '1' && $strBookUser['isadmin'] != '1' && $userid != $strBook['userid']){
			tsNotice('权限错误！');
		}
		
		$photoid = $new['book']->create('book_photo',array(
			'bookid' => $bookid,
			'userid' => $userid,
			'locationid' => $locationid,
			'addtime' => date('Y-m-d H:i:s', $addtime),
		));
		
		//上传
		$arrUpload = tsUpload($_FILES['Filedata'],$photoid,'bookphoto',array('jpg','gif','png'));
		
		if($arrUpload){
			$new['book']->update('book_photo',array(
				'photoid'=>$photoid,
			),array(
				'photoname'=>$arrUpload['name'],
				'phototype'=>$arrUpload['type'],
				'path'=>$arrUpload['path'],
				'photourl'=>$arrUpload['url'],
				'photosize'=>$arrUpload['size'],
			));
		}
		
		echo $photoid;
		
		break;
}