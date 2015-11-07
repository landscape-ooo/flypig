<?php
defined('IN_TS') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();
//获取用户信息
$strUser = $new['user']->getOneUser($userid);

switch($ts){
	case "base":
		$title = '基本设置';
		include template("set_base");
		break;
		
	case "flash":
		
		$strUser = $new['user']->find('user_info',array(
			'userid'=>$userid,
		));
		
		$title = 'Flash上传头像';
		include template('set_flash');
	
		break;
		
	case "cut":
		
		$strUser = $new['user']->find('user_info',array(
			'userid'=>$userid,
		));
		
		$title = '裁切头像';
		include template('set_cut');
	
		break;
		
	case "face":

		$title = '头像设置';
		
		$arrFace = tsScanDir('uploadfile/user/face',1);
		
		include template("set_face");

		break;
	
	//设置密码
	case "pwd":
	
		$title = '密码修改';
		include template("set_pwd");

		break;
		
	//修改登录Email
	case "email":
		$title = '修改登录Email';
		include template('set_email');
		break;
		
	//设置常居地 
	case "city":
		//省份
		if($strUser['province']){
			$strProvince = $new['user']->find('area_province',array(
				'provinceid'=>$strUser['province'],
			));
		}
		//城市 
		if($strUser['city']){
			$strCity = $new['user']->find('area_city',array(
				'cityid'=>$strUser['city'],
			));
		}
		//区域 
		if($strUser['area']){
			$strArea = $new['user']->find('area',array(
				'areaid'=>$strUser['area'],
			));
		}
		//调出省份数据
		$province = $new['user']->findAll('area_province');
		
		$title = '常居地修改';
		include template("set_city");
		break;
	
	//个人标签
	case "tag":
		
		$arrTag = aac('tag')->getObjTagByObjid('user','userid',$userid);
		
		$title = '个人标签修改';
		include template("set_tag");
		break;

}