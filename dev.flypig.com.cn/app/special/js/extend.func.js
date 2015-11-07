function gotoAnchor(selector){
	$("html,body").animate({
		scrollTop:$(selector).offset().top
	},200);
}
