<?php
defined('IN_TS') or die('Access Denied.');
/* 
 * 图书分类管理
 */

switch($ts){
	//分类列表 
	case "list":
		
		$arrCates = array();
		
		$arrCate = $new['book']->findAll('book_cate',array(
			'referid'=>'0',
		));
		foreach($arrCate as $key=>$item){
			$arrCates[] = $item;
			$arrCates[$key]['two'] = $new['book']->findAll('book_cate',array(
				'referid'=>$item['cateid'],
			));
		}
		
		include template("admin/cate_list");
		
		break;
	case "uporder":
		
		$idss = $_POST['ids'];
		$orderidss = $_POST['orderids'];
		//var_dump($idss);var_dump($orderidss);die;
		if($idss && $orderidss && count($idss)==count($orderidss)){
			foreach($idss as $key => $value){
				$new['book']->update('book_cate',array(
						'cateid'=>$value,
					),array(
						'orderid'=>$orderidss[$key],
					));
			}
		}
		header("Location: ".SITE_URL."index.php?app=book&ac=admin&mg=cate&ts=list");
		
		break;
	//分类添加
	case "add":
		
		$strCate = array();
		$referid = intval($_GET['referid']);
		if(!empty($referid)){
			$strCate = $new['book']->find('book_cate',array(
					'cateid'=>$referid,
				));
		}
		include template("admin/cate_add");
		
		break;
		
	case "add_do":
		
		$new['book']->create('book_cate',array(
			'catename'=>t($_POST['catename']),
			'cateflag'=>t($_POST['cateflag']),
			'referid'=>intval($_POST['referid']),
		));
		
		header("Location: ".SITE_URL."index.php?app=book&ac=admin&mg=cate&ts=list");
		
		break;
	
	//分类删除
	case "del":
		
		$cateid = intval($_GET['cateid']);
		
		$strCate = $new['book']->find('book_cate',array(
				'cateid'=>$cateid,
			));
		$status = $strCate['status']==1 ? 0 : 1;
		
		$result = $new['book']->update('book_cate',array(
				'cateid'=>$cateid,
			),array(
				'status'=>$status,
			));
		if($result){
			qiMsg("分类更新成功！");
		}else{
			qiMsg("分类更新失败！");
		}
		
		break;
	
	//分类修改
	case "edit":
		
		$cateid = intval($_GET['cateid']);
		$referid = intval($_GET['referid']);
		
		$strCate = $new['book']->find('book_cate',array(
				'cateid'=>$cateid,
			));
		
		//调出顶级分类
		if($referid){
			$arrOneCate = $new['book']->findAll('book_cate',array(
				'referid'=>0,
			));
		}
		
		include template("admin/cate_edit");
		
		break;
	
	//分类修改执行 
	case "edit_do":
		$cateid = intval($_POST['cateid']);
		$catename = t($_POST['catename']);
		$cateflag = t($_POST['cateflag']);
		$referid = intval($_POST['referid']);
		$new['book']->update('book_cate',array(
				'cateid'=>$cateid,
			),array(
				'catename'=>$catename,
				'cateflag'=>$cateflag,
				'referid'=>$referid,
			));
		if(empty($referid)){
			$new['book']->update('book_cate',array(
					'referid'=>$cateid,
				),array(
					'cateflag'=>$cateflag,
					'referid'=>$referid,
				));
		}
		
		header("Location: ".SITE_URL."index.php?app=book&ac=admin&mg=cate&ts=list");
		
		break;
}