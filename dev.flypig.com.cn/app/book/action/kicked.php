<?php
defined('IN_TS') or die('Access Denied.');

$bookuserid = intval($TS_USER['user']['userid']);

if($bookuserid==0){
	echo 0;exit;
}

$bookid = intval($_POST['bookid']);
$userid = intval($_POST['userid']);

$strBook = $new['book']->find('book',array(
	'bookid'=>$bookid,
));

if($strBook['userid']!=$bookuserid){

	echo 1;exit;
	
}

$new['book']->delete('book_user',array(
	'userid'=>$userid,
	'bookid'=>$bookid,
));

echo 2;exit;