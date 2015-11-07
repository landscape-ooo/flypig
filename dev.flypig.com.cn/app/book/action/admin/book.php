<?php
defined('IN_TS') or die('Access Denied.');
/* 
 * 图书管理
 */	

switch($ts){

	//图书列表
	case "list":
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$url = SITE_URL.'index.php?app=book&ac=admin&mg=book&ts=list&page=';
		$lstart = $page*10-10;
		$arrBook = $db->fetch_all_assoc("select * from ".dbprefix."book order by addtime desc limit $lstart,10");
		$bookNum = $db->once_num_rows("select * from ".dbprefix."book");
		if(is_array($arrBook)){
			foreach($arrBook as $key=>$item){
				$arrAllBook[] = $item;
				$arrAllBook[$key]['bookdesc'] = cututf8($item['bookdesc'],0,40);
			}
		}
		$pageUrl = pagination($bookNum, 10, $page, $url);

		include template("admin/book_list");
		
		break;
	
	//图书添加
	case "add":
		include template("admin/book_add");
		break;
	
	//图书添加执行
	case "add_do":
		$userid = intval($_POST['userid']);
		$strUser = $db->once_fetch_assoc("select * from ".dbprefix."user_info where userid='$userid'");
		$arrData = array(
			'userid' => $userid,
			'bookname'	=> t($_POST['bookname']),
			'bookdesc'	=> tsClean($_POST['bookdesc']),
			'isrecommend'	=> intval($_POST['isrecommend']),
			'addtime'	=> time(),
			'ispost'	=> intval($_POST['ispost']),
		);
		$bookid = $db->insertArr($arrData,dbprefix.'book');
		//更新book_user索引关系
		$bookUserNum = $db->once_num_rows("select * from ".dbprefix."book_user where userid='$userid' and bookid='$bookid'");
		if($bookUserNum > 0){
		}else{
			//插入图书成员索引
			$db->query("insert into ".dbprefix."book_user (`userid`,`bookid`) values ('".$userid."','".$bookid."')");
			//计算图书会员数
			$bookUserNum = $db->once_num_rows("select * from ".dbprefix."book_user where bookid='$bookid'");
			//更新图书成员统计
			$db->query("update ".dbprefix."book set `count_user`='$bookUserNum' where bookid='$bookid'");
		}
		//回到图书管理首页
		header("Location: ".SITE_URL."index.php?app=book&ac=admin&mg=book&ts=list");
		break;
	
	//图书删除
	case "del":
		$bookid = intval($_GET['bookid']);
		
		if($bookid == 1){
			qiMsg("默认图书不能删除！");
		}
		
		$reviewNum = $db->once_fetch_assoc("select count(*) from ".dbprefix."review where `bookid`='$bookid'");
		
		if($reviewNum['count(*)'] > 0){
			qiMsg("本图书还有书评，不允许删除。");
		}
		
		$db->query("DELETE FROM ".dbprefix."book WHERE bookid = '$bookid'");
		
		$db->query("DELETE FROM ".dbprefix."book_user WHERE bookid = '$bookid'");
		
		qiMsg("图书删除成功！");
		
		break;
		
	//审核图书 
	case "isaudit":
		$bookid = intval($_GET['bookid']);
		
		$strBook = $new['book']->find('book',array(
			'bookid'=>$bookid,
		));
		
		if($strBook['isaudit']=='0'){
			$new['book']->update('book',array(
				'bookid'=>$bookid,
			),array(
				'isaudit'=>'1',
			));
			//发送系统消息(审核通过)
			$msg_userid = '0';
			$msg_touserid = $strBook['userid'];
			$msg_content = '恭喜你，你申请的图书《'.$strBook['bookname'].'》审核通过！快去看看吧<br />'.tsUrl('book','show',array('id'=>$bookid));
			aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
		}
		
		if($strBook['isaudit']=='1'){
			$new['book']->update('book',array(
				'bookid'=>$bookid,
			),array(
				'isaudit'=>'0',
			));
		}
		
		qiMsg("操作成功！");
		
		break;
	
	//推荐图书 
	case "isrecommend":
		$bookid = intval($_GET['bookid']);
		
		$strBook = $db->once_fetch_assoc("select bookid,userid,bookname,isrecommend from ".dbprefix."book where bookid='$bookid'");
		
		if($strBook['isrecommend'] == 0){
			$db->query("update ".dbprefix."book set `isrecommend`='1' where bookid='$bookid'");
			
			//发送系统消息(审核通过)
			$msg_userid = '0';
			$msg_touserid = $strBook['userid'];
			$msg_content = '恭喜你，你的图书《'.$strBook['bookname'].'》被推荐啦！快去看看吧<br />'.tsUrl('book','show',array('id'=>$bookid));
			aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
			
		}else{
			
			$db->query("update ".dbprefix."book set `isrecommend`='0' where bookid='$bookid'");
			
		}
		
		qiMsg("操作成功！");
		
		break;
}