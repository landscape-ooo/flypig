<?php
defined('IN_TS') or die('Access Denied.');

//管理员是否登录
$userid = aac('user')->isAdminLogin();

switch($ts){
	
	case "list":
		$pagesize = 20;
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$lstart = $pagesize*($page-1);
		
		$arrFeeds = $new['feed']->findAll('feed', null,'addtime desc',null,$lstart.','.$pagesize);
		foreach($arrFeeds as $key=>$item){
			$strUser = aac('user')->getOneUser($item['userid']);
			$item['username'] = $strUser['username'];
			$item['template'] = '';
			$strType = $new['feed']->find('feed_type',array(
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
				'data' => $tmpdata,
				'status'=>$item['status'],
				'addtime' => $item['addtime'],
			);
		}
		//总数
		$feedNum = $new['feed']->findCount('feed');
		//分页
		$url = tsUrl('feed','admin',array('mg'=>'feed','ts'=>'list','page'=>''));
		$pageUrl = pagination($feedNum, $pagesize, $page, $url);
		
		include template("admin/feed_list");
		break;
		
	case "delete":
		$feedid = intval($_GET['feedid']);
		$new['feed']->delete('feed',array(
			'feedid'=>$feedid,
		));
		
		qiMsg('删除成功！');
		
		break;

}