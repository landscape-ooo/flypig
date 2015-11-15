<?php
defined('IN_TS') or die('Access Denied.');
class share extends tsApp{
	
	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	
	//根据cateid获取一个类型信息
	public function getOneCate($cateid){
		if(isset($cateid) && !empty($cateid)){
			$rowCate = $this->find('share_cate', array(
				'cateid'=>$cateid
			));
			if($rowCate) return $rowCate;
		}
		return false;
	}
	
	//通过shareid获取分享基本信息
	public function getOneShare($shareid){
		$strShare = $this->find('share',array(
			'shareid'=>$shareid
		));
		if(!$strShare){
			return false;
		}
		//分享类型
		$strShare['catename'] = '';
		if($strShare['cateid']){
			$strCate = $this->find('share_cate',array(
				'cateid'=>$strShare['cateid']
			));
			$strShare['catename'] = $strCate['catename'];
		}
		
		//分享海报
		if($strShare['photo'] && $strShare['path']){
			$strShare['src'] = SITE_URL."uploadfile/share/".$strShare['photo'];
			$strShare['thumb'] = tsXimg($strShare['photo'],'share',220,165,$strShare['path']);
		}else{
			$strShare['thumb'] = SITE_URL."public/images/share.jpg";
			$strShare['src'] = SITE_URL."public/images/share.jpg";
		}
		return $strShare;
	}
	
	//获取喜欢分享的用户
	public function getCollectUser($shareid,$num=null){
		$arrUser = array();
		$arrCollectUser = $this->findAll('share_collect', array(
			'shareid'=>$shareid
		),'addtime desc',null,$num);
		if(is_array($arrCollectUser)){
			foreach($arrCollectUser as $item){
				$strUser = aac('user')->getOneUser($item['userid']);
				$arrUser[] = $strUser;
			}
		}
		return $arrUser;
	}
	
	//热门分享,1天，7天，30天
	public function getHotDayShare($day, $num = null){
		$startTime = time()-($day*3600*60);
		$endTime = time();
		$arrShare = $this->findAll('share',array(
			'isaudit'=>'1',
			'status'=>'1',
				"`addtime`>'$startTime'",
				"`addtime`<'$endTime'",
				"`count_view`>'0'"
		),'addtime desc','shareid,title,count_view,count_comment',$num);
		foreach($arrShare as $key=>$item){
			$arrShare[$key]['title']=htmlspecialchars($item['title']);
		}
		return $arrShare;
	}
	
	//删除分享
	public function delShare($shareid){
		$strShare = $this->find('share',array(
			'shareid'=>$shareid,
		));
		if($strShare){
			$this->delete('share',array('shareid'=>$shareid));
			$this->delete('share_add',array('shareid'=>$shareid));
			$this->delete('share_comment',array('shareid'=>$shareid));
			$this->delete('share_collect',array('shareid'=>$shareid));
			$this->delete('share_do',array('shareid'=>$shareid));
			$this->delete('tag_share_index',array('shareid'=>$shareid));
			
			//删除图片
			if($strShare['photo']){
				unlink('uploadfile/share/'.$strShare['photo']);
			}
			
			//删除分享的评论
			$this->delShareComment($shareid);
			
			//更新分享数
			$this->updateCateShareCnt($strShare['cateid']);
		}
		return true;
	}
	
	//删除分享的评论
	public function delShareComment($shareid){
		$this->delete('share_comment',array(
			'shareid'=>$shareid,
		));
		return true;
	}
	
	//删除单个评论
	public function delComment($commentid){
		$this->delete('share_comment',array(
			'commentid'=>$commentid,
		));
		return true;
	}
	
	//更新分类分享数
	public function updateCateShareCnt($shareid){
		$strShare = $this->find('share_cate',array(
			'shareid'=>$shareid
		));
		if($strShare){
			$share = $strShare['count_share']-1;
			if($share<0) $share = 0;
			$this->update('share_cate',array(
				'cateid'=>$strShare['cateid']
			),array(
				'count_share'=>$share
			));
		}
		return true;
	}
	
	//析构函数
	public function __destruct(){
		
	}
	
	
	//最top visit 分享
	public function getTopVisitlist(){
		$arrList = $this->findAll('share',null,
				'count_view desc',
				"'share' as type,shareid,title ,count_view" ,
				5
		);
	
		foreach($arrList as $key=>$item){
			$arrList[$key]['title']=htmlspecialchars($item['title']);
		}
		return $arrList;
	}
	
	public function getFriendVisitlist(){
		$user_id=$GLOBALS['TS_USER']['user']?$GLOBALS['TS_USER']['user']['userid']:0;
		if(!$user_id){
			return false;
		}
		$relationList=aac('user')->getMyFollowInfoList($user_id);
	
		$f_userlist=$f_userid_list=array();
		foreach($relationList as $item) {
			$f_userid_list[]=$item['userid'];
			$f_userlist[$item['userid']]=$item;
		}
		if(!$f_userlist) return false;
		$s=$this->findAll('share',
				'userid in ('.implode(",",$f_userid_list).") ",
				'addtime desc ',
				null,
				5
		);
		
		foreach ($s as &$shareinfo){
			$shareinfo['user']=$f_userlist[$shareinfo['userid']];
		}
		return $s;
	}
	
	//mine
	public function getMyToplist(){
		$userid=$GLOBALS['TS_USER']['user']['userid'];
		if(!$userid) return false;
		$arrList = $this->findAll('share',array('userid'=>$userid),
				'count_view desc',
				null,
				5
		);
	
		foreach($arrList as $key=>$item){
			$arrList[$key]['title']=htmlspecialchars($item['title']);
		}
		return $arrList;
	}
	
}