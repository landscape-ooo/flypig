<?php
defined('IN_TS') or die('Access Denied.');

$title = $TS_SITE['base']['site_subtitle'];

//分页处理
$pagesize = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page-1)*$pagesize;

//获取首页list内容
$arrIndex = $new['index']->findAll('index',array(
	'status'=>'1'
),'indexid DESC', null, $start.','.$pagesize);
foreach($arrIndex as $key=>$item){
	$strUser = aac('user')->getOneUser($item['userid']);
	$item['username'] = $strUser['username'];
	$item['template'] = '';
	$strType = $new['index']->find('index_type',array(
		'typeid'=>$item['typeid']
	));
	if($strType){
		$item['template'] = $strType['template'];
		$tmpdata = array();
		//$data = json_decode($item['jsondata'],true);
		$data = unserialize($item['serializedata']);
		if(is_array($data)){
			foreach($data as $k=>$v){
				switch($k){
					case 'pic':
						$app_pic = '';
						$arr_pic = explode('/', $v);
						if (count($arr_pic) == 5) {
							list($p1, $p2, $p3, $p4, $p5) = $arr_pic;
							$file = $p3 . '/' . $p4 . '/' . $p5;
							$path = $p3 . '/' . $p4;
							if ($item['appflag'] == 'review') {
								$app_pic = tsXimg($file, $p2, 220, 165, $path);
							} else {
								$app_pic = tsXimg($file, $item['appflag'], 220, 165, $path);
							}
						}
						$tmpdata['{'.$k.'}'] = $app_pic;
						break;
					case 'time':
						$app_time = getTime($v,time());
						$tmpdata['{'.$k.'}'] = urldecode($app_time);
						break;
					default:
						$tmpdata['{'.$k.'}'] = urldecode($v);
						break;
				}
			}
			
		}
		$arrIndex[$key] = array(
			'content' => strtr($item['template'],$tmpdata)
		);
	}
}
//var_dump($arrIndex);die;

//总数
$indexNum = $new['index']->findCount('index', array(
	'status'=>'1'
));

//分页
$url = tsUrl('index', 'index', array('ts'=>$ts,'page'=>''));
$pageUrl = pagination($indexNum, $pagesize, $page, $url);

//推荐的图书
$arrRecommendBook = aac('book')->getRecommendBook(6);

//最新签到用户
$arrUser = aac('user')->getHotUser(16);


if($TS_CF['mobile']) $sitemb = tsUrl('moblie');


$topvisitlist=$new['index']->getTopVisitlist();


include template("index");