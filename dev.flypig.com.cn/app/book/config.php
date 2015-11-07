<?php
defined('IN_TS') or die('Access Denied.');
/*
 *包含数据库配置文件
 */
require_once THINKDATA."/config.inc.php";

$skin = 'default';

//APP配置变量 $APP_{appname} APP内有效。为统一格式appname小写状态
$APP_book = array(
	
	//数据缓存有效期
	'cachetime' => 3600,

	//分类群组，方便取数据而设
	'categroup' => array(
		'paper', 'packing', 'format', 'star','age', 'intel', 'theme', 'spec'
	),

	//分类筛选群组，方便取数据而设
	'categroup_guide' => array(
		'age', 'intel', 'theme', 'spec'
	),

	//图书附加内容表,附加信息分类。1 内容介绍, 2 专家推荐, 3 图画赏析
	'addtype' => array(
		1,2,3
	),

	//图书作者分类。1 文作者, 2 图作者, 3 翻译
	'authortype' => array(
		1,2,3
	),

	//作者所属国，数据来自邮编+区号库http://www.youbianku.com/%E4%BB%A5%E8%89%B2%E5%88%97
	'country' => array(
		array('9990000', '中国', '中'),
		array('9990390', '美国', '美'),
		array('9990200', '英国', '英'),
		array('9990400', '加拿大', '加'),
		array('9990240', '匈牙利', '匈'),
		array('9990130', '奥地利', '奥'),
		array('9990811', '俄国', '俄国'),
		array('9990810', '俄罗斯', '俄罗斯'),
		array('9990350', '德国', '德'),
		array('9990160', '意大利', '意'),
		array('9990260', '挪威', '挪'),
		array('9990010', '日本', '日'),
		array('9990070', '韩国', '韩'),
		array('9990850', '墨西哥', '墨'),
		array('9990130', '比利时', '比'),
		array('9990190', '法国', '法'),
		array('9990290', '澳大利亚', '澳'),
		array('9990140', '爱尔兰', '爱'),
		array('9990270', '瑞典', '瑞典'),
		array('9990340', '瑞士', '瑞士'),
		array('9990250', '荷兰', '荷'),
		array('9990230', '西班牙', '西'),
		array('9990800', '以色列', '以'),
	),
);
