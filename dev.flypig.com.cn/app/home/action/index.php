<?php
defined('IN_TS') or die('Access Denied.');

if(!isset($TS_USER['user']['isadmin']) || $TS_USER['user']['isadmin']!='1'){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	echo 'No APP 404 Page！';
	exit;
}

$title = $TS_SITE['base']['site_subtitle'];

if($TS_CF['mobile']) $sitemb = tsUrl('moblie');

include template("index");