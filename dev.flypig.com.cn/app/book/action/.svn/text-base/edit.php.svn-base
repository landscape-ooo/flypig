<?php
//编辑图书信息
defined('IN_TS') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

$bookid = intval($_GET['bookid']);

//图书表信息
$strBook = $new['book']->find('book',array(
	'bookid'=>$bookid,
));
if(!is_array($strBook)){
	tsNotice('参数错误！');
	exit();
}

$strBook['bookname'] = htmlspecialchars(stripslashes($strBook['bookname']));

//图书用户
$strBookUser = $new['book']->find('book_user',array(
	'userid'=>$userid,
	'bookid'=>$bookid,
));

//权限限制
if($TS_USER['user']['isadmin'] != '1' && $strBookUser['isadmin'] != '1' && $strBook['userid'] != $userid){
	tsNotice('非法操作！');
}
switch($ts){
	
	//编辑图书基本信息
	case "base":
		
		//获取类别数据
		$arrCate = $new['book']->getCateList();
		$arrPaper = $arrCate['paper']['catesub'];
		$arrPacking = $arrCate['packing']['catesub'];
		$arrFormat = $arrCate['format']['catesub'];
		$arrStar = $arrCate['star']['catesub'];
		
		//获取本图书分类
		$arrBookCate = $new['book']->getOneBookCate($bookid);
		$strBook['paper'] = key($arrBookCate['paper']);
		$strBook['packing'] = key($arrBookCate['packing']);
		$strBook['format'] = key($arrBookCate['format']);
		$strBook['star'] = key($arrBookCate['star']);
		
		//获取出版社数据
		$arrPubhouse = $new['book']->getPubhouseList();
		$strBook['pubhousepuname'] = $arrPubhouse[$strBook['pubhouse']]['puname'];
		
		//获取出版商数据
		$arrCompany = $new['book']->getCompanyList();
		$strBook['companyconame'] = $arrCompany[$strBook['company']]['coname'];
		
		$title = '编辑图书基本信息';
		include template("edit_base");
		
		break;
	
	//编辑图书头像
	case "icon":

		$title = '修改图书封面';
		include template("edit_icon");
		
		break;
	
	//编辑图书图片
	case "photo":
		
		$bookid = intval($_GET['bookid']);
		
		$arrBookPhoto = array();
		$arrBookPhotos = $new['book']->findAll('book_photo',array(
			'bookid'=>$bookid
		));
		foreach($arrBookPhotos as $k=>$v){
			if($v['photourl'] && $v['path']){
				$arrBookPhoto[$k] = array(
					'id' => $v['photoid'],
					'src' => SITE_URL.'uploadfile/bookphoto/' . $v['photourl'],
					'thumb' => tsXimg($v['photourl'],'bookphoto',150,150,$v['path'],0),
					'name' => $v['photoname'],
					'desc' => $v['photodesc']
				);
			}
		}
		$addtime = time();
		
		$title = '修改图书内页';
		include template("edit_photo");
		
		break;
	
	//图书分类
	case "cate":
		
		//注:数据在视图页面ajax获得
		
		$title = '编辑图书分类';
		include template("edit_cate");
		
		break;
		
	//编辑图书内容介绍
	case "intro":
		$strBook['addtype'] = 1;
		$strBook['addcontent'] = '';
		$arrAdd = $new['book']->getOneBookAdd($bookid,$strBook['addtype']);
		if($arrAdd){
			$strBook['addcontent'] = htmlspecialchars(stripslashes($arrAdd['content']));
		}
		
		$title = '修改内容介绍';
		$addtypename = '内容介绍';
		include template("edit_add");
		
		break;
		
	//编辑图书专家推荐
	case "recommend":
		$strBook['addtype'] = 2;
		$strBook['addcontent'] = '';
		$arrAdd = $new['book']->getOneBookAdd($bookid,$strBook['addtype']);
		if($arrAdd){
			$strBook['addcontent'] = htmlspecialchars(stripslashes($arrAdd['content']));
		}
		
		$title = '修改专家推荐';
		$addtypename = '专家推荐';
		include template("edit_add");
		
		break;
		
	//编辑图书图画赏析
	case "art":
		$strBook['addtype'] = 3;
		$strBook['addcontent'] = '';
		$arrAdd = $new['book']->getOneBookAdd($bookid,$strBook['addtype']);
		if($arrAdd){
			$strBook['addcontent'] = htmlspecialchars(stripslashes($arrAdd['content']));
		}
		
		$title = '修改图画赏析';
		$addtypename = '图画赏析';
		include template("edit_add");
		
		break;
	//编辑图书权限设置
	case "set":
		
		$title = '修改图书设置';
		include template("edit_set");
		
		break;
	
	//修改访问权限
	case "privacy":

		$title = '编辑图书权限';
		include template("edit_privacy");
		
		break;
	
	//友情图书
	case "friends":

		$title = '编辑友情链接';
		include template("edit_friends");
		
		break;
		
	//书评分类
	case "type":
		//调出类型
		$arrBookType = $new['book']->findAll('review_type',array(
			'bookid'=>$strBook['bookid'],
		));
		
		$title = '编辑书评分类';
		include template("edit_type");
		
		break;
		
}
