<?php
defined('IN_TS') or die('Access Denied.');
//require_once("config.php");

$return_url = '';
if(isset($_GET['return_url'])){
	$return_url = trim(htmlspecialchars(strip_tags($_GET['return_url'])));
}

require_once("API/qqConnectAPI.php");

$qc = new QC();
$qc->qq_login($return_url);