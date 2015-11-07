<?php 
defined('IN_TS') or die('Access Denied.');

//用户是否登录
$userid = aac('user')->isLogin();

switch ($ts) {
	
	//分享审核
	case "audit":
		
		$shareid = intval($_GET['shareid']);
		//获取原数据
		$strShare = $new['share']->find('share',array(
			'shareid'=>$shareid,
		));
		if(!$strShare){
			tsNotice('分享不存在');
		}
		$isaudit = $strShare['isaudit']=='0' ? '1' : '0';
		//审核或取消
		$new['share']->update('share',array(
			'shareid'=>$shareid,
		),array(
			'isaudit'=>$isaudit
		));
		if($isaudit == '0' && $TS_USER['user']['isadmin']!='1'){
			tsNotice('操作成功！','点击返回',tsUrl('share','show',array('id'=>$strShare['shareid'])));
		}
		header('Location: '.tsUrl('share','show',array('id'=>$shareid)));
		break;
		
	//分享删除
	case "del":
		
		$shareid = intval($_GET['shareid']);
		
		$strShare = $new['share']->find('share',array(
			'shareid'=>$shareid
		));
		if(!$strShare){
			tsNotice('分享不存在');
		}
		
		//系统管理员删除
		if($TS_USER['user']['isadmin'] == '1'){
			$new['share']->delShare($shareid);
			
			//删除首页推送数据
			aac('index')->del('share_list',$shareid);
			
			header('Location: '.tsUrl('share'));
			exit;
			
		}
		
		//其他人员删除
		if($userid == $strShare['userid'] || $strShareUser['isadmin']=='1'){
			
			$new['share']->update('share',array(
				'shareid'=>$shareid,
			),array(
				'status'=>0,
			));
			
			//删除首页推送数据
			aac('index')->del('share_list',$shareid);
			
			//扣除用户相应的积分，删除分享扣5分
			aac('user')->delScore($strShare['userid'], '删除分享', 5);
			
			tsNotice('你的删除分享申请已经提交！');
		}
		
		break;
		
	//置顶分享
	case "istop":
		$shareid = intval($_GET['shareid']);
		
		$strShare = $new['share']->find('share',array(
			'shareid'=>$shareid,
		));
		if(!$strShare){
			tsNotice("分享不存在！");
		}
		
		$strShare = aac('share')->find('share',array(
			'shareid'=>$strShare['shareid'],
		));
		if(!$strShare){
			tsNotice("关联图书不存在！");
		}
		//验证权限
		if($userid!=$strShare['userid'] && $TS_USER['user']['isadmin']!='1'){
			tsNotice("非法操作！");
		}
		
		$istop = $strShare['istop']=='0' ? '1' : '0';
		$new['share']->update('share',array(
			'shareid'=>$shareid,
		),array(
			'istop'=>$istop,
		));
		
		header("Location: ".tsUrl('share','show',array('id'=>$shareid)));
		break;
	
	//分享标签
	case "share_tag_ajax";
		
		$shareid = intval($_GET['shareid']);
		include template("share_tag_ajax");
		break;
	
	//添加分享标签
	case "share_tag_do":
		
		$shareid = intval($_POST['shareid']);
		
		if($shareid == 0) tsNotice("非法操作！");
		
		$tagname = t($_POST['tagname']);
		$uptime	= time();
		
		if($tagname != ''){
		
			if(strlen($tagname) > '32') tsNotice("TAG长度大于32个字节（不能超过16个汉字）");
			
			$tagcount = $db->once_num_rows("select * from ".dbprefix."tag where tagname='".$tagname."'");
			
			if($tagcount == '0'){
				$db->query("INSERT INTO ".dbprefix."tag (`tagname`,`uptime`) VALUES ('".$tagname."','".$uptime."')");
				$tagid = $db->insert_id();
				
				$tagIndexCount = $db->once_num_rows("select * from ".dbprefix."tag_share_index where shareid='".$shareid."' and tagid='".$tagid."'");
				if($tagIndexCount == '0'){
					$db->query("INSERT INTO ".dbprefix."tag_share_index (`shareid`,`tagid`) VALUES ('".$shareid."','".$tagid."')");
				}
				
				$tagIdCount = $db->once_num_rows("select * from ".dbprefix."tag_share_index where tagid='".$tagid."'");
				
				$db->query("update ".dbprefix."tag set `count_share`='".$tagIdCount."',`uptime`='".$uptime."' where tagid='".$tagid."'");
				
			}else{
				
				$tagData = $db->once_fetch_assoc("select * from ".dbprefix."tag where tagname='".$tagname."'");
				
				$tagIndexCount = $db->once_num_rows("select * from ".dbprefix."tag_share_index where shareid='".$shareid."' and tagid='".$tagData['tagid']."'");
				if($tagIndexCount == '0'){
					$db->query("INSERT INTO ".dbprefix."tag_share_index (`shareid`,`tagid`) VALUES ('".$shareid."','".$tagData['tagid']."')");
				}
				
				$tagIdCount = $db->once_num_rows("select * from ".dbprefix."tag_share_index where tagid='".$tagData['tagid']."'");
				
				$db->query("update ".dbprefix."tag set `count_share`='".$tagIdCount."',`uptime`='".$uptime."' where tagid='".$tagData['tagid']."'");
				
			}
			
			echo "<script language=JavaScript>parent.window.location.reload();</script>";
			
		}
		
		break;
		
	//分享分类
	case "share_type":
		
		$shareid = intval($_POST['shareid']);
		$typename = t($_POST['typename']);
		if($typename != '')
		  $db->query("insert into ".dbprefix."share_type (`shareid`,`typename`) values ('$shareid','$typename')");
		
		header("Location: ".tsUrl('share','edit',array('shareid'=>$shareid,'ts'=>'type')));
		
		break;
		
	case 'parseurl':
		$url = $_POST['parseurl'];
		$urlArr = parse_url($url);
		$domainArr = explode('.',$urlArr['host']);
		$data['type'] = $domainArr[count($domainArr)-2];
		$str = formPost('http://share.pengyou.com/index.php?mod=usershare&act=geturlinfo',array('url'=>$url));
		echo $str;
	
		break;
		
	//设置精华 
	case "isbrilliant":
		$shareid = intval($_GET['shareid']);
		
		$strShare = $new['share']->find('share',array(
			'shareid'=>$shareid,
		),'userid,shareid,title,isbrilliant');
		if(!$strShare){
			tsNotice("分享不存在！");
		}
		$strShare =  $new['share']->find('share',array(
			'shareid'=>$strShare['shareid'],
		),'userid');
		if(!$strShare){
			tsNotice("关联图书不存在！");
		}
		//验证权限
		if($userid != $strShare['userid'] && intval($TS_USER['user']['isadmin']) != '1'){
			tsNotice("非法操作！");
		}
		if($strShare['isbrilliant']=='0'){
			$new['share']->update('share',array(
				'shareid'=>$shareid,
			),array(
				'isbrilliant'=>'1'
			));
			if($userid != $strShare['userid']){
				//msg start
				$msg_userid = '0';
				$msg_touserid = $strShare['userid'];
				$msg_content = '恭喜，你的分享：《'.$strShare['title'].'》被评为精华帖啦^_^ <br />'.tsUrl('share','show',array('id'=>$shareid));
				aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
				//msg end
			}
			
		}else{
			$new['share']->update('share',array(
				'shareid'=>$shareid,
			),array(
				'isbrilliant'=>'0'
			));
		}
		
		//tsNotice("操作成功！",null,tsUrl('share','show',array('id'=>$shareid)),true);
		header("Location: ".tsUrl('share','show',array('id'=>$shareid)));
		break;
		
	//usertips
	case "usertips":
		
		$data = fileRead('data/user_tips.php');
		
		if($data == ''){
			$query = $db->fetch_all_assoc("select * from " . dbprefix . "user_info");
			foreach($query as $user) {
				$usertip[]=array('user'=>$user['username'],'name'=>$user['userid']);
			}
			fileWrite('user_tips.php','data',json_encode($usertip));
			$data = fileRead('data/user_tips.php');
		}
		
		echo $data;
		
		break;
}
