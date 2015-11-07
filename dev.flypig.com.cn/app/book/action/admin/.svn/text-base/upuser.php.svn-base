<?php
defined('IN_TS') or die('Access Denied.'); 
//将用户全部绑定到群组
$bookid = intval($_GET['bookid']);

$arrUser = $db->fetch_all_assoc("select userid from ".dbprefix."user order by userid desc");

foreach($arrUser as $item){
	$bookusernum = $db->once_num_rows("select * from ".dbprefix."book_user where  userid='".$item['userid']."' and bookid='".$bookid."'");
	
	if($bookusernum == '0'){
		$db->query("insert into ".dbprefix."book_user (`userid`,`bookid`,`addtime`) values ('".$item['userid']."','".$bookid."','".time()."')");
	}
	
}

$userNum = $db->once_num_rows("select * from ".dbprefix."book_user where bookid='".$bookid."'");

$db->query("update ".dbprefix."book set `count_user`='".$userNum."' where bookid='".$bookid."'");

qiMsg("会员投送成功！");