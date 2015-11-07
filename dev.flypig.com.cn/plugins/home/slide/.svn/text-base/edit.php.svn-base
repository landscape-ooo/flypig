<?php
defined('IN_TS') or die('Access Denied.');
//插件编辑
switch($ts){
	case "set":
	
		$arrData = $new[$app]->findAll('slide');
		
		include 'edit_set.html';
		break;
		
	case "do":
		$title = t($_POST['title']);
		$url = t($_POST['url']);
		
		$slideid = $new[$app]->create('slide',array(
			'title'=>$title,
			'url'=>$url,
			'addtime'=>time(),
		));
		
		
		//上传
		$arrUpload = tsUpload($_FILES['photo'],$slideid,'slide',array('jpg','gif','png','jpeg'));
		
		if($arrUpload){

			$new[$app]->update('slide',array(
				'slideid'=>$slideid,
			),array(
				'path'=>$arrUpload['path'],
				'photo'=>$arrUpload['url'],
			));
		}
		
		header('Location: '.SITE_URL.'index.php?app=home&ac=plugin&plugin=slide&in=edit&ts=set');
		break;
		
	case "delete":
		
		$slideid = intval($_GET['slideid']);
		
		$strSlide = $new[$app]->find('slide',array(
			'slideid'=>$slideid,
		));
		
		unlink('uploadfile/slide/'.$strSlide['photo']);
		
		$new[$app]->delete('slide',array(
			'slideid'=>$slideid,
		));
		
		header('Location: '.SITE_URL.'index.php?app=home&ac=plugin&plugin=slide&in=edit&ts=set');
		
		break;
}