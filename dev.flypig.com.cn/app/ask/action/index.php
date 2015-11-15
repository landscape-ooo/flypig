<?php
defined('IN_TS') or die('Access Denied.');

//问题分类
$arrCate = $new['ask']->findAll('ask_cate',array(
		'status'=>1
));

//用户关注的分类
$myCateArr = array();
if (isset($TS_USER['user']['userid']) && $TS_USER['user']['userid']!=''){
	$userid = intval($TS_USER['user']['userid']);
	$myCateArr = $new['ask']->findAll('ask_user_cate', array(
		'userid'=>$userid
	));
}

//分页处理
$pagesize = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page-1)*$pagesize;

if(!isset($ts)){
	$ts = '';
}
$askArr = array();
$findWhere = '';

//ts 开始
switch($ts){
	//待解决
	case "new":
		//已审核且答案数为0的
		$findWhere = array(
			'count_comment'=>'0',
			'status'=>'1',
			'isaudit'=>'1'
		);
		$askArr = $new['ask']->findAll('ask', $findWhere, 'addtime desc', null, $start.','.$pagesize);
		break;

	//最热
	case "hot":
		//已审核
		$findWhere = array(
			'status'=>'1',
			'isaudit'=>'1'
		);
		//按评论数排序
		$askArr = $new['ask']->findAll('ask', $findWhere, 'count_comment desc', null, $start.','.$pagesize);
		break;

	//我关注的
	case 'mycate':
		$catewhere = '';
		//登录用户根据关注的分类找出相关问题
		if (isset($myCateArr) && $myCateArr){
			$tempcate = array();
			foreach ($myCateArr as $val){
				$tempcate[] = $val['cateid'];
			}
			if(count($tempcate)>0){
				$strcate = implode(',', $tempcate);
			}
			$catewhere .= " AND cateid in(".$strcate.") ";
		}
		//已审核并且属于我关注的分类
		$findWhere = " `isaudit`='1' AND `status`='1' ".$catewhere;
		$askArr = $new['ask']->findAll('ask', $findWhere, 'count_comment desc', null, $start.','.$pagesize);
		break;

	//默认全部
	default:
		//已审核
		$findWhere = array(
			'status'=>'1',
			'isaudit'=>'1'
		);
		$askArr = $new['ask']->findAll('ask', $findWhere,'askid desc', null, $start.','.$pagesize);
		break;

}
//增添数据
foreach($askArr as $key=>$v){
	$askArr[$key]['cate'] = $new['ask']->getAskCate($v['askid']);
	$askArr[$key]['user'] = aac('user')->getOneUser($v['userid']);
}

//总数
$askNum = $new['ask']->findCount('ask', $findWhere);

//分页
$url = tsUrl('ask', 'index', array('ts'=>$ts,'page'=>''));
$pageUrl = pagination($askNum, $pagesize, $page, $url);



/*
 * 侧栏
 * */
//top visit share
$topvisitlist=$new['ask']->getTopVisitlist();
$toprelation_share=$new['ask']->getFriendVisitlist();



include template('index');