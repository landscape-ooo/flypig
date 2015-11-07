<?php 
defined('IN_TS') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch ($ts) {
	
	//加入该图书
	case "join":
		
		$bookid = intval($_GET['bookid']);
		
		//图书信息
		$strBook = $new['book']->find('book',array(
			'bookid'=>$bookid
		));
		
		//管理员可以加入任何图书
		if($TS_USER['user']['isadmin'] != 1){
			
			//除管理员外其他用户都要经过这一关审核
			if($strBook['joinway'] == 1) tsNotice('本图书禁止加入！');
			
			//先统计用户有多少个图书了，50个封顶
			$userBookNum = $new['book']->findCount('book_user',array('userid'=>$userid));
			
			if($userBookNum >= $TS_APP['options']['joinnum']) tsNotice('你加入的图书总数已经到达'.$TS_APP['options']['joinnum'].'个，不能再加入图书！');
			
			$bookUserNum = $new['book']->findCount('book_user',array(
				'userid'=>$userid,
				'bookid'=>$bookid,
			));
			
			if($bookUserNum > 0) tsNotice('你已经加入图书！');
		}
		
		$new['book']->create('book_user',array(
			'userid'=>$userid,
			'bookid'=>$bookid,
			'addtime'=>time(),
		));
		
		//更新
		$count_book = $new['book']->findCount('book_user',array(
			'userid'=>$userid,
		));
		$new['book']->update('user_info',array(
			'userid'=>$userid,
		),array(
			'count_book'=>$count_book,
		));
		
		//计算图书会员数
		$count_user = $new['book']->findCount('book_user',array(
			'bookid'=>$bookid,
		));
		
		//更新图书成员统计
		$new['book']->update('book',array(
			'bookid'=>$bookid,
		),array(
			'count_user'=>$count_user,
		));
		
		header('Location: '.tsUrl('book','show',array('id'=>$bookid)));
		break;
	
	//退出该图书
	case "exit":
		
		if($_GET['token'] != $_SESSION['token']) {
			tsNotice('非法操作！');
		}
		
		$bookid = intval($_GET['bookid']);
		
		//图书信息
		$strBook = $new['book']->find('book',array(
			'bookid'=>$bookid
		));
		
		//判断是否是组长，是组长不能退出图书
		if($strBook['userid'] == $userid) tsNotice('组长任务艰巨，请坚持到底！');
		
		$new['book']->delete('book_user',array(
			'userid'=>$userid,
			'bookid'=>$bookid,
		));
		
		//计算图书会员数
		$count_user = $new['book']->findCount('book_user',array(
			'bookid'=>$bookid,
		));
		
		//更新图书成员统计
		$new['book']->update('book',array(
			'bookid'=>$bookid,
		),array(
			'count_user'=>$count_user,
		));
		
		header('Location: '.tsUrl('book','show',array('id'=>$bookid)));
		
		break;
	
	//编辑图书基本信息
	case "edit_base":
		$bookid = intval($_POST['bookid']);
		
		//图书信息
		$strBook = $new['book']->find('book',array(
			'bookid'=>$bookid,
		));
		if(empty($strBook)) tsNotice("参数错误！");
		
		//图书用户
		$strBookUser = $new['book']->find('book_user',array(
			'userid'=>$userid,
			'bookid'=>$bookid,
		));
		
		//权限限制
		if($TS_USER['user']['isadmin'] != '1' && $strBookUser['isadmin'] != '1' && $userid != $strBook['userid']){
			tsNotice('权限错误！');
		}
		
		$bookname = t($_POST['bookname']);
		if($bookname==''){
			tsNotice("图书名称不能为空！");
		}
		
		$title = t($_POST['title']);
		$description = tsClean($_POST['description']);
		$awardsrecord = tsClean($_POST['awardsrecord']);
		
		$isbn = trim(t($_POST['isbn']));
		$price = trim(t($_POST['price']));
		$pubhouse = trim(t($_POST['pubhouse']));
		$company = trim(t($_POST['company']));
		$pubdate = trim(tsClean($_POST['pubdate']));
		$num_rev = trim(t($_POST['num_rev']));
		$cnt_pages = trim(t($_POST['cnt_pages']));
		$cnt_words = trim(t($_POST['cnt_words']));
		$prtdate = trim(tsClean($_POST['prtdate']));
		$num_print = trim(t($_POST['num_print']));
		
		$dangdangid = trim(t($_POST['dangdangid']));
		$amazonid = trim(t($_POST['amazonid']));
		$jdid = trim(t($_POST['jdid']));
		
		//检测禁用词语
		//aac('system')->antiWord($bookname);
		//aac('system')->antiWord($description);
		
		$isbookname = $new['book']->findCount('book',array(
			'bookname'=>$bookname,
			'bookid <> {$bookid}'
		));
		
		if($isbookname > 0){
			tsNotice('图书名称已经存在！');
		}
		
		$new['book']->update('book',array(
			'bookid'=>$bookid,
		),array(
			'bookname'	=> $bookname,
			'title'		=> $title,
			'description'	=>$description,
			'awardsrecord'	=> $awardsrecord,
			'isbn'	=> $isbn,
			'price'	=> $price,
			'pubhouse'	=> $pubhouse,
			'company'	=> $company,
			'pubdate'	=> $pubdate,
			'num_rev'	=> $num_rev,
			'cnt_pages'	=> $cnt_pages,
			'cnt_words'	=> $cnt_words,
			'prtdate'	=> $prtdate,
			'num_print'	=> $num_print,
			'dangdangid'	=> $dangdangid,
			'amazonid'	=> $amazonid,
			'jdid'	=> $jdid,
		));
		//获取作者数据
		$arrBookAuthor = $new['book']->getOneBookAuthor($bookid);
		foreach($APP_book['authortype'] as $k){
			//获取原作者数据(本图书当前类型作者auid的数组)
			$tmpABA = array_keys($arrBookAuthor[$k]);
			//获取POST作者数组
			$tmpPBA = isset($_POST['author'.$k.'s']) ? $_POST['author'.$k.'s'] : array();
			$com_d1 = array_diff($tmpABA,$tmpPBA);
			$com_d2 = array_diff($tmpPBA,$tmpABA);
			if(isset($tmpPBA) && count($tmpPBA)>0 && (!empty($com_d1) || !empty($com_d2))){
				//移除原数据
				$new['book']->delete('book_author_info',array(
					'autype'=>$k,
					'bookid'=>$bookid,
				));
				//循环添加新数据
				foreach($tmpPBA as $v){
					$new['book']->create('book_author_info',array(
						'bookid'=>$bookid,
						'auid'=>$v,
						'autype'=>$k
					));
				}
			}
		}
		
		//更新单选分类
		$paper = trim(t($_POST['paper']));
		$packing = trim(t($_POST['packing']));
		$format = trim(t($_POST['format']));
		$star = trim(t($_POST['star']));
		
		//获取分类数据
		$arrBookCate = $new['book']->getOneBookCate($bookid);
		$categroup1 = array_diff($APP_book['categroup'],$APP_book['categroup_guide']);	//获取单选分类cateflag数组
		foreach($categroup1 as $val){
			if(!empty(${$val})){
				if(isset($arrBookCate[$val])){
					//更新
					$new['book']->update('book_cate_info',array(
						'bookid'=>$bookid,
						'cateflag'=>$val
					),array(
						'cateid'=>${$val},
					));
				}else{
					//添加
					$new['book']->create('book_cate_info',array(
						'bookid'=>$bookid,
						'cateid'=>${$val},
						'cateflag'=>$val
					));
				}
			}else{
				//移除
				$new['book']->delete('book_cate_info',array(
					'bookid'=>$bookid,
					'cateflag'=>$val
				));
			}
		}
		
		header("Location: ".tsUrl('book','show',array('id'=>$bookid)));
		break;
		
	//上传图书头像
	case "edit_icon":
		
		$bookid = intval($_POST['bookid']);
		
		//图书信息
		$strBook = $new['book']->find('book',array(
			'bookid'=>$bookid,
		));
		if(empty($strBook)){
			tsNotice("参数错误！");
		}
		
		//图书用户
		$strBookUser = $new['book']->find('book_user',array(
			'userid'=>$userid,
			'bookid'=>$bookid,
		));
		
		//权限限制
		if($TS_USER['user']['isadmin'] != '1' && $strBookUser['isadmin'] != '1' && $userid != $strBook['userid']){
			tsNotice('权限错误！');
		}
		
		//上传
		$arrUpload = tsUpload($_FILES['picfile'],$bookid,'book',array('jpg','gif','png'));
		if(!$arrUpload){
			tsNotice("上传失败！");
		}
		$new['book']->update('book',array(
			'bookid'=>$bookid,
		),array(
			'path'=>$arrUpload['path'],
			'photo'=>$arrUpload['url'],
		));
		
		tsDimg($arrUpload['url'],'book','180','0',$arrUpload['path']);
		tsDimg($arrUpload['url'],'book','118','0',$arrUpload['path']);
		
		header("Location: ".tsUrl('book','show',array('id'=>$bookid)));
		break;
		
	//编辑图书分类筛选
	case "edit_cate":
		
		$bookid = intval($_POST['bookid']);
		
		//图书信息
		$strBook = $new['book']->find('book',array(
			'bookid'=>$bookid,
		));
		if(empty($strBook)) tsNotice("参数错误！");
		
		//图书用户
		$strBookUser = $new['book']->find('book_user',array(
			'userid'=>$userid,
			'bookid'=>$bookid,
		));
		
		//权限限制
		if($TS_USER['user']['isadmin'] != '1' && $strBookUser['isadmin'] != '1' && $userid != $strBook['userid']){
			tsNotice('权限错误！');
		}
		//获取作者数据
		$arrBookCate = $new['book']->getOneBookCate($bookid);
		foreach($APP_book['categroup_guide'] as $f){
			${$f} = array(); //定义变量
			if(isset($arrBookCate[$f])){
				${$f} = $arrBookCate[$f];
			}
			//获取原分类
			$tmpABC = array_keys(${$f});
			//获取POST分类数组
			$tmpPBC = isset($_POST[$f.'s']) ? $_POST[$f.'s'] : array();
			$com_d1 = array_diff($tmpABC,$tmpPBC);
			$com_d2 = array_diff($tmpPBC,$tmpABC);
			if(isset($tmpPBC) && count($tmpPBC)>0 && (!empty($com_d1) || !empty($com_d2))){
				//移除原数据
				$new['book']->delete('book_cate_info',array(
					'bookid'=>$bookid,
					'cateflag'=>$f,
				));
				//循环添加新数据
				foreach($tmpPBC as $v){
					$new['book']->create('book_cate_info',array(
						'bookid'=>$bookid,
						'cateid'=>$v,
						'cateflag'=>$f,
					));
				}
			}
		}
		
		header("Location: ".tsUrl('book','show',array('id'=>$bookid)));
		break;
	
	//编辑图书内图
	case "edit_photo":
		
		$bookid = intval($_POST['bookid']);
		
		//图书信息
		$strBook = $new['book']->find('book',array(
			'bookid'=>$bookid,
		));
		if(empty($strBook)) tsNotice("参数错误！");
		
		//图书用户
		$strBookUser = $new['book']->find('book_user',array(
			'userid'=>$userid,
			'bookid'=>$bookid,
		));
		
		//权限限制
		if($TS_USER['user']['isadmin'] != '1' && $strBookUser['isadmin'] != '1' && $userid != $strBook['userid']){
			tsNotice('权限错误！');
		}
		
		$arrIsDelIds = $_POST['isdel'];
		
		$arrPhotoIds = $_POST['photoid'];
		$arrPhotoName = $_POST['photoname'];
		$arrPhotoDesc = $_POST['photodesc'];
		
		if($TS_USER['user']['isadmin'] == 0){
			foreach($arrPhotoDesc as $key=>$item){
				//过滤内容开始
				aac('system')->antiWord($item);
				//过滤内容结束
			}
		}
		
		if(is_array($arrPhotoIds)){
			foreach($arrPhotoIds as $key => $value){
				if(!in_array($value,$arrIsDelIds)){
					$new['book']->update('book_photo',array(
						'bookid'=>$bookid,
						'photoid'=>$value,
					),array(
						'photoname'=>tsClean($arrPhotoName[$key]),
						'photodesc'=>tsClean($arrPhotoDesc[$key]),
					));
				}else{
					$new['book']->delete('book_photo',array(
						'bookid'=>$bookid,
						'photoid'=>$value,
					));
				}
			}
		}
		
		header("Location: ".tsUrl('book','show',array('id'=>$bookid)));
		break;
		
	//批量上传图片执行
	//case "upload_photo":
		//转移至upload.php
		//break;
	
	//编辑图书附加信息
	case "edit_add":
		
		$bookid = intval($_POST['bookid']);
		
		$addtype = intval($_POST['addtype']);
		$addcontent = htmlClean($_POST['addcontent']);
		
		if(empty($addtype) || !in_array($addtype,$APP_book['addtype'])) tsNotice("信息类型错误！");
		
		if($addcontent=='') tsNotice("内容不能为空！");
		
		//过滤内容开始
		//aac('system')->antiWord($addcontent);
		//过滤内容结束
		
		//图书信息
		$strBook = $new['book']->find('book',array(
			'bookid'=>$bookid,
		));
		if(empty($strBook)) tsNotice("参数错误！");
		
		//图书用户
		$strBookUser = $new['book']->find('book_user',array(
			'userid'=>$userid,
			'bookid'=>$bookid,
		));
		
		//权限限制
		if($TS_USER['user']['isadmin'] != '1' && $strBookUser['isadmin'] != '1' && $userid != $strBook['userid']){
			tsNotice('权限错误！');
		}
		//判断是否
		$isbookadd = $new['book']->findCount('book_add',array(
			'bookid'=>$bookid,
			'addtype'=>$addtype,
		));
		$new['book']->replace('book_add',array(
			'bookid'=>$bookid,
			'addtype'=>$addtype,
		),array(
			'bookid'=>$bookid,
			'addtype'=>$addtype,
			'content'=> trim($addcontent),
			'userid'=>$userid,
			'addtime'=>time()
		));
		
		header("Location: ".tsUrl('book','show',array('id'=>$bookid)));
		break;
		
	//编辑图书设置
	case "edit_set":
		
		$bookid = intval($_POST['bookid']);
		tsNotice('功能待开放',null,tsUrl('book','show',array('id'=>$bookid)),true);
		
		//图书信息
		$strBook = $new['book']->find('book',array(
			'bookid'=>$bookid,
		));
		if(empty($strBook)) tsNotice("参数错误！");
		
		//图书用户
		$strBookUser = $new['book']->find('book_user',array(
			'userid'=>$userid,
			'bookid'=>$bookid,
		));
		
		//权限限制
		if($TS_USER['user']['isadmin'] != '1' && $strBookUser['isadmin'] != '1' && $userid != $strBook['userid']){
			tsNotice('权限错误！');
		}
		$new['book']->update('book',array(
			'bookid'=>$bookid,
		),array(
			//'joinway' => intval($_POST['joinway']),
			'ispost' => intval($_POST['ispost']),
			//'isopen' => intval($_POST['isopen']),
			//'ispostaudit' => intval($_POST['ispostaudit']),
		));
		header("Location: ".tsUrl('book','show',array('id'=>$bookid)));
		break;
		
	//审核书评
	case 'audit_review':
		
		$bookid = intval($_GET['bookid']);
		
		//图书信息
		$strBook = $new['book']->find('book',array(
			'bookid'=>$bookid,
		));
		if(empty($strBook)) tsNotice("参数错误！");
		
		//图书用户
		$strBookUser = $new['book']->find('book_user',array(
			'userid'=>$userid,
			'bookid'=>$bookid,
		));
		
		//权限限制
		if($TS_USER['user']['isadmin'] != '1' && $strBookUser['isadmin'] != '1' && $userid != $strBook['userid']){
			tsNotice('权限错误！');
		}
		
		$reviewid = intval($_GET['reviewid']);
		$new['book']->update('review',array(
			'reviewid'=>$reviewid,
		),array(
			'isaudit'=>'1',
		));
		
		//更新书评数
		$new['book']->update('book',array(
			'bookid'=>$bookid,
		),array(
			'`count_review` = `count_review` + 1',
			'`count_review_audit` = `count_review_audit` - 1',
		));
		if($strBook['count_review_audit']>1){
			header("Location: ".tsUrl('book','audit',array('ts'=>'review','bookid'=>$bookid)));
		}else{
			header("Location: ".tsUrl('book','show',array('id'=>$bookid)));
		}
		break;
		
	//*****************************************************************************************************************
	case 'parseurl':
		$url = $_POST['parseurl'];
		$urlArr = parse_url($url);
		$domainArr = explode('.',$urlArr['host']);
		$data['type'] = $domainArr[count($domainArr)-2];
		$str = formPost('http://share.pengyou.com/index.php?mod=usershare&act=geturlinfo',array('url'=>$url));
		echo $str;
	
		break;
		
	//图书邀请用户 
	case "invite":
		
		$iuserid = intval($_POST['userid']);
		$bookid = intval($_POST['bookid']);
		
		if(aac('user')->isUser($iuserid) && $new['book']->isBook($bookid)){
			
			//先统计用户有多少个图书了，20个封顶
			$userBookNum = $new['book']->findCount('book_user',array('userid'=>$iuserid));
			
			if($userBookNum >= 20) tsNotice('邀请用户加入的图书总数已经到达20个，不能再加入图书！');
			
			$bookUserNum = $new['book']->findCount('book_user',array(
				'userid'=>$iuserid,
				'bookid'=>$bookid,
			));
			
			if($bookUserNum > 0) tsNotice('用户已经加入图书！');
			
			$new['book']->create('book_user',array(
				'userid'=>$iuserid,
				'bookid'=>$bookid,
				'addtime'=>time(),
			));
			
			//计算图书会员数
			$count_user = $new['book']->findCount('book_user',array(
				'bookid'=>$bookid,
			));
			
			//更新图书成员统计
			$new['book']->update('book',array(
				'bookid'=>$bookid,
			),array(
				'count_user'=>$count_user,
			));
			
			//发送系统消息开始
			$msg_userid = '0';
			$msg_touserid = $iuserid;
			$msg_content = '你被邀请加入一个图书，快去看看吧<br />'
						.tsUrl('book','show',array('id'=>$bookid));
			aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
			//发送系统消息end
		
			header('Location: '.tsUrl('book','show',array('id'=>$bookid)));
		
		}else{
			tsNotice('倒霉了吧？');
		}
		
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
