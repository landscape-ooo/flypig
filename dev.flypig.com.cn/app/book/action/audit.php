<?php 
defined('IN_TS') or die('Access Denied.');

$userid = aac('user')->isLogin();

$bookid = intval($_GET['bookid']);

$strBook = $new['book']->find('book',array(
	'bookid'=>$bookid,
));

if($strBook['userid']==$userid || $TS_USER['user']['isadmin']==1){
	switch($ts){
		
		case "review":
			
			$arrReview = $new['book']->findAll('review',array(
				'bookid'=>$bookid,
				'isaudit'=>'0',
			));
			
			$title = '审核书评';
			include template('audit_review');
		
			break;
			
		default:
			break;
	}
}else{
	tsNotice('非法操作！');
}