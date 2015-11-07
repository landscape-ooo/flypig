<?php
defined('IN_TS') or die('Access Denied.');
/*
 * 增加分类
*/
switch($ts){
	//分类列表
	case "list":
		$arrType = $new['index']->findAll('index_type',null,'typeflag asc');
		
		include template("admin/type_list");
		break;
	//分类添加
	case "add":
		include template("admin/type_add");
		break;
		
	//分类添加执行
	case "add_do":
		$arrData = array(
			'typename' => trim($_POST['typename']),
			'appflag' => trim($_POST['appflag']),
			'typeflag' => trim($_POST['typeflag']),
			'template' => trim($_POST['template'])
		);
		$db->insertArr($arrData,dbprefix.'index_type');
		header("Location: ".SITE_URL."index.php?app=index&ac=admin&mg=type&ts=list");
		break;
		
	//分类内容修改
	case "edit":
		$typeid = intval($_GET['typeid']);
		$strType = $new['index']->find('index_type', array(
			'typeid'=>$typeid
		));
		include template("admin/type_edit");
		
		break;
		
	//分类内容修改执行
	case "edit_do":
		$typeid = intval($_POST['typeid']);
		$typename = trim($_POST['typename']);
		$appflag = trim($_POST['appflag']);
		$typeflag = trim($_POST['typeflag']);
		$template = trim($_POST['template']);
		$new['index']->update('index_type',array(
			'typeid'=>$typeid
		), array(
			'typename'=>$typename,
			'appflag'=>$appflag,
			'typeflag'=>$typeflag,
			'template'=>$template
		));
		header("Location: ".SITE_URL."index.php?app=index&ac=admin&mg=type&ts=list");
		break;
		
	//分类状态修改执行
	case "status":
		$typeid = intval($_GET['typeid']);
		$arrType = $new['index']->find('index_type',array(
			'typeid'=>$typeid
		));
		if($arrType['status'] == 0){
			$status = 1;
		}else{
			$status = 0;
		}
		$new['index']->update('index', array(
			'typeid'=>$typeid
		), array(
			'status'=>$status
		));
		$new['index']->update('index_type',array(
			'typeid'=>$typeid
		), array(
			'status'=>$status
		));
		header("Location: ".SITE_URL."index.php?app=index&ac=admin&mg=type&ts=list");
		break;
		
	//分类删除
	case "del":
		
		$typeid = intval($_GET['typeid']);
		
		//首先判断该分类下 有没有问答
		$numTypeIndex = $new['index']->findAll('index',array(
			'typeid'=>$typeid,
		));
		if(count($numTypeIndex)>0){
			qiMsg("分类下还有问答，不允许删除！");
		}
		
		$new['index']->delete('index_type',array(
			'typeid'=>$typeid,
		));
		
		qiMsg("分类删除成功！");
	
		break;
}