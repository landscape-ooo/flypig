<?php
/**
 * KindEditor PHP
 *
 * 本PHP程序是演示程序，建议不要直接在实际项目中使用。
 * 如果您确定直接使用本程序，使用之前请仔细确认相关安全设置。
 *
 */

require_once 'JSON.php';

$php_path = dirname(__FILE__) . '/';
$php_url = dirname($_SERVER['PHP_SELF']) . '/';

//adan修改目录
//文件保存目录路径
//$save_path = $php_path . '../attached/';
$save_path = $php_path . '../../../../attached/';
//文件保存目录URL
//$save_url = $php_url . '../attached/';
$save_url = $php_url . '../../../../attached/';
///

//定义允许上传的文件扩展名
$ext_arr = array(
	'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
	'flash' => array('swf', 'flv'),
	'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
	'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
);
//最大文件大小
$max_size = 1000000;

$save_path = realpath($save_path) . '/';

//PHP上传失败
if (!empty($_FILES['imgFile']['error'])) {
	switch($_FILES['imgFile']['error']){
		case '1':
			$error = '超过php.ini允许的大小。';
			break;
		case '2':
			$error = '超过表单允许的大小。';
			break;
		case '3':
			$error = '图片只有部分被上传。';
			break;
		case '4':
			$error = '请选择图片。';
			break;
		case '6':
			$error = '找不到临时目录。';
			break;
		case '7':
			$error = '写文件到硬盘出错。';
			break;
		case '8':
			$error = 'File upload stopped by extension。';
			break;
		case '999':
		default:
			$error = '未知错误。';
	}
	alert($error);
}

//有上传文件时
if(empty($_FILES) === false){
	//原文件名
	$file_name = $_FILES['imgFile']['name'];
	//服务器上临时文件名
	$tmp_name = $_FILES['imgFile']['tmp_name'];
	//文件大小
	$file_size = $_FILES['imgFile']['size'];
	//检查文件名
	if (!$file_name) {
		alert("请选择文件。");
	}
	//检查目录
	if (@is_dir($save_path) === false) {
		alert("上传目录不存在。");
	}
	//检查目录写权限
	if (@is_writable($save_path) === false) {
		alert("上传目录没有写权限。");
	}
	//检查是否已上传
	if (@is_uploaded_file($tmp_name) === false) {
		alert("上传失败。");
	}
	//检查文件大小
	if ($file_size > $max_size) {
		alert("上传文件大小超过限制。");
	}
	//检查目录名
	$dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
	if (empty($ext_arr[$dir_name])) {
		alert("目录名不正确。");
	}
	//获得文件扩展名
	$temp_arr = explode(".", $file_name);
	$file_ext = array_pop($temp_arr);
	$file_ext = trim($file_ext);
	$file_ext = strtolower($file_ext);
	//检查扩展名
	if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
		alert("上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
	}
	//创建文件夹
	if ($dir_name !== '') {
		$save_path .= $dir_name . "/";
		$save_url .= $dir_name . "/";
		if (!file_exists($save_path)) {
			mkdir($save_path);
		}
	}
	$ymd = date("Ymd");
	$save_path .= $ymd . "/";
	$save_url .= $ymd . "/";
	if (!file_exists($save_path)) {
		mkdir($save_path);
	}
	//新文件名
	$new_file_name = date("YmdHis") . '_' . rand(10000, 99999);
	//移动文件
	$file_path = $save_path . $new_file_name . '.' . $file_ext;
	if (move_uploaded_file($tmp_name, $file_path) === false) {
		alert("上传文件失败。");
	}
	//adan等比例生成缩略图
	/*
	@chmod($file_path, 0644);
	$file_url = $save_url . $new_file_name;

	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 0, 'url' => $file_url));
	*/
	else{
		@chmod($file_path, 0644);
		$file_url = $save_url . $new_file_name . '.' . $file_ext;
		
		header('Content-type: text/html; charset=UTF-8');
		$json = new Services_JSON();
		
		//目标宽度
		if(!isset($_POST['maxWidth'])){
			$obj_width = 500;
		}else{
			$obj_width = intval($_POST['maxWidth']);
		}
		
		$file_info = getimagesize($file_path);
		if(!$file_info){
			alert("上传文件错误。");
		}
		$file_width = $file_info[0];
		$file_height = $file_info[1];
		if($file_width > $obj_width){
			$file_path_small = $save_path . $new_file_name . '_500x0' . '.' . $file_ext;
			$file_url_small = $save_url . $new_file_name . '_500x0' . '.' . $file_ext;
			move_uploaded_file(img2thumb($file_path,$file_path_small,'500','',0,0), $file_path);
			//图片适应宽度
			$img_width = strval($obj_width - 10);
			echo $json->encode(array('error' => 0, 'url' => $file_url_small, 'width' => $img_width, 'relurl' => $file_url));
		}else{
			echo $json->encode(array('error' => 0, 'url' => $file_url));
		}
	}
	///
	exit;
}

