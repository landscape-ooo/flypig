<?php
defined('IN_TS') or die('Access Denied.');

//ts
switch($ts){
	
	case "":
		$pagesize = 20;
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$lstart = $pagesize*($page-1);
		
		$arrFeeds = $new['system']->findAll('feed',array(
			'status'=>1
		),'addtime desc',null,$lstart.','.$pagesize);
		
		foreach($arrFeeds as $key=>$item){
			$strUser = aac('user')->getOneUser($item['userid']);
			$item['username'] = $strUser['username'];
			$item['template'] = '';
			$strType = $new['system']->find('feed_type',array(
				'typeid'=>$item['typeid']
			));
			if($strType){
				$item['template'] = $strType['template'];
			}
			
			//$data = json_decode($item['jsondata'],true);
			$data = unserialize($item['serializedata']);
			if(is_array($data)){
				foreach($data as $key=>$itemTmp){
					$tmpkey = '{'.$key.'}';
					$tmpdata[$tmpkey] = urldecode($itemTmp);
				}
			}
			$arrFeed[] = array(
				'feedid'=>$item['feedid'],
				'userid'=>$item['userid'],
				'username'=>$item['username'],
				'content' => strtr($item['template'],$tmpdata),
				'addtime' => $item['addtime'],
			);
		}
		//总数
		$feedNum = $new['system']->findCount('feed',array(
			'status'=>1
		));
		//分页
		$url = tsUrl('system', 'assemline', array('page'=>''));
		$pageUrl = pagination($feedNum, $pagesize, $page, $url);
		
		include template("assemline");
		break;
		
	case "delete":
		$feedid = intval($_GET['feedid']);
		$new['system']->delete('feed',array(
			'feedid'=>$feedid,
		));
		
		qiMsg('删除成功！',null,SITE_URL."index.php?app=system&ac=assemline",true);
		
		break;

}