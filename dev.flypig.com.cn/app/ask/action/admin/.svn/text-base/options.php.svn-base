<?php
defined('IN_TS') or die('Access Denied.');
/* 
 * 配置选项
 */	

switch($ts){
	//基本配置
	case "":
		$arrOptions = $new['ask']->findAll('ask_options');
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
				$new['ask']->update('ask_options', array(
					'optionname'=>$key,
				), array(
					'optionvalue'=>$val,
				));
			}
			
		}
		
		//更新缓存
		$arrOptions = $db->fetch_all_assoc("select optionname,optionvalue from ".dbprefix."ask_options");
		$arrOptions = $new['ask']->findAll('ask_options', null, null, 'optionname,optionvalue');
		foreach($arrOptions as $item){
			$arrOption[$item['optionname']] = $item['optionvalue'];
		}
		
		fileWrite('ask_options.php','data',$arrOption);
		$tsMySqlCache->set('ask_options',$arrOption);
		
		qiMsg("问答配置修改成功！");
		
		break;
}