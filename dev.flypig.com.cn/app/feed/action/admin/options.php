<?php
defined('IN_TS') or die('Access Denied.');

//管理员是否登录
$userid = aac('user')->isAdminLogin();

switch($ts){
	//基本配置
	case "":
		
		$arrOptions = $new['feed']->findAll('feed_options');

		foreach($arrOptions as $item){
			$strOption[$item['optionname']] = stripslashes($item['optionvalue']);
		}
		
		include template("admin/options");
		
		break;
		
	case "do":
		
		foreach($_POST['option'] as $key=>$item){
			$optionname = $key;
			$optionvalue = trim($item);
			
			$new['feed']->replace('feed_options',array(
				'optionname'=>$optionname
			),array(
				'optionname'=>$optionname,
				'optionvalue'=>$optionvalue
			));
		}
		
		$arrOptions = $new['feed']->findAll('feed_options',null,null,'optionname,optionvalue');
		foreach($arrOptions as $item){
			$arrOption[$item['optionname']] = $item['optionvalue'];
		}
		
		fileWrite('feed_options.php','data',$arrOption);
		$tsMySqlCache->set('feed_options',$arrOption);
		
		qiMsg('修改成功！');
		break;
}