<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div id="path" class="bd clearfix">
	<span class="icon icon-home"></span>
	<a href="<?php echo SITE_URL;?>" title="<?php echo $TS_SITE['base']['site_title'];?>首页">首页</a>  &gt;  <a href="<?php echo tsurl('review','index')?>" title="飞猪网好书评">好书评</a>  &gt;  <?php if(!empty($bookid)) { ?>《<?php echo $bookname;?>》的书评<?php } else { ?>书评列表<?php } ?>
</div>

<div id="bd" class="bd clearfix">
	<div class="bd-left">
		
		<div id="review_list">
			<?php if(!empty($bookid)) { ?>
			<div class="com-bar clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-file2"></span>
					最新书评
					<span class="f12 color-gray">(<?php echo $reviewNum;?>)</span>
				</div>
				<div class="com-bar-more">
					&nbsp;&nbsp;<span class="icon icon-redo"></span> <a href="<?php echo tsurl('book','show',array('id'=>$bookid))?>">返回《<?php echo $bookname;?>》</a>
				</div>
			</div>
			<?php } else { ?>
			<div class="com-bar clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-file2"></span>
					最新书评
					<span class="f12 color-gray">(<?php echo $reviewNum;?>)</span>
				</div>
				<div class="com-bar-more">
					&nbsp;&nbsp;<span class="icon icon-books"></span> <a href="<?php echo tsurl('book')?>" target="_blank">去选书</a>
				</div>
			</div>
			<?php } ?>
			<div class="review_box">
				<?php if($arrReview) { ?>
				<div class="review_list">
					<ul>
						<?php foreach((array)$arrReview as $key=>$item) {?>
						<li class="clearfix">
							<div class="bookimg">
								<a href="<?php echo tsurl('book','show',array('id'=>$item['book']['bookid']))?>" title="<?php echo $item['book']['bookname'];?>" target="_blank"><img src="<?php echo $item['book']['icon_120'];?>" width="92" alt="<?php echo $item['book']['bookname'];?>" /></a>
							</div>
							<div class="content">
								<div class="review_title">
									<a target="_blank" title="<?php echo $item['title'];?>" href="<?php echo tsurl('review','show',array('id'=>$item['reviewid']))?>"><?php echo $item['title'];?></a>
									<?php if($item['istop']==1) { ?>
									<img src="<?php echo SITE_URL;?>public/images/tops.gif" title="[置顶]" alt="[置顶]" /> 
									<?php } ?> 
									<?php if($item['isbrilliant']==1) { ?>
									<img src="<?php echo SITE_URL;?>public/images/posts.gif" title="[精华]" alt="[精华]" />
									<?php } ?>
									<?php if($item['postby']==1) { ?>
									<a href="<?php echo tsurl('home','phone')?>"><img align="absmiddle" alt="通过Iphone手机端发布" title="通过Iphone手机端发布" src="<?php echo SITE_URL;?>public/images/ios.jpg" /></a>
									<?php } ?>
									<span class="data">
										<span class="icon icon-eye"></span>
										<a target="_blank" href="<?php echo tsurl('review','show',array('id'=>$item['reviewid']))?>" title="浏览数"><?php echo $item['count_view'];?></a>
										<span class="icon icon-bubble2"></span>
										<a target="_blank" href="<?php echo tsurl('review','show',array('id'=>$item['reviewid']))?>" title="回复数"><?php echo $item['count_comment'];?></a>
										<span class="icon icon-heart"></span>
										<a target="_blank" href="<?php echo tsurl('review','show',array('id'=>$item['reviewid']))?>" title="喜欢数"><?php echo $item['count_love'];?></a>
									</span>
								</div>
								<div class="review_content">
									<?php echo cututf8(t($item['summary']),0,120)?>
								</div>
								<div class="review_info">
									<span style="float:left;">
										<?php echo getTime($item['uptime'],time())?>
										，By <a href="<?php echo tsurl('user','space',array('id'=>$item['userid']))?>"><?php echo $item['user'][username];?></a>
										，来自<a target="_blank" title="<?php echo $item['book']['bookname'];?>" href="<?php echo tsurl('book','show',array('id'=>$item['book']['bookid']))?>">《<?php echo $item['book']['bookname'];?>》</a>
									</span>
									<span style="float:right;text-align:right;">
										<span class="icon icon-quill"></span> <a href="<?php echo tsurl('review','add',array('bookid'=>$item['book']['bookid']))?>" target="_blank">我也写书评</a>
									</span>
								</div>
							</div>
							<div class="clear"></div>
						</li>
						<?php }?>
					</ul>
				</div>
				<div class="com-page"><?php echo $pageUrl;?></div>
				<?php } else { ?>
				<p style="width:640px;margin:15px 15px 30px 15px;text-align:center;color:gray;">暂无书评</p>
				<?php } ?>
			</div>
		</div>
		
	</div>
	<div class="bd-right">
		
		<?php if($TS_APP['options']['iscreate']==0 || $TS_USER['user']['isadmin']==1) { ?>
		<?php if(!empty($bookid)) { ?>
		<a class="btn3d btn3d-full" href="<?php echo tsurl('review','add',array('bookid'=>$bookid))?>" style="margin-top:30px;"><span class="icon-pen"></span> 发布书评</a>
		<?php } else { ?>
		<a class="btn3d btn3d-full" href="<?php echo tsurl('book')?>" style="margin-top:30px;" onClick="return confirm('亲，先去选本图书吧！');return false;"><span class="icon-pen"></span> 发布书评</a>
		<?php } ?>
		<?php } ?>
		
		<div id="hot_review" class="com-box" style="margin-top:30px;">
			<div class="com-bar3 clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-fire"></span>
					热门书评
				</div>
				<div class="com-bar-more">
					&nbsp;&nbsp;
				</div>
			</div>
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
		
		<div class="com-box">
			<div class="com-bar3 clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-clock2"></span>
					最新图书
				</div>
				<div class="com-bar-more">
					&nbsp;&nbsp;
				</div>
			</div>
			<div class="content line23">
				<?php if($arrNewBook) { ?>
				<?php foreach((array)$arrNewBook as $key=>$item) {?>
				<a href="<?php echo tsurl('book','show',array('id'=>$item['bookid']))?>">《<?php echo $item['bookname'];?>》</a><br><br>
				<?php }?>
				<?php } ?>
			</div>
		</div>
		
		<!--广告位-->
		<?php doAction('gobad','300')?>
		
	</div>
</div>

<?php include template('footer'); ?>