function alert($msg) {
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 1, 'message' => $msg));
	exit;
}

/**
 * 生成缩略图
 * @param string     源图绝对完整地址{带文件名及后缀名}
 * @param string     目标图绝对完整地址{带文件名及后缀名}
 * @param int        缩略图宽{0:此时目标高度不能为0，目标宽度为源图宽*(目标高度/源图高)}
 * @param int        缩略图高{0:此时目标宽度不能为0，目标高度为源图高*(目标宽度/源图宽)}
 * @param int        是否裁切{宽,高必须非0}
 * @param int/float  缩放{0:不缩放, 0<this<1:缩放到相应比例(此时宽高限制和裁切均失效)}
 * @return boolean
 */
function img2thumb($src_img, $dst_img, $width=800, $height=600, $cut=0, $proportion=0){
	if(!is_file($src_img)){
		return false;
	}
	$ot = pathinfo($dst_img, PATHINFO_EXTENSION);//fileext
	$otfunc = 'image' . ($ot == 'jpg' ? 'jpeg' : $ot);
	$srcinfo = getimagesize($src_img);
	$src_w = $srcinfo[0];
	$src_h = $srcinfo[1];
	$type  = strtolower(substr(image_type_to_extension($srcinfo[2]), 1));
	$createfun = 'imagecreatefrom' . ($type == 'jpg' ? 'jpeg' : $type);

	$dst_h = $height;
	$dst_w = $width;
	$x = $y = 0;

	/**
	* 缩略图不超过源图尺寸（前提是宽或高只有一个）
	*/
	if(($width> $src_w && $height> $src_h) || ($height> $src_h && $width == 0) || ($width> $src_w && $height == 0)){
		$proportion = 1;
	}
	if($width> $src_w){
		$dst_w = $width = $src_w;
	}
	if($height> $src_h){
		$dst_h = $height = $src_h;
	}

	if(!$width && !$height && !$proportion){
		return false;
	}
	if(!$proportion){
		if($cut == 0){
			if($dst_w && $dst_h){
				if($dst_w/$src_w> $dst_h/$src_h){
					$dst_w = $src_w * ($dst_h / $src_h);
					$x = 0 - ($dst_w - $width) / 2;
				}else{
					$dst_h = $src_h * ($dst_w / $src_w);
					$y = 0 - ($dst_h - $height) / 2;
				}
			}else if($dst_w xor $dst_h){
				if($dst_w && !$dst_h){
					//有宽无高
					$propor = $dst_w / $src_w;
					$height = $dst_h  = $src_h * $propor;
				}else if(!$dst_w && $dst_h){
					//有高无宽
					$propor = $dst_h / $src_h;
					$width  = $dst_w = $src_w * $propor;
				}
			}
		}else{
			//裁剪时无高
			if(!$dst_h){
				$height = $dst_h = $dst_w;
			}
			//裁剪时无宽
			if(!$dst_w){
				$width = $dst_w = $dst_h;
			}
			$propor = min(max($dst_w / $src_w, $dst_h / $src_h), 1);
			$dst_w = (int)round($src_w * $propor);
			$dst_h = (int)round($src_h * $propor);
			$x = ($width - $dst_w) / 2;
			$y = ($height - $dst_h) / 2;
		}
	}else{
		$proportion = min($proportion, 1);
		$height = $dst_h = $src_h * $proportion;
		$width  = $dst_w = $src_w * $proportion;
	}

	$src = $createfun($src_img);
	$dst = imagecreatetruecolor($width ? $width : $dst_w, $height ? $height : $dst_h);
	$white = imagecolorallocate($dst, 255, 255, 255);
	imagefill($dst, 0, 0, $white);

	if(function_exists('imagecopyresampled')){
		imagecopyresampled($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
	}else{
		imagecopyresized($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
	}
	$otfunc($dst, $dst_img);
	imagedestroy($dst);
	imagedestroy($src);
	return true;
}