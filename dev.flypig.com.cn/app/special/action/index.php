<?php 
defined('IN_TS') or die('Access Denied.');

//专题分类数据
$arrSpecialCate = $new['special']->findAll('special_cate', array(
	'status'=>'1'
));

//有分类ID请求
$catename = '';
$cateid = isset($_GET['cateid']) ? intval($_GET['cateid']) : 0;
if(!empty($cateid)){
	$strCate = $new['special']->getOneCate($cateid);
	if(!$strCate){
		header("Location: ".tsUrl('special'));
		exit;
	}
	$catename = $strCate['catename'];
}

//分页处理
$pagesize = 12;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$lstart = $pagesize * ($page-1);
$url = tsUrl('special','index',array('page'=>''));

//获取专题
if(!empty($cateid)){
	$arrSpecial = $new['special']->findAll('special', array(
		'cateid'=>$cateid,
		'isaudit'=>'1',
		'status'=>'1'
	),'addtime desc', null, $lstart.','.$pagesize);
}else{
	$arrSpecial = $new['special']->findAll('special', array(
		'isaudit'=>'1',
		'status'=>'1'
	),'addtime desc', null, $lstart.','.$pagesize);
}

//数据完善
foreach($arrSpecial as $key => $item){
	
	//添加及格式化数据
	$arrSpecial[$key] = $new['special']->getOneSpecial($item['specialid']);
	
	//专题类型
	$tmpSpecialCate = $new['special']->getOneCate($item['cateid']);
	$arrSpecial[$key]['catename'] = $tmpSpecialCate['catename'];
	
}

//总数
$specialNumAll = $new['special']->findCount('special',array(
	'isaudit'=>'1',
	'status'=>'1'
));
if(!empty($cateid)){
	$specialNum = $new['special']->findCount('special',array(
		'cateid'=>$cateid,
		'isaudit'=>'1',
		'status'=>'1'
	));
}else{
	$specialNum = $specialNumAll;
}

//分页
$pageUrl = pagination($specialNum, $pagesize, $page, $url);

include template("index");