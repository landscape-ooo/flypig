
/*视频弹出或隐藏播放*/
function showVideo(id,url)
{
	 if($('#play_'+id).is(":hidden")){
		  $('#swf_'+id).html('<object width="500" height="420" id="swf_'+id+'"><param name="allowscriptaccess" value="always"></param><param name="wmode" value="window"></param><param name="movie" value="'+url+'"></param><embed src="'+url+'" width="500" height="420" allowscriptaccess="always" wmode="window" type="application/x-shockwave-flash"></embed></object>')
		  $('#play_'+id).show();
	 }else{
		$('#swf_'+id).find('object').remove();
		$('#play_'+id).hide();
	 }
	$('#img_'+id).toggle();
}

function showMp3(id,url)
{
	$('#mp3swf_'+id).toggle();
	$('#mp3img_'+id).toggle();
}



//显示和隐藏
	function viewcontent(){
		$("#displaycontent").toggle();
		$("#displaytitle").hide();
	}
	//显示和隐藏
	function closecontent(){
		$("#displaycontent").hide();
		$("#displaytitle").toggle();
	}

//收藏分享(1.8改为喜欢)
function collectShare(shareid){
	var _url = siteUrl+'index.php?app=share&ac=ajax&ts=collect';
	$.ajax({
		url: _url,
		type: 'POST',
		data: {'shareid':shareid},
		dataType:'json',
		success: function(res){
			if(res.code == 0){
				art.dialog({
					content : res.msg,
					time : 3000
				})
			}else if(res.code == 2){
				art.dialog({
					content : res.msg,
					time : 3000
				})	
			}else{
				//share_collect_user(shareid);
				window.location.reload();
			}
		}
	});
}

//淘分享,加专辑
function taoalbum(shareid){
	$.post(siteUrl+'index.php?app=share&ac=album&ts=share',{'shareid':shareid},function(rs){
		if(rs==0){
			art.dialog({
				content : '请登陆后再进行淘帖',
				time : 1000
			})
		}else if(rs == 1){
			art.dialog({
				content : '请创建专辑后再进行淘贴',
				time : 1000
			})
		}else {
			art.dialog({
				content : rs
			})
		}
	})
}

//回复评论
function recomment(rid,tid,token){
	c = $('#recontent_'+rid).val();
	if(c==''){alert('回复内容不能为空');return false;}
	var url = siteUrl+'index.php?app=share&ac=do&ts=recomment';
	$('#recomm_btn_'+rid).hide();
	$.post(url,{referid:rid,shareid:tid,content:c,'token':token} ,function(rs){
		if(rs == 0){
			//alert('回复成功');
			window.location.reload();
		}else{
			$('#recomm_btn_'+rid).show();
		}
	})
}

//向下加载更多分享
function loadShare(userid,page){
	var num = parseInt(page)+1;
	$("#viewmore").html('<img src="'+siteUrl+'public/images/loading.gif" />');
	$.get(siteUrl+'index.php?app=share&ac=ajax&ts=share',{'userid':userid,'page':page},function(rs){
		if(rs==''){
			$("#viewmore").html('没有可以加载的内容啦...');
		}else{
			$("#before").before(rs);
			$("#viewmore").html('<a class="btn" href="javascript:void(0);" onclick="loadTeview('+userid+','+num+')">查看更多内容......</a>');
		}
	})
}
