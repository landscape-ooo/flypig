<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<link type="text/css" href="<?php echo SITE_URL;?>public/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo SITE_URL;?>public/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

<div id="path" class="bd clearfix">
	<span class="icon icon-home"></span>
	<a href="<?php echo SITE_URL;?>" title="<?php echo $TS_SITE['base'][site_title];?>首页">首页</a>  &gt;  <a href="<?php echo tsurl('event','index')?>" title="<?php echo $TS_APP['options']['appname'];?>"><?php echo $TS_APP['options']['appname'];?></a>  &gt;  <a href="<?php echo tsurl('event','index',array('cateid'=>$strEvent['cateid']))?>"><?php echo $strEvent['catename'];?></a>  &gt;  活动详情
</div>

<div id="bd" class="bd clearfix">
	<div class="bd-left">
		
		<div id="event-show">
			
			<div id="show-base" class="clearfix">
				<div class="pic">
					<a href="<?php echo $strEvent['src'];?>" class="eventphoto_image" target="_blank"><img title="点击看大图" src="<?php echo $strEvent['thumb'];?>" width="220" target="_blank"></a>
					<script type="text/javascript">
					$(document).ready(function() {
						$(".eventphoto_image").fancybox();
					});
					</script>
				</div>
				<div class="info">
					<h1 class="wordfix"><?php echo $strEvent['title'];?></h1>
					<ul class="baseinfo">
						<?php if($strEvent['catename']) { ?>
						<li>
							<dl class="clearfix">
								<dt>
									<span class="icon icon-tag"></span>
									<span class="t">活动类型：</span>
								</dt>
								<dd><a href="<?php echo tsurl('event','index',array('cateid'=>$strEvent['cateid']))?>"><?php echo $strEvent['catename'];?></a></dd>
							</dl>
						</li>
						<?php } ?>
						<?php if($strEvent['PCA'] || $strEvent['address']) { ?>
						<li>
							<dl class="clearfix">
								<dt>
									<span class="icon icon-location2"></span>
									<span class="t">活动地点：</span>
								</dt>
								<dd>
									<?php if($strEvent['PCA']) { ?><?php echo $strEvent['PCA'];?><?php } ?>
									<?php if($strEvent['address']) { ?><br><?php echo $strEvent['address'];?><?php } ?>
								</dd>
							</dl>
						</li>
						<?php } ?>
						<li>
							<dl class="clearfix">
								<dt>
									<span class="icon icon-clock"></span>
									<span class="t">开始时间：</span>
								</dt>
								<dd><?php echo $strEvent['time_start'];?></dd>
							</dl>
						</li>
						<?php if($strEvent['time_end']) { ?>
						<li>
							<dl class="clearfix">
								<dt>
									<span class="icon icon-clock2"></span>
									<span class="t">结束时间：</span>
								</dt>
								<dd><?php if($strEvent['time_end']=='') { ?>不限<?php } else { ?><?php echo $strEvent['time_end'];?><?php } ?></dd>
							</dl>
						</li>
						<?php } ?>
						<li>
							<dl class="clearfix">
								<dt>
									<span class="icon icon-user22"></span>
									<span class="t">发 起 人：</span>
								</dt>
								<dd><a href="<?php echo tsurl('user','space',array('id'=>$strEvent['user'][userid]))?>" target="_blank"><?php echo $strEvent['user']['username'];?></a></dd>
							</dl>
						</li>
						<li>
							<dl class="clearfix">
								<dt>
									<span class="icon icon-users2"></span>
									<span class="t">报名人数：</span>
								</dt>
								<dd><a href="javascript:viod(0);" onclick="gotoAnchor('#show-user-list');"><?php echo $strEvent['count_user'];?></a> 人</dd>
							</dl>
						</li>
					</ul>
				</div>
				<div class="brtool">
					<?php if(isset($TS_USER['user']['userid']) && $isEventUser) { ?>
					您已报名，<a class="btn btn-success" href="javascript:void('0');" onclick="cancelEvent('<?php echo $strEvent['eventid'];?>');">退出活动</a>
					<?php } else { ?>
					<a class="btn btn-success" href="javascript:void(0);" onclick="joinEvent('<?php echo $strEvent['eventid'];?>');">我要参加</a>
					<?php } ?>
				</div>
			</div>
			<div id="show-content" class="clearfix">
				<div class="com-box">
					<div class="com-bar clearfix">
						<div class="com-bar-tit">
							<span class="icon icon-file2"></span>
							活动详细介绍
						</div>
					</div>
					<div class="content wordfix"><?php echo $strEvent['content'];?></div>
					<div class="com-tool" style="text-align:right;">
						<?php if($TS_USER['user'][userid] == $strEvent['userid'] || $TS_USER['user']['isadmin']=='1') { ?>
						<a class="btn-tool" href="<?php echo tsurl('event','edit',array('eventid'=>$strEvent['eventid']))?>">修改</a> 
						<?php } ?>
						<?php if($TS_USER['user']['isadmin']=='1') { ?>
						<a class="btn-tool" href="<?php echo tsurl('event','do',array('ts'=>'isaudit','eventid'=>$strEvent['eventid']))?>"><?php if($strEvent['isaudit']==0) { ?>审核<?php } else { ?>取消审核<?php } ?></a>
						<a class="btn-tool" href="<?php echo tsurl('event','do',array('ts'=>'del','eventid'=>$strEvent['eventid']))?>" onClick="return confirm('确定删除吗?')">删除</a>
						<?php } ?>
					</div>
				</div>
				<div class="com-box" id="show-user-list">
					<div class="com-bar clearfix">
						<div class="com-bar-tit">
							<span class="icon icon-users2"></span>
							参加这个活动的成员<span class="pl">(全部 <?php echo $strEvent['count_user'];?> 人)</span>
						</div>
					</div>
					<div class="content">
						<?php foreach((array)$arrEventUser as $key=>$item) {?>
						 <a class="nbg" href="<?php echo tsurl('user','space',array('id'=>$item['userid']))?>"><img  class="m_sub_img" src="<?php echo $item['face'];?>" alt="<?php echo $item['username'];?>" width="48" height="48" /></a>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
		<div id="event_comment">
			<div class="com-bar clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-bubbles"></span>
					活动回应(<?php echo $strEvent['count_comment'];?>)
				</div>
			</div>
			<ul class="comment">
				<?php if(is_array($arrEventComment)) { ?>
				<?php foreach((array)$arrEventComment as $key=>$item) {?>
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
						<div class="tool" style="text-align:right;" id="comment-tool<?php echo $item['commentid'];?>">
							<?php if($TS_USER['user']['userid'] == $item['userid'] || $TS_USER['user']['isadmin']=='1') { ?>
							<a class="btn-tool2 deleteComment" data-id="<?php echo $item['commentid'];?>" data-operation="deleteComment" href="javascript:void(0);" onclick="return confirm('确定要删除？');">删除</a>
							<a class="btn-tool2 editComment" data-id="<?php echo $item['commentid'];?>" data-operation="editComment" href="javascript:void(0);">修改</a>
							<?php } ?>
						</div>
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
				<?php } else { ?>
				<form method="POST" action="<?php echo SITE_URL;?>index.php?app=event&ac=comment&ts=add">
					<textarea type="text" style="width:638px;" id="content" name="content"></textarea>
					<p>
						<input type="hidden" name="eventid" value="<?php echo $strEvent['eventid'];?>" />
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
								},
								afterCreate : function(){
									
								},
								afterFocus : function(){
									
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
									alert("评论内容不能超过2000字");
									return false;
								}
								$.ajax({
									url: "<?php echo tsurl('event','ajax',array('ts'=>'submitEditComment'))?>", 
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
					
					//删除答案
					$(".deleteComment").each(function(){
						$(this).click(function(){
							var commentid = $(this).attr("data-id");
							$.ajax({
								type: "POST",
								url: "<?php echo tsurl('event','ajax',array('ts'=>'deleteComment'))?>",
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
		
		&gt; <a href="<?php echo tsurl('event','index')?>">返回活动列表</a><br><br>
		
		<!--广告位-->
		<?php doAction('gobad','300')?>
		
	</div>
</div>

<?php doAction('tseditor2','#content','event_comment')?>

<?php include template('footer'); ?>