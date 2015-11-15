<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div id="bd" class="bd clearfix">
	<h1 id="user-title">
		<span class="icon icon-cog"></span>
		会员中心
	</h1>
	<div class="bd-left">
		
		<div id="space" class="com-box">
			<div id="space-menu">
				<?php include template('space_menu'); ?>
			</div>
			<div class="content">
				<div class="guestbook">
					<?php if(intval($TS_USER['user']['userid']) >0 && intval($TS_USER['user']['userid']) != $strUser['userid']) { ?>
					<div id="guestbook-form" class="clearfix">
						<img src="<?php echo SITE_URL;?>public/images/user_normal.jpg" />
						<form method="post" action="<?php echo SITE_URL;?>index.php?app=user&ac=guestbook&ts=do">
						<textarea style="width:610px;height:50px;margin-bottom: 5px;" name="content"></textarea>
						<p>
							<input type="hidden" name="touserid" value="<?php echo $strUser['userid'];?>" />
							<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
							<button class="btn btn-success fr" type="submit">添加留言</button>
						</p>
						</form>
					</div>
					<?php } ?>
					<div class="gbook-list">
						<ul>
							<?php foreach((array)$arrGuestList as $key=>$item) {?>
							<li id="gb_<?php echo $item['id'];?>" class="clearfix">
								<div class="face">
									<a href="<?php echo tsurl('user','space',array('id'=>$item['userid']))?>" rel="face" uid="<?php echo $item['user']['userid'];?>"><img src="<?php echo $item['user']['face'];?>" alt="<?php echo $item['user']['username'];?>" width="48" height="48" /></a>
								</div>
								<div class="message">
									<p><a href="<?php echo tsurl('user','space',array('id'=>$item['userid']))?>"  rel="face" uid="<?php echo $item['user']['userid'];?>"><?php echo $item['user']['username'];?></a> <?php echo $item['addtime'];?></p>
									<?php echo nl2br(htmlspecialchars($item['content']))?>
									<?php if(intval($TS_USER['user']['userid'] == $strUser['userid'])) { ?>
									<div class="brtool">
										<a href="javascript:;" onclick="showReplyBox('<?php echo $item['user']['username'];?>','<?php echo $item['userid'];?>','<?php echo $item['id'];?>')">回复</a>
										<a href="<?php echo tsurl('user','guestbook',array('ts'=>'delete','gbid'=>$item['id']))?>" onclick="return confirm('确定删除?')">删除</a>
									</div>
									<?php } ?>
								</div>
							</li>
							<?php }?>
						</ul>
					</div>
					<div class="com-page"><?php echo $pageUrl;?></div>
					<div id="reguest" style="display:none;">
						<form method="post" action="<?php echo SITE_URL;?>index.php?app=user&ac=guestbook&ts=redo">
						<textarea style="width:610px;height:50px;margin-bottom: 5px;" name="content"></textarea>
						<p>
							<input id="touserid" type="hidden" name="touserid" value="0" />
							<input id="reid" type="hidden" name="reid" value="0" />
							<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
							<input class="btn btn-success fr" type="submit" value="回复" />
						</p>
						</form>
					</div>
					<script type="text/javascript">
					function showReplyBox(username,userid,reid){
						if($("#reguest_"+reid).length<1){
							$("#gb_"+reid).append('<div id=\"reguest_'+reid+'\">'+ $("#reguest").html() +"</div>");
							$("#reguest_"+reid+" textarea").val('@'+username+'#');
							$("#reguest_"+reid+" #touserid").val(userid);
							$("#reguest_"+reid+" #reid").val(reid);
							$("#reguest_"+reid+" textarea").focus();
						}else{
							$("#reguest_"+reid).remove();
						}
					}
					</script>
				</div>
			</div>
		</div>
		
	</div>
	<div class="bd-right">
		
		<?php include template('userinfo'); ?>
		
		<!--广告位-->
		<?php doAction('gobad','300')?>
		
	</div>
</div>

<?php include template('footer'); ?>