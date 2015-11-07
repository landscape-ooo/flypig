<?php
defined('IN_TS') or die('Access Denied.');
/* 
 * 配置选项
 */	

switch($ts){
	//基本配置
	case "":
		$arrOptions = $new['event']->findAll('event_options');
		foreach($arrOptions as $item){
			$strOption[$item['optionname']] = $item['optionvalue'];
		}
		
		include template("admin/options");
		
		break;
		
	case "do":
	
		$arrData = array(
			'appname' => t($_POST['appname']),
			'appdesc' => t($_POST['appdesc']),
			'iscreate' => t($_POST['iscreate']),
			'isaudit' => t($_POST['isaudit']),
			'needcredit' => trim($_POST['needcredit']),
			
		);
	
		foreach ($arrData as $key => $val){
			if($val!=''){
				$new['event']->update('event_options', array(
					'optionname'=>$key,
				), array(
					'optionvalue'=>$val,
				));
			}
			
		}
		
		//更新缓存
		$arrOptions = $db->fetch_all_assoc("select optionname,optionvalue from ".dbprefix."event_options");
		$arrOptions = $new['event']->findAll('event_options', null, null, 'optionname,optionvalue');
		foreach($arrOptions as $item){
			$arrOption[$item['optionname']] = $item['optionvalue'];
		}
		
		fileWrite('event_options.php','data',$arrOption);
		$tsMySqlCache->set('event_options',$arrOption);
		
		qiMsg("活动配置修改成功！");
		
		break;
}