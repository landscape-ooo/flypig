<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div id="path" class="bd clearfix">
	<span class="icon icon-home"></span>
	<a href="<?php echo SITE_URL;?>" title="<?php echo $TS_SITE['base'][site_title];?>首页">首页</a>  &gt;  <a href="<?php echo tsurl('ask','index')?>" title="<?php echo $TS_APP['options'][appname];?>"><?php echo $TS_APP['options'][appname];?></a>  &gt;  问答详情
</div>

<div id="bd" class="bd clearfix">
	<div class="bd-left">
		
		<div id="ask-show">
			<div class="show clearfix">
				<div class="show-face">
					<a href="<?php echo tsurl('user','space',array('id'=>$strAsk['userid']))?>">
						<img class="userface" src="<?php echo $strAsk['user'][face];?>" width="75" height="75" />
					</a>
					<br><a href="<?php echo tsurl('group','user',array('id'=>$strAsk['userid']))?>"><?php echo $strAsk['user']['username'];?></a>
				</div>
				<div class="show-info">
					<h1 class="title wordfix">
						<?php echo $strAsk['title'];?>
					</h1>
					<div class="tags">
						
					</div>
					<div class="meta">
						<span class="icon icon-clock"></span> <?php echo $strAsk['addtime'];?>&nbsp;&nbsp;•&nbsp;&nbsp;By <a  href="<?php echo tsurl('group','user',array('id'=>$strAsk['userid']))?>" target="_blank"><?php echo $strAsk['user']['username'];?></a>&nbsp;&nbsp;•&nbsp;&nbsp;分类：<?php foreach((array)$strAsk['cate'] as $k=>$v) {?><a href="<?php echo tsurl('ask', 'cate', array('cateid'=>$v['cateid']))?>" target="_blank"><?php echo $v['catename'];?></a><?php if((count($strAsk['cate'])-1)>$k) { ?>、<?php } ?><?php }?>
					</div>
					<div class="content wordfix">
						<?php echo $strAsk['content'];?>
					</div>
					<div class="tool" style="text-align:right;">
						<?php if(($strAsk['userid']!=$TS_USER['user']['userid']) || $TS_USER['user']['isadmin']=='1') { ?>
						<a class="btn-tool" href="#comment_anchor" id="goToEditor">我来回答</a>
						<?php } ?>
						<?php if(($strAsk['userid']==$TS_USER['user']['userid']) || $TS_USER['user']['isadmin']=='1') { ?>
						<a class="btn-tool" id="closeOrOpenQuestion" data-id="<?php echo $askid;?>" href="javascript:void(0);"><?php if($strAsk['isopen']=='1') { ?>关闭问题<?php } else { ?>解锁问题<?php } ?></a>
						<a class="btn-tool" href="<?php echo tsurl('ask','edit',array('askid'=>$strAsk['askid']))?>">修改</a>
						<?php if($TS_USER['user']['isadmin']=='1') { ?>
						<a class="btn-tool" href="<?php echo tsurl('ask','delete',array('askid'=>$strAsk['askid']))?>" onclick="return confirm('确定要删除？');">删除</a>
						<?php } ?>
						<script type="text/javascript">
						$(document).ready(function(){
							//关闭/解锁问题
							$("#closeOrOpenQuestion").die("click").live("click",function(){
								var askid = $(this).attr("data-id");
								$.ajax({
									url: siteUrl+'index.php?app=ask&ac=ajax&ts=closeOrOpenQuestion',
									type: "POST",
									data:{"askid": askid},
									dataType: "json",
									success: function(result){
										if (1 == result.code){
											window.location.reload();
										}
										if (0 == result.code){
											alert(result.html);
										}
									},
									error: function(result){
										alert('ajax error!');
									}
								});
							})
						});
						</script>
						<?php } ?>
					</div>
					
				</div>
			</div>
			
			<div id="answers" class="answers">
				
				<div class="com-bar clearfix">
					<div class="com-bar-tit">
						<span class="icon icon-quill"></span>
						<?php if($strAsk['count_comment'] == 0) { ?>没有答案<?php } else { ?>答案 <span class="f12 color-gray">(<?php echo $strAsk['count_comment'];?>)</span><?php } ?>
					</div>
				</div>
				
				<ul>
					<?php foreach((array)$arrComment as $v) {?>
					<li id="answer<?php echo $v['commentid'];?>" class="show <?php if($v['userid']==$TS_USER['user']['userid']) { ?> highlight<?php } ?><?php if($v['isbest']=='1') { ?> best<?php } ?> clearfix">
						<?php if($v['isbest']=='1') { ?>
							<div class="icon-best">
								<span class="icon icon-checkmark-circle"></span>
							</div>
						<?php } ?>
						<div class="show-face">
							<a title="<?php echo $v['user']['username'];?>" href="<?php echo tsurl('user','space',array('id'=>$v['userid']))?>" class="answer-img">
								<img class="userface" src="<?php echo $v['user']['face'];?>" width="75" height="75">
							</a>
							<br><a title="<?php echo $v['user']['username'];?>" href="<?php echo tsurl('user','space',array('id'=>$v['userid']))?>" class="answer-usr-name"><?php echo $v['user']['username'];?></a>
						</div>
						<div class="show-info">
							<div class="meta">
								<span class="icon icon-clock"></span> <?php echo date('Y-m-d H:i:s', $v['addtime']);?>&nbsp;&nbsp;•&nbsp;&nbsp;By <a href="<?php echo tsurl('user','space',array('id'=>$v['userid']))?>" title="<?php echo $v['user']['username'];?>" target="_blank"><?php echo $v['user']['username'];?></a>
							</div>
							<div class="digg">
								<div class="digg_box">
									<a id="btn_digg_<?php echo $v['commentid'];?>" class="btn_digg" onclick="doDigg('<?php echo $v['commentid'];?>', 1);" href="javascript:void(0)">
										<span class="icon icon-thumbs-up2" title="顶"></span>
										<span id="cnt_digg_<?php echo $v['commentid'];?>"><?php echo $v['digg'];?></span>
									</a>
									<a id="btn_undigg_<?php echo $v['commentid'];?>" class="btn_undigg" onclick="doDigg('<?php echo $v['commentid'];?>', 2);" href="javascript:void(0)">
										<span class="icon icon-thumbs-up" title="踩"></span>
										<span id="cnt_undigg_<?php echo $v['commentid'];?>"><?php echo $v['undigg'];?></span>
									</a>
								</div>
							</div>
							<div class="content wordfix" id="comment-txt<?php echo $v['commentid'];?>"><?php echo $v['content'];?></div>
							<div class="com-tool" style="text-align:right;" id="comment-tool<?php echo $v['commentid'];?>">
								<?php if($TS_USER['user']['isadmin']=='1' || $TS_USER['user']['userid']==$v['userid']) { ?>
								<a class="btn-tool2 deleteComment" data-id="<?php echo $v['commentid'];?>" data-operation="deleteComment" href="javascript:void(0);" onclick="return confirm('确定要删除？');">删除</a>
								<a class="btn-tool2 editComment" data-id="<?php echo $v['commentid'];?>" data-operation="editComment" href="javascript:void(0);">修改</a>
								<?php } ?>
								<?php if($TS_USER['user']['isadmin']=='1' || $TS_USER['user']['userid']==$strAsk['userid']) { ?>
								<a class="btn-tool2 bestComment" data-id="<?php echo $v['commentid'];?>" href="javascript:void(0);" onclick="return confirm('确定要选择为最佳答案？');">最佳答案</a>
								<?php } ?>
							</div>
							
						</div>
					</li>
					<?php } ?>
				</ul>
				
				<div class="com-page"><?php echo $pageUrl;?></div>
				
				<a name="comment_anchor"></a>
				
				<?php if($strAsk['isopen']=='0') { ?>
				<p class="commentmsg">此问题目前不允许回答</p>
				<?php } else { ?>
				<?php if(!$userid) { ?>
				<div class="commentmsg" style="border:1px dotted #ccc;">
					提示：需要登陆才能回答，<a href="<?php echo tsurl('user','login')?>">登陆</a> | <a href="<?php echo tsurl('user','register')?>">注册</a>
				</div>
				<?php } else { ?>
				
				<?php if($iscommented) { ?>
				<p class="commentmsg">您已经回答过此问题！每个问题每人仅能回答一次，如需更新请直接修改</p>
				<?php } else { ?>
				<div id="commentAdd" class="post_commet clearfix">
					<div class="show-face">
						<a href="<?php echo tsurl('user','space',array('id'=>$TS_USER['user']['userid']))?>">
							<img class="userface" src="<?php if($TS_USER['user']['face']=='') { ?><?php echo SITE_URL;?>public/images/user_normal.jpg<?php } else { ?><?php echo tsXimg($TS_USER['user']['face'],'user','75','75',$TS_USER['user']['path'],'1')?><?php } ?>" width="75" height="75" />
						</a>
						<br><a href="<?php echo tsurl('user','space',array('id'=>$TS_USER['user']['userid']))?>"><?php echo $TS_USER['user']['username'];?></a>
					</div>
					<div class="show-info">
						<form method="POST" action="<?php echo tsurl('ask', 'comment', array('ts'=>'add','askid'=>$askid))?>" id="comment_add">
						<textarea style="width:528px;" id="editor_comment_add" name="content"></textarea>
						<br><span id="editor_comment_add_tip"></span> <a class="btn btn-ok fr" href="javascript:;" id="btn_comment_add">新增答案</a>
						</form>
					</div>
				</div>
				<?php } ?>
				
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
					//设为最佳答案
					$(".bestComment").each(function(){
						$(this).click(function(){
							var commentid = $(this).attr("data-id");
							$.ajax({
								url: "<?php echo tsurl('ask','ajax',array('ts'=>'bestComment'))?>",
								type: "POST",
								data: {"commentid": commentid},
								dataType: 'json',
								success: function(result) {
									if(result.code == 1){
										window.location.reload();
									}else if(result.code == 0){
										alert(result.msg);
										return false;
									}
								}
							});
						});
					});
					
					//修改答案
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
										'removeformat', '|','bold', '|', 'justifyleft', 'justifycenter', 'justifyright', '|', 'emoticons', 'image', 'link'
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
								}
							});
							//修改答案执行
							$("#submitEditComment").die("click").live("click",function(){
								var content = editEditor.html();
								if (editEditor.isEmpty()){
									alert("请填写内容");
									return false;
								}
								if (editEditor.count()>5000){
									alert("答案内容不能超过2000字");
									return false;
								}
								$.ajax({
									url: "<?php echo tsurl('ask','ajax',array('ts'=>'submitEditComment'))?>", 
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
					
					//删除答案
					$(".deleteComment").each(function(){
						$(this).click(function(){
							var commentid = $(this).attr("data-id");
							$.ajax({
								type: "POST",
								url: "<?php echo tsurl('ask','ajax',array('ts'=>'deleteComment'))?>",
								data: {'commentid': commentid},
								dataType: 'json',
								success: function(result) {
									if(result.code == 1){
										window.location.reload();
									}else if(result.code == 0){
										alert(result.msg);
										return false;
									}
								}
							});
						});
					});
					
				});
				</script>
				<?php } ?>
				<?php } ?>
			</div>
		</div>

	</div>
	<div class="bd-right">
		
		<p class="clearfix">
			<?php if($TS_APP['options'][iscreate]==0 || $TS_USER['user'][isadmin]==1) { ?>
			<a class="btn3d btn3d-two fl" href="#comment_anchor"><span class="icon-bubble"></span> 我要回答</a>
			<a class="btn3d btn3d-two fr" href="<?php echo tsurl($app, 'add')?>"><span class="icon-question"></span> 我要提问</a>
			<?php } else { ?>
			<a class="btn3d btn3d-one" href="#comment_anchor"><span class="icon-pen"></span> 我要回答</a>
			<?php } ?>
		</p>
		
		<!--广告位-->
		<?php doAction('gobad','300')?>
		
	</div>
</div>

<?php doAction('tseditor2','#editor_comment_add','default',500)?>

<?php if($strAsk['isopen']=='1' && $userid && !$iscommented) { ?>
<script type="text/javascript">
$(document).ready(function(){
	//回答问题
	$('#btn_comment_add').click(function(){
		//防重复提交
		if (sign === 1){
			return false;
		}
		var count_content_add = defaultEditor.count('text');
		if(count_content_add < 1){
			alert("答案内容不能为空");
			return false;
		}
		if(count_content_add > 500){
			alert("不能超过500字");
			return false;
		}
		$("#comment_add").submit();
		sign = 1;
	});
});
</script>
<?php } ?>
<?php include template('footer'); ?>