<?php 
defined('IN_TS') or die('Access Denied.');

switch($ts){
	//收藏
	case "collect":
		//用户是否登录
		$userid = intval($TS_USER['user']['userid']);
		if(!$userid){
			echo jsonAjax('0','未登陆，请先登陆',array(
				'url'=>tsUrl('user','login')
			));
			exit;
		}
		$bookid = intval($_POST['bookid']);
		$strBook = $new['book']->find('book',array(
			'bookid'=>$bookid,
		));
		if(!$strBook){
			echo jsonAjax('2','图书不存在，参数错误');
			exit;
		}
		$collectNum = $new['book']->findCount('book_collect',array(
			'userid'=>$userid,
			'bookid'=>$bookid,
		));
		if($collectNum > 0){
			echo jsonAjax('2','你已经收藏过本书啦，请不要再次收藏');
			exit;
		}else{
			$new['book']->create('book_collect',array(
				'userid'=>$userid,
				'bookid'=>$bookid,
				'addtime'=>time(),
			));
			$new['book']->update('book',array(
				'bookid'=>$bookid,
			),array(
				'`count_collect`=`count_collect`+1'
			));
			echo jsonAjax('1','收藏成功');
			exit;
		}
		
		break;
		
	//do操作
	case "do":
		//用户是否登录
		$userid = intval($TS_USER['user']['userid']);
		if(!$userid){
			echo jsonAjax('0','未登陆，请先登陆',array(
				'url'=>tsUrl('user','login')
			));
			exit;
		}
		$bookid = intval($_POST['bookid']);
		$strBook = $new['book']->find('book',array(
			'bookid'=>$bookid,
		));
		if(!$strBook){
			echo jsonAjax('2','图书不存在，参数错误');
			exit;
		}
		$count_want = $strBook['count_want'];
		$count_read = $strBook['count_read'];
		$count_done = $strBook['count_done'];
		
		$type = intval($_POST['type']);
		
		if(!$type || !in_array($type,array('1','2','3'))){
			echo jsonAjax('2',$type.'非法操作，参数错误');
			exit;
		}
		$tabset = array();
		$strBookDo = $new['book']->find('book_do',array(
			'userid'=>$userid,
			'bookid'=>$bookid
		));
		if($strBookDo){
			$oldtype = $strBookDo['type'];
			if($type == $oldtype){
				echo jsonAjax('2','请不要重复操作');
				exit;
			}
			switch($oldtype){
				case 1:
					$tabset[] = '`count_want`=`count_want`-1';
					break;
				case 2:
					$tabset[] = '`count_read`=`count_read`-1';
					break;
				case 3:
					$tabset[] = '`count_done`=`count_done`-1';
					break;
			}
		}
		switch($type){
			case 1:
				$tabset[] = '`count_want`=`count_want`+1';
				break;
			case 2:
				$tabset[] = '`count_read`=`count_read`+1';
				break;
			case 3:
				$tabset[] = '`count_done`=`count_done`+1';
				break;
		}
		$new['book']->replace('book_do',array(
			'userid'=>$userid,
			'bookid'=>$bookid
		),array(
			'userid'=>$userid,
			'bookid'=>$bookid,
			'type'=>$type,
			'addtime'=>time(),
		));
		$new['book']->update('book',array(
			'bookid'=>$bookid,
		),$tabset);
		
		echo jsonAjax('1','操作成功');
		
		break;
		
	case "edit_author":
		$isbookid = false;
		$bookid = intval($_GET['bookid']);
		$autype = intval($_GET['autype']);
		
		if(empty($autype) || !in_array($autype, $APP_book['authortype'])) exit('');
		
		if(!empty($bookid)){
			$isbookid = true;
			//书的作者
			$arrBookAuthor = $new['book']->getOneBookAuthor($bookid);
			foreach($APP_book['authortype'] as $t){
				${'arrAuthor'.$t} = array(); //定义变量
				if(isset($arrBookAuthor[$t])){
					${'arrAuthor'.$t} = $arrBookAuthor[$t];
				}
			}
		}
		//获取国家简称数组
		$arrCountry = array();
		foreach($APP_book['country'] as $c){
			$arrCountry[$c[1]] = $c[2];
		}
		
		//获取作者数据
		$arrAuthor = $new['book']->getAuthorList($autype,1); //按国家分类
		foreach($arrAuthor as $ckey => $cval){
			echo "<optgroup label=\"".$ckey."\" class=\"optgroup__".$ckey."\">";
			foreach($cval as $akey => $aval){
				if($isbookid){
					if(array_key_exists($akey,${'arrAuthor'.$autype})){
						echo "<option value=\"".$akey."\" selected=selected>[".$arrCountry[$aval['country']]."]".$aval['auname']."</option>";
					}else{
						echo "<option value=\"".$akey."\">[".$arrCountry[$aval['country']]."]".$aval['auname']."</option>";
					}
				}else{
					echo "<option value=\"".$akey."\">[".$arrCountry[$aval['country']]."]".$aval['auname']."</option>";
				}
			}
			echo "</optgroup>";
		}
		
		break;
		
	//修改绑定分类
	case "edit_cate":
		$bookid = intval($_GET['bookid']);
		$cateflag = tsFilter($_GET['cateflag']);
		
		if(empty($bookid) || empty($cateflag) || !in_array($cateflag, $APP_book['categroup'])) exit('');
		
		//本书分类数组
		$arrBookCate = $new['book']->getOneBookCate($bookid);
		foreach($APP_book['categroup_guide'] as $f){
			${$f} = array(); //定义变量
			if(isset($arrBookCate[$f])){
				${$f} = $arrBookCate[$f];
			}
		}
		//var_dump(${$cateflag});
		
		//获取分类数据
		$arrCate = $new['book']->getCateList($cateflag);
		//var_dump($arrCate);die;
		$arrCatesub = array();
		if(isset($arrCate[$cateflag]['catesub']) && count($arrCate[$cateflag]['catesub'])>0){
			$arrCatesub = $arrCate[$cateflag]['catesub'];
		}
		foreach($arrCatesub as $ckey => $cval){
			if(array_key_exists($ckey,${$cateflag})){
				echo "<option value=\"".$ckey."\" selected=selected>".$cval['catename']."</option>";
			}else{
				echo "<option value=\"".$ckey."\">".$cval['catename']."</option>";
			}
		}
		
		break;
	//书评审核
	case "reviewaudit":
		
		$reviewid = intval($_POST['reviewid']);
		
		$strReview = $new['book']->find('review',array(
			'reviewid'=>$reviewid,
		));
		
		if($strReview['isaudit']==0){
			$new['book']->update('review',array(
				'reviewid'=>$reviewid,
			),array(
				'isaudit'=>1,
			));
			
			echo 0;exit;
			
		}
		
		if($strReview['isaudit']==1){
			$new['book']->update('review',array(
				'reviewid'=>$reviewid,
			),array(
				'isaudit'=>0,
			));
			
			echo 1;exit;
			
		}
		
		break;
}