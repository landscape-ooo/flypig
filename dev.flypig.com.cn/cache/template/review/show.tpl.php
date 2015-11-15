<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div id="path" class="bd clearfix">
	<a href="<?php echo SITE_URL;?>" title="<?php echo $TS_SITE['base'][site_title];?>首页">首页</a>  &gt;  <a href="<?php echo tsurl('review','index')?>" title="飞猪网好书评">好书评</a>  &gt;  书评内容
</div>

<div id="bd" class="bd clearfix">
	<h1 id="review-title">
		<span class="icon icon-file"></span>
		<?php echo $strReview['title'];?>
		<?php if($strReview['istop']==1) { ?>
		<img src="<?php echo SITE_URL;?>public/images/tops.gif" title="[置顶]" alt="[置顶]" /> 
		<?php } ?> 
		<?php if($strReview['isbrilliant']==1) { ?>
		<img src="<?php echo SITE_URL;?>public/images/posts.gif" title="[精华]" alt="[精华]" />
		<?php } ?>
		<?php if($strReview['postby']==1) { ?>
		<a href="<?php echo tsurl('home','phone')?>"><img align="absmiddle" alt="通过Iphone手机端发布" title="通过Iphone手机端发布" src="<?php echo SITE_URL;?>public/images/ios.jpg" /></a>
		<?php } ?>
	</h1>
	<div id="review-tools">
		<div class="review-from">
			<span class="icon icon-book" style="margin-left:10px;"></span>
			来自<a href="<?php echo tsurl('book','show',array('id'=>$strBook['bookid']))?>" title="<?php echo $strBook['bookname'];?>">《<?php echo $strBook['bookname'];?>》</a>的书评
			，<span class="icon-redo"></span> 返回<a href="<?php echo tsurl('book','show',array('id'=>$strBook['bookid']))?>" title="<?php echo $strBook['bookname'];?>">《<?php echo $strBook['bookname'];?>》</a>
			<?php if($TS_APP['options'][iscreate]==0 || $TS_USER['user']['isadmin']==1) { ?>
			<span class="icon-pen"></span> <a href="<?php echo tsurl('review','add',array('bookid'=>$strBook['bookid']))?>">我也要写书评</a>
			<?php } ?>
		</div>
	</div>
	<div class="bd-left">
		<?php if($page == '1') { ?>
		<div id="review-content" class="clearfix">
			<div class="show-face">
				<a href="<?php echo tsurl('user','space',array('id'=>$strReview['user'][userid]))?>"><img class="userface" title="<?php echo $strReview['user'][username];?>" alt="<?php echo $strReview['user'][username];?>" src="<?php echo $strReview['user'][face];?>" width="75" height="75"></a>
			</div>
			<div class="show-info">
				<div class="meta">
					<span class="color-gray icon-alarm"></span> <?php echo date('Y-m-d H:i:s',$strReview['addtime'])?>，
					By <a href="<?php echo tsurl('user','space',array('id'=>$strReview['userid']))?>"><?php echo $strReview['user'][username];?></a>
				</div>
				<div class="review-rating">
					<?php echo $strReview['rating'];?>
				</div>
				<div class="review-view">
					<?php echo $strReview['content'];?>
				</div>
				<!--
				<?php if($strReview['tags']) { ?>
				<div id="review_tags">
					<span class="icon-tags"></span>
					<?php foreach((array)$strReview['tags'] as $key=>$item) {?>
					<a href="<?php echo tsurl('book','tag',array('id'=>urlencode($item['tagname'])))?>"><?php echo $item['tagname'];?></a>
					<?php }?>
				</div>
				<?php } ?>
				-->
				<?php if($TS_USER['user']['userid']==$strReview['userid'] || $TS_USER['user']['userid']==$strBook['userid'] || $TS_USER['user']['isadmin']=="1") { ?>
				<div class="tool" style="text-align:right;">
					<?php if($TS_USER['user']['userid']==$strBook['userid'] || $TS_USER['user']['isadmin']=="1") { ?>
					<a class="btn-tool" href="<?php echo tsurl('review','do',array('ts'=>'audit','reviewid'=>$strReview['reviewid']))?>"><?php if($strReview['isaudit']==0) { ?>审核<?php } else { ?>取消审核<?php } ?></a>
					<a class="btn-tool" href="<?php echo tsurl('review','do',array('ts'=>'istop','reviewid'=>$strReview['reviewid']))?>"><?php if($strReview['istop']==0) { ?>置顶<?php } else { ?>取消置顶<?php } ?></a>
					<a class="btn-tool" href="<?php echo tsurl('review','do',array('ts'=>'isbrilliant','reviewid'=>$strReview['reviewid']))?>"><?php if($strReview['isbrilliant']==0) { ?>精华<?php } else { ?>取消精华<?php } ?></a>
					<?php } ?>
					<a class="btn-tool" href="<?php echo tsurl('review','edit',array('reviewid'=>$strReview['reviewid']))?>">编辑</a>
					<a class="btn-tool" href="<?php echo tsurl('review','do',array('ts'=>'del','reviewid'=>$strReview['reviewid']))?>" onClick="return confirm('确定删除吗?')">删除</a>
				</div>
				<?php } ?>
			</div>
		</div>
		<?php } ?>
		<div id="review_comment">
			<a name="comment_add"></a>
			<div class="com-bar clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-image"></span>
					用户评论(<?php echo $strReview['count_comment'];?>)
				</div>
			</div>
			<ul class="comment">
				<?php if(is_array($arrReviewComment)) { ?>
				<?php foreach((array)$arrReviewComment as $key=>$item) {?>
				<li class="clearfix" id="l_<?php echo $item['commentid'];?>">
					<div class="show-face">
						<a href="<?php echo tsurl('user','space',array('id'=>$item['user'][userid]))?>"><img class="userface" title="<?php echo $item['user'][username];?>" alt="<?php echo $item['user'][username];?>" src="<?php echo $item['user'][face];?>" width="75" height="75" /></a>
					</div>
					<div class="show-info">
						<div class="meta">
							<?php echo date('Y-m-d H:i:s',$item['addtime'])?>
							<a href="<?php echo tsurl('user','space',array('id'=>$item['user'][userid]))?>" rel="face" uid="<?php echo $item['user'][userid];?>" style="margin-left:5px; margin-right:5px;"><?php echo $item['user'][username];?></a>
							<i><?php echo $item['lou'];?>#</i>
						</div>
						<div class="content wordfix" id="comment-txt<?php echo $item['commentid'];?>"><?php echo $item['content'];?></div>
						<div class="com-tool" style="text-align:right;" id="comment-tool<?php echo $item['commentid'];?>">
							<?php if($TS_USER['user']['userid']==$item['userid'] || $TS_USER['user']['isadmin']=='1') { ?>
							<a class="btn-tool2 deleteComment" data-id="<?php echo $item['commentid'];?>" data-operation="deleteComment" href="javascript:void(0);" onclick="return confirm('确定要删除？');">删除</a>
							<a class="btn-tool2 editComment" data-id="<?php echo $item['commentid'];?>" data-operation="editComment" href="javascript:void(0);">修改</a>
							<?php } ?>
						</div>
						<!--
						<div id="rcomment_<?php echo $item['commentid'];?>" style="display:none">
							<textarea style="width:90%;height:60px;font-size:14px;" id="recontent_<?php echo $item['commentid'];?>" type="text" onKeyDown="keyRecomment(<?php echo $item['commentid'];?>,<?php echo $item['reviewid'];?>,event)"></textarea>
							<p>
								<a class="btn" href="javascript:void(0);" onClick="recomment(<?php echo $item['commentid'];?>,<?php echo $item['reviewid'];?>,'<?php echo $_SESSION['token'];?>')" id="recomm_btn_<?php echo $item['commentid'];?>">提交</a> <a href="javascript:void('0');" onclick="commentOpen(<?php echo $item['commentid'];?>,<?php echo $item['reviewid'];?>)">取消</a>
							</p>
						</div>
						-->
					</div>
				</li>
				<?php }?>
				<?php } ?>
			</ul>
			<div class="com-page"><?php echo $pageUrl;?></div>
			<div class="commentform">
				<?php if(intval($TS_USER['user']['userid'])=='0') { ?>
				<div class="commentmsg" style="border:1px dotted #ccc;">
					提示：需要登陆才能评论，<a href="<?php echo tsurl('user','login')?>">登陆</a> | <a href="<?php echo tsurl('user','register')?>">注册</a>
				</div>
				<?php } elseif ($strReview['isclose']=='1') { ?>
				<div class="commentmsg">
				该书评已被关闭，无法评论
				</div>
				<?php } else { ?>
				<form method="POST" action="<?php echo SITE_URL;?>index.php?app=review&ac=comment&ts=do">
					<textarea type="text" style="width:638px;" id="content" name="content"></textarea>
					<p>
						<input type="hidden" name="reviewid" value="<?php echo $strReview['reviewid'];?>" />
						<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
						<div class="authcode">
							<?php if($TS_SITE['base']['isauthcode']) { ?>
							验证码：<input name="authcode" />
							<img align="absmiddle" src="<?php echo tsurl('pubs','code')?>" onclick="javascript:newgdcode(this,this.src);" title="点击刷新验证码" alt="点击刷新验证码" style="cursor:pointer;"/>
							<?php } ?>
						</div>
						<div class="submit">
							<button class="btn btn-success" type="submit">提交评论</button>
						</div>
					</p>
				</form>
				<!--
				<div id="comment-add-box" style="display:none;">
					<div id="comment-add-tpl">
						<textarea style="width:528px;height:100px;" id="comment-add-content" name="content"></textarea>
						<div id="comment-add-tpl-btn" class="com-tool" style="text-align:right;">
							<a id="cancelAddComment" class="btn btn-cancel" href="javascript:void(0);">取消</a>
							<a id="submitAddComment" class="btn btn-success" href="javascript:void(0);">添加评论</a>
						</div>
					</div>
				</div>
				-->

				<div id="comment-edit-box" style="display:none;">
					<div id="comment-edit-tpl">
						<textarea style="width:528px;height:100px;" id="comment-edit-content" name="content"></textarea>
						<div id="comment-edit-tpl-btn" class="com-tool" style="text-align:right;">
							<a id="cancelEditComment" class="btn btn-cancel" href="javascript:void(0);">取消</a>
							<a id="submitEditComment" class="btn btn-success" href="javascript:void(0);">确认修改</a>
						</div>
					</div>
				</div>
				<div id="comment-edit-data-original" style="display:none;"></div>
				<script type="text/javascript">
				$(document).ready(function(){
					//修改评论
					$(".editComment").each(function(){
						$(this).click(function(){
							var commentid = $(this).attr("data-id");
							//判断是否已经打开
							if($("#comment-txt"+commentid).find("textarea").length > 0){
								return false;
							}
							var editans = $("#comment-edit-box");
							if(editans.html()==''){
								alert('编辑窗口已打开，请先关闭！');
								return false;
							}
							var originaleditstr = editans.html();
							var originalcomment = $("#comment-txt"+commentid).html();
							$('#comment-edit-content').html(originalcomment);
							$('#comment-edit-data-original').html(originalcomment);
							var editstr = editans.html();
							editans.html('');
							$("#comment-txt"+commentid).html(editstr);
							$("#comment-tool"+commentid).css({'display':'none'});
							var editEditor = KindEditor.create('#comment-edit-content', {
								basePath : '/plugins/pubs/kindeditor/',
								readonlyMode : false,
								minWidth : 100,
								minHeight: 100,
								resizeType : 1,
								pasteType : 1,
								cssPath : '/plugins/pubs/kindeditor/themes/default/add.css',
								items : [
										'removeformat', '|','bold', '|', 'justifyleft', 'justifycenter', 'justifyright', '|', 'emoticons', 'image', 'netvideo', 'link'
										],
								afterChange : function() {
									this.sync();
									if($('#comment-edit-content_tip').length>0){
										var editlimitNum = 500;
										//计算剩余字数
										var editresult = limitNum - this.count('text');
										var editpatternTip = '还可以输入 <font color=\"red\">' + result + '</font> 字';
										$('#comment-edit-content_tip').html(editpatternTip);
									}
								},
								afterCreate : function(){
									
								},
								afterFocus : function(){
									
								}
							});
							//修改评论执行
							$("#submitEditComment").die("click").live("click",function(){
								var content = editEditor.html();
								if (editEditor.isEmpty()){
									alert("请填写内容");
									return false;
								}
								if (editEditor.count()>5000){
									alert("评论内容不能超过2000字");
									return false;
								}
								$.ajax({
									url: "<?php echo tsurl('review','ajax',array('ts'=>'submitEditComment'))?>", 
									type: "POST",
									data: {"commentid" : commentid, "content" : content},
									dataType: "json",
									success: function(result){
										if(result.code == 1){
											editans.html(originaleditstr);
											$("#comment-edit-box textarea[name='content']").html(result.data);
											$("#comment-txt"+commentid).html(result.data);
											$("#comment-edit-data-original").html(result.data);
											$("#comment-tool"+commentid).css({'display':''});
										}else if(result.code == 0){
											alert(result.msg);
											return false;
										}
									},
									error: function(result){
										alert('ajax error!');
									}
								});
								
							});
							//取消
							$("#cancelEditComment").die("click").live("click",function(){
								KindEditor.remove('#comment-edit-content');
								if ($("#comment-edit-box").html() == ''){
									editans.html(originaleditstr);
								}
								$("#comment-txt"+commentid).html($("#comment-edit-data-original").html());
								$("#comment-tool"+commentid).css({'display':''});
								$('#comment-edit-data-original').html('');
							});
						});
					});
					
					//删除评论
					$(".deleteComment").each(function(){
						$(this).click(function(){
							var commentid = $(this).attr("data-id");
							$.ajax({
								type: "POST",
								url: "<?php echo tsurl('review','ajax',array('ts'=>'deleteComment'))?>",
								data: {'commentid': commentid},
								dataType: 'json',
								success: function(result) {
									if(result.code == 1){
										//$("#comment"+commentid).remove();
										window.location.reload();
									}else if(result.code == 0){
										alert(result.msg);
										return false;
									}
								},
								error: function(result){
									alert('ajax error!');
								}
							});
						});
					});
					
				});
				</script>
				
				<?php } ?>
			</div>
		</div>

	</div>
	<div class="bd-right">
		
		<div class="clearfix" style="margin-top:20px;">
			<a href="#comment_add" class="btn3d btn3d-two"><span class="icon-bubble"></span> 回复(<?php echo $strReview['count_comment'];?>)</a>
			<a href="javascript:void('0');" onclick="collectReview('<?php echo $strReview['reviewid'];?>')" class="btn3d btn3d-two fr"><span class="icon-heart2"></span> 喜欢(<?php echo $strReview['count_love'];?>)</a>
		</div>
		
		<div id="new_review" class="com-box" style="margin-top:30px;">
			<div class="com-bar3 clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-clock2"></span>
					最新书评
				</div>
				<div class="com-bar-more">
					&nbsp;&nbsp;
				</div>
			</div>
			<ul class="content line23">
				<?php foreach((array)$newReview as $key=>$item) {?>
				<li>
					<a title="<?php echo $item['title'];?>" href="<?php echo tsurl('review','show',array('id'=>$item['reviewid']))?>"><?php echo cututf8($item['title'],0,25)?></a> 
				</li>
			<?php }?>
			</ul>
		</div>
		
		<div id="hot_review" class="com-box">
			<div class="com-bar3 clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-fire"></span>
					热门书评
				</div>
				<div class="com-bar-more">
					&nbsp;&nbsp;
				</div>
			</div>
			<ul class="content line23">
				<?php foreach((array)$arrHotReview as $key=>$item) {?>
				<li><a href="<?php echo tsurl('review','show',array('id'=>$item['reviewid']))?>" target="_blank"><?php echo $item['title'];?></a></li>
				<?php }?>
			</ul>
		</div>
		
		<div id="review_user" class="com-box">
			<h3>
				<span class="icon icon-heart2"></span>
				喜欢这个书评的用户
			</h3>
			<div class="content" id="collects">
				<?php if(!$arrCollectUser) { ?>
				<div style="color: #999999;margin-bottom: 10px;padding: 20px 0">还没有人喜欢，赶快来做第一个喜欢者吧^_^</div>
				<?php } else { ?>
				<div style="margin-bottom: 10px;overflow: hidden;">
					<?php foreach((array)$arrCollectUser as $key=>$item) {?>
					<a href="<?php echo tsurl('user','space',array('id'=>$item['userid']))?>" target="_blank"><img src="<?php echo $item['face'];?>" alt="<?php echo $item['username'];?>" title="<?php echo $item['username'];?>" width="48" height="48" /></a>&nbsp;
					<?php }?>
				</div>
				<?php } ?>
			</div>
		</div>
		
		<!--广告位-->
		<?php doAction('gobad','300')?>
		
	</div>
</div>

<?php doAction('tseditor2','#content','review_comment')?>

<?php include template('footer'); ?>