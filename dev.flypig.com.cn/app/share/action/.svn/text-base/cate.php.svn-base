<?php
defined('IN_TS') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin ();

/*
 * 增加分类
*/
switch($ts){
	//分类列表
	case "list":
		$arrCate = $new['share']->findAll('share_cate',array(
			'userid'=>$userid,
			'status'=>'1'
		));
		
		$title = '我的分类';
		include template("cate_list");
		break;
	//分类添加
	case "add":
		$title = '添加分类';
		include template("cate_add");
		break;
		
	//分类添加执行
	case "add_do":
		//验证token
		if(!isset($_POST['token']) || $_POST['token'] != $_SESSION['token']) {
			tsNotice('非法操作！');
		}
		$catename = trim(tsClean($_POST['catename']));
		if($catename==''){
			tsNotice('分类名不能为空！');
		}
		$arrData = array(
			'userid' => $userid,
			'catename' => $catename
		);
		$new['share']->create('share_cate',$arrData);
		header("Location: ".tsUrl('share','cate',array('ts'=>'list')));
		break;
		
	//分类内容修改
	case "edit":
		$cateid = intval($_GET['cateid']);
		$strCate = $new['share']->find('share_cate', array(
			'userid'=>$userid,
			'cateid'=>$cateid
		));
		if(!$strCate){
			tsNotice('分类不存在！');
		}
		//验证权限
		if($TS_USER['user']['userid'] != $strCate['userid'] && $TS_USER['user']['isadmin'] != '1'){
			tsNotice('非法权限！');
		}
		
		$title = '编辑分类';
		include template("cate_edit");
		break;
		
	//分类内容修改执行
	case "edit_do":
		$cateid = intval($_POST['cateid']);
		$strCate = $new['share']->find('share_cate', array(
			'userid'=>$userid,
			'cateid'=>$cateid
		));
		
		if(!$strCate){
			tsNotice('分类不存在！');
		}
		//验证权限
		if($TS_USER['user']['userid'] != $strCate['userid'] && $TS_USER['user']['isadmin'] != '1'){
			tsNotice('非法权限！');
		}
		
		//验证token
		if(!isset($_POST['token']) || $_POST['token'] != $_SESSION['token']) {
			tsNotice('非法操作！');
		}
		
		$catename = trim($_POST['catename']);
		$new['share']->update('share_cate',array(
			'userid'=>$userid,
			'cateid'=>$cateid
		), array(
			'catename'=>$catename
		));
		header("Location: ".tsUrl('share','cate',array('ts'=>'list')));
		break;
		
	//分类删除
	case "del":
		$cateid = intval($_GET['cateid']);
		$strCate = $new['share']->find('share_cate', array(
			'userid'=>$userid,
			'cateid'=>$cateid
		));
		
		if(!$strCate){
			tsNotice('分类不存在！');
		}
		//验证权限
		if($TS_USER['user']['userid'] != $strCate['userid'] && $TS_USER['user']['isadmin'] != '1'){
			tsNotice('非法权限！');
		}
		
		//验证token
		if(!isset($_GET['token']) || $_GET['token'] != $_SESSION['token']) {
			tsNotice('非法操作！');
		}
		
		//首先判断该分类下 有没有问答
		$numCateShare = $new['share']->findAll('share',array(
			'cateid'=>$cateid,
		));
		if(count($numCateShare)>0){
			tsNotice("分类下还有分享，不允许删除！");
		}
		
		$new['share']->delete('share_cate',array(
			'cateid'=>$cateid,
		));
		
		header("Location: ".tsUrl('share','cate',array('ts'=>'list')));
		break;
}