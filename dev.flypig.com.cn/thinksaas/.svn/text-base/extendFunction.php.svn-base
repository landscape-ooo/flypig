<?php
defined ( 'IN_TS' ) or die ( 'Access Denied.' );

/*
 * ThinkSAAS extend function 
 * @copyright (c) Flypig All Rights Reserved 
 * @code by LiuDan 
 * @Email:38388742@qq.com 
 * @TIME:2013-11-11
 */

/**
 * 纯文本输入
 * @param unknown $text
 * @return mixed
 */
function txtClean($text) {
	$text = cleanJs2 ( $text );
	$text = strip_tags ( $text );
	// 彻底过滤空格BY QINIAO
	$text = preg_replace ( '/\[.*?\]/is', '', $text );
	$text = preg_replace ( '/\s(?=\s)/', '', $text );
	$text = preg_replace ( '/[\n\r\t]/', ' ', $text );
	$text = str_replace ( '  ', ' ', $text );
	// $text = str_replace ( ' ', '', $text );
	$text = str_replace ( '&nbsp;', '', $text );
	$text = str_replace ( '&', '', $text );
	$text = str_replace ( '=', '', $text );
	$text = str_replace ( '-', '', $text );
	$text = str_replace ( '#', '', $text );
	$text = str_replace ( '%', '', $text );
	$text = str_replace ( '!', '', $text );
	$text = str_replace ( '@', '', $text );
	$text = str_replace ( '^', '', $text );
	$text = str_replace ( '*', '', $text );
	$text = str_replace ( "'", "", $text );
	$text = str_replace ( 'amp;', '', $text );
	$text = str_replace ( 'position', '', $text );
	return $text;
}

/**
 * 输入安全过滤
 * @param unknown $text
 * @return mixed
 * @Modify by adan
 */
function htmlClean($text) {
	if(is_string($text)){
		return cleanJs2($text);
	}elseif(is_array($text)){
		foreach($text as $key => $val){
			$text[$key] = htmlClean($val);
		}
		return $text;
	}elseif(is_object($text)){
		$vars = get_object_vars($text);
		foreach($vars as $key=>$val){
			$text->$key = htmlClean($val);
		}
		return $text;
	}
	return;
}

/**
 * 过滤脚本代码
 * @param unknown $text
 * @return mixed
 */
function cleanJs2($text) {
	$text = stripslashes(trim($text));
	//去除前后空格，并去除反斜杠
	//$text = br2nl($text); //将br转换成/n
	
	///////XSS start
	require_once 'thinksaas/xsshtml.class.php';
	$xss = new XssHtml($text);
	$text = $xss -> getHtml();
	//$text = substr ($text, 4);//去除左边<p>标签
	//$text = substr ($text, 0,-5);//去除右边</p>标签
	///////XSS end
	
	//$text = htmlentities($text, ENT_NOQUOTES, "utf-8");
	//把字符转换为 HTML 实体
	
	return $text;
}

//adan输出转换
function htmlShow($text) {
	if(is_string($text)){
		return stripslashes($text);
	}elseif(is_array($text)){ 
		foreach($text as $key => $val){
			$text[$key] = htmlShow($val); 
		}
		return $text;
	}elseif(is_object($text)) {
		$vars = get_object_vars($text); 
		foreach($vars as $key=>$val) { 
			$text->$key = htmlShow($val);
		}
		return $text;
	}
	return;
}

/**
 * json格式化数据
 */
function jsonAjax($code, $msg='', $data=array()) {
	$arr_temp = array();
	$arr_temp['code'] = $code;
	$arr_temp['msg'] = $msg;
	if(!empty($data)){
		$arr_temp['data'] = $data;
	}
	return json_encode($arr_temp);
}

//
function jsonResult($code, $msg='', $data=array()) {
	$arr_temp = array();
	$arr_temp['errorCode'] = $code;
	$arr_temp['errorMsg'] = $msg;
	if(!empty($data)){
		$arr_temp['responseData'] = $data;
	}
	return json_encode($arr_temp);
}

/**
 * 以下是DedeCMS中用到的字符编码转换的小助手函数
 *
 * @version        $Id: charset.helper.php 1 2010-07-05 11:43:09Z tianya $
 * @package        DedeCMS.Helpers
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

$UC2GBTABLE = '';

/**
 *  UTF-8 转GB编码
 *
 * @access    public
 * @param     string  $utfstr  需要转换的字符串
 * @return    string
 */
