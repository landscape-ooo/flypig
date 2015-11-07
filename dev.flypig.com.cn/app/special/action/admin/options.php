<?php
defined('IN_TS') or die('Access Denied.');
/* 
 * 配置选项
 */	

switch($ts){
	//基本配置
	case "":
		$arrOptions = $new['special']->findAll('special_options');
		foreach($arrOptions as $item){
			$strOption[$item['optionname']] = $item['optionvalue'];
		}
		
		include template("admin/options");
		
		break;
		
	case "do":
	
		$arrData = array(
			'appname' => tsClean($_POST['appname']),
			'appdesc' => tsClean($_POST['appdesc']),
			'iscreate' => intval($_POST['iscreate']),
			'isaudit' => intval($_POST['isaudit']),
			'needcredit' => trim($_POST['needcredit']),
			
		);
	
		foreach ($arrData as $key => $val){
			if($val!=''){
				$new['special']->update('special_options', array(
					'optionname'=>$key,
				), array(
					'optionvalue'=>$val,
				));
			}
			
		}
		
		//更新缓存
		$arrOptions = $db->fetch_all_assoc("select optionname,optionvalue from ".dbprefix."special_options");
		$arrOptions = $new['special']->findAll('special_options', null, null, 'optionname,optionvalue');
		foreach($arrOptions as $item){
			$arrOption[$item['optionname']] = $item['optionvalue'];
		}
		
		fileWrite('special_options.php','data',$arrOption);
		$tsMySqlCache->set('special_options',$arrOption);
		
		qiMsg("专题配置修改成功！");
		
		break;
}