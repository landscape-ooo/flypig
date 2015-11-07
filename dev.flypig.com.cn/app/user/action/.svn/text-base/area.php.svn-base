<?php 
defined('IN_TS') or die('Access Denied.');

$cityid = intval($_GET['cityid']);

$city = $new['user']->findAll('area',array(
	'fatherid'=>$cityid
));
if(is_array($city) && count($city)>0){
	echo '<select id="sel_area" name="sel_area">
			<option value="0">请选择区</option>';
	foreach($city as $k=>$v){
		echo '<option value="'.$v['areaid'].'">'.$v['area'].'</option>';
	}
	echo '</select>';
}