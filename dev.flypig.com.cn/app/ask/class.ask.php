<?php
defined('IN_TS') or die('Access Denied.');
class ask extends tsApp{

	//构造函数
	public function __construct($db){
		parent::__construct($db);
	}
	
	//获取问答内容
	public function getAskAdd($askid){
		$content = '';
		$strAskAdd = $this->find('ask_add',array(
			'askid'=>$askid
		));
		if($strAskAdd){
			$content = $strAskAdd['content'];
		}
		return $content;
	}
	
	//获取评论内容
	public function getCommentAdd($commentid){
		$content = '';
		$strCommentAdd = $this->find('ask_comment_add',array(
			'commentid'=>$commentid
		));
		if($strCommentAdd){
			$content = $strCommentAdd['content'];
		}
		return $content;
	}
	
	//根据cateid获取一个分类信息
	function getOneCate($cateid){
		$arrCate = array();
		if(isset($cateid) && !empty($cateid)){
			$rowCate = $this->find('ask_cate', array('cateid'=>$cateid));
			if($rowCate) return $rowCate;
		}
		return $arrCate;
	}
	//获取问答的分类
	function getAskCate($askid){
		$arrCate = array();
		if(isset($askid) && !empty($askid)){
			$arrCateInfo = $this->findAll('ask_cate_info', array('askid'=>$askid));
			foreach($arrCateInfo as $key => $val){
				$arrCate[$key] = $this->getOneCate($val['cateid']);
			}
		}
		return $arrCate;
	}
	//问题分类数增1
	function add_cate_one($cateid){
		$cateid = intval($cateid);
		$this->db->query("update ".dbprefix."ask_cate set count_ask = count_ask + 1 where cateid = ".$cateid);
	}
	
	//问题分类数减1
	function reduce_cate_one($cateid){
		$cateid = intval($cateid);
		$this->db->query("update ".dbprefix."ask_cate set count_ask = count_ask - 1 where cateid = ".$cateid);
	}
	
	//答案数增1
	function add_ask_one($askid){
		$askid = intval($askid);
		$this->db->query("update ".dbprefix."ask set count_comment = count_comment + 1 where askid = ".$askid);
	}
	
	//答案数减1
	function reduce_ask_one($askid){
		$askid = intval($askid);
		$this->db->query("update ".dbprefix."ask set count_comment = count_comment - 1 where askid = ".$askid);
	}
	
	//回复支持数增1
	function add_comment_one($commentid){
		$commentid = intval($commentid);
		$this->db->query("update ".dbprefix."ask_comment set digg = digg + 1 where commentid = ".$commentid);
	}
	
	//回复反对数增1
	function opp_comment_one($commentid){
		$commentid = intval($commentid);
		$this->db->query("update ".dbprefix."ask_comment set undigg = undigg + 1 where commentid = ".$commentid);
	}
	
	//用户积分增1
	function add_userscore_one($userid,$scorenum=1){
		$scorearr = $this->find('ask_user_score', array('userid'=>$userid));
		if ($scorearr){
			$score = $scorearr['score'] + $scorenum;
			$this->update('ask_user_score', array('userid'=>$userid), array('score'=>$score));
			return;
		}
		$this->create('ask_user_score', array('userid'=>$userid, 'score'=>$scorenum));
	}
	
	//用户积分减1
	function reduce_userscore_one($userid,$scorenum=1){
		$scorearr = $this->find('ask_user_score', array('userid'=>$userid));
		if ($scorearr){
			$score = $scorearr['score'] - $scorenum < 0 ? 0 : $scorearr['score'] - $scorenum;
			$this->update('ask_user_score', array('userid'=>$userid), array('score'=>$score));
			return;
		}
	}
	
}