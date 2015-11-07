<?php
// 请求初始化
$url = 'http://blog.snsgou.com/user/123456';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

// 返回的 http body 内容
$response = curl_exec($ch);

// 返回的 http header 的 Content-Type 的内容
$contentType = curl_getinfo($ch, 'content_type');

// 关闭请求资源
curl_close($ch);

// 结果自动格式输出
$autoDetectFormats = array(
	'application/xml' => 'xml',
	'text/xml' => 'xml',
	'application/json' => 'json',
	'text/json' => 'json',
	'text/csv' => 'csv',
	'application/csv' => 'csv',
	'application/vnd.php.serialized' => 'serialize'
);

if (strpos($contentType, ';')) {
	list($contentType) = explode(';', $contentType);
}

$contentType = trim($contentType);

if (array_key_exists($contentType, $autoDetectFormats)) {
	echo '_' . $autoDetectFormats[$contentType]($response);
}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++
// 常用 格式化 方法
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++


/**
 * 格式化xml输出
 */
function _xml($string) {
	return $string ? (array)simplexml_load_string($string, 'SimpleXMLElement', LIBXML_NOCDATA) : array();
}

/**
 * 格式化csv输出
 */
function _csv($string) {
	$data = array();
	
	$rows = explode("\n", trim($string));
	$headings = explode(',', array_shift($rows));
	foreach ($rows as $row) {
		// 利用 substr 去掉 开始 与 结尾 的 "
		$data_fields = explode('","', trim(substr($row, 1, -1)));
		if (count($data_fields) === count($headings)) {
			$data[] = array_combine($headings, $data_fields);
		}
	}
	
	return $data;
}

/**
 * 格式化json输出
 */
function _json($string) {
	return json_decode(trim($string), true);
}

/**
 * 反序列化输出
 */
function _serialize($string) {
	return unserialize(trim($string));
}

/**
 * 执行PHP脚本输出
 */
function _php($string) {
	$string = trim($string);
	$populated = array();
	eval("\$populated = \"$string\";");
	
	return $populated;
}