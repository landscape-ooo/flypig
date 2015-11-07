<?php
defined('IN_TS') or die('Access Denied.');  

class index extends tsApp{
	
	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	public function isRun($appflag){
		$isindex = $this->findCount('index_type',array(
			'appflag'=>$appflag,
			'status'=>'1'
		));
		if($isindex>0){
			return true;
		}
		return false;
	}
	//添加index
	public function add($userid,$action,$data){
		$userid = intval($userid);
		if(!isset($action) || empty($action)){
			return false;
		}
		$strType = $this->find('index_type',array(
			'typeflag'=>$action
		));
		if(!$strType){
			return false;
		}
		$typeid = $strType['typeid'];
		$appflag = $strType['appflag'];
		$arrData = array();
		foreach($data as $key=>$value){
			$arrData[$key] = $value; 
		}
		if($arrData['id']){
			$jsondata = json_encode($arrData);
			$serializedata = serialize($arrData);
			//入库
			$this->create('index',array(
				'userid'=>$userid,
				'typeid'=>$typeid,
				'appflag'=>$appflag,
				'appid'=>$arrData['id'],
				'jsondata'=>$jsondata,
				'serializedata'=>$serializedata,
				'addtime'=>time()
			));
			return true;
		}
		return false;
	}
	
	//删除分享
	public function del($action,$appid){
		$appid = intval($appid);
		if(!isset($action) || empty($action) || empty($appid)){
			return false;
		}
		$strType = $this->find('index_type',array(
			'typeflag'=>$action
		));
		if(!$strType){
			return false;
		}
		$typeid = $strType['typeid'];
		$appflag = $strType['appflag'];
		
		$this->update('index',array(
			'typeid'=>$typeid,
			'appflag'=>$appflag,
			'appid'=>$appid
		),array(
			'status'=>0,
		));
		return true;
	}
	
}
