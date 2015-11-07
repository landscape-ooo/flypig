<?php
defined('IN_TS') or die('Access Denied.');
/* 
 * 配置选项
 */	

switch($ts){
	//基本配置
	case "":
		$arrOptions = $db->fetch_all_assoc("select * from ".dbprefix."index_options");
		foreach($arrOptions as $item){
			$strOption[$item['optionname']] = $item['optionvalue'];
		}
		
		include template("admin/options");
		
		break;
		
	case "do":
		
		$arrData = array(
			'appname' => t($_POST['appname']),
			'appdesc' => t($_POST['appdesc'])
		);
		
		foreach ($arrData as $key => $val){
			if($val!=''){
				$db->query("UPDATE ".dbprefix."index_options SET optionvalue='$val' where optionname='$key'");
			}
			
		}
		
		//更新缓存
		$arrOptions = $db->fetch_all_assoc("select optionname,optionvalue from ".dbprefix."index_options");
		foreach($arrOptions as $item){
			$arrOption[$item['optionname']] = $item['optionvalue'];
		}
		
		fileWrite('index_options.php','data',$arrOption);
		$tsMySqlCache->set('index_options',$arrOption);
		
		qiMsg("首页配置修改成功！");
		
		break;
}