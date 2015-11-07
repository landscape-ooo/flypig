<?php 
defined('IN_TS') or die('Access Denied.');

class review extends tsApp{
	
	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	
	//获取书评内容
	public function getReviewAdd($reviewid){
		$content = '';
		$strReviewAdd = $this->find('review_add',array(
			'reviewid'=>$reviewid
		));
		if($strReviewAdd){
			$content = $strReviewAdd['content'];
		}
		return $content;
	}
	
	//删除书评
	public function delReview($reviewid){
		$strReview = $this->find('review',array(
			'reviewid'=>$reviewid,
		));
		$this->delete('review',array('reviewid'=>$reviewid));
		$this->delete('review_add',array('reviewid'=>$reviewid));
		$this->delete('review_comment',array('reviewid'=>$reviewid));
		$this->delete('tag_review_index',array('reviewid'=>$reviewid));
		$this->delete('review_collect',array('reviewid'=>$reviewid));
		
		//删除书评的评论
		$this->delCommentOfReview($reviewid);
		//统计书评更新图书书评数
		$this->updateReviewCntOfBook($strReview['bookid']);
		
		return true;
	}
	
	//删除书评评论
	public function delCommentOfReview($reviewid){
		$arrComment = $this->findAll('review_comment',array(
			'reviewid'=>$reviewid,
		));
		
		foreach($arrComment as $item){
			$this->delComment($item['commentid']);
		}
		
		return true;
	}
	
	//删除单个评论
	public function delComment($commentid){
		$strComment = $this->find('review_comment',array(
			'commentid'=>$commentid,
		));
		if($strComment){
			$this->delete('review_comment',array(
				'commentid'=>$commentid,
			));
			$this->delete('review_comment',array(
				'commentid'=>$commentid,
			));
			return true;
		}
		return false;
	}
	//获取评论内容
	public function getCommentAdd($commentid){
		$content = '';
		$strCommentAdd = $this->find('review_comment_add',array(
			'commentid'=>$commentid
		));
		if($strCommentAdd){
			$content = $strCommentAdd['content'];
		}
		return $content;
	}
	//更新书评评论数
	public function updateCommentCnt($reviewid,$pattern=1){
		$count_comment = $this->findCount('review_comment',array(
			'reviewid'=>$reviewid,
			'status'=>'1'
		));
		$this->update('review',array(
			'reviewid'=>$reviewid
		),array(
			'count_comment'=>$count_comment
		));
	}
	
	//获取喜欢书评的用户
	public function getCollectUser($reviewid,$num=null){
		$arrUser = array();
		$arrCollectUser = $this->findAll('review_collect', array(
			'reviewid'=>$reviewid
		),'addtime desc',null,$num);
		if(is_array($arrCollectUser)){
			foreach($arrCollectUser as $item){
				$strUser = aac('user')->getOneUser($item['userid']);
				$arrUser[] = $strUser;
			}
		}
		return $arrUser;
	}
	
	//统计图书里的书评并更新到图书
	public function updateReviewCntOfBook($bookid){
		$count_review = $this->findCount('review',array(
			'bookid'=>$bookid,
			'isaudit'=>'1',
			'status'=>'1'
		));
		$this->update('book',array(
			'bookid'=>$bookid,
		),array(
			'count_review'=>$count_review,
		));
		
	}
	
	//热门书评,1天，7天，30天
	public function getHotDayReview($day, $num = null){
		$startTime = time()-($day*3600*60);
		$endTime = time();
		$arrReview = $this->findAll('review',array(
			'isaudit'=>'1',
			'status'=>'1',
				"`addtime`>'$startTime'",
				"`addtime`<'$endTime'",
				"`count_view`>'0'"
		),'addtime desc','reviewid,title,count_view,count_comment',$num);
		foreach($arrReview as $key=>$item){
			$arrReview[$key]['title']=htmlspecialchars($item['title']);
		}
		return $arrReview;
	}
	
	

	//最top visit 分享
	public function getTopVisitlist(){
		$arrList = $this->findAll('review',null,
				'count_view desc',
				"'review' as type,reviewid,title ,count_view" ,
				5
		);
	
		foreach($arrList as $key=>$item){
			$arrList[$key]['title']=htmlspecialchars($item['title']);
		}
		return $arrList;
	}
	//析构函数
	public function __destruct(){
		
	}
	
}