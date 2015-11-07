<?php
defined('IN_TS') or die('Access Denied.');

$userid = aac('user')->isLogin(false);

//ts 开始
switch($ts){
	case "new":
		
		break;
		
	//编辑答案提交
	case "submitEditComment":
		//用户是否登录
		if(!$userid){
			echo jsonAjax('0','未登陆，请先登陆',array(
				'url'=>tsUrl('user','login')
			));
			exit();
		}
		
		$commentid = intval($_POST['commentid']);
		//查询评论信息
		$strComment = $new['ask']->find('ask_comment', array(
			'commentid'=>$commentid
		));
		if(!$strComment){
			echo jsonAjax('0', '评论不存在');
			exit();
		}
		if($strComment['userid']!=$userid && $TS_USER['user']['isadmin']!='1'){
			echo jsonAjax('0', '权限错误');
			exit();
		}
		//过滤内容
		$content = htmlClean($_POST['content']);
		if($content == ''){
			echo jsonAjax('0', '内容不能为空');
			exit();
		}
		if(mb_strlen($content, 'utf8') > 2000){
			echo jsonAjax('0', '字数超过2000限制');
			exit();
		}
		
		//更新
		$res = $new['ask']->replace('ask_comment_add',array(
			'commentid'=>$commentid
		), array(
			'commentid'=>$commentid,
			'content'=>$content
		));
		
		echo jsonAjax('1', '修改成功', htmlShow($content));
		break;
		
	//设为最佳答案
	case "bestComment":
		//用户是否登录
		if(!$userid){
			echo jsonAjax('0','未登陆，请先登陆',array(
				'url'=>tsUrl('user','login')
			));
			exit;
		}
		$commentid = intval($_POST['commentid']);
		//判断该答案的所有者
		$onecomment = $new['ask']->find('ask_comment', array(
			'commentid'=>$commentid
		));
		if(!$onecomment){
			echo jsonAjax('0', '答案不存在，参数错误！');
			exit();
		}
		$strAsk = $new['ask']->find('ask', array(
			'askid'=>$onecomment['askid']
		));
		if(!$strAsk){
			echo jsonAjax('0', '问答不存在！');
			exit();
		}
		if($strAsk['isopen']!='1'){
			echo jsonAjax('0', '问答已关闭！');
			exit();
		}
		if(($strAsk['userid']==$userid) || $TS_USER['user']['isadmin']=='1'){
			$isbest = 0;
			switch($onecomment['isbest']){
				case '1':
					$isbest = '0';
					break;
				case '0':
					$isbest = '1';
					break;
			}
			$new['ask']->update('ask_comment', array(
				'commentid'=>$commentid
			),array(
				'isbest'=>$isbest
			));
			//计入用户积分 减1分
			switch($isbest){
				case '1':
					$new['ask']->add_userscore_one($onecomment['userid'],10);
					//对积分进行处理
					aac('user')->doScore($app,$ac,$ts);
					break;
				case '0':
					$new['ask']->reduce_userscore_one($onecomment['userid'],10);
					//对积分进行处理
					aac('user')->doScore($app,$ac,$ts,0,'2');
					break;
			}
		}
		echo jsonAjax('1', '操作成功！');
		break;
		
	//删除答案
	case "deleteComment":
		//用户是否登录
		if(!$userid){
			echo jsonAjax('0','未登陆，请先登陆',array(
				'url'=>tsUrl('user','login')
			));
			exit;
		}
		$commentid = intval($_POST['commentid']);
		//判断该评论的所有者
		$strComment = $new['ask']->find('ask_comment', array(
			'commentid'=>$commentid
		));
		if(!$strComment){
			echo jsonAjax('0', '评论不存在');
			exit();
		}
		if($strComment['userid']!=$userid && $TS_USER['user']['isadmin']!='1'){
			echo jsonAjax('0', '权限错误');
			exit();
		}
		//假删除
		$new['ask']->update('ask_comment', array(
			'commentid'=>$commentid
		),array(
			'status'=>'0'
		));
		$new['ask']->delete('ask_comment_do', array(
			'commentid'=>$commentid
		));
		
		//计入答案数
		$new['ask']->reduce_ask_one($strComment['askid']);
		//计入用户积分 减1分
		$new['ask']->reduce_userscore_one($userid);
		
		echo jsonAjax('1', '操作成功！');
		break;
		
	//顶(踩)答案
	case "digg":
		//检测是否登陆
		if(!$userid){
			echo jsonAjax('0', '未登陆');
			exit();
		}
		$type = intval($_POST['type']);
		$commentid = intval($_POST['commentid']);
		$strComment = $new['ask']->find('ask_comment', array(
			'commentid'=>$commentid
		));
		if(!$strComment){
			echo jsonAjax('0', '答案不存在，参数错误');
			exit();
		}
		if($strComment['userid']==$userid){
			echo jsonAjax('0', '自己不可以评断自己的答案');
			exit();
		}
		$strAsk = $new['ask']->find('ask',array(
			'askid'=>$strComment['askid']
		));
		if(!$strAsk || $strAsk['isopen']=='0' && $TS_USER['user']['isadmin']!='1'){
			echo jsonAjax('0', '问答已关闭，停止相关操作！');
			exit();
		}
		//查找是否已经有过操作
		$strCommentDo = $new['ask']->find('ask_comment_do', array(
			'commentid'=>$commentid,
			'userid'=>$userid,
			'type'=>$type
		));
		if($strCommentDo){
			switch($type){
				case '1':
					echo jsonAjax('0', '你已经顶过此答案');
					exit();
					break;
				case '2':
					echo jsonAjax('0', '你已经踩过此答案');
					exit();
					break;
			}
		}
		
		//将反对记录置为支持记录
		$new['ask']->replace('ask_comment_do', array(
			'commentid'=>$commentid,
			'userid'=>$userid,
		), array(
			'commentid'=>$commentid,
			'userid'=>$userid,
			'type'=>$type,
			'updatetime'=>time()
		));
		
		//避免负数
		$newdigg = $newundigg = 0;
		$digg = $strComment['digg'];
		$undigg = $strComment['undigg'];
		switch($type){
			case '1':
				if($undigg<1) $undigg = 1;
				$newdigg = $digg+1;
				$newundigg = $undigg-1;
				break;
			case '2':
				if($digg<1) $digg = 1;
				$newdigg = $digg-1;
				$newundigg = $undigg+1;
				break;
		}
		//更新回复顶字段数量
		$new['ask']->update('ask_comment',array(
			'commentid'=>$commentid
		),array(
			'digg'=>$newdigg,
			'undigg'=>$newundigg
		));
		
		//计入用户积分
		$new['ask']->add_userscore_one($userid);
		
		if($type=='1'){
			//message开始，通知被顶者
			$msg_userid = '0';
			$msg_touserid = $strComment['userid'];
			$msg_content = $TS_USER['user']['username'].'顶了你的答案：“'.$strComment['comment'].'”，快去看看吧^_^ <br />'
			.tsUrl('ask','show',array('askid'=>$strComment['askid']));
			aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
			//message结束
		}
		
		echo jsonAjax('1', '操作成功', array('digg'=>$newdigg, 'undigg'=>$newundigg));
		break;
	
	//关闭/解锁问题
	case "closeOrOpenQuestion":
		
		$askid = intval($_POST['askid']);
		$userid = aac('user') -> isLogin();
		//判断问题所有者
		$askarr = $new['ask']->find('ask', array(
			'askid'=>$askid
		));
		if(!$askarr){
			format_json(FAILURE, '该问题不存在或已被删除');
		}
		if($askarr['userid'] != $userid && $TS_USER['user']['isadmin'] != 1){
			format_json(FAILURE, '无权编辑该问题');
		}
		$now = time();
		if($now - $askarr['opentime'] < 600 && $TS_USER['user']['isadmin'] != 1){
			format_json(FAILURE, '问题10分钟内只可以打开/关闭1次');
		}
		
		$isopen = 0;
		if($askarr['isopen'] == 0){
			$isopen = 1;
		}
		$new['ask']->update('ask', array(
			'askid'=>$askid
		), array(
			'isopen'=>$isopen,
			'opentime'=>$now
		));
		format_json(SUCCESS, array());
		
		break;
		
	//关注分类
	case "follow":
		$cateid = intval($_POST['cateid']);
		$userid = aac('user') -> isLogin();
		
		$catearr = $new['ask']->find("ask_user_cate", array('userid'=>$userid, 'cateid'=>$cateid));
		if($catearr){
			//有存在记录 此时属于取消关注 删除该记录
			$new['ask']->delete("ask_user_cate", array('userid'=>$userid, 'cateid'=>$cateid));
			echo 1;
			return;
		}
		
		//未关注 插入新记录
		$new['ask']->create("ask_user_cate", array(
			'userid'=>$userid,
			'cateid'=>$cateid,
			'addtime'=>time()
		));
		echo 1;
		break;
		
	//添加评论
	case "addcomment":
		$content = t($_POST['content']);
		$dataid = intval($_POST['dataid']);
		$datatype = t($_POST['datatype']);
		
		if(!$TS_USER['user']['userid']){
			format_json(FAILURE, '未登录');
		}
		if(mb_strlen($content, 'utf8') > 500){
			// 限制发表内容多长度，默认为500
			format_json(FAILURE, '最多允许输入500字');
		}
		
		$userid = $TS_USER['user']['userid'];
		switch($datatype){
			case 'question' :
				$addcommentarr = $new['ask']->find('ask_add', array(
					'userid'=>$userid,
					'askid'=>$dataid
				), null, 'addtime desc');
				$now = time();
				if($addcommentarr){
					if($now - $addcommentarr['addtime'] < 600 && $TS_USER['user']['isadmin'] != 1){
						format_json(FAILURE, '10分钟之内只能添加一次讨论');
					}
				}
				$replyid = $new['ask']->create('ask_add', array(
					'askid'=>$dataid,
					'userid'=>$userid,
					'content'=>$content,
					'addtime'=>$now
				));
				$retundata = array();
				if($replyid){
					$home_url = tsUrl('user','space',array('id'=>$userid));
					$retundata = array(
						'userid'=>$userid,
						'username'=>$TS_USER['user']['username'],
						'home_url'=>$home_url,
						'replyid'=>$replyid,
						'content'=>$content,
						'addtime'=>date('Y-m-d', $now)
					);
					
					//通知问题发起者
					$onecomment = $new['ask']->find('ask', array(
						'askid'=>$dataid
					));
					if($userid != $onecomment['userid']){
						$msg_userid = '0';
						$msg_touserid = $onecomment['userid'];
						$msg_content = $TS_USER['user']['username'].'对你的问题添加了讨论：“'.$content.'”，快去看看吧^_^ <br />'
						.tsUrl('ask','show',array('id'=>$dataid));
						aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
					}
				}
				
				format_json(SUCCESS, $retundata);
				break;
				
			case 'answer':
				$addcommentarr = $new['ask']->find('ask_comment_add', array('userid'=>$userid, 'commentid'=>$dataid), null, 'addtime desc');
				$now = time();
				if($addcommentarr){
					if($now - $addcommentarr['addtime'] < 600 && $TS_USER['user']['isadmin'] != 1){
						format_json(FAILURE, '10分钟之内只能添加一次讨论');
					}
				}
				
				$replyid = $new['ask']->create('ask_comment_add', array(
					'commentid'=>$dataid,
					'userid'=>$userid,
					'content'=>$content,
					'addtime'=>$now
				));
				$retundata = array();
				if($replyid){
					$home_url = tsUrl('user','space',array('id'=>$userid));
					$retundata = array(
						'userid'=>$userid,
						'username'=>$TS_USER['user']['username'],
						'home_url'=>$home_url,
						'replyid'=>$replyid,
						'content'=>$content,
						'addtime'=>date('Y-m-d', $now)
					);
					
					//通知问题发起者
					$onecomment = $new['ask']->find('ask_comment', array('commentid'=>$dataid));
					if($userid != $onecomment['userid']){
						$msg_userid = '0';
						$msg_touserid = $onecomment['userid'];
						$msg_content = $TS_USER['user']['username'].'对你的答案添加了讨论：“'.$content.'”，快去看看吧^_^ <br />'
						.tsUrl('ask','show',array('id'=>$onecomment['askid']));
						aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
					}
				}
				format_json(SUCCESS, $retundata);
				break;
		}
		break;
	
	//删除评论
	case "deladdcomment":
		$dataid = intval($_POST['dataid']);
		$datatype = $_POST['datatype'];
		
		if(!$TS_USER['user']['userid']){
			format_json(FAILURE, '未登录');
		}
		$userid = $TS_USER['user']['userid'];
		if('question' == $datatype){
			//判断讨论的所有者
			$addcommentarr = $new['ask']->find('ask_add', array('replyid'=>$dataid));
			if($addcommentarr){
				if($addcommentarr['userid'] == $userid){
					$new['ask']->delete('ask_add', array('replyid'=>$dataid));
					format_json(SUCCESS);
				}
			}
		}
		if('answer' == $datatype){
			//判断讨论的所有者
			$addcommentarr = $new['ask']->find('ask_comment_add', array(
				'replyid'=>$dataid
			));
			if($addcommentarr){
				if($addcommentarr['userid'] == $userid){
					$new['ask']->delete('ask_comment_add', array(
						'replyid'=>$dataid
					));
					format_json(SUCCESS);
				}
			}
		}
		break;
}

//生成json数据
function format_json($code=0,$html=''){
	echo json_encode(array('code'=>$code, 'html'=>$html));
	exit();
}
