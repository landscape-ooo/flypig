function gotoAnchor(selector){
	$("html,body").animate({
		scrollTop:$(selector).offset().top
	},200);
}

//取消活动
function cancelEvent(id){
	var _url = siteUrl+'index.php?app=event&ac=ajax&ts=cancel';
	$.ajax({
		type: "POST",
		url: _url,
		data: {"id":id},
		dataType :'json',
		success:function(result){
			if(result.code == 1){
				window.location.reload();
			}else{
				art.dialog({
					content : res.msg,
					time : 3000
				});
			}
		}
	});
}
//参加活动
function joinEvent(id){
	var _url = siteUrl+'index.php?app=event&ac=ajax&ts=join';
	$.ajax({
		type: "POST",
		url: _url,
		data: {"id":id},
		dataType :'json',
		success:function(result){
			if(result.code == 1){
				window.location.reload();
			}else{
				art.dialog({
					content : res.msg,
					time : 3000
				});
			}
		}
	});
}

