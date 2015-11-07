<?php 
defined('IN_TS') or die('Access Denied.');

//所有图书
$cidset = isset($_GET['cidset']) ? trim($_GET['cidset']) : '0_0_0_0_0';
//解析cidset
if(!preg_match("/^[0-9]+(_[0-9]+){4}$/i",$cidset)){
	die('param error!');
}
$cidsets = explode('_',$cidset);
list($az,$age,$intel,$theme,$spec) = $cidsets;

//获取类别数据
$arrCate = $new['book']->getCateList();

//获取作者数据
$arrAuthor = $new['book']->getAuthorList();

//获取出版社数据
$arrPubhouse = $new['book']->getPubhouseList();

$cate_sql = "";
$cate_where = "";
$cate_sqls = array();
$cate_wheres = array();
if($age) $cate_wheres[] = $age;
if($intel) $cate_wheres[] = $intel;
if($theme) $cate_wheres[] = $theme;
if($spec) $cate_wheres[] = $spec;
if(count($cate_wheres)>0){
	$cate_where = join(',',$cate_wheres);
	$cate_where = ' cateid in('.$cate_where.') group by bookid having count(*)='.count($cate_wheres);
	
	//定义当前类别id数组
	$cate_ids = array();
	$cate_idss = $new['book']->findAll('book_cate_info',$cate_where,'bookid asc','bookid');
	//$cate_idss = $db->fetch_all_assoc("select bookid from ".dbprefix."book_cate_info ".$cate_where." group by bookid ");
	foreach($cate_idss as $k=>$v){
		$cate_ids[$k] = $v['bookid'];
	};
	$cate_ids = array_flip(array_flip($cate_ids)); 
	$cate_idstr = implode(',',$cate_ids);
	$cate_sqls[] = "bookid in({$cate_idstr})";
}

//加载字母
if($az) $cate_sqls[] = "letter='".chr($az)."'";
$cate_sql = join(' AND ',$cate_sqls);
//var_dump($cate_sql);

//筛选类别菜单
$bookcates  = "<ul>\r\n";
$bookcates .= "  <li class=\"clearfix first\">\r\n";
$bookcates .= "    <span class=\"t\">\r\n";
$bookcates .= "      字母分类：&nbsp;\r\n";
$bookcates .= "      <a".(($az == 0) ? " class=\"on\"" : "")." href=\"".tsUrl('book','index',array('cidset'=>'0_'.$age.'_'.$intel.'_'.$theme.'_'.$spec))."\">不限</a>\r\n";
$bookcates .= "    </span>\r\n";
$bookcates .= "    <span class=\"c\">\r\n";
for($i=ord("a");$i<=ord("z");$i++){
	$bookcates .= "      <a".(($az == $i) ? " class=\"on\"" : "")." href=\"".tsUrl('book','index',array('cidset'=>$i.'_'.$age.'_'.$intel.'_'.$theme.'_'.$spec))."\">".strtoupper(chr($i))."</a>\r\n";
}
$bookcates .= "    </span>\r\n";
$bookcates .= "  </li>\r\n";
foreach($APP_book['categroup_guide'] as $ckey=>$citem){
	if($arrCate[$citem]){
		${$citem.'_tmp'} = ${$citem};
		${$citem} = 0;//全部
		//$bookcates .= "  <li class=\"clearfix".($ckey==0 ? " first":"")."\">\r\n";
		$bookcates .= "  <li class=\"clearfix\">\r\n";
		$bookcates .= "    <span class=\"t\">\r\n";
		$bookcates .= "      {$arrCate[$citem]['catename']}：&nbsp;\r\n";
		$bookcates .= "      <a".((${$citem.'_tmp'} == 0) ? " class=\"on\"" : "")." href=\"".tsUrl('book','index',array('cidset'=>$az.'_'.$age.'_'.$intel.'_'.$theme.'_'.$spec))."\">不限</a>\r\n";
		$bookcates .= "    </span>\r\n";
		$bookcates .= "    <span class=\"c\">\r\n";
		foreach($arrCate[$citem]['catesub'] as $key=>$item){
			${$citem} = $key;
			$bookcates .= "      <a".((${$citem.'_tmp'} == $item['cateid']) ? " class=\"on\"" : "")." href=\"".tsUrl('book','index',array('cidset'=>$az.'_'.$age.'_'.$intel.'_'.$theme.'_'.$spec))."\">".$item['catename']."</a>\r\n";
		}
		$bookcates .= "    </span>\r\n";
		$bookcates .= "  </li>\r\n";
		${$citem} = ${$citem.'_tmp'};
	}
}
$bookcates .= "</ul>\r\n";

$pagesize = 10;
$page = isset($_GET['page']) ? $_GET['page'] : '1';
$url = tsUrl('book','index',array('cidset'=>$cidset,'page'=>''));
$lstart = ($page-1)*$pagesize;

//查询结果数
$bookNum = $new['book']->findCount('book',$cate_sql);
$bookNum = $bookNum ? $bookNum : 0;

//查询结果
$arrFilterBook = array();
$arrBooks = $new['book']->findAll('book',$cate_sql,'addtime desc','bookid',$lstart.','.$pagesize);
//$catBooks = $db->fetch_all_assoc("select * from ".dbprefix."book_cate order by cateid ASC");
foreach($arrBooks as $key=>$item){
	$arrFilterBook[] = $new['book']->getOneBook($item['bookid']);
}

//格式化输出数据
foreach($arrFilterBook as $key=>$item){
	$arrFilterBook[$key]['description'] = cututf8(tt(t($item['description'])),0,110);
	//作者
	$arrBookAuthor = $new['book']->getOneBookAuthor($item['bookid']);
	$arrFilterBook[$key]['author'] = formatAuthor($arrAuthor,$arrBookAuthor);
	//echo "<pre>";var_dump($arrBookAuthor);
	//出版社
	$arrFilterBook[$key]['pubhouse'] = $arrPubhouse[$item['pubhouse']]['puname'];
	//类别
	$arrBookCate = $new['book']->getOneBookCate($item['bookid']);
	//格式化类别输出
	$formatBookCate = formatCate($arrCate,$arrBookCate);
	foreach($formatBookCate as $k=>$v){
		$arrFilterBook[$key][$k] = $v;
	}
}

//分页
$pageUrl = pagination($bookNum, $pagesize, $page, $url);

//我加入的图书
$myBook = array();
if($TS_USER['user']['userid']){
	$myBooks = $new['book']->findAll('book_user',array(
		'userid'=>$TS_USER['user']['userid'],
	),null,'bookid');
	foreach($myBooks as $item){
		$myBook[]=$item['bookid'];
	}
}

//最新10个图书
$arrNewBook = $new['book']->getNewBook(10);

//热门书评
$arrReviews = $new['book']->findAll('review',array(
		'isaudit'=>'1',
	),'count_comment desc','bookid,reviewid,title,count_comment',10);
foreach($arrReviews as $key=>$item){
	$arrReview[] = $item;
	$arrReview[$key]['book'] = $new['book']->getOneBook($item['bookid']);
	$arrReview[$key]['title'] = htmlspecialchars($item['title']);
}

$title = '分类筛选';

include template('index');
