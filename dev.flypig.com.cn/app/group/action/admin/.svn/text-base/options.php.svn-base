<?php
defined('IN_TS') or die('Access Denied.');
/* 
 * 配置选项
 */

//管理员是否登录
$userid = aac('user')->isAdminLogin();

switch($ts){
	//基本配置
	case "":
		$arrOptions = $new['group']->findAll('group_options');
		foreach($arrOptions as $item){
			$strOption[$item['optionname']] = stripslashes($item['optionvalue']);
		}
		
		include template("admin/options");
		break;
		
	case "do":
	
		$joinnum = intval($_POST['joinnum']);
		if($joinnum == 0){
			qiMsg('加入小组数不能为0！');
		}
		
		$arrData = array(
			'appname' => t($_POST['appname']),
			'appkey' => t($_POST['appkey']),
			'appdesc' => t($_POST['appdesc']),
			'iscreate' => t($_POST['iscreate']),
			'isaudit' => t($_POST['isaudit']),
			'needcredit' => trim($_POST['needcredit']),
			'joinnum' => $joinnum,
			
			
		);
		foreach ($arrData as $key => $val){
			if($key!='' && $val!=''){
				$new['group']->replace('group_options',array(
					'optionname'=>$key
				),array(
					'optionname'=>$key,
					'optionvalue'=>trim($val)
				));
			}
		}
		
		//更新缓存
		$arrOptions = $new['group']->findAll('group_options',null,null,'optionname,optionvalue');
		foreach($arrOptions as $item){
			$arrOption[$item['optionname']] = $item['optionvalue'];
		}
		
		fileWrite('group_options.php','data',$arrOption);
		$tsMySqlCache->set('group_options',$arrOption);
		
		qiMsg("小组配置修改成功！");
		
		break;
}