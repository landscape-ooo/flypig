<?php
defined('IN_TS') or die('Access Denied.');

// 用户是否登录
$userid = aac('user') -> isLogin();

switch($ts){
	//编辑
	case "":
		$specialid = intval($_GET['specialid']);
		
		//专题信息
		$strSpecial = $new['special']->getOneSpecial($specialid);
		if(!$strSpecial){
			tsNotice('该专题不存在');
		}
		//判断问题所有者
		if ($strSpecial['userid'] != $userid && $TS_USER['user']['isadmin']!=1){
			tsNotice('无权编辑该专题');
		}
		
		//取出该问题分类
		$specialCate = $new['special']->getOneCate($specialid);
		
		//取出分类
		$arrCate = $new['special']->findAll('special_cate', array(
			'status'=>1
		));
		
		//调出省份数据
		$province = $new['special']->findAll('area_province');
		
		$title = '编辑专题信息';
		include template("edit");
		break;
		
	//编辑执行
	case "do":
		$specialid = intval($_POST['specialid']);
		//专题信息
		$strSpecial = $new['special']->getOneSpecial($specialid);
		if(!$strSpecial){
			tsNotice('该专题不存在');
		}
		if ($strSpecial['userid'] != $userid && $TS_USER['user']['isadmin']!=1){
			tsNotice('无权编辑该问题');
		}
		//数据
		$title = tsClean($_POST['title']);
		$cateid = intval($_POST['cateid']);
		$linkurl = tsClean($_POST['linkurl']);
		$content = tsClean($_POST['content']);
		
		if($title=='' || $cateid=='' || $time_start=='' || $content==''){
			tsNotice("请完善专题必填信息！");
		}
		//待更新数据
		$specialData = array(
			'title' => $title,
			'cateid' => $cateid,
			'linkurl' => $linkurl,
			'content' => $content
		);
		//由于增加了审核机制.重新编辑活动将需要重新审核
		if($TS_APP['options']['isaudit']!='0' && $TS_USER['user']['isadmin']!='1'){
			$specialData['isaudit'] = '0';
		}
		//更新数据
		$new['special']->update('special',array(
			'specialid'=>$specialid,
		),$specialData);
		
		//如果原数据为已审核，则原分类专题数-1
		if($strSpecial['isaudit']=='1'){
			$new['special']->update('special_cate',array(
				'cateid'=>$strSpecial['cateid']
			),array(
				"`count_special` = `count_special`-1"
			));
		}
		
		//上传
		if($_FILES['photo']){
			$arrUpload = tsUpload($_FILES['photo'],$specialid,'special',array('jpg','gif','png'));
			if($arrUpload){
				rmrf('cache/special');
				$new['special']->update('special',array(
					'specialid'=>$specialid
				),array(
					'path'=>$arrUpload['path'],
					'photo'=>$arrUpload['url']
				));
			}
		}
		
		//feed开始
		if($TS_SITE['base']['isfeed']){
			$feed_action = 'special_edit';
			$feed_data = array(
				'link' => tsUrl('special','show', array('id'=>$specialid)),
				'title' => $title,
				'content' => cututf8(t($content),'0','50'),
			);
			aac('feed')->add($userid,$feed_action,$feed_data);
		}
		//feed结束
		
		header("Location: ".tsUrl('special'));
		break;
		
}
