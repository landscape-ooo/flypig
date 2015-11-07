<?php
defined('IN_TS') or die('Access Denied.');

$specialid = intval($_GET['id']);

//专题信息
$strSpecial = $new['special']->getOneSpecial($specialid);
if(!$strSpecial){
	tsNotice("参数错误，专题不存在!");
}

if($strSpecial['isaudit'] =='0' && $TS_USER['user']['isadmin']!='1'){
	tsNotice("该专题未通过审核，暂不允许浏览!");
}

$title = $strSpecial['title'];

$linkurl = $strSpecial['linkurl'];

//增加浏览次数
$new['special']->update('special', array(
		'specialid' => $specialid,
), array(
		'count_click' => $strSpecial['count_click'] + 1,
));


header("Location: ".$linkurl);
