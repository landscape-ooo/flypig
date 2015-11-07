<?php 
defined('IN_TS') or die('Access Denied.'); 
//首页幻灯片插件
function slide(){
	
	$arrData = aac('home')->findAll('slide');;
	
echo '<div class="bbox"><div id="ind_focus" class="ind_focus">
<div class="slides_container">';

foreach($arrData as $key=>$item){
echo '<div class="slide">
<a target="_blank" href="'.$item['url'].'"><img width="640" height="210" src="'.tsXimg($item['photo'],'slide','640','210',1).'" alt="'.$item['title'].'" /></a>
<div class="caption" style="bottom:0">
<p>'.$item['title'].'</p>
</div>
</div>';
}
echo '</div></div></div><div class="clear"></div>';
}

function slide_css(){
	echo '<link href="'.SITE_URL.'plugins/home/slide/images/style.css" rel="stylesheet" type="text/css" />';
}

function slide_js(){
	echo '<script src="'.SITE_URL.'plugins/home/slide/images/slides.min.jquery.js" type="text/javascript"></script>';
	echo '<script>
$(function(){
  $("#ind_focus").slides({
	preload: true,
	preloadImage: "'.SITE_URL.'public/images/loading.gif",
    play: 5000,
    pause: 2500,
    hoverPause: true,
	animationStart: function(current){
		$(".caption").animate({
			bottom:-35
		},100);
		if (window.console && console.log) {
			// example return of current slide number
			console.log("animationStart on slide: ", current);
		};
	},
	animationComplete: function(current){
		$(".caption").animate({
			bottom:0
		},200);
		if (window.console && console.log) {
			// example return of current slide number
			console.log("animationComplete on slide: ", current);
		};
	},
	slidesLoaded: function() {
		$(".caption").animate({
			bottom:0
		},200);
	}
  });
});
</script>';
}

addAction('home_index_left','slide');
addAction('pub_header_top','slide_css');
addAction('pub_footer','slide_js');