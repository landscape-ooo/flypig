<?php
defined('IN_TS') or die('Access Denied.');
/* 
 * 图书作者管理
 */

switch($ts){
	//作者列表 
	case "list":
		
		$arrAuthors = array();
		
		$arrAuthor = $new['book']->findAll('book_author','status=1 group by country','orderpy asc');
		foreach($arrAuthor as $key=>$item){
			$arrAuthors[] = $item;
			$arrAuthors[$key]['two'] = $new['book']->findAll('book_author',array(
				'country'=>$item['country'],
				'status'=>'1',
			));
		}
		
		include template("admin/author_list");
		
		break;
	case "uporder":
		
		$idss = $_POST['ids'];
		$orderidss = $_POST['orderids'];
		//var_dump($idss);var_dump($orderidss);die;
		if($idss && $orderidss && count($idss)==count($orderidss)){
			foreach($idss as $key => $value){
				$new['book']->update('book_author',array(
						'authorid'=>$value,
					),array(
						'orderid'=>$orderidss[$key],
					));
			}
		}
		header("Location: ".SITE_URL."index.php?app=book&ac=admin&mg=author&ts=list");
		
		break;
	//作者添加
	case "add":
		
		$referid = intval($_GET['referid']);

		include template("admin/author_add");
		
		break;
		
	case "add_do":
		
		$new['book']->create('book_author',array(
		
			'auname'=>t($_POST['auname']),
			'referid'=>intval($_POST['referid']),
		
		));
		
		header("Location: ".SITE_URL."index.php?app=book&ac=admin&mg=author&ts=list");
		
		break;
	
	//作者删除
	case "del":
		
		$auid = intval($_GET['auid']);
		
		$arrAuthor = $new['book']->find('book_author',array(
				'auid'=>$auid,
			));
		$status_to = $arrAuthor['status']==1 ? 0 : 1;
		$result = $new['book']->update('book_author',array(
				'auid'=>$auid,
			),array(
				'status'=>$status_to,
			));
		if($result){
			qiMsg("作者更新成功！");
		}else{
			qiMsg("作者更新失败！");
		}
		
		break;
	
	//作者修改
	case "edit":
	
		$auid = intval($_GET['auid']);
		
		$referid = intval($_GET['referid']);
		
		$strAuthor = $new['book']->find('book_author',array(
				'auid'=>$auid,
			));
		
		//调出顶级作者
		if($referid){
			$arrOneAuthor = $new['book']->findAll('book_author',array(
				'referid'=>0,
			));
		}
		
		include template("admin/author_edit");
		
		break;
	
	//作者修改执行 
	case "edit_do":
		$auid = intval($_POST['auid']);
		$auname = t($_POST['auname']);
		
		$referid = intval($_POST['referid']);
		
		$refer = '';
		if($referid){
			$refer = ", `referid`='$referid'";
		}
		
		$db->query("update ".dbprefix."book_author set `auname`='".$auname."'".$refer." where auid='$auid'");
		
		header("Location: ".SITE_URL."index.php?app=book&ac=admin&mg=author&ts=list");
		
		break;
}