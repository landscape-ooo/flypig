<?php
defined('IN_TS') or die('Access Denied.');
class event extends tsApp{
	
	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	
	//根据cateid获取一个分类信息
	public function getOneCate($cateid){
		if(isset($cateid) && !empty($cateid)){
			$rowCate = $this->find('event_cate', array(
				'cateid'=>$cateid
			));
			if($rowCate) return $rowCate;
		}
		return false;
	}
	
	//通过eventid获取活动基本信息
	public function getOneEvent($eventid){
		$strEvent = $this->find('event',array(
			'eventid'=>$eventid
		));
		if(!$strEvent){
			return false;
		}
		//活动类型
		$strEvent['catename'] = '';
		if($strEvent['cateid']){
			$strCate = $this->find('event_cate',array(
				'cateid'=>$strEvent['cateid']
			));
			$strEvent['catename'] = $strCate['catename'];
		}
		//活动开始时间
		$time_start = isset($strEvent['time_start']) ? intval($strEvent['time_start']) : 0;
		if($time_start > 0 && $time_start != '1970'){
			$strEvent['time_start'] = date('Y-m-d H:i',strtotime($strEvent['time_start']));
		}else{
			$strEvent['time_start'] = '';
		}
		//活动结束时间
		$time_end = isset($strEvent['time_end']) ? intval($strEvent['time_end']) : 0;
		if($time_end > 0 && $time_end != '1970'){
			$strEvent['time_end'] = date('Y-m-d H:i',strtotime($strEvent['time_end']));
		}else{
			$strEvent['time_end'] = '';
		}
		//活动海报
		if($strEvent['photo'] && $strEvent['path']){
			$strEvent['src'] = SITE_URL."uploadfile/event/".$strEvent['photo'];
			$strEvent['thumb'] = tsXimg($strEvent['photo'],'event',220,165,$strEvent['path']);
		}else{
			$strEvent['thumb'] = SITE_URL."public/images/event.jpg";
			$strEvent['src'] = SITE_URL."public/images/event.jpg";
		}
		return $strEvent;
	}
	//获取省市区
	public function getEventPCA($separator,$provinceid,$cityid,$areaid){
		if(!isset($separator)) $separator= '';
		$arrPCA = array();
		//省份
		if($provinceid){
			$strProvince = $this->find('area_province',array(
				'provinceid'=>$provinceid,
			));
			if($strProvince){
				$arrPCA[] = $strProvince['province'];
			}
		}
		//城市 
		if($cityid){
			$strCity = $this->find('area_city',array(
				'cityid'=>$cityid,
			));
			if($strCity){
				$arrPCA[] = $strCity['city'];
			}
		}
		//区域 
		if($areaid){
			$strArea = $this->find('area',array(
				'areaid'=>$areaid,
			));
			if($strArea){
				$arrPCA[] = $strArea['area'];
			}
		}
		$arrPCA = array_unique($arrPCA);
		return implode($separator,$arrPCA);
	}
	//更新活动评论数
	public function updateCommentCnt($eventid,$pattern=1){
		$strEvent = $this->find('event',array(
			'eventid'=>$eventid,
		));
		if($strEvent){
			$count_comment = intval($strEvent['count_comment']) + intval($pattern);
			$this->update('event',array(
				'eventid'=>$eventid
			),array(
				'count_comment'=>$count_comment
			));
		}
		return true;
	}
}