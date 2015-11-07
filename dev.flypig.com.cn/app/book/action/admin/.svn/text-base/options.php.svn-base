<?php
defined('IN_TS') or die('Access Denied.');
/* 
 * 配置选项
 */	

switch($ts){
	//基本配置
	case "":
		$arrOptions = $db->fetch_all_assoc("select * from ".dbprefix."book_options");
		foreach($arrOptions as $item){
			$strOption[$item['optionname']] = $item['optionvalue'];
		}
		
		include template("admin/options");
		
		break;
		
	case "do":
	
		$joinnum = intval($_POST['joinnum']);
	
		if($joinnum == 0) qiMsg('加入图书数不能为0！');
	
		$arrData = array(
			'appname' => t($_POST['appname']),
			'appdesc' => t($_POST['appdesc']),
			'iscreate' => t($_POST['iscreate']),
			'isaudit' => t($_POST['isaudit']),
			'needcredit' => trim($_POST['needcredit']),
			'joinnum' => $joinnum,
		);
	
		foreach ($arrData as $key => $val){
			if($val!=''){
				$db->query("UPDATE ".dbprefix."book_options SET optionvalue='$val' where optionname='$key'");
			}
			
		}
		
		//更新缓存
		$arrOptions = $db->fetch_all_assoc("select optionname,optionvalue from ".dbprefix."book_options");
		foreach($arrOptions as $item){
			$arrOption[$item['optionname']] = $item['optionvalue'];
		}
		
		fileWrite('book_options.php','data',$arrOption);
		$tsMySqlCache->set('book_options',$arrOption);
		
		qiMsg("图书配置修改成功！");
		
		break;
}