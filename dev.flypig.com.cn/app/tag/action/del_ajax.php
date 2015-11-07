<?php 
defined('IN_TS') or die('Access Denied.');
switch($ts){
	case "":
		
		$objname = tsFilter($_GET['objname']);
		$idname = tsFilter($_GET['idname']);
		$objid = intval($_GET['objid']);
		
		var_dump('no do!');
		break;
		
	case "do":
	
		$objname = t($_POST['objname']);
		$idname = t($_POST['idname']);
		$objid = t($_POST['objid']);
		$tagid = t($_POST['tagid']);
		
		$result = $new['tag']->delOneTag($objname,$idname,$objid,$tagid);
		if($result){
			echo "<script language=JavaScript>parent.window.location.reload();</script>";
		}
		break;
	default:
		break;
}