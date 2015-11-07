<?php 
defined('IN_TS') or die('Access Denied.');

class photo extends tsApp{

	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	
	//getPhotoForApp
	function getPhotoForApp($photoid){
		$strPhoto = $this->find('photo',array(
			'photoid' => $photoid
		));
		
		return $strPhoto;
	}
	
	function getSamplePhoto($photoid){
		$strPhoto = $this->find('photo',array(
			'photoid' => $photoid
		),'path,photourl');
		
		return $strPhoto;
	}
	
	//是否存在图片 
	public function isPhoto($photoid){
		$photoNum = $this->findCount('photo',array(
			'photoid'=>$photoid,
		));
		
		if($photoNum > 0){
			return true;
		}else{
			return false;
		}
		
	}
	

}