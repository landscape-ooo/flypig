<?php
defined('IN_TS') or die('Access Denied.');

//格式化带图片内容
function formatContent($content){
	
	$widthpat = '/<img(\s+)([^>]*)(width(\s*)=(\s*)([\'\"]*)([^>]*)([\'\"]*))(\s+)([^>]*)>/';
	$content = preg_replace($widthpat , '<img $2 width="" $10>' , $content);
	
	$heightpat = '/<img(\s+)([^>]*)(height(\s*)=(\s*)([\'\"]*)([^>]*)([\'\"]*))(\s+)([^>]*)>/';
	$content = preg_replace($heightpat , '<img $2 height="60" $10>' , $content);
	
	return $content;
}

