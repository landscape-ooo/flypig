<?php defined('IN_TS') or die('Access Denied.'); ?><?php if($TS_SITE['base'][isgzip]==1) { ?><?php ob_start('ob_gzip');?><?php } ?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
<?php if($app=='home' && $ac=='index') { ?>
<?php echo $TS_SITE['base'][site_title];?><?php if($title) { ?>_<?php echo $title;?><?php } ?>
<?php } elseif ($app!='home' && $ac=='index') { ?>
<?php echo $TS_APP['options'][appname];?><?php if($title) { ?>_<?php echo $title;?><?php } ?>_<?php echo $TS_SITE['base'][site_title];?>
<?php } else { ?>
<?php if($title) { ?><?php echo $title;?>_<?php } ?><?php echo $TS_APP['options'][appname];?>_<?php echo $TS_SITE['base'][site_title];?>
<?php } ?>
</title>
<?php if($app=='home' && $ac=='index') { ?>
<meta name="keywords" content="<?php echo $TS_SITE['base'][site_key];?>" />
<meta name="description" content="<?php echo $TS_SITE['base'][site_desc];?>" />
<?php } else { ?>
<?php if($sitekey) { ?><meta name="keywords" content="<?php echo $sitekey;?>" /><?php } ?>
<?php if($sitedesc) { ?><meta name="description" content="<?php echo $sitedesc;?>" /><?php } ?>
<?php } ?>
<?php if($sitemb) { ?>
<meta http-equiv="mobile-agent" content="format=xhtml; url=<?php echo $sitemb;?>" />
<?php } ?>
<link rel="shortcut icon" href="<?php echo SITE_URL;?>favicon.ico" />
<?php if(is_file('theme/'.$tstheme.'/base.css')) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>theme/<?php echo $tstheme;?>/base.css" />
<?php } ?>
<?php if(is_file('theme/'.$tstheme.'/style.css')) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>theme/<?php echo $tstheme;?>/style.css" id="tsTheme" />
<?php } ?>
<?php if(is_file('app/'.$app.'/skins/'.$skin.'/style.css')) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>app/<?php echo $app;?>/skins/<?php echo $skin;?>/style.css">
<?php } ?>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>public/artDialog/skins/default.css" rel="stylesheet" />
<script type="text/javascript">var siteUrl = '<?php echo SITE_URL;?>';</script>
<script type="text/javascript" src="<?php echo SITE_URL;?>public/js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>public/js/scrollfix/jquery.scrollfix.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>public/js/lazyload/jquery.lazyload.min.js"></script> 
<script type="text/javascript" src="<?php echo SITE_URL;?>public/js/jquery.imgLoader.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>public/artDialog/artDialog.min.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>public/js/jquery.slides.min.js"></script>
<?php doAction('pub_header_top')?>
<script type="text/javascript"> 
$(function(){
	$("img").lazyload({
		placeholder : "img/grey.gif",
		event : "click",
		effect: "fadeIn"
	});
});
</script>
</head>
<?php if(is_array($TS_SITE['appnav']) && $TS_SITE['appnav'][$app]!='') { ?>
<body class="app-<?php echo $app;?>">
<!--
<?php foreach((array)$TS_SITE['appnav'] as $key=>$item) {?>
<?php if($app==$key) { ?><body class="app-<?php echo $key;?>"><?php } ?>
<?php }?>
-->
<?php } else { ?>
<body>
<?php } ?>
<div id="top">
	<div class="clearfix">
		<div class="user">
			<?php if($TS_USER['user'] == '') { ?>
			<a href="<?php echo tsurl('user','register')?>"><img class="fimg" src="<?php echo SITE_URL;?>public/images/user_normal.jpg" width="24" height="24" align="absmiddle" alt="欢迎" /></a> 欢迎
			<a href="<?php echo tsurl('user','login')?>">登陆</a> | <a href="<?php echo tsurl('user','register')?>">注册</a>
			<?php } else { ?>
			<a href="<?php echo tsurl('user','space',array('id'=>$TS_USER['user'][userid]))?>">
			<img class="fimg" src="<?php if($TS_USER['user'][face]=="") { ?><?php echo SITE_URL;?>public/images/user_normal.jpg<?php } else { ?><?php echo tsXimg($TS_USER['user'][face],'user','18','18',$TS_USER['user'][path],'1')?><?php } ?>" width="18" align="absmiddle" alt="<?php echo $TS_USER['user']['username'];?>" /> 
			</a>
			<a href="<?php echo tsurl('user','space',array('id'=>$TS_USER['user'][userid]))?>"><?php echo $TS_USER['user'][username];?></a>，<a href="<?php echo tsurl('message','my')?>" class="msg">消息<span id="newmsg"></span></a> | <a href="<?php echo tsurl('user','set',array(ts=>base))?>" >设置</a> | 
			<?php if($TS_USER['user']['isadmin']=='1') { ?>
			<a target="_blank" href="<?php echo SITE_URL;?>index.php?app=system">管理</a> | 
			<?php } ?>
			<?php if($TS_SITE['base']['isinvite']=='1') { ?>
			<a href="<?php echo tsurl('user','invite')?>">邀请</a> | 
			<?php } ?>
			<a href="<?php echo tsurl('user','login',array(ts=>out))?>">退出</a>&nbsp;&nbsp;&nbsp;&nbsp;
			
			<?php if(!isset($_SESSION['tscover']) || (isset($_SESSION['tscover']['isadmin']) && $_SESSION['tscover']['isadmin']=='1')) { ?>
			<input name="cross_userid" value="" style="width:50px;height:15px;margin:0;padding:0;border:0;" />
			<span id="cross_do">ID穿越</span>
			<script type="text/javascript">
			$(function(){
				$("#cross_do").css({'cursor':'pointer'}).click(function(){
					var cross_userid = $("input[name='cross_userid']").val();
					if(cross_userid != ''){
						window.location = "<?php echo SITE_URL;?>index.php?app=user&ac=across&ts=do&userid=" + cross_userid + "&token=<?php echo $_SESSION['token'];?>";
					}
				});
			});
			</script>
			<?php if($tsMajiaUser) { ?>
			<select id="cross_majia" style="width:50px;height:15px;line-height:15px;margin:0;padding:-2px;border:0;font:normal 10px '\5FAE\8F6F\96C5\9ED1','Microsoft YaHei','Arial','simsun';">
			<option value=""> </option>
			<?php foreach((array)$tsMajiaUser as $key=>$value) {?>
			<option value="<?php echo $value['userid'];?>"><?php echo $value['username'];?></option>
			<?php }?>
			</select>
			<script type="text/javascript">
			$(function(){
				$("#cross_majia").change(function(){
					var cross_userid = $(this).children('option:selected').val();
					if(cross_userid != ''){
						window.location = "<?php echo SITE_URL;?>index.php?app=user&ac=across&ts=do&userid=" + cross_userid + "&token=<?php echo $_SESSION['token'];?>";
					}
				});
			});
			</script>
			<?php } ?>
			<?php } ?>
			<?php if(isset($_SESSION['tscover']['isadmin']) && $_SESSION['tscover']['isadmin']=='1') { ?>
			 | <span id="cross_back">恢复身份</span>
			<script type="text/javascript">
			$(function(){
				$("#cross_back").css({'cursor':'pointer'}).click(function(){
					window.location = "<?php echo tsurl('user','across',array('ts'=>'back','token'=>$_SESSION['token']))?>";
				});
			});
			</script>
			<?php } ?>
			<?php } ?>
		</div>
		<ul id="nav">
			<li<?php if($app=='index') { ?> class="select"<?php } ?>><a href="<?php echo SITE_URL;?>"><?php echo $TS_SITE['appnav'][index];?></a></li>
			<li<?php if($app=='ask') { ?> class="select"<?php } ?>><a href="<?php echo tsurl('ask')?>"><?php echo $TS_SITE['appnav'][ask];?></a></li>
			<li<?php if($app=='book') { ?> class="select"<?php } ?>><a href="<?php echo tsurl('book')?>"><?php echo $TS_SITE['appnav'][book];?></a></li>
			<li<?php if($app=='review') { ?> class="select"<?php } ?>><a href="<?php echo tsurl('review')?>"><?php echo $TS_SITE['appnav'][review];?></a></li>
			<li<?php if($app=='share') { ?> class="select"<?php } ?>><a href="<?php echo tsurl('share')?>"><?php echo $TS_SITE['appnav'][share];?></a></li>
			<li<?php if($app=='special') { ?> class="select"<?php } ?>><a href="<?php echo tsurl('special')?>"><?php echo $TS_SITE['appnav'][special];?></a></li>
			<li<?php if($app=='event') { ?> class="select"<?php } ?>><a href="<?php echo tsurl('event')?>"><?php echo $TS_SITE['appnav'][event];?></a></li>
		</ul>
	</div>
