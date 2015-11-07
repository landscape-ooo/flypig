<?php 
defined('IN_TS') or die('Access Denied.');

function ueditor($loadjs='load'){
		if($loadjs!='load'){
			$loadjs='load_'.$loadjs;
		}
		echo "<script type=\"text/javascript\">\r\n";
		echo "	window.UEDITOR_HOME_URL = \"".SITE_URL."plugins/pubs/ueditor/\";\r\n";
		echo "</script>\r\n";
		echo "<script type=\"text/javascript\" charset=\"utf-8\" src=\"".SITE_URL."plugins/pubs/ueditor/ueditor.config.js\"></script>\r\n";
		echo "<script type=\"text/javascript\" charset=\"utf-8\" src=\"".SITE_URL."plugins/pubs/ueditor/ueditor.all.js\"></script>\r\n";
		echo "<script type=\"text/javascript\" charset=\"utf-8\" src=\"".SITE_URL."plugins/pubs/ueditor/lang/zh-cn/zh-cn.js\"></script>\r\n";
		echo "<script type=\"text/javascript\" charset=\"utf-8\" src=\"".SITE_URL."plugins/pubs/ueditor/".$loadjs.".js\"></script>\r\n";
}

if($_SESSION['tsuser']){
	addAction('tseditor','ueditor');
}