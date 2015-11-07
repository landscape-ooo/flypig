<?php
defined ( 'IN_TS' ) or die ( 'Access Denied.' );
// 搜索结果

$kw = urldecode ( tsFilter ( $_GET ['kw'] ) );

if ($kw == '') {
	header ( "Location: " . tsUrl ( 'search' ) );
	exit ();
}

$kw = t ( $kw );

if (count_string_len ( $kw ) < 2) {
	header ( "Location: " . tsUrl ( 'search' ) );
	exit ();
}
;

switch ($ts) {
	case "" :
		$page = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
		$url = tsUrl ( 'search', 's', array (
				'kw' => $kw,
				'page' => '' 
		) );
		$lstart = $page * 10 - 10;
		
		$allQuery = "
				select askid as id, title, 'ask' as type, addtime, uptime from " . dbprefix . "ask where title like '%$kw%'
				union 
				select bookid as id, bookname as title, 'book' as type, addtime, uptime from " . dbprefix . "book where `bookname` like '%$kw%'
				union 
				select reviewid as id, title, 'review' as type, addtime, uptime from " . dbprefix . "review where `title` like '%$kw%'
				union 
				select eventid as id, title, 'event' as type, addtime, uptime from " . dbprefix . "event where `title` like '%$kw%'
				union 
				select userid as id, username as title, 'user' as type, addtime, uptime from " . dbprefix . "user_info where `username` like '%$kw%'";
		// $arrAlls = $db->fetch_all_assoc ( "select groupid as id,'group' as type from " . dbprefix . "group where `groupname` like '%$kw%' union select topicid as id,'topic' as type from " . dbprefix . "group_topic WHERE `title` like '%$kw%' union select userid as id,'user' as type from " . dbprefix . "user_info where username like '%$kw%' union select articleid as id,'article' as type from " . dbprefix . "article where `title` like '%$kw%' union select bookid as id,'book' as type from " . dbprefix . "book where `bookname` like '%$kw%' limit $lstart,10" );
		$arrAlls = $db->fetch_all_assoc ( "select * from ({$allQuery}) temp order by uptime limit $lstart,10" );
		
		foreach ( $arrAlls as $item ) {
			if ($item ['type'] == 'ask') {
				$arrAsk [] = $new ['search']->find ( 'ask', array (
						'askid' => $item ['id'] 
				) );
			} elseif ($item ['type'] == 'book') {
				$arrBook [] = $new ['search']->find ( 'book', array (
						'bookid' => $item ['id'] 
				) );
			} elseif ($item ['type'] == 'review') {
				$arrReview [] = $new ['search']->find ( 'review', array (
						'reviewid' => $item ['id'] 
				) );
			} elseif ($item ['type'] == 'event') {
				$arrEvent [] = $new ['search']->find ( 'event', array (
						'eventid' => $item ['id'] 
				) );
			} elseif ($item ['type'] == 'user') {
				$arrUser [] = $new ['search']->find ( 'user_info', array (
						'userid' => $item ['id'] 
				) );
			}
		}
		
		// $all_num = $db->once_num_rows ( "select groupid as id,'group' as type from " . dbprefix . "group where `groupname` like '%$kw%' union select topicid as id,'topic' as type from " . dbprefix . "group_topic WHERE `title` like '%$kw%' union select userid as id,'user' as type from " . dbprefix . "user_info where username like '%$kw%' union select articleid as id,'article' as type from " . dbprefix . "article where `title` like '%$kw%' union select bookid as id,'book' as type from " . dbprefix . "book where `bookname` like '%$kw%'" );
		$all_num = $db->once_num_rows ( $allQuery );
		
		$pageUrl = pagination ( $all_num, 10, $page, $url );
		
		$title = $kw . ' - 全部搜索';
		
		include template ( "s_all" );
		break;
	
	// 问答
	case "ask" :
		$page = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
		$url = tsUrl ( 'search', 's', array (
				'ts' => 'ask',
				'kw' => $kw,
				'page' => '' 
		) );
		$lstart = $page * 10 - 10;
		
		$arrBook = $db->fetch_all_assoc ( "select * from " . dbprefix . "ask WHERE `title` like '%$kw%' order by uptime desc limit $lstart,10" );
		
		$ask_num = $db->once_num_rows ( "select * from " . dbprefix . "ask WHERE title like '%$kw%'" );
		
		$pageUrl = pagination ( $ask_num, 10, $page, $url );
		
		$title = $kw . ' - 精品汇搜索';
		include template ( "s_ask" );
		break;
	
	// 图书
	case "book" :
		$page = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
		$url = tsUrl ( 'search', 's', array (
				'ts' => 'book',
				'kw' => $kw,
				'page' => '' 
		) );
		$lstart = $page * 10 - 10;
		
		$arrBook = $db->fetch_all_assoc ( "select * from " . dbprefix . "book WHERE `bookname` like '%$kw%' order by uptime desc limit $lstart,10" );
		
		$book_num = $db->once_num_rows ( "select * from " . dbprefix . "book WHERE bookname like '%$kw%'" );
		
		$pageUrl = pagination ( $book_num, 10, $page, $url );
		
		$title = $kw . ' - 精品汇搜索';
		include template ( "s_book" );
		break;
	
	// 问答
	case "event" :
		$page = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
		$url = tsUrl ( 'search', 's', array (
				'ts' => 'event',
				'kw' => $kw,
				'page' => '' 
		) );
		$lstart = $page * 10 - 10;
		
		$arrBook = $db->fetch_all_assoc ( "select * from " . dbprefix . "event WHERE `title` like '%$kw%' order by uptime desc limit $lstart,10" );
		
		$event_num = $db->once_num_rows ( "select * from " . dbprefix . "event WHERE title like '%$kw%'" );
		
		$pageUrl = pagination ( $event_num, 10, $page, $url );
		
		$title = $kw . ' - 精品汇搜索';
		include template ( "s_event" );
		break;
	
	// 用户
	case "user" :
		$page = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
		$url = tsUrl ( 'search', 's', array (
				'ts' => 'user',
				'kw' => $kw,
				'page' => '' 
		) );
		$lstart = $page * 10 - 10;
		
		$arrUser = $db->fetch_all_assoc ( "select * from " . dbprefix . "user_info WHERE `username` like '%$kw%' order by userid desc limit $lstart,10" );
		
		$user_num = $db->once_num_rows ( "select * from " . dbprefix . "user_info WHERE `username` like '%$kw%'" );
		
		$pageUrl = pagination ( $user_num, 10, $page, $url );
		
		$title = $kw . ' - 用户搜索';
		include template ( "s_user" );
		
		break;
	// 小组
	case "group" :
		
		$page = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
		$url = tsUrl ( 'search', 's', array (
				'ts' => 'group',
				'kw' => $kw,
				'page' => '' 
		) );
		$lstart = $page * 10 - 10;
		
		$arrGroup = $db->fetch_all_assoc ( "select * from " . dbprefix . "group WHERE `groupname` like '%$kw%' order by groupid desc limit $lstart,10" );
		
		$group_num = $db->once_num_rows ( "select * from " . dbprefix . "group WHERE groupname like '%$kw%'" );
		
		$pageUrl = pagination ( $group_num, 10, $page, $url );
		
		$title = $kw . ' - 小组搜索';
		
		include template ( "s_group" );
		break;
	// 帖子
	case "topic" :
		
		$page = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
		$url = tsUrl ( 'search', 's', array (
				'ts' => 'topic',
				'kw' => $kw,
				'page' => '' 
		) );
		$lstart = $page * 10 - 10;
		
		$arrTopic = $db->fetch_all_assoc ( "select * from " . dbprefix . "group_topic WHERE `title` like '%$kw%' order by topicid desc limit $lstart,10" );
		
		$topic_num = $db->once_num_rows ( "select * from " . dbprefix . "group_topic WHERE title like '%$kw%'" );
		
		$pageUrl = pagination ( $topic_num, 10, $page, $url );
		
		$title = $kw . ' - 帖子搜索';
		include template ( "s_topic" );
		break;
	
	case "article" :
		
		$page = isset ( $_GET ['page'] ) ? intval ( $_GET ['page'] ) : 1;
		$url = tsUrl ( 'search', 's', array (
				'ts' => 'article',
				'kw' => $kw,
				'page' => '' 
		) );
		$lstart = $page * 10 - 10;
		
		$arrArticle = $db->fetch_all_assoc ( "select * from " . dbprefix . "article WHERE `title` like '%$kw%' order by addtime desc limit $lstart,10" );
		
		$articleNum = $db->once_num_rows ( "select * from " . dbprefix . "article WHERE `title` like '%$kw%'" );
		
		$pageUrl = pagination ( $articleNum, 10, $page, $url );
		
		$title = $kw . ' - 文章搜索';
		include template ( "s_article" );
		
		break;
}