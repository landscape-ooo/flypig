<?php
defined('IN_TS') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch($ts){

	//编辑分享
	case "":
		$shareid = intval($_GET['shareid']);
		
		if($shareid == 0){
			tsNotice('参数错误','',tsUrl('share'),true);
		}
		
		//主表
		$strShare = $new['share']->find('share', array(
				'shareid'=>$shareid
		));
		if(!$strShare){
			tsNotice('分享不存在','',tsUrl('share'),true);
		}
		$strShare['title'] = $strShare['title'];
		
		//附表
		$strShare['content'] = '';
		$strShareAdd = $new['share']->find('share_add', array(
			'shareid'=>$shareid
		));
		if($strShareAdd){
			$strShare['content'] = $strShareAdd['content'];
		}
		
		//获取用户分享分类
		$arrCate = $new['share']->findAll('share_cate',array(
			'userid'=>$userid
		));
		
		if($strShare['userid'] != $userid && $TS_USER['user']['isadmin']!='1'){
			tsNotice('权限错误','',tsUrl('share','show',array('shareid'=>$shareid)),true);
		}
		
		//找出TAG
		$arrTags = aac('tag')->getObjTagByObjid('share', 'shareid', $shareid);
		foreach($arrTags as $key=>$item){
			$arrTag[] = $item['tagname'];
		}
		$strShare['tag'] = array_to_str($arrTag);
		
		$title = '编辑分享';

		include template("edit");
		break;
		
	//编辑分享执行
	case "do":
		//验证token
		if(!isset($_POST['token']) || $_POST['token']!=$_SESSION['token']) {
			tsNotice('非法操作！');
		}
		//验证码
		if ($TS_SITE['base']['isauthcode']){
			$authcode = isset($_POST['authcode']) ? strtolower($_POST['authcode']) : '';
			if ($authcode != $_SESSION ['verify']) {
				tsNotice("验证码输入有误，请重新输入！" );
			}
		}
		
		$shareid = intval($_POST['shareid']);
		if(empty($shareid)){
			tsNotice("参数错误!");
		}
		
		$title = tsClean($_POST['title']);
		$content = htmlClean($_POST['content']);
		
		if($title == '' || $content == '') {
			tsNotice('标题、内容不允许为空！' );
		}
		
		//检测分享数据
		$strShare = $new['share']->find('share',array(
				'shareid' => $shareid
		));
		if(!$strShare){
			tsNotice('分享不存在');
		}
		if($strShare['userid']!=$userid && $TS_USER['user']['isadmin']!='1'){
			tsNotice('权限错误');
		}
		
		//收集其它数据
		$cateid = intval($_POST['cateid']);
		$summary = cututf8(t($_POST['content']),'0','250');
		$nowtime = time();
		
		/*
		if($TS_USER['user']['isadmin']=='0'){
			aac('system')->antiWord($title);
			aac('system')->antiWord($content);
		}
		*/
		
		$isaudit = '0';
		if($TS_APP['options']['isaudit'] == '0' || $TS_USER['user']['isadmin']=='1'){
			$isaudit = '1';
		}
		
		//更新主表
		$new['share']->update('share',array(
			'shareid' => $shareid
		),array(
			'title' => $title,
			'cateid' => $cateid,
			'summary' => $summary,
			'isaudit' => $isaudit,
			'uptime' => $nowtime
		));
		//内容表
		$new['share']->replace('share_add',array(
			'shareid' => $shareid
		),array(
			'shareid' => $shareid,
			'content' => $content
		));
		
		//上传头图
		if($_FILES['photo']){
			//删除原图
			if($strShare['path']){
				unlink('uploadfile/share/'.$strShare['photo']);
			}
			
			$arrUpload = tsUpload($_FILES['photo'],$shareid,'share',array('jpg','gif','png','jpeg'));
			if($arrUpload){
				//删除缓存
				rmrf('cache/share');
				$new['share']->update('share',array(
					'shareid' => $shareid
				),array(
					'path' => $arrUpload['path'],
					'photo' => $arrUpload['url']
				));
				tsDimg($arrUpload['url'], 'share', '220', '165', $arrUpload ['path'] );
			}
		}
		
		//处理标签
		$tag = trim($_POST['tag']);
		if($tag){
			aac('tag')->delIndextag('share','shareid',$shareid);
			aac('tag')->addTag('share', 'shareid', $shareid, $tag);
		}
		
		header("Location: ".tsUrl('share','show',array('id'=>$shareid)));
		break;

}