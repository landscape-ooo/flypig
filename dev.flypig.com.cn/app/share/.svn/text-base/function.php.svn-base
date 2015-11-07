<?php
defined('IN_TS') or die('Access Denied.');

//远程POST
function formPost($url,$post_data){
	$data = '';
	foreach ($post_data as $k=>$v){
		$data .= "$k=".urlencode($v)."&";
	}
	$post_data=substr($data,0,-1);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$result = curl_exec($ch);
	return $result;
}

//过滤所有空格，回车，换行
function tt($str){
	$str = t($str);
	$str = preg_replace('/ /','',$str);
	$str = preg_replace('/&nbsp;/','',$str);
	$str = preg_replace('/　/','',$str);
	$str = preg_replace('/\r\n/','',$str);
	$str = str_replace(chr(13),'',$str);
	$str = str_replace(chr(10),'',$str);
	$str = str_replace(chr(9),'',$str);
	return $str;
}
//过滤正文样式
function __tthtml($str){
	return $str;
}
function _tthtml($str){
	$str = strip_tags($str,'<p><a><br><img><div>');
	$str = preg_replace("/<!--[^>]*-->/i", "", $str); //注释内容
	$str = preg_replace("/ style=.+?['|\"][^>]*/i",'',$str); //去除样式
	$str = preg_replace("/ class=.+?['|\"][^>]*/i",'',$str); //去除样式
	$str = preg_replace("/ id=.+?['|\"][^>]*/i",'',$str); //去除样式
	$str = preg_replace("/ lang=.+?['|\"][^>]*/i",'',$str); //去除样式
	$str = preg_replace("/ width=.+?['|\"][^>]*/i",'',$str); //去除样式
	$str = preg_replace("/ height=.+?['|\"][^>]*/i",'',$str); //去除样式
	$str = preg_replace("/ border=.+?['|\"][^>]*/i",'',$str); //去除样式
	$str = preg_replace("/ face=.+?['|\"][^>]*/i",'',$str); //去除样式
	return $str;
}

//格式化图书作者输出
function formatAuthor($arrAuthor, $arrBookAuthor){
	if(!isset($arrAuthor) || !isset($arrBookAuthor)) return '';
	global $APP_book;
	$arrCountry = array();
	foreach($APP_book['country'] as $ckey => $cval){
		$arrCountry[$cval[1]] = $cval[2];//简称
	}
	$author1 = $author2 = $author3 = array();
	if(isset($arrBookAuthor[1])){
		$author1 = array_keys($arrBookAuthor[1]);
	}
	if(isset($arrBookAuthor[2])){
		$author2 = array_keys($arrBookAuthor[2]);
	}
	if(isset($arrBookAuthor[3])){
		$author3 = array_keys($arrBookAuthor[3]);
	}
	
	$strAuthor = '';
	if(empty($author1) && empty($author2))
		return '';
	if(!empty($author1)){
		$diffa = array_diff($author1, $author2);
		$diffb = array_diff($author2, $author1);
		if(empty($diffa) && empty($diffb)){
			$arrAuthor_tmp = array();
			foreach($author1 as $uid){
				$arrAuthor_tmp[] = "[".$arrCountry[$arrAuthor[$uid]['country']]."]".$arrAuthor[$uid]['auname'];
			}
			$strAuthor_tmp = join(" ", $arrAuthor_tmp);
			$strAuthor .= "文/图，".$strAuthor_tmp;
		}else{
			$arrAuthor_tmp = array();
			foreach($author1 as $uid){
				$arrAuthor_tmp[] = "[".$arrCountry[$arrAuthor[$uid]['country']]."]".$arrAuthor[$uid]['auname'];
			}
			$strAuthor_tmp = join(" ", $arrAuthor_tmp);
			$strAuthor .= "文，".$strAuthor_tmp;
			if(!empty($author2)){
				$arrAuthor_tmp = array();
				foreach($author2 as $uid){
					$arrAuthor_tmp[] = "[".$arrCountry[$arrAuthor[$uid]['country']]."]".$arrAuthor[$uid]['auname'];
				}
				$strAuthor_tmp = join(" ", $arrAuthor_tmp);
				$strAuthor .= "　图，".$strAuthor_tmp;
			}
		}
	}elseif(!empty($author2)){
		$arrAuthor_tmp = array();
		foreach($author2 as $uid){
			$arrAuthor_tmp[] = "[".$arrCountry[$arrAuthor[$uid]['country']]."]".$arrAuthor[$uid]['auname'];
		}
		$strAuthor_tmp = join(" ", $arrAuthor_tmp);
		$strAuthor .= "图，".$strAuthor_tmp;
	}
	if(!empty($author3)){
		$arrAuthor_tmp = array();
		foreach($author3 as $uid){
			$arrAuthor_tmp[] = "[".$arrCountry[$arrAuthor[$uid]['country']]."]".$arrAuthor[$uid]['auname'];
		}
		$strAuthor_tmp = join(" ", $arrAuthor_tmp);
		$strAuthor .= (!empty($strAuthor) ? "<br>":"")."译，".$strAuthor_tmp;
	}
	return preg_replace('/(·|•)/i',"<span style=\"font-family:'宋体';\">·</span>",$strAuthor);
}

//格式化类别输出
function formatCate($arrCate,$arrBookCate,$flag=false){
	global $APP_book;
	$formatArr = array();
	foreach($APP_book['categroup'] as $val){
		if(isset($arrBookCate[$val])){
			switch($val){
				case "star":
					$tmp_str = '';
					$curCate = current($arrBookCate[$val]);
					$catename = $arrCate[$val]['catesub'][$curCate['cateid']]['catename'];
					$catevalue = $arrCate[$val]['catesub'][$curCate['cateid']]['catevalue'];
					$tmp_str .= "<span class=\"com-star-level\" title=\"".$catename."\">\r\n";
					$tmp_str .= "  <span style=\"width: ".$catevalue."%;\"></span>\r\n";
					$tmp_str .= "</span>（".$catename."）\r\n";
					$formatArr[$val] = $tmp_str;
					break;
				case "packing":
				case "format":
				case "paper":
					$tmp_str = '';
					$curCate = current($arrBookCate[$val]);
					$tmp_str .= $arrCate[$val]['catesub'][$cateid]['catename'];
					$formatArr[$val] = $tmp_str;
					break;
				case "age":
				case "intel":
				case "theme":
				case "spec":
					$tmp_arr = array();
					foreach($arrBookCate[$val] as $k=>$v){
						$tmp_arr[] = $arrCate[$val]['catesub'][$k]['catename'];
					}
					$formatArr[$val] = join('，',$tmp_arr);
					break;
				default:
					break;
			}
		}
	}
	if($flag !== false){
		return $formatArr[$flag];
	}else{
		return $formatArr;
	}
}
//获取汉字拼音
