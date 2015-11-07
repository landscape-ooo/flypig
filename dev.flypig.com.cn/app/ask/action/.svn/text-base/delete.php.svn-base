<?php
defined('IN_TS') or die('Access Denied.');

$userid = aac('user')->isLogin();

if (1 != $TS_USER['user']['isadmin']){
	tsNotice('没有权限执行该操作');
}
$askid = intval($_GET['askid']);

//删除该问题分类对应分类表
$askStr = $new['ask']->find('ask', array('askid'=>$askid));

//删除先前的分类
$askCate = $new['ask']->findAll('ask_cate_info', array('askid'=>$askid));
foreach ($askCate as $value){
	//更改分类数
	$new['ask']->reduce_cate_one($value['cateid']);
}
$new['ask']->delete('ask_cate_info', array('askid'=>$askid));

//删除问题
$new['ask']->delete('ask', array(
	'askid'=>$askid
));

header("Location:".tsUrl('ask'));
