<?php
defined('IN_TS') or die('Access Denied.');

$cateid = intval($_GET['cateid']);
$curCateArr = $new['ask']->find('ask_cate', array(
	'cateid'=>$cateid
));

$title = $curCateArr['catename'].'_问答分类';

//关注这个分类的用户数
$follownum = $new['ask']->findCount('ask_user_cate', array(
	'cateid'=>$cateid
));
//判断登录用户是否已关注
$myCateArr = array();
if (isset($TS_USER['user']['userid']) && '' != $TS_USER['user']['userid']){
	$userid = intval($TS_USER['user']['userid']);
	$myCateArr = $new['ask']->find('ask_user_cate', array(
		'userid'=>$userid,
		'cateid'=>$cateid
	));
}

//他们关注了这个分类
$followUsersArr = array();
$followUsers = $new['ask']->findAll('ask_user_cate', array(
	'cateid'=>$cateid
), 'addtime desc', 'userid', 6);
foreach ($followUsers as $val){
	$followUsersArr[] = aac('user')->getOneUser($val['userid']);
}

//分页处理
$pagesize = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = $pagesize * ($page - 1);

if(!isset($ts)) $ts = '';
$askArr = array();
$findWhere = '';

//筛选数据
$curAskidStr = $new['ask']->findAll('ask_cate_info', array(
	'cateid'=>$cateid
),'askid desc','GROUP_CONCAT(askid) as askids');
$curAskids = isset($curAskidStr[0]['askids']) ? $curAskidStr[0]['askids'] : '';

//ts 开始
switch($ts){
	//待解决
	case 'new':
		//通过审核且答案数为0的
		$findWhere = " `status`=1 AND `isaudit`=1 AND `count_comment`=0 AND `askid` in(".$curAskids.") ";
		$askArr = $new['ask']->findAll('ask', $findWhere, 'askid desc', null, $start.','.$pagesize);
		break;
		
	//最热
	case 'hot':
		//通过审核且答案数为0的
		$findWhere = " `status`=1 AND `isaudit`=1 AND `count_comment`>0 AND `askid` in(".$curAskids.") ";
		$askArr = $new['ask']->findAll('ask', $findWhere, 'count_comment desc', null, $start.','.$pagesize);
		break;
		
	default:
		//通过审核且答案数为0的
		$findWhere = " `status`=1 AND `isaudit`=1 AND `askid` in(".$curAskids.") ";
		$askArr = $new['ask']->findAll('ask', $findWhere, 'askid desc', null, $start.','.$pagesize);
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
$url = tsUrl('ask', 'cate', array('cateid'=>$cateid,'ts'=>$ts,'page'=>''));
$pageUrl = pagination($askNum, $pagesize, $page, $url);

include template('cate');