<?php 
defined('IN_TS') or die('Access Denied.');

switch($ts){
	
	case "":

		//用户是否登录
		$userid = aac('user')->isLogin();

		$albumid = intval($_GET['albumid']);

		$strAlbum = $new['photo']->find('photo_album',array(
			'albumid'=>$albumid,
		));

		if($userid != $strAlbum['userid']) {

			tsNotice('非法操作！');

		}

		$addtime = time();

		$title = '上传照片';
		include template("upload");	

		break;
		
	case "do":
	
		/*
		$userid = intval($_GET['userid']);
		if($userid=='0'){
			echo '00000';
			exit;
		}
		
		$albumid = intval($_GET['albumid']);
		*/
		
		$photoid = $new['photo']->create('photo',array(
			/*'userid'	=> $userid,
			'locationid'=>aac('user')->getLocationId($userid),
			'albumid'	=> $albumid,*/
			'addtime'	=> date('Y-m-d H:i:s'),
		));
		
		//上传
		$arrUpload = tsUpload($_FILES['Filedata'],$photoid,'photo',array('jpg','gif','png'));
		
		if($arrUpload){

			$new['photo']->update('photo',array(
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
		
	case "callback":
	
		$userid = intval($TS_USER['user']['userid']);
		$albumid = intval($_POST['albumid']);
		$photoid = intval($_POST['photoid']);
		
		if($userid==0 || $albumid==0 || $photoid==0){
			echo 0;exit;//非法操作
		}
		
		$isAlbum = $new['photo']->findCount('photo_album',array(
			'albumid'=>$albumid,
			'userid'=>$userid,
		));
		
		$isPhoto = $new['photo']->findCount('photo',array(
			'photoid'=>$photoid,
			'userid'=>0,
			'albumid'=>0,
		));
		
		if($isAlbum==0 || $isPhoto==0){
			echo 0;exit;//非法操作
		}
		
		$new['photo']->update('photo',array(
			'photoid'=>$photoid,
			'userid'=>0,
			'albumid'=>0,
		),array(
			'photoid'=>$photoid,
			'userid'=>$userid,
			'locationid'=>aac('user')->getLocationId($userid),
			'albumid'=>$albumid,
		));
		
		//对积分进行出来
		aac('user')->doScore($app,$ac,$ts,$userid);
		
		echo 1;exit;
	
		break;
	
}