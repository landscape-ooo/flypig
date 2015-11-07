<?php 
defined('IN_TS') or die('Access Denied.');

switch($ts){
	
	case "list":
		$pagesize = 10;
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$url = SITE_URL.'index.php?app=review&ac=admin&mg=review&ts=list&page=';
		$lstart = ($page-1)*$pagesize;
		
		$arrReview = $new['review']->findAll('review',null,'addtime desc',null,$lstart.','.$pagesize);
		foreach($arrReview as $key=>$value){
			$arrTmpBook = aac('book')->getOneBook($value['bookid']);
			$arrReview[$key]['bookname'] = $arrTmpBook['bookname'];
		}
		
		$reviewNum = $new['review']->findCount('review');
		
		$pageUrl = pagination($reviewNum, $pagesize, $page, $url);

		include template("admin/review_list");
		
		break;
		
	//删除的书评
	case "list_delete":
		$pagesize = 10;
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$url = SITE_URL.'index.php?app=review&ac=admin&mg=review&ts=deletereview&page=';
		$lstart = ($page-1)*$pagesize;
		
		$arrReview = $new['review']->findAll('review',array('status'=>'0'),'addtime desc',null,$lstart.','.$pagesize);
		foreach($arrReview as $key=>$value){
			$arrTmpBook = aac('book')->getOneBook($value['bookid']);
			$arrReview[$key]['bookname'] = $arrTmpBook['bookname'];
		}
		
		$reviewNum = $new['review']->findCount('review',array(
			'isdelete'=>'1',
		));
		
		$pageUrl = pagination($reviewNum, $pagesize, $page, $url);
		
		include template("admin/review_list_delete");
		
		break;
		
	//编辑的书评
	case "list_edit":
		
		$pagesize = 10;
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$url = SITE_URL.'index.php?app=review&ac=admin&mg=review&ts=editreview&page=';
		$lstart = ($page-1)*$pagesize;
		
		$arrReview = $new['review']->findAll('review_edit',null,'isupdate asc,addtime desc',null,$lstart.','.$pagesize);
		
		$reviewNum = $new['review']->findCount('review_edit');
		
		$pageUrl = pagination($reviewNum, $pagesize, $page, $url);
		
		include template("admin/review_list_edit");
		
		break;
		
	//执行更新书评
	case "update":
		
		$reviewid = intval($_GET['reviewid']);
		
		$new['review']->syncEditReview($reviewid);
		
		qiMsg('更新成功！');
		
		break;
		
	//查看单独某个修改的书评
	case "editview":
		$reviewid = intval($_GET['reviewid']);
		
		$strReview = $new['review']->find('review_edit',array(
			'reviewid'=>$reviewid,
		));
		
		include template('admin/review_view_edit');
		break;
		
	case "delete":
		$reviewid = intval($_GET['reviewid']);
		
		$new['review']->delReview($reviewid);

		qiMsg('删除成功');
		break;
	
	//书评审核
	case "isaudit":
	
		$reviewid = intval($_GET['reviewid']);
		
		$strReview = $new['review']->find('review',array(
			'reviewid'=>$reviewid,
		));
		
		if($strReview['isaudit']==0){
			$new['review']->update('review',array(
				'reviewid'=>$reviewid,
			),array(
				'isaudit'=>1,
			));
		}
		
		if($strReview['isaudit']==1){
			$new['review']->update('review',array(
				'reviewid'=>$reviewid,
			),array(
				'isaudit'=>0,
			));
		}
		
		qiMsg('操作成功！');
	
		break;
		
}