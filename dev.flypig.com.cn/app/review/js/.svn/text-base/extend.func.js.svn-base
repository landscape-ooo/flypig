
/*视频弹出或隐藏播放*/
function showVideo(id,url){
	 if($('#play_'+id).is(":hidden")){
		  $('#swf_'+id).html('<object width="500" height="420" id="swf_'+id+'"><param name="allowscriptaccess" value="always"></param><param name="wmode" value="window"></param><param name="movie" value="'+url+'"></param><embed src="'+url+'" width="500" height="420" allowscriptaccess="always" wmode="window" type="application/x-shockwave-flash"></embed></object>')
		  $('#play_'+id).show();
	 }else{
		$('#swf_'+id).find('object').remove();
		$('#play_'+id).hide();
	 }
	$('#img_'+id).toggle();
}

function showMp3(id,url){
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

//收藏书评(1.8改为喜欢)
function collectReview(reviewid){
	var _url = siteUrl+'index.php?app=review&ac=ajax&ts=collect';
	$.ajax({
		url: _url,
		type: 'POST',
		data: {'reviewid':reviewid},
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
				//review_collect_user(reviewid);
				window.location.reload();
			}
		}
	});
}

//淘书评,加专辑
function taoalbum(reviewid){
	$.post(siteUrl+'index.php?app=review&ac=album&ts=review',{'reviewid':reviewid},function(rs){
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
	var url = siteUrl+'index.php?app=review&ac=do&ts=recomment';
	$('#recomm_btn_'+rid).hide();
	$.post(url,{referid:rid,reviewid:tid,content:c,'token':token} ,function(rs){
				if(rs == 0)
				{
					//alert('回复成功');
					window.location.reload();
				}else{
					$('#recomm_btn_'+rid).show();
				}
	})	
}

function newReviewFrom(that){
	var title = $(that).find('input[name=title]').val();
	var rating = $(that).find('input[name=rating]:checked').val();
	var content = $(that).find('input[name=content]').val();
	if(title == '' || content == ''){alert('请填写标题和内容'); return false;}
	if(rating == null){alert('请选择评价'); return false;}
	$(that).find('input[type=submit]').val('正在提交^_^').attr('disabled',true);
}

//向下加载更多书评
function loadReview(userid,page){
	var num = parseInt(page)+1;
	$("#viewmore").html('<img src="'+siteUrl+'public/images/loading.gif" />');
	$.get(siteUrl+'index.php?app=review&ac=ajax&ts=review',{'userid':userid,'page':page},function(rs){
		if(rs==''){
			$("#viewmore").html('没有可以加载的内容啦...');
		}else{
			$("#before").before(rs);
			$("#viewmore").html('<a class="btn" href="javascript:void(0);" onclick="loadTeview('+userid+','+num+')">查看更多内容......</a>');
		}
	})
}
