<?php 
defined('IN_TS') or die('Access Denied.');

$isbookadd = $new['book']->findCount('book_add',array(
				'bookid'=>888,
				'addtype'=>1,
			));
var_dump($isbookadd);
?>