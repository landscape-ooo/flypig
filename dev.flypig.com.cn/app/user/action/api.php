<?php
/*
 * API单入口
 */
 

if(is_file(__APP_API__.'/'.$api.'.php')){
		require_once(__APP_API__.'/'.$api.'.php');
}else{
		qiMsg('sorry:no index!');
}

