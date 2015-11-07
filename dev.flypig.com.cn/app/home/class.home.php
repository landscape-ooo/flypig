<?php
defined('IN_TS') or die('Access Denied.');  

class home extends tsApp{
	
	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	
	//添加home
	function add($userid,$appflag,$appdata){
		$userid = intval($userid);
		if(!isset($action) || empty($action)){
			return;
		}
		$strCate = $this->find('index_type',array(
			'action'=>$action
		));
		if($strCate){
			$typeid = $strCate['typeid'];
			foreach($data as $key=>$value){
				$testJSON[$key] = urlencode($value); 
			}
			$data = json_encode($testJSON);
			
			$this->create('index',array(
				'typeid'=>$typeid,
				'userid'=>$userid,
				'data'=>$data,
				'addtime'=>time(),
			));
			
		}
	}
	
}