</div>
<div id="hd" class="clearfix">
	<div class="logo clearfix">
		<a class="main" href="<?php echo SITE_URL;?>" title="<?php echo $TS_SITE['base'][site_title];?>首页"><img title="<?php echo $TS_SITE['base'][site_title];?>" src="<?php echo SITE_URL;?>uploadfile/logo/<?php echo $TS_SITE['base'][logo];?>?v=<?php echo rand();?>" alt="<?php echo $TS_SITE['base'][site_title];?>" width="190" height="64" /></a>
		<?php if($TS_APP['options'][appname]) { ?>
		<a class="channel" href="<?php echo tsurl($app)?>" title="<?php echo $TS_SITE['base'][site_title];?><?php echo $TS_APP['options'][appname];?>频道"><?php echo $TS_APP['options'][appname];?><?php if($TS_APP['options'][appdesc]) { ?><span><?php echo $TS_APP['options'][appdesc];?></span><?php } ?></a>
		<?php } ?>
	</div>
	<div class="search">
		<form method="GET" action="<?php echo SITE_URL;?>index.php">
		<input type="hidden" name="app" value="search" />
		<input type="hidden" name="ac" value="s" />
		<div class="search_input clearfix">
			<input id="searchkw" type="text" name="kw" value="" placeholder="书评、图书、问答、活动" />
			<a class="search_btn" onclick="searchon()"></a>
		</div>
		<span style="display:none;"><input id="searchto" type="submit" value="搜索" /></span>
		</form>
	</div>
