<?php 
defined('IN_TS') or die('Access Denied.');

class book extends tsApp{
	
	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	
	//获取筛选分类
	public function getCateList($flag=false){
		global $APP_book;
		$where = " status = 1 ";
		if($flag !== false && in_array($flag, $APP_book['categroup'])){
			$where .= " AND cateflag='".$flag."'";
		}
		$arrCate = array();
		$cateArr = $this->findAll('book_cate', $where, 'orderid asc');
		foreach($cateArr as $key=>$val){
			if($val['referid']==0){
				$arrCate[$val['cateflag']]['cateid'] = $val['cateid'];
				$arrCate[$val['cateflag']]['catename'] = $val['catename'];
			}elseif($val['referid']>0){
				$arrCate[$val['cateflag']]['catesub'][$val['cateid']] = $val;
			}
		}
		return $arrCate;
	}
	
	//获取作者数据，写入缓存
	public function getAuthorList($type=false,$country=0){
		global $APP_book;
		$filename = '';
		$filedir = 'data/book';
		$arrAuthor = array();
		if($type === false){
			if(!$country){
				$filename = 'book_author.php';
			}else{
				$filename = 'book_country_author.php';
			}
		}else{
			if(in_array($type,$APP_book['authortype'])){
				if(!$country){
					$filename = 'book_author'.$type.'.php';
				}else{
					$filename = 'book_country_author'.$type.'.php';
				}
			}
		}
		if($filename!=''){
			$cachefile = $filedir.'/'.$filename;
			$arrAuthor = include $cachefile;
			if(!$arrAuthor || !$APP_book['cachetime'] || ($APP_book['cachetime']>0 && (time()-filemtime($cachefile))>$APP_book['cachetime']) ) {
				//获取作者数据
				//$arrAuthors = $this->db->fetch_all_assoc("select * from ".dbprefix."book_author where `status`='1' order by auname asc");
				$arrAuthors = $this->findAll('book_author',array(
					'status'=>1,
				),'auname asc');
				if(is_array($arrAuthors)){
					if($country){
						//简单按拼音排序
						usort($arrAuthors, function($tmp_a, $tmp_b) {
							$a = $tmp_a['py'];
							$b = $tmp_b['py'];
							if ($a == $b)
								return 0;
							return ($a < $b) ? -1 : 1;
						});
						//array_multisort();
					}
					foreach($arrAuthors as $item){
						if($type === false){
							if(!$country){
								$arrAuthor[$item['auid']] = $item;
							}else{
								$arrAuthor[$item['country']][$item['auid']] = $item;
							}
						}else{
							if($item['author'.$type]){
								if(!$country){
									$arrAuthor[$item['auid']] = $item;
								}else{
									$arrAuthor[$item['country']][$item['auid']] = $item;
								}
							}
						}
					}
					
					fileWrite($filename,$filedir,$arrAuthor);
				}
			}
		}
		return $arrAuthor;
	}
	
	//获取出版社数据
	public function getPubhouseList(){
		$arrPubhouse = array();
		//$arrPubhouses = $this->db->fetch_all_assoc("select * from ".dbprefix."book_pubhouse where `status`='1' order by puname asc");
		$arrPubhouses = $this->findAll('book_pubhouse',array(
			'status'=>'1',
		),'puname asc');
		if(is_array($arrPubhouses)){
			foreach($arrPubhouses as $item){
				$arrPubhouse[$item['puid']] = $item;
			}
		}
		return $arrPubhouse;
	}
	
	//获取出版社
	public function getCompanyList(){
		$arrCompany = array();
		//$arrCompanys = $this->db->fetch_all_assoc("select * from ".dbprefix."book_company where `status`='1' order by coname asc");
		$arrCompanys = $this->findAll('book_company',array(
			'status'=>'1',
		),'coname asc');
		if(is_array($arrCompanys)){
			foreach($arrCompanys as $item){
				$arrCompany[$item['coid']] = $item;
			}
		}
		return $arrCompany;
	}
	
	//获取一个图书
	public function getOneBook($bookid){
		$strBook = $this->find('book',array(
			'bookid' => $bookid,
		));
		if(!$strBook){
			return false;
		}
		//封面
		if($strBook['path'] && $strBook['photo']){
			$strBook['bookicon'] = SITE_URL.'uploadfile/book/'.$strBook['photo'];
			$strBook['icon_48'] = tsXimg($strBook['photo'],'book',48,0,$strBook['path'],0);
			$strBook['icon_80'] = tsXimg($strBook['photo'],'book',80,0,$strBook['path'],0);
			$strBook['icon_120'] = tsXimg($strBook['photo'],'book',120,0,$strBook['path'],0);
			$strBook['icon_180'] = tsXimg($strBook['photo'],'book',180,0,$strBook['path'],0);
		}else{
			$strBook['bookicon'] = SITE_URL.'public/images/book.jpg';
			$strBook['icon_48'] = $strBook['bookicon'];
			$strBook['icon_80'] = $strBook['bookicon'];
			$strBook['icon_120'] = $strBook['bookicon'];
			$strBook['icon_180'] = $strBook['bookicon'];
		}
		return $strBook;
	}
	
