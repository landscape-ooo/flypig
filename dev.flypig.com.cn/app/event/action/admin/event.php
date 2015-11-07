<?php 

switch($ts){
	case "list":
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$url = 'index.php?app=event&ac=admin&mg=event&ts=list&page=';
		$lstart = $page*10-10;
		$arrEvent = $db->fetch_all_assoc("select * from ".dbprefix."event order by addtime desc limit $lstart,10");
		$eventNum = $db->once_num_rows("select * from ".dbprefix."event");
		$pageUrl = pagination($eventNum, 10, $page, $url);

		include template("admin/event_list");
		
		break;
		
	//删除
	case "delete":
		
		$eventid = intval($_GET['eventid']);
		
		//获取原数据
		$strEvent = $new['event']->find('event',array(
			'eventid'=>$eventid
		));
		if(!$strEvent){
			qiMsg('活动不存在！');
		}
		
		//删除数据以及缓存
		rmrf('cache/event');//删除海报缓存
		unlink("uploadfile/event/".$strEvent['path']."/".$eventid.".jpg");//删除原始海报
		$new['event']->delete('event',array(
			'eventid'=>$eventid
		));
		$new['event']->delete('event_comment',array(
			'eventid'=>$eventid
		));
		$new['event']->delete('event_user',array(
			'eventid'=>$eventid
		));
		
		//更新活动分类统计
		$curCateNum = $new['event']->findCount('event',array(
			'cateid'=>$strEvent['cateid'],
			'isaudit'=>'1'
		));
		$new['event']->update('event_cate',array(
			'cateid'=>$strEvent['cateid']
		),array(
			'count_event'=>$curCateNum
		));
		
		qiMsg('删除成功！');
		
		break;
		
	//审核
	case "isaudit":
		
		$eventid = intval($_GET['eventid']);
		
		//获取原数据
		$strEvent = $new['event']->find('event',array(
			'eventid'=>$eventid
		));
		if(!$strEvent){
			qiMsg('活动不存在！');
		}
		//审核
		if($strEvent['isaudit']=='0'){
			$isaudit = '1';
			
			//审核通过
			$new['event']->update('event',array(
				'eventid'=>$strEvent['eventid']
			),array(
				'isaudit'=>$isaudit
			));
			
			//更新分类活动数
			$new['event']->update('event_cate',array(
				'cateid'=>$strEvent['cateid']
			),array(
				"`count_event` = `count_event`+1"
			));
			
			//message开始
			$msg_userid = '0';
			$msg_touserid = $strEvent['userid'];
			$msg_content = '你发布的活动：《'.$strEvent['title'].'》已经通过审核!快去看看吧 <br />'.SITE_URL.'index.php?app=event&ac=show&eventid='.$eventid;
			aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
			//message结束
			
		//取消审核
		}else{
			$isaudit = '0';
			//审核通过
			$new['event']->update('event',array(
				'eventid'=>$strEvent['eventid']
			),array(
				'isaudit'=>$isaudit
			));
			//更新分类活动数
			$new['event']->update('event_cate',array(
				'cateid'=>$strEvent['cateid']
			),array(
				"`count_event` = `count_event`-1"
			));
		}
		
		qiMsg('操作成功！');
		
		break;
		
}