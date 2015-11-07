<?php
defined ( 'IN_TS' ) or die ( 'Access Denied.' );

$userid = aac ( 'user' )->isLogin ();

$articleid = intval ( $_GET ['articleid'] );

$strArticle = $new ['article']->find ( 'article', array (
		'articleid' => $articleid 
) );

if ($strArticle ['userid'] == $userid || $TS_USER ['user'] ['isadmin'] == 1) {
	$new ['article']->delete ( 'article', array (
			'articleid' => $articleid 
	) );
	$new ['article']->delete ( 'article_comment', array (
			'articleid' => $articleid 
	) );
	$new ['article']->delete ( 'article_recommend', array (
			'articleid' => $articleid 
	) );
}

header ( 'Location: ' . tsUrl ( 'article' ) );