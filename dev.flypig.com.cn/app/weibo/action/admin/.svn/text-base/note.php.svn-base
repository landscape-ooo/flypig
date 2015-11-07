<?php
defined('IN_TS') or die('Access Denied.');

//管理员是否登录
$userid = aac('user')->isAdminLogin();

switch($ts){

	case "list":
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$url = SITE_URL.'index.php?app=note&ac=admin&mg=note&ts=list&page=';
		$lstart = $page*20-20;
		$arrNote = $new['note']->findAll('note',null,'addtime desc',null,$lstart.',20');
		
		$noteNum = $new['note']->findCount('note');
		$pageUrl = pagination($noteNum, 20, $page, $url);
		
		include template("admin/note_list");
		
		break;
		
		
	case "isaudit":
	
		$noteid = $_GET['noteid'];
		
		$strNote = $new['note']->find('note',array(
		
			'noteid'=>$noteid,
			
		));
		
		if($strNote['isaudit'] == 0){
		
			$new['note']->update('note',array(
				
				'noteid'=>$noteid,
			
			),array(
			
				'isaudit'=>1,
			
			));
		
		}
		
		if($strNote['isaudit'] == 1){
		
			$new['note']->update('note',array(
				
				'noteid'=>$noteid,
			
			),array(
			
				'isaudit'=>0,
			
			));
		
		}
		
		qiMsg('操作成功！');
	
		break;
		
		
	case "delete":
	
		$noteid=$_GET['noteid'];
		
		$new['note']->delete('note',array(
			'noteid'=>$noteid,
		));
		
		$new['note']->delete('note_comment',array(
			'noteid'=>$noteid,
		));
		
		//删除动态
		aac('feed')->del($noteid,'note');
		
		qiMsg('删除成功！');
		
		break;
}