</div>
<div class="bd">
	<?php if($app=='index') { ?>
	<style type="text/css">
	#slides{width:960px;height:283px;position:relative;}
	#slides li{list-style:none;}
	.slide-pic{width:960px;height:283px;overflow:hidden;}
	.slide-op{position:absolute;right:10px;bottom:10px;z-index:100;}
	.slide-op li{width:20px;height:20px;line-height:20px;border-radius:20px;background:#fff;color:#000;text-align:center;float:left;cursor:pointer;filter:alpha(opacity=50);-moz-opacity:0.5;opacity:0.5;}
	.slide-op li.cur{background:#000;color:#fff;}
	</style>
	<div id="slides">
		<ul class="slide-pic">
			<li class="cur"><img src="http://www.flypig.com.cn/attached/image/20141012/20141012194358_85143.jpg" alt=""></li>
			<li><img src="http://www.flypig.com.cn/attached/image/20150407/20150407031741_88365.jpg" alt=""></li>
			<li><img src="http://www.flypig.com.cn/attached/image/20150407/20150407032044_76445.jpg" alt=""></li>
			<li><img src="http://www.flypig.com.cn/attached/image/20141130/20141130234649_20373.jpg" alt=""></li>
		</ul>
		<ul class="slide-op">
			<li class="cur">1</li>
			<li>2</li>
			<li>3</li>
			<li>4</li>
		</ul>
	</div>
	<script>
	jQuery(function($){
		if ($(".slide-pic").length > 0){
			var defaultOpts = { interval: 5000, fadeInTime: 300, fadeOutTime: 200 };
			var _ops = $("ul.slide-op li");
			var _bodies = $("ul.slide-pic li");
			var _count = _ops.length;
			var _current = 0;
			var _intervalID = null;
			var stop = function () { window.clearInterval(_intervalID); };
			var slide = function (opts) {
				if (opts) {
				_current = opts.current || 0;
				} else {
				_current = (_current >= (_count - 1)) ? 0 : (++_current);
				};
				_bodies.filter(":visible").fadeOut(defaultOpts.fadeOutTime, function () {
				_bodies.eq(_current).fadeIn(defaultOpts.fadeInTime);
				_bodies.removeClass("cur").eq(_current).addClass("cur");
				});
				_ops.removeClass("cur").eq(_current).addClass("cur");
			};
			var go = function () {
				stop();
				_intervalID = window.setInterval(function () { slide(); }, defaultOpts.interval);
			};
			var itemMouseOver = function (target, items) {
				stop();
				var i = $.inArray(target, items);
				slide({ current: i });
			};
			_ops.hover(function () { if ($(this).attr('class') != 'cur') { itemMouseOver(this, _ops); } else { stop(); } }, go);
			_bodies.hover(stop, go);
			go();
		}
	});
	</script>
	<?php } else { ?>
	<?php doAction('gobad','960')?>
	<?php } ?>
</div>

<script type="text/javascript">
$(window).scroll(function () {
	//var top_n = $('#hd .inner').offset().top + $('#hd .inner').height();
	var top = document.documentElement.scrollTop || document.body.scrollTop;
	var top_n = 0;
	if(top > top_n){
		if(typeof document.body.style.maxHeight === "undefined"){
			$('#top').css({'position':'absolute', 'top':top, 'left':'0', 'z-index':'9999'});
		}else{
			$('#top').css({'position':'fixed', 'top':'0', 'left':'0', 'z-index':'9999'});
		}
	}else{
		$('#top').css({'position': 'static'});
	}
});
</script>