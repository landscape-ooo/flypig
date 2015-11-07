<?php 
defined('IN_TS') or die('Access Denied.');

$provinceid = intval($_GET['provinceid']);

$city = $new['user']->findAll('area_city',array(
	'fatherid'=>$provinceid,
));
if(is_array($city) && count($city)>0){
	echo '<select id="sel_city" name="sel_city">
			<option value="0">请选择市</option>';
	foreach($city as $k=>$v){
		echo '<option value="'.$v['cityid'].'">'.$v['city'].'</option>';
	}
	echo '</select>';
}