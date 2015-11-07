<?php
header("Content-Type: text/html; charset=utf-8");
    error_reporting( E_ERROR | E_WARNING );
	//adan
	date_default_timezone_set("Asia/chongqing");

	$globalConfig = include( "php/config.php" );
	$fileSavePathConfig = $globalConfig[ 'fileSavePath' ];
	$i = array_rand($fileSavePathConfig, 1);//随机选择一个服务器目录
	$path = $fileSavePathConfig[$i];
	///
	var_dump($path);
?>