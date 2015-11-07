<?php 
defined('IN_TS') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch ($ts) {
	
	//书评审核
	case "audit":
		
		$reviewid = intval($_GET['reviewid']);
		//获取原数据
		$strReview = $new['review']->find('review',array(
			'reviewid'=>$reviewid,
		));
		if(!$strReview){
			tsNotice('书评不存在');
		}
		$isaudit = $strReview['isaudit']=='0' ? '1' : '0';
		//审核或取消
		$new['review']->update('review',array(
			'reviewid'=>$reviewid,
		),array(
			'isaudit'=>$isaudit
		));
		if($isaudit == '0' && $TS_USER['user']['isadmin']!='1'){
			tsNotice('书评取消审核成功！','点击返回',tsUrl('book','show',array('id'=>$strReview['bookid'])));
		}
		header('Location: '.tsUrl('review','show',array('id'=>$reviewid)));
		break;
		
	//书评删除
	case "del":
		
		$reviewid = intval($_GET['reviewid']);
		
		$strReview = $new['review']->find('review',array('reviewid'=>$reviewid));
		
		$bookid = $strReview['bookid'];
		
		$strBook = aac('book')->find('book',array('bookid'=>$bookid));
		
		$strBookUser = aac('book')->find('book_user',array(
			'userid'=>$userid,
			'bookid'=>$bookid,
		));
		
		//系统管理员删除
		if($TS_USER['user']['isadmin'] == '1'){
			$new['review']->delReview($reviewid);
			
			//删除首页推送数据
			aac('index')->del('review_list',$reviewid);
			
			header('Location: '.tsUrl('book'));
			exit;
			
		}
		
		//其他人员删除
		if($userid == $strReview['userid'] || $userid == $strBook['userid'] || $strBookUser['isadmin']=='1'){
			
			$new['review']->update('review',array(
				'reviewid'=>$reviewid,
			),array(
				'status'=>0,
			));
			
			// 扣除用户相应的积分，删除书评扣5分
			aac('user')->delScore($strReview['userid'],'删除书评',5);
			
			//删除首页推送数据
			aac('index')->del('review_list',$reviewid);
			
			tsNotice('你的删除书评申请已经提交！');
			
		}
		
		break;
		
	//置顶书评
	case "istop":
		$reviewid = intval($_GET['reviewid']);
		
		$strReview = $new['review']->find('review',array(
			'reviewid'=>$reviewid,
		));
		if(!$strReview){
			tsNotice("书评不存在！");
		}
		
		$strBook = aac('book')->find('book',array(
			'bookid'=>$strReview['bookid'],
		));
		if(!$strBook){
			tsNotice("关联图书不存在！");
		}
		//验证权限
		if($userid!=$strBook['userid'] && $TS_USER['user']['isadmin']!='1'){
			tsNotice("非法操作！");
		}
		
		$istop = $strReview['istop']=='0' ? '1' : '0';
		$new['review']->update('review',array(
			'reviewid'=>$reviewid,
		),array(
			'istop'=>$istop,
		));
		
		header("Location: ".tsUrl('review','show',array('id'=>$reviewid)));
		break;
	
	//书评标签
	case "review_tag_ajax";
		
		$reviewid = intval($_GET['reviewid']);
		include template("review_tag_ajax");
		break;
	
	//添加书评标签
	case "review_tag_do":
		
		$reviewid = intval($_POST['reviewid']);
		
		if($reviewid == 0) tsNotice("非法操作！");
		
		$tagname = t($_POST['tagname']);
		$uptime	= time();
		
		if($tagname != ''){
		
			if(strlen($tagname) > '32') tsNotice("TAG长度大于32个字节（不能超过16个汉字）");
			
			$tagcount = $db->once_num_rows("select * from ".dbprefix."tag where tagname='".$tagname."'");
			
			if($tagcount == '0'){
				$db->query("INSERT INTO ".dbprefix."tag (`tagname`,`uptime`) VALUES ('".$tagname."','".$uptime."')");
				$tagid = $db->insert_id();
				
				$tagIndexCount = $db->once_num_rows("select * from ".dbprefix."tag_review_index where reviewid='".$reviewid."' and tagid='".$tagid."'");
				if($tagIndexCount == '0'){
					$db->query("INSERT INTO ".dbprefix."tag_review_index (`reviewid`,`tagid`) VALUES ('".$reviewid."','".$tagid."')");
				}
				
				$tagIdCount = $db->once_num_rows("select * from ".dbprefix."tag_review_index where tagid='".$tagid."'");
				
				$db->query("update ".dbprefix."tag set `count_review`='".$tagIdCount."',`uptime`='".$uptime."' where tagid='".$tagid."'");
				
			}else{
				
				$tagData = $db->once_fetch_assoc("select * from ".dbprefix."tag where tagname='".$tagname."'");
				
				$tagIndexCount = $db->once_num_rows("select * from ".dbprefix."tag_review_index where reviewid='".$reviewid."' and tagid='".$tagData['tagid']."'");
				if($tagIndexCount == '0'){
					$db->query("INSERT INTO ".dbprefix."tag_review_index (`reviewid`,`tagid`) VALUES ('".$reviewid."','".$tagData['tagid']."')");
				}
				
				$tagIdCount = $db->once_num_rows("select * from ".dbprefix."tag_review_index where tagid='".$tagData['tagid']."'");
				
				$db->query("update ".dbprefix."tag set `count_review`='".$tagIdCount."',`uptime`='".$uptime."' where tagid='".$tagData['tagid']."'");
				
			}
			
			echo "<script language=JavaScript>parent.window.location.reload();</script>";
			
		}
		
		break;
		
	//书评分类
	case "review_type":
		
		$bookid = intval($_POST['bookid']);
		$typename = t($_POST['typename']);
		if($typename != '')
		  $db->query("insert into ".dbprefix."review_type (`bookid`,`typename`) values ('$bookid','$typename')");
		
		header("Location: ".tsUrl('book','edit',array('bookid'=>$bookid,'ts'=>'type')));
		
		break;
		
	case 'parseurl':
		$url = $_POST['parseurl'];
		$urlArr = parse_url($url);
		$domainArr = explode('.',$urlArr['host']);
		$data['type'] = $domainArr[count($domainArr)-2];
		$str = formPost('http://share.pengyou.com/index.php?mod=usershare&act=geturlinfo',array('url'=>$url));
		echo $str;
	
		break;
		
	//设置精华 
	case "isbrilliant":
		$reviewid = intval($_GET['reviewid']);
		
		$strReview = $new['review']->find('review',array(
			'reviewid'=>$reviewid,
		),'userid,bookid,title,isbrilliant');
		if(!$strReview){
			tsNotice("书评不存在！");
		}
		$strBook =  $new['review']->find('book',array(
			'bookid'=>$strReview['bookid'],
		),'userid');
		if(!$strBook){
			tsNotice("关联图书不存在！");
		}
		//验证权限
		if($userid != $strBook['userid'] && intval($TS_USER['user']['isadmin']) != '1'){
			tsNotice("非法操作！");
		}
		if($strReview['isbrilliant']=='0'){
			$new['review']->update('review',array(
				'reviewid'=>$reviewid,
			),array(
				'isbrilliant'=>'1'
			));
			if($userid != $strReview['userid']){
				//msg start
				$msg_userid = '0';
				$msg_touserid = $strReview['userid'];
				$msg_content = '恭喜，你的书评：《'.$strReview['title'].'》被评为精华帖啦^_^ <br />'.tsUrl('review','show',array('id'=>$reviewid));
				aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
				//msg end
			}
			
		}else{
			$new['review']->update('review',array(
				'reviewid'=>$reviewid,
			),array(
				'isbrilliant'=>'0'
			));
		}
		
		//tsNotice("操作成功！",null,tsUrl('review','show',array('id'=>$reviewid)),true);
		header("Location: ".tsUrl('review','show',array('id'=>$reviewid)));
		break;
		
	//usertips
	case "usertips":
		
		$data = fileRead('data/user_tips.php');
		
		if($data == ''){
			$query = $db->fetch_all_assoc("select * from " . dbprefix . "user_info");
			foreach($query as $user) {
				$usertip[]=array('user'=>$user['username'],'name'=>$user['userid']);
			}
			fileWrite('user_tips.php','data',json_encode($usertip));
			$data = fileRead('data/user_tips.php');
		}
		
		echo $data;
		
		break;
}
