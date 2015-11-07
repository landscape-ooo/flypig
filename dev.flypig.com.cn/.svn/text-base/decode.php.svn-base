<?php
header("content-type:text/html;charset=utf-8");

$path = dirname(__FILE__) . '/decode/';
//var_dump(Dir::formatDirPath($path));die;

$files_list = Dir::getAllFiles(Dir::formatDirPath($path), 'php');
//var_dump($files_list);die;

if(is_array($files_list) && count($files_list) > 0){
	foreach($files_list as $value){
		if(is_file($value) && $value != __FILE__){ 
			//value是要解密的文件
			$lines = file($value);//0,1,2行
			//var_dump($lines);
			//die;

			//第一次base64解密 
			$content=""; 
			if(preg_match("/O0O0000O0\(\'(.*)\'\)\)\)\;/", $lines[1], $y)) {
				if(isset($y[1]) && $y[1] != ''){
					$content = base64_decode($y[1]);
					//var_dump($content);
					//die;

					//第一次base64解密后的内容中查找密钥
					$decode_key = '';
					if(preg_match("/\)\,\'(.*)\'\,\'/", $content, $k)) { 
						if(isset($k[1]) && $k[1] != '') {
							$decode_key = $k[1];
							//var_dump($decode_key);
							//die;


							//截取文件加密后的密文
							$Secret = substr($lines[2], 380);
							//var_dump($Secret);
							//die;

							//直接还原密文输出
							$php_code = base64_decode(strtr($Secret, $decode_key, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/'));

							//替换文件
							if($php_code){
								$fp = fopen($value . '.tmp', 'a+');
								if ($fp) {
									fwrite($fp, "<?php ".$php_code."?>");
									fclose($fp);
								}

								if(copy($value, $value . '.bak')){
									copy($value . '.tmp', $value);
									unlink($value . '.tmp');
									echo $value . '解密完成';
								} else {
									echo $value . '文件复制出错';
								}
							} else {
								echo $value . '解密内容为空或出错';
							}
						}
					}

				}
				
			}
		}
	}
}

/**
 * Dir
* @author adan
*
*/
class Dir {

	//标准化文件路径
	public static function formatDirPath($path) {
		$path = str_replace('\\', '/', $path);
		if (substr($path, -1) != '/') {
			$path = $path . '/';
		}
		return $path;
	}

	//递归获取文件夹子文件列表(数组，所有子文件)
	public static function getAllFiles($dir, $ext = null, $order = 'asc') {
		$files = array();
		$dir = self::formatDirPath($dir);
		if (is_dir($dir)) {
			if ($dh = @opendir($dir)) {
				while ($file = readdir($dh)) {
					if ($file != '.' && $file != '..') {
						$file_path = $dir . $file;
						if (is_dir($file_path)) {
							$files = array_merge($files, self::getAllFiles($file_path, $ext, $order));
						} else {
							//如果指定文件格式
							if ($ext) {
								if (!is_array($ext)) {
									$ext = explode(',', $ext);
								}
								$d = strrpos($file, '.');
								if ($d) {
									$e = substr($file, $d + 1);
									if (in_array($e, $ext)) {
										$files[] = $file_path;
									}
								}
							} else {
								$files[] = $file_path;
							}
						}
					}
				}
			}
		}
		if ($order == 'asc') {
			sort($files); //正序
		} else {
			rsort($files); //倒序，由新到旧排序
		}
		return $files;
	}

}