function utf82gb($utfstr){
	if(function_exists('iconv')){
		return iconv('utf-8','gbk//ignore',$utfstr);
	}
	global $UC2GBTABLE;
	$okstr = "";
	if(trim($utfstr)==""){
		return $utfstr;
	}
	if(empty($UC2GBTABLE)){
		$filename = THINKROOT.'/thinksaas/data/gb2312-utf8.dat';
		$fp = fopen($filename,"r");
		while($l = fgets($fp,15)){
			$UC2GBTABLE[hexdec(substr($l, 7, 6))] = hexdec(substr($l, 0, 6));
		}
		fclose($fp);
	}
	$okstr = "";
	$ulen = strlen($utfstr);
	for($i=0;$i<$ulen;$i++){
		$c = $utfstr[$i];
		$cb = decbin(ord($utfstr[$i]));
		if(strlen($cb)==8){
			$csize = strpos(decbin(ord($cb)),"0");
			for($j=0;$j < $csize;$j++){
				$i++; $c .= $utfstr[$i];
			}
			$c = utf82u($c);
			if(isset($UC2GBTABLE[$c])){
				$c = dechex($UC2GBTABLE[$c]+0x8080);
				$okstr .= chr(hexdec($c[0].$c[1])).chr(hexdec($c[2].$c[3]));
			}else{
				$okstr .= "&#".$c.";";
			}
		}else{
			$okstr .= $c;
		}
	}
	$okstr = trim($okstr);
	return $okstr;
}

/**
 *  utf8转Unicode
 *
 * @access    public
 * @param     string  $c  UTF-8的字符串信息
 * @return    string
 */
function utf82u($c){
	switch(strlen($c)){
		case 1:
			return ord($c);
		case 2:
			$n = (ord($c[0]) & 0x3f) << 6;
			$n += ord($c[1]) & 0x3f;
			return $n;
		case 3:
			$n = (ord($c[0]) & 0x1f) << 12;
			$n += (ord($c[1]) & 0x3f) << 6;
			$n += ord($c[2]) & 0x3f;
			return $n;
		case 4:
			$n = (ord($c[0]) & 0x0f) << 18;
			$n += (ord($c[1]) & 0x3f) << 12;
			$n += (ord($c[2]) & 0x3f) << 6;
			$n += ord($c[3]) & 0x3f;
			return $n;
	}
}

/**
 *  获取拼音信息
 *
 * @access    public
 * @param     string  $str  字符串
 * @param     int  $ishead  是否为首字母
 * @param     int  $isclose  解析后是否释放资源
 * @return    string
 */
function SpGetPinyin($str, $ishead=0, $isclose=1){
	global $pinyins;
	$restr = '';
	$str = trim($str);
	$slen = strlen($str);
	if($slen < 2){
		return $str;
	}
	if(count($pinyins) == 0){
		$fp = fopen(THINKROOT.'/thinksaas/data/pinyin.dat', 'r');
		while(!feof($fp)){
			$line = trim(fgets($fp));
			$pinyins[$line[0].$line[1]] = substr($line, 3, strlen($line)-3);
		}
		fclose($fp);
	}
	for($i=0; $i<$slen; $i++){
		if(ord($str[$i])>0x80){
			$c = $str[$i].$str[$i+1];
			$i++;
			if(isset($pinyins[$c])){
				if($ishead==0){
					$restr .= $pinyins[$c];
				}else{
					$restr .= $pinyins[$c][0];
				}
			}else{
				$restr .= "_";
			}
		}else if( preg_match("/[a-z0-9]/i", $str[$i]) ){
			$restr .= $str[$i];
		}else{
			$restr .= "_";
		}
	}
	if($isclose==0){
		unset($pinyins);
	}
	return $restr;
}

/**
 *  获取拼音以gbk编码为准
 *
 * @access    public
 * @param     string  $str     字符串信息
 * @param     int     $ishead  是否取头字母
 * @param     int     $isclose 是否关闭字符串资源
 * @return    string
 */
function GetPinyin($str, $ishead=0, $isclose=1, $lang='utf-8'){
	if($lang=='utf-8'){
		return SpGetPinyin(utf82gb($str), $ishead, $isclose);
	}else{
		return SpGetPinyin($str, $ishead, $isclose);
	}
}

/**
 *  获取半角字符
 *
 * @param     string  $fnum  数字字符串
 * @return    string
 */
function GetAlabNum($fnum){
	$nums = array("０","１","２","３","４","５","６","７","８","９");
	//$fnums = "0123456789";
	$fnums = array("0","1","2","3","4","5","6","7","8","9");
	$fnum = str_replace($nums, $fnums, $fnum);
	$fnum = preg_replace("/[^0-9\.-]/", '', $fnum);
	if($fnum=='')
	{
		$fnum=0;
	}
	return $fnum;
}

/*
 * writelog    /log.txt
 */
function phplog($str){
	$open=fopen("log.txt","a" );
	fwrite($open,$str."\r\n");
	fclose($open);
}