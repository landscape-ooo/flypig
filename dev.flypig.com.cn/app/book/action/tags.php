<?php 
defined('IN_TS') or die('Access Denied.');
$page = isset($_GET['page']) ? $_GET['page'] : '1';

$url = tsUrl('book','tags',array('page'=>''));

$lstart = $page*200-200;

$arrTag = $new['book']->findAll('tag',"`count_review`!=''",null,null,$lstart.',200');

$tagNum = $new['book']->findCount('tag',"`count_review`!=''");

$pageUrl = pagination($tagNum, 200, $page, $url);

$title = '标签';
include template('tags');