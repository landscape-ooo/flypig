<?php
defined('IN_TS') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch($ts){
	
	//专题审核 
	case "isaudit":
		//验证权限
		if($TS_USER['user']['isadmin'] != '1'){
			tsNotice("非法操作,请返回!");
		}
		
		$specialid = intval($_GET['specialid']);
		$strSpecial = $new['special']->find('special',array(
			'specialid'=>$specialid
		));
		if(!$strSpecial){
			tsNotice("专题不存在，请返回!",null,tsUrl('special'),true);
		}
		//审核
		if($strSpecial['isaudit']=='0'){
			$isaudit = '1';
			
			//审核通过
			$new['special']->update('special',array(
				'specialid'=>$strSpecial['specialid']
			),array(
				'isaudit'=>$isaudit
			));
			
			//更新分类专题数
			$new['special']->update('special_cate',array(
				'cateid'=>$strSpecial['cateid']
			),array(
				"`count_special` = `count_special`+1"
			));
			
			if($TS_USER['user']['userid'] != $strSpecial['userid']){
				//message开始
				$msg_userid = '0';
				$msg_touserid = $strSpecial['userid'];
				$msg_content = '你发布的专题：《'.$strSpecial['title'].'》已经通过审核!快去看看吧 <br />'.SITE_URL.'index.php?app=special&ac=show&specialid='.$specialid;
				aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
				//message结束
			}
			
		//取消审核
		}else{
			$isaudit = '0';
			//审核通过
			$new['special']->update('special',array(
				'specialid'=>$strSpecial['specialid']
			),array(
				'isaudit'=>$isaudit
			));
			//更新分类专题数
			$new['special']->update('special_cate',array(
				'cateid'=>$strSpecial['cateid']
			),array(
				"`count_special` = `count_special`-1"
			));
		}
		tsNotice("操作成功！",null,tsUrl('special'),true);
		break;
		
	//删除专题 
	case "del":
		if($TS_USER['user']['isadmin'] != '1'){
			tsNotice("非法操作,请返回!",null,tsUrl('special'),true);
		}
		
		$specialid = intval($_GET['specialid']);
		
		$strSpecial = $new['special']->find('special',array(
			'specialid'=>$specialid
		));
		if(!$strSpecial){
			tsNotice("专题不存在，请返回!",null,tsUrl('special'),true);
		}
		
		//删除数据以及缓存
		rmrf('cache/special');//删除海报缓存
		unlink("uploadfile/special/".$strSpecial['path']."/".$specialid.".jpg");//删除原始海报
		$new['special']->delete('special',array(
			'specialid'=>$specialid
		));
		
		//更新专题分类统计
		$curCateNum = $new['special']->findCount('special',array(
			'cateid'=>$strSpecial['cateid'],
			'isaudit'=>'1'
		));
		$new['special']->update('special_cate',array(
			'cateid'=>$strSpecial['cateid']
		),array(
			'count_special'=>$curCateNum
		));
		
		//删除首页推送数据
		aac('index')->del('special_list',$specialid);
		
		tsNotice("操作成功！",null,tsUrl('special'),true);
		break;
		
}
