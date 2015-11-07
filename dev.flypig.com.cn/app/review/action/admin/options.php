<?php
defined('IN_TS') or die('Access Denied.');
/* 
 * 配置选项
 */	

switch($ts){
	//基本配置
	case "":
		$arrOptions = $db->fetch_all_assoc("select * from ".dbprefix."review_options");
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
		);
	
		foreach ($arrData as $key => $val){
			if($val!=''){
				$db->query("UPDATE ".dbprefix."review_options SET optionvalue='$val' where optionname='$key'");
			}
			
		}
		
		//更新缓存
		$arrOptions = $db->fetch_all_assoc("select optionname,optionvalue from ".dbprefix."review_options");
		foreach($arrOptions as $item){
			$arrOption[$item['optionname']] = $item['optionvalue'];
		}
		
		fileWrite('review_options.php','data',$arrOption);
		$tsMySqlCache->set('review_options',$arrOption);
		
		qiMsg("书评配置修改成功！");
		
		break;
}