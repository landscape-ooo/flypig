<?php
defined('IN_TS') or die('Access Denied.');
/*
 * 增加分类
*/
switch($ts){
	//分类列表
	case "list":
		$arrCate = $new['ask']->findAll('ask_cate');
		
		include template("admin/cate_list");
		break;
	//分类添加
	case "add":
		include template("admin/cate_add");
		break;
		
	//分类添加执行
	case "add_do":
		$arrData = array(
			'catename'	=> trim($_POST['catename']),
			'catedesc'	=> trim($_POST['catedesc'])
		);
		$db->insertArr($arrData,dbprefix.'ask_cate');
		header("Location: ".SITE_URL."index.php?app=ask&ac=admin&mg=cate&ts=list");
		break;
		
	//分类内容修改
	case "edit":
		$cateid = intval($_GET['cateid']);
		$strCate = $new['ask']->find('ask_cate', array('cateid'=>$cateid));
		include template("admin/cate_edit");
		
		break;
		
	//分类内容修改执行
	case "edit_do":
		$cateid = intval($_POST['cateid']);
		$catename = trim($_POST['catename']);
		$catedesc = trim($_POST['catedesc']);
		$new['ask']->update('ask_cate',array(
			'cateid'=>$cateid
		), array(
			'catename'=>$catename,
			'catedesc'=>$catedesc
		));
		header("Location: ".SITE_URL."index.php?app=ask&ac=admin&mg=cate&ts=list");
		break;
		
	//分类状态修改执行
	case "status":
		$cateid = intval($_GET['cateid']);
		$arrCate = $new['ask']->find('ask_cate',array(
			'cateid'=>$cateid
		));
		if($arrCate['status'] == 0){
			$status = 1;
		}else{
			$status = 0;
		}
		$askidsArr = $new['ask']->findAll('ask_cate_info', array(
			'cateid'=>$cateid
		),'askid desc','GROUP_CONCAT(askid) as askids');
		$askidsStr = isset($askidsArr[0]['askids']) ? $askidsArr[0]['askids'] : '';
		if($askidsStr != ''){
			$new['ask']->update('ask'," askid in(".$askidsStr.")", array(
				'status'=>$status
			));
		}
		$new['ask']->update('ask_cate',array(
			'cateid'=>$cateid
		), array(
			'status'=>$status
		));
		header("Location: ".SITE_URL."index.php?app=ask&ac=admin&mg=cate&ts=list");
		break;
		
	//分类删除
	case "del":
		
		$cateid = intval($_GET['cateid']);
		
		//首先判断该分类下 有没有问答
		$numCateAsk = $new['ask']->findAll('ask_cate_info',array(
			'cateid'=>$cateid,
		));
		if(count($numCateAsk)>0){
			qiMsg("分类下还有问答，不允许删除！");
		}
		
		$new['ask']->delete('ask_cate',array(
			'cateid'=>$cateid,
		));
		
		qiMsg("分类删除成功！");
	
		break;
}