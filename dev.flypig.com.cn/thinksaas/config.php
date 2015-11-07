<?php 
//环境配置文件
return array(
	
	//Memcache配置
	'memcache'=>array(
		//'host' => '127.0.0.1',
		//'port' => 11211,
	),
	
	//是否开启debug，正式环境下请关闭
	'debug'=>true,
	
	//是否开启显示插件钩子
	'hook'=>false, 
	
	//是否开启数据库存取session  暂时还有点问题预留
	'session'=>false,   
	
	//是否开启系统日志记录功能，日志存放在根目录下logs目录下
	'logs'=>false,  
	
	//是否支持app二级域名访问，比如小组group支持group.thinksaas.cn域名访问
	//不开启请留空数组，开启写域名，比如thinksaas.cn
	'subdomain'=>array(
		//'domain'=>'thinkpaas.com', //域名
		//'app'=>array('group','user'), //开启子域的APP
	), 
	
	//APP独立域名支持
	'appdomain'=>array(
		//'photo'=>'www.thinkphotos.com', //www.thinkphotos.com
	),
	
	//缓存图片和附件等支持其他域名访问，首先请将需要绑定的域名解析到程序目录
	//'fileurl'=>'',
	'fileurl'=>array(
		//'url'=>'cache.thinksaas.cn',
		//'dir'=>array('cache','uploadfile','public'),
	), 
	
	//数据库配置
	'db'=>array(
		'sql'=>'mysql',
		'host'=>'localhost',
		'port'=>'3306',
		'user'=>'root',
		'pwd'=>'',
		'name'=>'thinksaas',
		'pre'=>'ts_',
	),
	
	//是否开启手机web端，只针对具有mobile app的用户
	'mobile'=>true,
	
	//上传图片格式和大小
	'photo'=>array(
		'type'=>array('jpg','gif','png','jpeg'),
		'size'=>3 //比如2M就写2
	),
	//上传附件
	'attach'=>array(
		'type'=>array ('jpg','gif','png','rar','zip','doc','ppt','txt' ),
		'size'=>3 //比如2M就写2
	),
	
	/* 软件信息
	 * 请尊重ThinkSAAS版权信息，如需去除请购买ThinkSAAS商业授权
	 * 联系QQ:1078700473
	 */
	'info'=>array(
		'name'	=>	'ThinkSAAS',
		'version'	=>	'2.1',
		'url'		=>	'http://www.thinksaas.cn/',
		'email'	=>	'jun.qiu@thinksaas.cn',
		'powered'	=>	'Powered by ThinkSAAS',
		'copyright' =>	'飞猪网',
		'copyurl'=>'http://www.flypig.com.cn/',
		'year'		=>	'2014',
		'author'	=>	'QiuJun',
	),
	
);