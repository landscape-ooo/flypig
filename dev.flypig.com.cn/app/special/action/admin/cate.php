<?php
defined('IN_TS') or die('Access Denied.');
/*
 * 增加分类
*/
switch($ts){
	//分类列表
	case "list":
		$arrCate = $new['special']->findAll('special_cate');
		
		include template("admin/cate_list");
		break;
	//分类添加
	case "add":
		include template("admin/cate_add");
		break;
		
	//分类添加执行
	case "add_do":
		$res = $new['special']->create('special_cate', array(
			'catename' => trim($_POST['catename']),
		));
		if(!$res){
			qiMsg("添加失败！");
		}
		header("Location: ".SITE_URL."index.php?app=special&ac=admin&mg=cate&ts=list");
		break;
		
	//分类修改
	case "edit":
		$cateid = intval($_GET['cateid']);
		$strCate = $new['special']->find('special_cate', array(
			'cateid'=>$cateid
		));
		include template("admin/cate_edit");
		
		break;
		
	//分类修改执行
	case "edit_do":
		$cateid = intval($_POST['cateid']);
		$catename = trim($_POST['catename']);
		$new['special']->update('special_cate',array(
			'cateid'=>$cateid
		), array(
			'catename'=>$catename
		));
		header("Location: ".SITE_URL."index.php?app=special&ac=admin&mg=cate&ts=list");
		break;
		
	//分类状态修改执行
	case "status":
		$cateid = intval($_GET['cateid']);
		$arrCate = $new['special']->find('special_cate',array(
			'cateid'=>$cateid
		));
		if($arrCate['status'] == 0){
			$status = 1;
		}else{
			$status = 0;
		}
		$new['special']->update('special', array(
			'cateid'=>$cateid
		), array(
			'status'=>$status
		));
		$new['special']->update('special_cate',array(
			'cateid'=>$cateid
		), array(
			'status'=>$status
		));
		header("Location: ".SITE_URL."index.php?app=special&ac=admin&mg=cate&ts=list");
		break;
		
	//分类删除
	case "del":
		$cateid = intval($_GET['cateid']);
		
		//首先判断该分类下 有没有专题
		$numCateSpecial = $new['special']->findAll('special',array(
			'cateid'=>$cateid,
		));
		if(count($numCateAsk)>0){
			qiMsg("分类下还有专题，不允许删除！");
		}
		
		$new['special']->delete('special_cate',array(
			'cateid'=>$cateid,
		));
		
		qiMsg("分类删除成功！");
		break;
		
}