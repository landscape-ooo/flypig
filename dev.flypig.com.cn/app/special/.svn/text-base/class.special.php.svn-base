<?php
defined('IN_TS') or die('Access Denied.');
class special extends tsApp{
	
	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	
	//根据cateid获取一个分类信息
	public function getOneCate($cateid){
		if(isset($cateid) && !empty($cateid)){
			$rowCate = $this->find('special_cate', array(
				'cateid'=>$cateid
			));
			if($rowCate) return $rowCate;
		}
		return false;
	}
	
	//通过specialid获取专题基本信息
	public function getOneSpecial($specialid){
		$strSpecial = $this->find('special',array(
			'specialid'=>$specialid
		));
		if(!$strSpecial){
			return false;
		}
		//专题类型
		$strSpecial['catename'] = '';
		if($strSpecial['cateid']){
			$strCate = $this->find('special_cate',array(
				'cateid'=>$strSpecial['cateid']
			));
			$strSpecial['catename'] = $strCate['catename'];
		}
		
		//专题海报
		if($strSpecial['photo'] && $strSpecial['path']){
			$strSpecial['src'] = SITE_URL."uploadfile/special/".$strSpecial['photo'];
			$strSpecial['thumb'] = tsXimg($strSpecial['photo'],'special',220,165,$strSpecial['path']);
		}else{
			$strSpecial['thumb'] = SITE_URL."public/images/special.jpg";
			$strSpecial['src'] = SITE_URL."public/images/special.jpg";
		}
		return $strSpecial;
	}
	
}