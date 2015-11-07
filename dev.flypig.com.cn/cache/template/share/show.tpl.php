<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div id="path" class="bd clearfix">
	<span class="icon icon-home"></span>
	<a href="<?php echo SITE_URL;?>" title="<?php echo $TS_SITE['base']['site_title'];?>首页">首页</a>  &gt;  <a href="<?php echo tsurl($app)?>" title="<?php echo $TS_APP['options']['appname'];?>"><?php echo $TS_APP['options']['appname'];?></a>  &gt;  分享内容
</div>

<div id="bd" class="bd clearfix">
	<div class="bd-left">
		
		<div id="share-show">
			<div class="show clearfix">
				
				<div class="show-content">
					<h1 class="title wordfix">
						<?php echo $strShare['title'];?>
					</h1>
					<div class="meta">
						<span class="icon icon-clock"></span> <?php echo date('Y-m-d H:i:s',$strShare['addtime'])?>&nbsp;&nbsp;•&nbsp;&nbsp;By <a href="<?php echo tsurl('user','space',array('id'=>$strShare['userid']))?>" target="_blank"><?php echo $strShare['user']['username'];?></a>&nbsp;&nbsp;•&nbsp;&nbsp;分类：<a class="tag" href="<?php echo tsurl('share', 'index', array('cateid'=>$strShare['cateid']))?>"><?php echo $strShare['catename'];?></a>
					</div>
					<div class="content wordfix">
						<?php if($strShare['src']) { ?><center><a href="<?php echo $strShare['src'];?>" target="_blank"><img src="<?php echo $strShare['src'];?>"></a></center><?php } ?>
						<?php echo $strShare['content'];?>
					</div>
					
					<?php if($strShare['tags']) { ?>
					<div id="share_tags">
						<span class="icon-tags"></span>
						<?php foreach((array)$strShare['tags'] as $key=>$item) {?>
						<a href="<?php echo tsurl('share','tag',array('id'=>urlencode($item['tagname'])))?>"><?php echo $item['tagname'];?></a>
						<?php }?>
					</div>
					<?php } ?>
					
					<div class="com-tool" style="text-align:right;">
						<?php if($TS_USER['user']['userid'] == $strShare['userid'] || $TS_USER['user']['isadmin']=='1') { ?>
						<a class="btn-tool" href="<?php echo tsurl('share','edit',array('shareid'=>$strShare['shareid']))?>">修改</a> 
						<?php } ?>
						<?php if($TS_USER['user']['isadmin']=='1') { ?>
						<a class="btn-tool" href="<?php echo tsurl('share','do',array('ts'=>'audit','shareid'=>$strShare['shareid']))?>"><?php if($strShare['isaudit']==0) { ?>审核<?php } else { ?>取消审核<?php } ?></a>
						<a class="btn-tool" href="<?php echo tsurl('share','do',array('ts'=>'del','shareid'=>$strShare['shareid']))?>" onClick="return confirm('确定删除吗?')">删除</a>
						<?php } ?>
					</div>
					<script type="text/javascript">
					$(function(){
						var _w = 600;
						$('.content img').each(function(i){
							var img = $(this);
							var realWidth;//真实的宽度
							var realHeight;//真实的高度
							$("<img/>").attr("src", $(img).attr("src")).load(function() {
								realWidth = this.width;
								realHeight = this.height;
								//如果真实的宽度大于浏览器的宽度就按照100%显示
								if(realWidth>=_w){
									$(img).css("width","100%").css("height","auto");
								}else{//如果小于浏览器的宽度按照原尺寸显示
									$(img).css("width",realWidth+'px').css("height",realHeight+'px');
								}
							});
						});
					});
					</script>
					
				</div>
			</div>
		</div>
		
		<div id="share_comment">
			<a name="comment_add"></a>
			<div class="com-bar clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-image"></span>
					用户评论(<?php echo $strShare['count_comment'];?>)
				</div>
			</div>
			<ul class="comment">
				<?php if(is_array($arrShareComment)) { ?>
				<?php foreach((array)$arrShareComment as $key=>$item) {?>
				<li class="clearfix" id="l_<?php echo $item['commentid'];?>">
					<div class="show-face">
						<a href="<?php echo tsurl('user','space',array('id'=>$item['user'][userid]))?>" rel="face" uid="<?php echo $item['user'][userid];?>"><img title="<?php echo $item['user']['username'];?>" alt="<?php echo $item['user']['username'];?>" src="<?php echo $item['user'][face];?>" width="48" /></a>
					</div>
					<div class="show-info">
						<div class="meta">
							<?php echo date('Y-m-d H:i:s',$item['addtime'])?>
							<a href="<?php echo tsurl('user','space',array('id'=>$item['user'][userid]))?>" rel="face" uid="<?php echo $item['user'][userid];?>" style="margin-left:5px; margin-right:5px;"><?php echo $item['user']['username'];?></a>
							<i><?php echo $item['lou'];?>#</i>
						</div>
						<div class="content wordfix">
						<?php echo $item['content'];?>
						</div>
						<div class="com-tool" style="text-align:right">
							<?php if($TS_USER['user']['userid'] == $strShare['userid'] || $TS_USER['user']['userid'] == $item['userid'] || $TS_USER['user']['isadmin']==1) { ?>
							<a class="btn-tool" href="<?php echo SITE_URL;?>index.php?app=share&ac=comment&ts=delete&commentid=<?php echo $item['commentid'];?>" onClick="return confirm('确定删除吗?')">删除</a>
							<?php } ?>
						</div>
						<div id="rcomment_<?php echo $item['commentid'];?>" style="display:none">
							<textarea style="width:90%;height:60px;font-size:14px;" id="recontent_<?php echo $item['commentid'];?>" type="text" onKeyDown="keyRecomment(<?php echo $item['commentid'];?>,<?php echo $item['shareid'];?>,event)"></textarea>
							<p>
								<a class="btn" href="javascript:void(0);" onClick="recomment(<?php echo $item['commentid'];?>,<?php echo $item['shareid'];?>,'<?php echo $_SESSION['token'];?>')" id="recomm_btn_<?php echo $item['commentid'];?>">提交</a> <a href="javascript:void('0');" onclick="commentOpen(<?php echo $item['commentid'];?>,<?php echo $item['shareid'];?>)">取消</a>
							</p>
						</div>
					</div>
					<div class="clear"></div>
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
				<?php } elseif ($strShare['iscomment'] == '0' && $strShare['userid'] != $TS_USER['user']['userid'] && $TS_USER['user']['isadmin']==1) { ?>
				<div class="commentmsg">
				本帖除作者外不允许任何人评论
				</div>
				<?php } elseif ($strShare['isclose']=='1') { ?>
				<div class="commentmsg">
				该分享已被关闭，无法评论
				</div>
				<?php } else { ?>
				<form method="POST" action="<?php echo SITE_URL;?>index.php?app=share&ac=comment&ts=do" enctype="multipart/form-data">
					<textarea type="text" style="width:638px;" id="content" name="content"></textarea>
					<p>
						<input type="hidden" name="shareid" value="<?php echo $strShare['shareid'];?>" />
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
				<?php } ?>
			</div>
		</div>

	</div>
	<div class="bd-right">
		
		<p class="clearfix">
			<a href="#comment_add" class="btn3d btn3d-two"><span class="icon-bubble"></span> 回复(<?php echo $strShare['count_comment'];?>)</a>
			<a href="javascript:void('0');" onclick="collectShare('<?php echo $strShare['shareid'];?>')" class="btn3d btn3d-two fr"><span class="icon-heart2"></span> 喜欢(<?php echo $strShare['count_love'];?>)</a>
		</p>
		
		<div id="new_share" class="com-box">
			<h3>
				<span class="icon icon-clock2"></span>
				最新分享
			</h3>
			<ul class="content line23">
				<?php foreach((array)$newShare as $key=>$item) {?>
				<li>
					<?php if($item['appkey'] != 'share' && $item['appkey']!='') { ?>
					<a href="<?php echo SITE_URL;?><?php echo tsUrl($item['appkey'])?>" target="_blank" style="color:#999999;font-size: 12px;margin-right: 5px;" class="titles-type">[<?php echo $item['appname'];?>]</a>
					<a href="<?php echo SITE_URL;?><?php echo tsUrl($item['appkey'],$item['appaction'],array('id'=>$item['shareid']))?>" title="<?php echo $item['title'];?>" target="_blank"><?php echo $item['title'];?></a>
					<?php } else { ?>
					<a title="<?php echo $item['title'];?>" href="<?php echo tsurl('share','show',array('id'=>$item['shareid']))?>"><?php echo cututf8($item['title'],0,25)?></a> 
					<?php } ?>
				</li>
			<?php }?>
			</ul>
		</div>
		
		<div id="hot_share" class="com-box">
			<h3>
				<span class="icon icon-fire"></span>
				热门分享
			</h3>
			<ul class="content line23">
				<?php foreach((array)$arrHotShare as $key=>$item) {?>
				<li><a href="<?php echo tsurl('share','show',array('id'=>$item['shareid']))?>" target="_blank"><?php echo $item['title'];?></a></li>
				<?php }?>
			</ul>
		</div>
		
		<div id="share_user" class="com-box">
			<h3>
				<span class="icon icon-heart2"></span>
				喜欢这个分享的用户
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

<?php doAction('tseditor2','#content','share_comment')?>

<?php include template('footer'); ?>