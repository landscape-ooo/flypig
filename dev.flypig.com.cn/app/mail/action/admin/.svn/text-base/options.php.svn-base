<?php
defined('IN_TS') or die('Access Denied.');

//管理员是否登录
$userid = aac('user')->isAdminLogin();

/* 
 * 配置选项
 */
$arrOptions = $db->fetch_all_assoc("select * from ".dbprefix."mail_options");

foreach($arrOptions as $item){
	$strOption[$item['optionname']] = $item['optionvalue'];
}

include template("admin/options");