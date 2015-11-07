<?php
defined('IN_TS') or die('Access Denied.');
/*
 * 增加分类
*/
switch($ts){
	//分类列表
	case "list":
		$arrCate = $new['event']->findAll('event_cate');
		
		include template("admin/cate_list");
		break;
	//分类添加
	case "add":
		include template("admin/cate_add");
		break;
		
	//分类添加执行
	case "add_do":
		$res = $new['event']->create('event_cate', array(
			'catename' => trim($_POST['catename']),
		));
		if(!$res){
			qiMsg("添加失败！");
		}
		header("Location: ".SITE_URL."index.php?app=event&ac=admin&mg=cate&ts=list");
		break;
		
	//分类修改
	case "edit":
		$cateid = intval($_GET['cateid']);
		$strCate = $new['event']->find('event_cate', array(
			'cateid'=>$cateid
		));
		include template("admin/cate_edit");
		
		break;
		
	//分类修改执行
	case "edit_do":
		$cateid = intval($_POST['cateid']);
		$catename = trim($_POST['catename']);
		$new['event']->update('event_cate',array(
			'cateid'=>$cateid
		), array(
			'catename'=>$catename
		));
		header("Location: ".SITE_URL."index.php?app=event&ac=admin&mg=cate&ts=list");
		break;
		
	//分类状态修改执行
	case "status":
		$cateid = intval($_GET['cateid']);
		$arrCate = $new['event']->find('event_cate',array(
			'cateid'=>$cateid
		));
		if($arrCate['status'] == 0){
			$status = 1;
		}else{
			$status = 0;
		}
		$new['event']->update('event', array(
			'cateid'=>$cateid
		), array(
			'status'=>$status
		));
		$new['event']->update('event_cate',array(
			'cateid'=>$cateid
		), array(
			'status'=>$status
		));
		header("Location: ".SITE_URL."index.php?app=event&ac=admin&mg=cate&ts=list");
		break;
		
	//分类删除
	case "del":
		$cateid = intval($_GET['cateid']);
		
		//首先判断该分类下 有没有活动
		$numCateEvent = $new['event']->findAll('event',array(
			'cateid'=>$cateid,
		));
		if(count($numCateAsk)>0){
			qiMsg("分类下还有活动，不允许删除！");
		}
		
		$new['event']->delete('event_cate',array(
			'cateid'=>$cateid,
		));
		
		qiMsg("分类删除成功！");
		break;
		
}