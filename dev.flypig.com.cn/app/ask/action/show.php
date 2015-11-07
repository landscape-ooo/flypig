<?php
defined('IN_TS') or die('Access Denied.');

$askid = intval($_GET['id']);
$strAsk = $new['ask']->find('ask', array(
	'askid'=>$askid,
));
if(!$strAsk || $strAsk['isaudit']==0){
	tsNotice('问答不存在，参数错误！');
	exit;
}
$strAsk['content'] = $new['ask']->getAskAdd($askid);
$strAsk['user'] = aac('user')->getOneUser($strAsk['userid']);
$strAsk['addtime'] = date('Y-m-d H:i:s', $strAsk['addtime']);
$strAsk['title'] = htmlspecialchars($strAsk['title']);

$strAsk['cate'] = $new['ask']->getAskCate($askid);

$title = $strAsk['title'];

//问题添加讨论
$askaddarr = $new['ask']->findAll('ask_add', array(
		'askid'=>$askid,
	));
foreach ($askaddarr as $key=>$val){
	$adduserarr = aac('user')->getOneUser($val['userid']);
	$askaddarr[$key]['username'] = $adduserarr['username'];
	$askaddarr[$key]['addtime'] = date('Y-m-d', $askaddarr[$key]['addtime']);
}

//分页处理
$pagesize = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page-1)*$pagesize;

$commentNum = $new['ask']->findCount('ask_comment', array(
	'askid'=>$askid
));
$arrComment = $new['ask']->findAll('ask_comment', array(
	'askid'=>$askid,
	'status'=>'1'
),'digg-undigg desc,addtime asc', null, $start.','.$pagesize);
//遍历评论
foreach ($arrComment as $key=>$v){
	$arrComment[$key]['user'] = aac('user')->getOneUser($v['userid']);
	//评论内容
	$arrComment[$key]['content'] = $new['ask']->getCommentAdd($v['commentid']);
}

//如果是登录用户
$userid = aac('user')->isLogin(false);
//判断是否回答过该问题
$iscommented = false;
if($userid){
	$selfarrComment = $new['ask']->find('ask_comment', array(
		'userid'=>$userid,
		'askid'=>$askid,
		'status'=>'1'
	));
	if ($selfarrComment){
		$iscommented = true;
	}
}

//你可能感兴趣
if ($strAsk['cate']){
	$tempid = array();
	foreach ($strAsk['cate'] as $val){
		$tempid[] = $val['cateid'];
	}
	$strcate = implode(',', $tempid);
	$sql = "select distinct(a.askid),userid,title,count_comment from ".dbprefix."ask_cate_info a left join ".dbprefix."ask b on a.askid = b.askid where a.cateid in (".$strcate.") and b.askid!=".$askid." order by a.askid desc limit 0, 10";
}else{
	$sql = "select distinct(a.askid),userid,title,count_comment from ".dbprefix."ask_cate_info a left join ".dbprefix."ask b on a.askid = b.askid where b.askid!=".$askid." order by a.askid desc limit 0, 10";
}
$maybeAsk = $new['ask']->db->fetch_all_assoc($sql);

//分页
$url = tsUrl('ask', 'show', array('id'=>$askid,'page'=>''));
$pageUrl = pagination($commentNum, $pagesize, $page, $url);

include template('show');