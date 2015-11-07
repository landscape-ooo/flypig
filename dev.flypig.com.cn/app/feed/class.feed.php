<?php
defined('IN_TS') or die('Access Denied.');
class feed extends tsApp{


	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	
	//添加feed
	function add($userid,$action,$data){
		$userid = intval($userid);
		if(!isset($action) || empty($action)){
			return false;
		}
		$arrData = array();
		$strCate = $this->find('feed_type',array(
			'typeflag'=>$action
		));
		if(!$strCate){
			return false;
		}
		$typeid = $strCate['typeid'];
		foreach($data as $key=>$value){
			$arrData[$key] = urlencode($value); 
		}
		$jsondata = json_encode($arrData);
		$serializedata = serialize($arrData);
		//入库
		$this->create('feed',array(
			'userid'=>$userid,
			'typeid'=>$typeid,
			'jsondata'=>$jsondata,
			'serializedata'=>$serializedata,
			'addtime'=>time()
		));
		return true;
	}
	
}