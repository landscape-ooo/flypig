<?php defined('IN_TS') or die('Access Denied.'); ?><div id="ft">
	<p>
		<a href="<?php echo tsurl('home','info',array('key'=>'about'))?>">关于我们</a> | <a href="<?php echo tsurl('home','info',array('key'=>'contact'))?>">联系我们</a> | <a href="<?php echo tsurl('home','info',array('key'=>'agreement'))?>">用户条款</a> | <a href="<?php echo tsurl('home','info',array('key'=>'privacy'))?>">隐私申明</a> | <a 
		href="<?php echo tsurl('home','info',array('key'=>'job'))?>">加入我们</a>
	</p>
	<p>
		Copyright © <?php echo $TS_CF['info'][year];?> by <a target="_blank" href="<?php echo $TS_CF['info']['copyurl'];?>"><?php echo $TS_CF['info']['copyright'];?></a>, All Rights Reserved. <?php echo $TS_SITE['base'][site_icp];?>
	</p>
	<p>
		<span style="font-size:0.8em">Powered by <a target="_blank" class="softname" href="<?php echo $TS_CF['info'][url];?>"><?php echo $TS_CF['info'][name];?></a></span>，<span style="font-size:0.83em;">Processed in <?php echo $runTime;?> second(s)</span>
	</p>
</div>

<?php if(intval($TS_USER['user']['userid'])) { ?>
<script type="text/javascript" src="<?php echo SITE_URL;?>public/js/imbox/imbox.js"></script>
<script type="text/javascript">
var siteUid=<?php echo intval($TS_USER['user']['userid'])?>; //网站用户ID
evdata(siteUid);
</script>
<?php } ?>
<script type="text/javascript" src="<?php echo SITE_URL;?>public/js/common.js"></script>
<?php if(is_file('app/'.$app.'/js/extend.func.js')) { ?>
<script type="text/javascript" src="<?php echo SITE_URL;?>app/<?php echo $app;?>/js/extend.func.js"></script>
<?php } ?>

<div id="go_top"><div></div></div>
<script type="text/javascript">
$(function(){
	var window_width = $('body').width();
	if (window_width <= 1024) {
		$('#go_top').css({'left':'auto','right':'0','margin-left':'0'});
	}
	$(window).scroll(function () {
		var top = document.documentElement.scrollTop || document.body.scrollTop;
		if (top > 0) {
			$('#go_top').fadeIn();
		} else {
			$('#go_top').hide();
		};
	});
	$('#go_top').click(function () {
		$(document).scrollTop(0);
	});
	$('#go_top').hover(function () {
		$(this).find('div').addClass('hover');
	},function(){
		$(this).find('div').removeClass('hover');
	});
});
</script>

<?php doAction('pub_footer')?>
</body>
</html>
<?php if($TS_SITE['base'][isgzip]==1) { ?><?php ob_end_flush();?><?php } ?>