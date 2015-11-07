<?php 
defined('IN_TS') or die('Access Denied.');

switch($ts){

	case "list":
	
		$pagesize = 10;
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$url = SITE_URL.'index.php?app=ask&ac=admin&mg=ask&ts=list&page=';
		$lstart = ($page-1)*$pagesize;

		$askNum = $new['ask']->findCount('ask');
		$pageUrl = pagination($askNum, 20, $page, $url);
	
		$arrAsk = $new['ask']->findAll('ask',null,'addtime desc',null,$lstart.','.$pagesize);
		
		include template('admin/ask_list');
	
		break;
		
	//删除
	case "delete":
	
		$askid = intval($_GET['askid']);
		
		$new['ask']->delete('ask',array(
			'askid'=>$askid,
		));
		
		$new['ask']->delete('ask_comment',array(
			'askid'=>$askid,
		));
		
		$new['ask']->delete('ask_add',array(
			'askid'=>$askid,
		));
		
		$new['ask']->delete('ask_cate_info',array(
			'askid'=>$askid,
		));
		
		
		qiMsg('删除成功！');
	
		break;
		
	//审核 
	case "isaudit":
		
		$askid = intval($_GET['askid']);
		
		$strAsk = $new['ask']->find('ask',array(
		
			'askid'=>$askid,
		
		));
		
		if($strAsk['isaudit']==1){
		
			$new['ask']->update('ask',array(
				'askid'=>$askid,
			),array(
				'isaudit'=>0,
			));
		
		}
		
		if($strAsk['isaudit']==0){
		
			$new['ask']->update('ask',array(
				'askid'=>$askid,
			),array(
				'isaudit'=>1,
			));
		
		}
		
		qiMsg('操作成功！');
		
		break;

}