<?php
defined('IN_TS') or die('Access Denied.');

switch($ts){
	
	case "list":
		$pagesize = 20;
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$lstart = $pagesize*($page-1);
		
		$arrIndexs = $new['index']->findAll('index', null,'addtime desc',null,$lstart.','.$pagesize);
		foreach($arrIndexs as $key=>$item){
			$strUser = aac('user')->getOneUser($item['userid']);
			$item['username'] = $strUser['username'];
			$item['template'] = '';
			$strType = $new['index']->find('index_type',array(
				'typeid'=>$item['typeid']
			));
			if($strType){
				$item['template'] = $strType['template'];
			}
			
			//$data = json_decode($item['data'],true);
			$data = unserialize($item['serializedata']);
			if(is_array($data)){
				foreach($data as $key=>$itemTmp){
					$tmpkey = '{'.$key.'}';
					$tmpdata[$tmpkey] = urldecode($itemTmp);
				}
			}
			$arrIndex[] = array(
				'indexid'=>$item['indexid'],
				'userid'=>$item['userid'],
				'username'=>$item['username'],
				'content' => strtr($item['template'],$tmpdata),
				'data' => $tmpdata,
				'status'=>$item['status'],
				'addtime' => $item['addtime'],
			);
		}
		//总数
		$indexNum = $new['index']->findCount('index');
		//分页
		$url = tsUrl('index','admin',array('mg'=>'index','ts'=>'list','page'=>''));
		$pageUrl = pagination($indexNum, $pagesize, $page, $url);
		
		include template("admin/index_list");
		break;
		
	case "delete":
		$indexid = intval($_GET['indexid']);
		$new['index']->delete('index',array(
			'indexid'=>$indexid,
		));
		
		qiMsg('删除成功！');
		
		break;

}