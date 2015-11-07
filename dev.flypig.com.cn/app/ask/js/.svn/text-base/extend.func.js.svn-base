function format(c, f, h) {
	if (!f) return c;
	if ("object" !== typeof f) {
		var k = h || f;
		return c.replace(RegExp(h ? f: "{v}", "g"), "" + k)
	}
	return c.replace(h || /\{([^{}]+)\}/g, 
	function(c, h) {
		k = f[h];
		return "" + k
	})
};

function doDigg(commentid,type){
	//取出顶数据
	var cnt_digg = $("#cnt_digg_"+commentid);
	var cnt_undigg = $("#cnt_undigg_"+commentid);
	var _url = siteUrl+'index.php?app=ask&ac=ajax&ts=digg';
	$.ajax({
		type: "POST",
		url: _url,
		data:{'commentid': commentid,'type': type},
		dataType: "json",
		success: function(result){
			if(result.code == 0){
				alert(result.msg);
				return false;
			}
			if(result.code == 1){
				cnt_digg.html(result.data.digg);
				cnt_undigg.html(result.data.undigg);
			}
		}
	});
}

var sign = 0;
$(function(){
	var l = $(".tag-cates"),
	x = $(".selected", l).length;
	l.delegate("a", 
		"click", 
		function() {
			var a = $(this);
			var b = a.attr("data-id");
			a.is(".selected") ? ($("#tag-cate" + b).remove(), a.removeClass("selected"), x--) : 3 <= x ? alert("问题最多只允许添加三个标签") : (x++, l.append(format('<input type="hidden" value="{v}" name="tag[]" id="{id}"/>', {
				v: b,
				id: "tag-cate" + b
			})), a.addClass("selected"))
		});
	
	$("#editor").submit(function() {
		//初始变量
		var h = 64;
		
		//防重复提交
		if (1 === sign) return false;
		//标题判断
		var a = $.trim($("#editorTitle").val()).length;
		if (0 === a){
			alert("标题不能为空");
			return false;
		}
		if (a > h){
			alert("标题字数不能超过" + h + "字");
			return false; 
		}
		//内容判断
		var c = $.trim($("#bbcode").val()).length;
		if (5E3 < c){
			alert("补充说明内容不能超过5000字");
			return false;
		}
		sign = 1;
	});
	
	//顶自来更多
	$("#answers .expandDiggers").die("click").live("click",function(){
		var o = $(this).closest(".answer-diggers");
		var str = o.find("span.hide").html();
		$(o.find("span").get(0)).append(str)
		$(this).remove();
	})
	
	//关注分类
	$("#tagList li a.followBt").die("click").live("click",function(){
		var cateid = $(this).attr("data-id");
		var _url = siteUrl+'index.php?app=ask&ac=ajax&ts=follow';
		var obj = $(this);
		$.ajax({
			type: "POST",
			url: _url,
			data:"cateid=" + cateid,
			success: function(result) {
				if (1 == result){
					if (obj.hasClass("side-tags-follow")){
						obj.html("取消关注");
						obj.removeClass("side-tags-follow").addClass("side-tags-unfollow");
						obj.parent("li").find(".tag").addClass("selected");
					}else{
						if (obj.hasClass("side-tags-unfollow")){
							obj.html("关注");
							obj.removeClass("side-tags-unfollow").addClass("side-tags-follow");
							obj.parent("li").find(".tag").removeClass("selected");
						}
					}
				}
			}
		});
	})
	
	//分类列表详细中的关注
	$("#mainTag a.followBt").die("click").live("click",function(){
		var cateid = $(this).attr("data-id");
		var _url = siteUrl+'index.php?app=ask&ac=ajax&ts=follow';
		var obj = $(this);
		
		$.ajax({
			type: "POST",
			url: _url,
			data:"cateid=" + cateid,
			success: function(result){
				if (1 == result){
					if (obj.hasClass("main-tag-follow")){
						obj.html("取消关注");
						obj.removeClass("main-tag-follow").addClass("main-tag-unfollow");
						obj.parent(".main-tag-tit").find(".tag").addClass("selected");
					}else{
						if (obj.hasClass("main-tag-unfollow")){
							obj.html("关注");
							obj.removeClass("main-tag-unfollow").addClass("main-tag-follow");
							obj.parent(".main-tag-tit").find(".tag").removeClass("selected");
						}
					}
				}
			}
		});
	})
	
	//该分类的活跃达人
	$(".side-chippys .side-chippys-brief").bind("mouseover", function(){
		$(".side-chippys .side-chippys-brief .pt-txt-d, .side-chippys .side-chippys-brief .pt-pic").show();
	}).bind("mouseout", function(){
		$(".side-chippys .side-chippys-brief .pt-txt-d, .side-chippys .side-chippys-brief .pt-pic").hide();
	});
	
});
