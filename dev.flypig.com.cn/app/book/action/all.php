<?php
defined('IN_TS') or die('Access Denied.');
//所有图书
$page = isset($_GET['page']) ? intval($_GET['page']) : '1';
$url = tsUrl('book','all',array('page'=>''));
$lstart = $page*20-20;
$arrBooks = $db->fetch_all_assoc("select bookid from ".dbprefix."book order by isrecommend desc limit $lstart,20");
foreach($arrBooks as $key=>$item){
	$arrData[] = $new['book']->getOneBook($item['bookid']);
}
foreach($arrData as $key=>$item){
	$arrBook[] =  $item;
	$arrBook[$key]['bookdesc'] = cututf8(t($item['bookdesc']),0,35);
}
$bookNum = $db->once_fetch_assoc("select count(bookid) from ".dbprefix."book");
$pageUrl = pagination($bookNum['count(bookid)'], 20, $page, $url);
if($page > 1){
	$title = '全部图书 - 第'.$page.'页';
}else{
	$title = '全部图书';
}


//热门书评
$arrReview = $db->fetch_all_assoc("select reviewid,title,count_comment from ".dbprefix."review order by count_comment desc limit 10");

//最新10个图书
$arrNewBook = $new['book']->getNewBook('10');

include template('all');