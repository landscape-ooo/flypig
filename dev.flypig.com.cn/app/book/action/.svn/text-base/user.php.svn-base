<?php
defined('IN_TS') or die('Access Denied.');
//图书成员

switch($ts){
	
	//图书成员首页
	case "":
	
		$bookid = intval($_GET['id']);

		//判断是否存在这个群组
		$strBook = $new['book']->getOneBook($bookid);
		if($strBook == '') {
			header("HTTP/1.1 404 Not Found");
			header("Status: 404 Not Found");
			$title = '404';
			include pubTemplate("404");
			exit;
		}

		//图书组长信息
		$leaderId = $strBook['userid'];

		$strLeader = aac('user')->getOneUser($leaderId);

		//管理员信息
		
		$strAdmin = $new['book']->findAll('book_user',array(
			'bookid'=>$strBook['bookid'],
			'isadmin'=>'1',
			'isfounder'=>'0',
		));
		

		if(is_array($strAdmin)){
			foreach($strAdmin as $key=>$item){
				$arrAdmin[] = aac('user')->getOneUser($item['userid']);
				$arrAdmin[$key]['isadmin'] = $item['isadmin'];
			}
		}

		//图书会员分页

		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

		$url = tsUrl('book','user',array('id'=>$bookid,'page'=>''));


		$lstart = $page*40-40;

		//普通用户
		$bookUserNum = $new['book']->findCount('book_user',array(
			
			'bookid'=>$bookid,
			'isadmin'=>0,
			'isfounder'=>0,
		
		));
		
		$bookUser = $new['book']->findAll('book_user',array(
			'bookid'=>$strBook['bookid'],
			'isadmin'=>'0',
			'isfounder'=>'0',
		),'userid desc',null,$lstart.',40');
		//print_r($bookUser);

		if(is_array($bookUser)){
			foreach($bookUser as $key=>$item){
				$arrBookUser[] = aac('user')->getOneUser($item['userid']);
				$arrBookUser[$key]['isadmin'] = $item['isadmin'];
			}
		}

		$pageUrl = pagination($bookUserNum, 40, $page, $url,$TS_URL['suffix']);

		if($page > '1'){
			$titlepage = " - 第".$page."页";
		}else{
			$titlepage='';
		}

		$title = $strBook['bookname'].'成员'.$titlepage;

		include template("user");
		
		break;
		
	//设为管理员 
	case "manager":
	
		if($_POST['token'] != $_SESSION['token']) {
			echo '0';exit;//非法操作
		}
		
		$nuserid = intval($TS_USER['user']['userid']);
		
		if($nuserid==0){
			echo '0';exit;//非法操作
		}
		
		$bookid = intval($_POST['bookid']);
		$userid= intval($_POST['userid']);
		
		$strBook = $new['book']->find('book',array(
			'bookid'=>$bookid,
		));
		
		if($strBook['bookid'] == $bookid){
		
			$strBookUser = $new['book']->find('book_user',array(
				'userid'=>$userid,
				'bookid'=>$bookid,
			));
			
			if($strBook['userid'] != $userid && $strBook['userid']==$nuserid){
			
			
				if($strBookUser['isadmin']==1){
				
					$new['book']->update('book_user',array(
						'userid'=>$userid,
						'bookid'=>$bookid,
					),array(
					
						'isadmin'=>0,
					
					));
				
				}elseif($strBookUser['isadmin']==0){
				
					$new['book']->update('book_user',array(
						'userid'=>$userid,
						'bookid'=>$bookid,
					),array(
					
						'isadmin'=>1,
					
					));
				
				}
				
				echo '1';exit;
			
			
			}else{
			
				echo '0';exit;
			
			}
			
			
			
		
		}else{
			
			echo '0';exit;
		
		}
	
		break;
	
	//删除成员
	
}