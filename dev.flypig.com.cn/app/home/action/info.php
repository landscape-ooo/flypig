<?php 
defined('IN_TS') or die('Access Denied.');

header('Location: '.tsUrl('index'));

$keys = tsFilter($_GET['key']);

$strInfo = $new['home']->find('home_info',array(
	'infokey'=>$keys,
));

$arrInfo = $new['home']->findAll('home_info');

$title = $strInfo['title'];

include template('info');