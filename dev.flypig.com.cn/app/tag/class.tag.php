<?php
defined('IN_TS') or die('Access Denied.');
class tag extends tsApp{
	
	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	
	//添加多个标签 
	function addTag($objname,$idname,$objid,$tags){
	
		if($objname != '' && $idname != '' && $objid!='' && $tags!=''){
			$tags = preg_replace ( '/[，\s]/', ',', $tags );
			$arrTag = explode(',',$tags);
			foreach($arrTag as $item){
				$tagname = t($item);
				if(strlen($tagname) < '32' && $tagname != ''){
					$uptime = time();
					
					$tagcount = $this->findCount('tag',array(
						'tagname'=>$tagname,
					));
					
					if($tagcount == '0'){
						
						$tagid = $this->create('tag',array(
							'tagname'=>$tagname,
							'uptime'=>$uptime,
						));
						
						$tagIndexCount = $this->findCount('tag_'.$objname.'_index',array(
							$idname=>$objid,
							'tagid'=>$tagid,
						));
						
						if($tagIndexCount == '0'){
							
							$this->create("tag_".$objname."_index",array(
								$idname=>$objid,
								'tagid'=>$tagid,
							));
							
						}
						
						$tagIdCount = $this->findCount("tag_".$objname."_index",array(
							'tagid'=>$tagid,
						));
						
						$count_obj = "count_".$objname;
						
						$this->update('tag',array(
							'tagid'=>$tagid,
						),array(
							$count_obj=>$tagIdCount,
						));
						
					}else{

						$tagData = $this->find('tag',array(
							'tagname'=>$tagname,
						));
						
						$tagIndexCount = $this->findCount("tag_".$objname."_index",array(
							$idname=>$objid,
							'tagid'=>$tagData['tagid'],
						));
						
						if($tagIndexCount == '0'){
							
							$this->create("tag_".$objname."_index",array(
							
								$idname=>$objid,
								'tagid'=>$tagData['tagid'],
							
							));
							
						}
						
						$tagIdCount = $this->findCount("tag_".$objname."_index",array(
							'tagid'=>$tagData['tagid'],
						));
						
						$count_obj = "count_".$objname;
						
						$this->update('tag',array(
							'tagid'=>$tagData['tagid'],
						),array(
							$count_obj=>$tagIdCount,
							'uptime'=>$uptime,
						));
						
					}
					
				}
			}
		}
	}
	
	//通过topic获取tag
	function getObjTagByObjid($objname,$idname,$objid){
	
		$arrTagIndex = $this->findAll("tag_".$objname."_index",array(
			$idname=>$objid,
		));
		
		if(is_array($arrTagIndex)){
			foreach($arrTagIndex as $item){
				$strTag = $this->getOneTag($item['tagid']);
				if($strTag){
					$arrTag[] = $strTag;
				}
			}
		}
		
		return $arrTag;
		
	}
	
	//通过tagid获得tagname
	function getOneTag($tagid){
		
		$tagData = $this->find('tag',array(
			'tagid'=>$tagid,
		));
		
		return $tagData;
	}
	
	//通过tagname获取tagid
	function getTagId($tagname){

		$strTag = $this->find('tag',array(
			'tagname'=>$tagname,
		));
		
		return intval($strTag['tagid']);
	}
	
	//统计标签
	function countObjTag($objname,$tagid){
		$countObj = $this->findCount("tag_".$objname."_index",array(
			'tagid'=>$tagid,
		));
		$this->update('tag',array(
			'tagid'=>$tagid,
		),array(
			'count_'.$objname=>$countObj,
		));
		
	}
	
	//删除项目ID所有标签
	function delIndextag($objname,$idname,$objid){
		$cntTag = 0;
		$count_obj = "count_".$objname;
		$arrTagIndex = $this->findAll("tag_".$objname."_index",array(
			$idname=>$objid,
		));
		if(is_array($arrTagIndex)){
			foreach($arrTagIndex as $item){
				$strTag = $this->getOneTag($item['tagid']);
				if($strTag){
					$cntTag = $strTag[$count_obj];
				}
				$this->delete("tag_".$objname."_index",array(
					'tagid'=>$item['tagid'],
				));
				$uptime = time();
				$this->update('tag',array(
					'tagid'=>$item['tagid'],
				),array(
					$count_obj=>$cntTag,
					'uptime'=>$uptime,
				));

			}
		}
		return true;
	}
	
	//删除一个标签
	function delOneTag($objname,$idname,$objid,$tagid){
		$tagIdCount = 0;
		$count_obj = "count_".$objname;
		$tagData = $this->getOneTag($tagid);
		if($tagData){
			$uptime = time();
			$this->delete("tag_".$objname."_index",array(
				'tagid'=>$tagid,
			));
			$tagIdCount = $tagData[$count_obj]-1;
			if($tagIdCount < 0){
				$tagIdCount = 0;
			}
			$this->update('tag',array(
				'tagid'=>$tagid,
			),array(
				$count_obj=>$tagIdCount,
				'uptime'=>$uptime,
			));
			return true;
		}
		return false;
	}
	
}