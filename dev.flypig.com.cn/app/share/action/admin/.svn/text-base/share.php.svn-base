<?php 
defined('IN_TS') or die('Access Denied.');

switch($ts){
	
	case "list":
		$pagesize = 10;
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$url = SITE_URL.'index.php?app=share&ac=admin&mg=share&ts=list&page=';
		$lstart = ($page-1)*$pagesize;
		
		$arrShare = $new['share']->findAll('share',null,'addtime desc',null,$lstart.','.$pagesize);
		foreach($arrShare as $key=>$value){
			$arrTmpBook = aac('book')->getOneBook($value['bookid']);
			$arrShare[$key]['bookname'] = $arrTmpBook['bookname'];
		}
		
		$shareNum = $new['share']->findCount('share');
		
		$pageUrl = pagination($shareNum, $pagesize, $page, $url);

		include template("admin/share_list");
		
		break;
		
	//删除的分享
	case "list_delete":
		$pagesize = 10;
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$url = SITE_URL.'index.php?app=share&ac=admin&mg=share&ts=deleteshare&page=';
		$lstart = ($page-1)*$pagesize;
		
		$arrShare = $new['share']->findAll('share',array('status'=>'0'),'addtime desc',null,$lstart.','.$pagesize);
		foreach($arrShare as $key=>$value){
			$arrTmpBook = aac('book')->getOneBook($value['bookid']);
			$arrShare[$key]['bookname'] = $arrTmpBook['bookname'];
		}
		
		$shareNum = $new['share']->findCount('share',array(
			'isdelete'=>'1',
		));
		
		$pageUrl = pagination($shareNum, $pagesize, $page, $url);
		
		include template("admin/share_list_delete");
		
		break;
		
	//编辑的分享
	case "list_edit":
		
		$pagesize = 10;
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$url = SITE_URL.'index.php?app=share&ac=admin&mg=share&ts=editshare&page=';
		$lstart = ($page-1)*$pagesize;
		
		$arrShare = $new['share']->findAll('share_edit',null,'isupdate asc,addtime desc',null,$lstart.','.$pagesize);
		
		$shareNum = $new['share']->findCount('share_edit');
		
		$pageUrl = pagination($shareNum, $pagesize, $page, $url);
		
		include template("admin/share_list_edit");
		
		break;
		
	//执行更新分享
	case "update":
		
		$shareid = intval($_GET['shareid']);
		
		$new['share']->syncEditShare($shareid);
		
		qiMsg('更新成功！');
		
		break;
		
	//查看单独某个修改的分享
	case "editview":
		$shareid = intval($_GET['shareid']);
		
		$strShare = $new['share']->find('share_edit',array(
			'shareid'=>$shareid,
		));
		
		include template('admin/share_view_edit');
		break;
		
	case "delete":
		$shareid = intval($_GET['shareid']);
		
		$new['share']->delShare($shareid);

		qiMsg('删除成功');
		break;
	
	//分享审核
	case "isaudit":
	
		$shareid = intval($_GET['shareid']);
		
		$strShare = $new['share']->find('share',array(
			'shareid'=>$shareid,
		));
		
		if($strShare['isaudit']==0){
			$new['share']->update('share',array(
				'shareid'=>$shareid,
			),array(
				'isaudit'=>1,
			));
		}
		
		if($strShare['isaudit']==1){
			$new['share']->update('share',array(
				'shareid'=>$shareid,
			),array(
				'isaudit'=>0,
			));
		}
		
		qiMsg('操作成功！');
	
		break;
		
}