<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div id="path">
	<!--<a href="#" target="_blank" class="join_link">分类反馈</a>-->
	<span class="icon icon-home"></span>
	<a href="<?php echo SITE_URL;?>" title="<?php echo $TS_SITE['base'][site_title];?>首页">首页</a>  &gt;  <a href="<?php echo tsurl('book','index')?>" title="飞猪网精品图书汇">精品汇</a>  &gt;  分类筛选
</div>

<div id="bd" class="bd clearfix">
	<div class="bd-left">

		<?php if($arrCate) { ?>
		<div id="cate_opt" class="com-cate-opt">
			<?php echo $bookcates;?>
		</div>
		<?php } ?>
		<div id="cate_opt_list">
			<div class="com-bar clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-search"></span>
					搜索到 <span><?php echo $bookNum;?>本</span> 图书
				</div>
				<div class="com-bar-more">
					<a class="look_bookreview" href="javascript:void(0);">去看书评</a>
				</div>
			</div>
			<?php if(count($arrFilterBook)>0) { ?>
			<ul>
				<?php foreach((array)$arrFilterBook as $key=>$item) {?>
				<li class="clearfix" onclick="window.open('<?php echo tsurl('book','show',array('id'=>$item['bookid']))?>', '_blank');return false;">
					<div class="pic">
						<a href="<?php echo tsurl('book','show',array('id'=>$item['bookid']))?>" title="<?php echo $item['bookname'];?>" target="_blank"><img src="<?php echo $item['icon_120'];?>" alt="<?php echo $item['bookname'];?>封面" title="<?php echo $item['bookname'];?>" /></a>
					</div>
					<div class="info">
						<a href="<?php echo tsurl('book','show',array('id'=>$item['bookid']))?>" class="name">《<?php echo $item['bookname'];?>》</a>
						<?php if($item['title'] && $item['title']!=$item['bookname']) { ?><p class="title"><em>——</em> <?php echo $item['title'];?></p><?php } ?>
						<?php if($item['description']) { ?><p class="desc"><?php echo $item['description'];?></p><?php } ?>
						<?php if($item['star']) { ?><p class="star f12"><em>推荐星级：</em><?php echo $item['star'];?></p><?php } ?>
						<?php if($item['author']) { ?><p class="author f12"><em>　　作者：</em><?php echo $item['author'];?></p><?php } ?>
						<?php if($item['pubhouse']) { ?><p class="pubhouse f12"><em>　出版社：</em><?php echo $item['pubhouse'];?></p><?php } ?>
						<?php if($item['age']) { ?><p class="age f12"><em>阅读年龄：</em><?php echo $item['age'];?></p><?php } ?>
						<?php if($item['intel']) { ?><p class="intel f12"><em>图书智能：</em><?php echo $item['intel'];?></p><?php } ?>
						<?php if($item['theme']) { ?><p class="theme f12"><em>阅读主体：</em><?php echo $item['theme'];?></p><?php } ?>
						<?php if($item['spec']) { ?><p class="spec f12"><em>其　　它：</em><?php echo $item['spec'];?></p><?php } ?>
					</div>
				</li>
				<?php }?>
			</ul>
			<div class="com-page"><?php echo $pageUrl;?></div>
			<?php } else { ?>
			<p style="width:640px;margin:80px auto;text-align:center;color:gray;">当前 0 个搜索结果</p>
			<?php } ?>
		</div>
		
	</div>
	<div class="bd-right">
		
		<?php if($TS_APP['options'][iscreate]==0 || $TS_USER['user'][isadmin]==1) { ?>
		<a class="btn3d btn3d-full" href="<?php echo tsurl('book','add')?>"><span class="icon-book"></span> 创建图书</a>
		<?php } ?>
		
		<div class="com-box">
			<h3>
				<span class="icon icon-clock2"></span>
				最新图书
			</h3>
			<div class="content line23">
				<?php if($arrNewBook) { ?>
				<?php foreach((array)$arrNewBook as $key=>$item) {?>
				<a href="<?php echo tsurl('book','show',array('id'=>$item['bookid']))?>">《<?php echo $item['bookname'];?>》</a><br>
				<?php }?>
				<?php } ?>
			</div>
		</div>
		
		<div id="hot_review" class="com-box">
			<h3>
				<span class="icon icon-fire"></span>
				热门书评
			</h3>
			<ul class="content">
				<?php foreach((array)$arrReview as $key=>$item) {?>
				<li>
					<h4><a href="<?php echo tsurl('review','show',array('id'=>$item['reviewid']))?>" target="_blank"><?php echo $item['title'];?></a></h4>
					<span class="r-grey">
						<span class="icon icon-bubble2"></span>
						<a href="<?php echo tsurl('review','show',array('id'=>$item['reviewid']))?>" target="_blank" title="评论数"><?php echo $item['count_comment'];?></a>
					</span>
					<p class="b-titles">
						<span class="b-titles-l">来自：<a title="<?php echo $item['book']['bookname'];?>" target="_blank" href="<?php echo tsurl('book','show',array('id'=>$item['bookid']))?>">《<?php echo cututf8(t($item['book']['bookname']),0,14)?>》</a></span>
					</p>
				</li>
				<?php }?>
			</ul>
		</div>
		
		<!--广告位-->
		<?php doAction('gobad','300')?>
		
	</div>
</div>
<script type="text/javascript">
$(function(){
	$('#filter_list').find('li').each(function(){
		$(this).hover(function(){
			$(this).addClass('hover');
		},function(){
			$(this).removeClass('hover');
		});
	});
});
</script>
<?php include template('footer'); ?>