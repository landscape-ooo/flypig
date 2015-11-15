<?php
defined ( 'IN_TS' ) or die ( 'Access Denied.' );
// 程序主体
switch ($ts) {
	case "" :
		if (intval ( $TS_USER ['user'] ['userid'] ) > 0)
			tsNotice ( "已经登陆啦!" );
			
			// 记录上次访问地址
		$jump = $_SERVER ['HTTP_REFERER'];
		
		$title = '登录';
		include template ( "login" );
		break;
	
	// 执行登录
	case "do" :
		
		// 验证token
// 		if ($_POST ['token'] != $_SESSION ['token']) {
// 			tsNotice ( '非法操作！' );
// 		}
		
		/* 禁止以下IP用户登陆或注册 */
		$arrIp = aac ( 'system' )->antiIp ();
		if (in_array ( getIp (), $arrIp )) {
			header ( 'Location: ' . SITE_URL );
			exit ();
		}
		// 获取跳转url
		$jump = '';
		if (! isset ( $_POST ['jump'] ) || empty ( $_POST ['jump'] )) {
			if (isset ( $_SERVER ['HTTP_REFERER'] ) && ! empty ( $_SERVER ['HTTP_REFERER'] )) {
				$jump = trim ( $_SERVER ['HTTP_REFERER'] );
			}
		} else {
			$jump = trim ( $_POST ['jump'] );
		}
		$jump = ! empty ( $jump ) ? $jump : SITE_URL;
		
		$email = trim ( $_POST ['email'] );
		$pwd = trim ( $_POST ['pwd'] );
		$cktime = $_POST ['cktime'];
		
		if ($email == '' || $pwd == '') {
			tsNotice ( 'Email和密码都不能为空！' );
		}
		
		// 查询email注册用户
		$strUser = $new ['user']->find ( 'user', array (
				'email' => $email 
		) );
		if (! $strUser) {
			tsNotice ( 'Email不存在，你可能还没有注册！' );
		}
		// 判断密码
		if (md5 ( $strUser ['salt'] . $pwd ) !== $strUser ['pwd']) {
			tsNotice ( '密码错误！' );
		}
		
		// 用户信息
		$userData = $new ['user']->find ( 'user_info', array (
				'email' => $email 
		) );
		
		// 记住登录Cookie，根据用户Email和最后登录时间
		if ($cktime != '') {
			setcookie ( "ts_email", $userData ['email'], time () + $cktime, '/' );
			setcookie ( "ts_uptime", $userData ['uptime'], time () + $cktime, '/' );
		}
		
		// 用户session信息
		$sessionData = array (
				'userid' => $userData ['userid'],
				'username' => $userData ['username'],
				'path' => $userData ['path'],
				'face' => $userData ['face'],
				'isadmin' => $userData ['isadmin'],
				'uptime' => $userData ['uptime'] 
		);
		// 写入session
		$_SESSION ['tsuser'] = $sessionData;
		
		// 用户userid
		$userid = $userData ['userid'];
		
		// 一天之内登录只算一次积分
		if ($userData ['uptime'] < strtotime ( date ( 'Y-m-d' ) )) {
			// 对积分进行处理
			aac ( 'user' )->doScore ( $app, $ac, $ts );
		}
		
		// 更新登录时间，用作自动登录
		$new ['user']->update ( 'user_info', array (
				'userid' => $userid 
		), array (
				'ip' => getIp (), // 更新登录ip
				'uptime' => time ()  // 更新登录时间
		) );
		
		// 跳转
		header ( "Location: " . $jump );
		break;
	
	// 退出
	case "out" :
		
		// 记录上次访问地址
		$jump = isset ( $_SERVER ['HTTP_REFERER'] ) ? $_SERVER ['HTTP_REFERER'] : tsUrl ( 'user', 'login' );
		aac ( 'user' )->logout ();
		// header('Location: '.tsUrl('user','login'));
		header ( 'Location: ' . $jump );
		break;
}