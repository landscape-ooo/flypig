<?php
defined('IN_TS') or die('Access Denied.');

$shareid = intval($_GET['id']);

$strShare = $new['share']->find('share',array(
	'shareid'=>$shareid,
	'status'=>'1'
));
if(!$strShare){
	tsNotice('参数错误，分享不存在', null, tsUrl('share'), true);
}

//审核状态 
if($strShare['isaudit']=='0' && $TS_USER['user']['isadmin']!='1'){
	tsNotice('分享还在审核中，审核后显示',null,tsUrl('share'),true);
}

//删除状态
if($strShare['status']=='0' && $TS_USER['user']['isadmin']!='1'){
	tsNotice('分享已被删除！',null,tsUrl('share'),true);
}

$strShare = $new['share']->getOneShare($shareid);
$strShare['title'] = htmlspecialchars($strShare['title']);
$strShare['content'] = '';
//附表数据
$strShareAdd = $new['share']->find('share_add',array(
	'shareid'=>$shareid,
));
if($strShareAdd){
	$strShare['content'] = $strShareAdd['content'];
}

//标题
$title = $strShare['title'];

//分享所属分类
$strShare['catename'] = '';
$strCate = $new['share']->find('share_cate',array(
	'cateid'=>$strShare['cateid']
));
if($strCate){
	$strShare['catename'] = $strCate['catename'];
}

//@用户功能处理
//$strShare['content'] = preg_replace("/\[@(.*)\:(.*)]/U","<a href='".tsUrl('user','space',array('id'=>'$2'))." ' rel=\"face\" uid=\"$2\"'>@$1</a>",$strShare['content']);

//分享标签
$strShare['tags'] = aac('tag')->getObjTagByObjid('share', 'shareid', $shareid);
$strShare['user'] = aac('user')->getOneUser($strShare['userid']);

//把标签作为关键词
if($strShare['tags']){
	foreach($strShare['tags'] as $key=>$item){
		$arrTag[] = $item['tagname'];
	}
	$sitekey = array_to_str($arrTag);
}

//评论分页开始
$pagesize = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; 
$url = tsUrl('share', 'show', array('id' => $shareid, 'page' => ''));
$lstart = ($page-1)*$pagesize;

//查询
$arrComment = $new['share']->findAll('share_comment',array(
	'shareid'=>$shareid,
	'status'=>'1'
),'addtime asc',null,$lstart.','.$pagesize);
//补充数据
foreach($arrComment as $key => $item){
	$arrShareComment[] = $item;
	$arrShareComment[$key]['lou'] = $lstart + $key + 1;
	$arrShareComment[$key]['user'] = aac('user')->getOneUser($item['userid']);
	//@用户功能处理
	//$arrShareComment[$key]['content'] = preg_replace("/\[@(.*)\:(.*)]/U","<a href='".tsUrl('user','space',array('id'=>'$2'))." ' rel=\"face\" uid=\"$2\"'>@$1</a>",$arrShareComment[$key]['content']);	
}
//总数
$commentNum = $new['share']->findCount('share_comment',array(
	'shareid'=>$shareid,
	'status'=>'1'
));
//分页
$pageUrl = pagination($commentNum, $pagesize, $page, $url); 

//增加浏览次数
$new['share']->update('share', array(
	'shareid' => $shareid,
), array(
	'count_view' => $strShare['count_view'] + 1,
));

//最新分享
$newShare = $new['share']->findAll('share',array(
	'isaudit'=>'1',
	'status'=>'1'
),'addtime desc',null,5);

//7天内的热门分享
$arrHotShare = $new['share']->getHotDayShare(7, 5);

//谁喜欢（收藏）了这篇分享
$arrCollectUser = $new['share']->getCollectUser($shareid,1);

if($TS_CF['mobile']){
	$sitemb = tsUrl('moblie','share',array('ts'=>'show','shareid'=>$shareid));
}

include template('show');