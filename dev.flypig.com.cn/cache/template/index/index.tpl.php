<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div id="bd" class="bd clearfix">
	<div class="bd-left">
		
		<ul id="index_list">
			<?php foreach((array)$arrIndex as $key=>$item) {?>
			<li class="clearfix">
				<?php echo $item['content'];?>
			</li>
			<?php }?>
		</ul>
		<div class="com-page"><?php echo $pageUrl;?></div>
		
	</div>
	<div class="bd-right">
	
		<embed src="http://player.youku.com/player.php/sid/XNDI4NDE5MjQw/v.swf" allowFullScreen="true" quality="high" width="300" height="270" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" style="margin-top:50px;"></embed>
		
		<div id="hot-users" class="com-box" style="margin-top:30px;">
			<div class="com-bar3 clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-users2"></span>
					最新签到用户
				</div>
			</div>
			<ul class="facelist">
				<?php foreach((array)$arrUser as $key=>$item) {?>
				<li>
					<a href="<?php echo tsurl('user','space',array('id'=>$item['userid']))?>" title="<?php echo $item['username'];?>" target="_blank"><img src="<?php echo $item['face'];?>" alt="<?php echo $item['username'];?>" title="<?php echo $item['username'];?>" width="48" height="48" /></a>
				</li>
				<?php }?>
			</ul>
		</div>
		
		<?php if($arrRecommendBook) { ?>
		<div id="recommend-book">
			<div class="com-bar clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-fire"></span>
					最新上传精品图书
				</div>
			</div>
			<ul class="clearfix">
				<?php foreach((array)$arrRecommendBook as $key=>$item) {?>
				<li>
					<div class="pic">
						<a href="<?php echo tsurl('book','show',array('id'=>$item['bookid']))?>" title="<?php echo $item['bookname'];?>" target="_blank"><img src="<?php echo $item['icon_120'];?>" width="90" alt="<?php echo $item['bookname'];?>封面" title="<?php echo $item['bookname'];?>" /></a>
					</div>
				</li>
				<?php }?>
			</ul>
		</div>
		<script type="text/javascript">
		$(function(){
			$("#recommend-book .pic img").imgLoader(true,120,140);
			$("#index_list .content").each(function () {
				if ($(this).height() > 75) {
					$(this).css({'height':'75px','overflow':'hidden'});
				};
			});
		});
		</script>
		<?php } ?>
		
		
		<div id="hot_review" class="com-box">
			<h3>
				<span class="icon icon-fire"></span>
				推荐热门文章
			</h3>
			<ul class="content">
				<?php foreach((array)$topvisitlist as $key=>$item) {?>
				<li>
					<h4><a href="<?php echo tsurl($item['type'],'show',array('id'=>$item[$item['type'].'id']))?>"
					 target="_blank"><?php echo getsubstrutf8($item['title'],0,16);?></a></h4>
				</li>
				<?php }?>
			</ul>
		</div>
		<!--广告位-->
		<?php doAction('gobad','300')?>
		
	</div>
</div>

<?php include template('footer'); ?>