	//获取一个图书的类别信息
	public function getOneBookCate($bookid,$flag=false){
		global $APP_book;
		$where = " bookid=".$bookid;
		if($flag !== false && in_array($flag, $APP_book['categroup'])){
			$where .= " AND cateflag='".$flag."'";
		}
		$arrBookCate = array();
		$cateArr = $this->findAll('book_cate_info', $where);
		foreach($cateArr as $key=>$val){
			$arrBookCate[$val['cateflag']][$val['cateid']] = $val;
		}
		return $arrBookCate;
	}
	
	//获取一个图书的图片信息
	public function getOneBookPhoto($bookid){
		$arrBookPhoto = array();
		$arrBookPhotos = $this->findAll('book_photo',array(
			'bookid' => $bookid,
		));
		foreach($arrBookPhotos as $k=>$v){
			if($v['photourl'] && $v['path']){
				$arrBookPhoto[$k] = array(
					'src' => SITE_URL.'uploadfile/bookphoto/' . $v['photourl'],
					'thumb' => tsXimg($v['photourl'],'bookphoto',0,150,$v['path'],0),
					'title' => $v['photoname'],
					'desc' => $v['photodesc']
				);
			}
		}
		return $arrBookPhoto;
	}
	
	/*
	* 获取一个图书的作者信息
	* @params 图书id[,作者类型]
	* @return array()
	*/
	public function getOneBookAuthor($bookid, $type=false){
		global $APP_book;
		$arrBookAuthor = array();
		foreach($APP_book['authortype'] as $at){
			$arrBookAuthor[$at] = array();
		}
		$arrBookAuthors = $this->findAll('book_author_info',array(
			'bookid' => $bookid,
		));
		foreach($arrBookAuthors as $item){
			$arrBookAuthor[$item['autype']][$item['auid']] = $item;
		}
		if($type!==false && in_array($type,$APP_book['authortype'])){
			return $arrBookAuthor[$type];
		}
		return $arrBookAuthor;
	}
	
	//获取一个图书的附加信息
	public function getOneBookAdd($bookid, $type=false){
		global $APP_book;
		$arrBookAdd = array();
		$arrBookAdds = $this->findAll('book_add',array(
			'bookid' => $bookid
		));
		if($arrBookAdds){
			foreach($arrBookAdds as $item){
				$arrBookAdd[$item['addtype']] = $item;
			}
		}
		if($type!==false && in_array($type,$APP_book['addtype']) && isset($arrBookAdd[$type])){
			return $arrBookAdd[$type];
		}
		return $arrBookAdd;
	}
	
	//获取推荐的图书
	public function getRecommendBook($num){
		$arrRecommendBook = array();
		//$arrRecommendBooks = $this->db->fetch_all_assoc("select bookid from ".dbprefix."book where isrecommend='1' limit $num");
		$arrRecommendBooks = $this->findAll('book',array(
			'isrecommend'=>1,
		),null,'bookid',$num);
		
		
		if(is_array($arrRecommendBooks)){
			foreach($arrRecommendBooks as $item){
				$arrRecommendBook[] = $this->getOneBook($item['bookid']);
			}
		}
		return $arrRecommendBook;
	}
	
	//获取最新创建的图书
	public function getNewBook($num){
		$arrNewBook = array();
		//$arrNewBooks = $this->db->fetch_all_assoc("select bookid from ".dbprefix."book where `isaudit`='1' order by addtime desc limit $num");
		$arrNewBooks = $this->findAll('book',array(
			'isaudit'=>'1',
		),'addtime desc','bookid',$num);
		if(is_array($arrNewBooks)){
			foreach($arrNewBooks as $item){
				$arrNewBook[] = $this->getOneBook($item['bookid']);
			}
		}
		return $arrNewBook;
	}
	
	//判断是否存在图书
	public function isBook($bookid){
		
		$isBook = $this->findCount('book',array(
			'bookid'=>$bookid,
		));
		
		if($isBook > 0){
			return true;
		}else{
			return false;
		}
	}
	
	//析构函数
	public function __destruct(){
		
	}
	
}