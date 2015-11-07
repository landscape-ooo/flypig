<?php 

switch($ts){
	case "list":
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$url = 'index.php?app=special&ac=admin&mg=special&ts=list&page=';
		$lstart = $page*10-10;
		$arrSpecial = $db->fetch_all_assoc("select * from ".dbprefix."special order by addtime desc limit $lstart,10");
		$specialNum = $db->once_num_rows("select * from ".dbprefix."special");
		$pageUrl = pagination($specialNum, 10, $page, $url);

		include template("admin/special_list");
		
		break;
		
	//删除
	case "delete":
		
		$specialid = intval($_GET['specialid']);
		
		//获取原数据
		$strSpecial = $new['special']->find('special',array(
			'specialid'=>$specialid
		));
		if(!$strSpecial){
			qiMsg('专题不存在！');
		}
		
		//删除数据以及缓存
		rmrf('cache/special');//删除海报缓存
		unlink("uploadfile/special/".$strSpecial['path']."/".$specialid.".jpg");//删除原始海报
		$new['special']->delete('special',array(
			'specialid'=>$specialid
		));
		
		//更新专题分类统计
		$curCateNum = $new['special']->findCount('special',array(
			'cateid'=>$strSpecial['cateid'],
			'isaudit'=>'1'
		));
		$new['special']->update('special_cate',array(
			'cateid'=>$strSpecial['cateid']
		),array(
			'count_special'=>$curCateNum
		));
		
		qiMsg('删除成功！');
		
		break;
		
	//审核
	case "isaudit":
		
		$specialid = intval($_GET['specialid']);
		
		//获取原数据
		$strSpecial = $new['special']->find('special',array(
			'specialid'=>$specialid
		));
		if(!$strSpecial){
			qiMsg('专题不存在！');
		}
		//审核
		if($strSpecial['isaudit']=='0'){
			$isaudit = '1';
			
			//审核通过
			$new['special']->update('special',array(
				'specialid'=>$strSpecial['specialid']
			),array(
				'isaudit'=>$isaudit
			));
			
			//更新分类专题数
			$new['special']->update('special_cate',array(
				'cateid'=>$strSpecial['cateid']
			),array(
				"`count_special` = `count_special`+1"
			));
			
			//message开始
			$msg_userid = '0';
			$msg_touserid = $strSpecial['userid'];
			$msg_content = '你发布的专题：《'.$strSpecial['title'].'》已经通过审核!快去看看吧 <br />'.SITE_URL.'index.php?app=special&ac=show&specialid='.$specialid;
			aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
			//message结束
			
		//取消审核
		}else{
			$isaudit = '0';
			//审核通过
			$new['special']->update('special',array(
				'specialid'=>$strSpecial['specialid']
			),array(
				'isaudit'=>$isaudit
			));
			//更新分类专题数
			$new['special']->update('special_cate',array(
				'cateid'=>$strSpecial['cateid']
			),array(
				"`count_special` = `count_special`-1"
			));
		}
		
		qiMsg('操作成功！');
		
		break;
		
}