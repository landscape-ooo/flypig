<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div id="path">
	<span class="icon icon-home"></span>
	<a href="<?php echo SITE_URL;?>" title="<?php echo $TS_SITE['base']['site_title'];?>首页">首页</a>  &gt;  <a href="<?php echo tsurl($app)?>" title="<?php echo $TS_APP['options']['appname'];?>"><?php echo $TS_APP['options']['appname'];?></a><?php if(!empty($cateid)) { ?>  &gt;  <a href="<?php echo tsurl($app,'index',array('cateid'=>$cateid))?>"><?php echo $catename;?></a><?php } ?>  &gt;  最新活动
</div>

<div id="bd" class="bd clearfix">
	<div class="bd-left">
		
		<div id="event_list">
			<ul>
				<?php foreach((array)$arrEvent as $key=>$item) {?>
				<li class="event-box clearfix" onclick="window.open('<?php echo tsurl($app,'show',array('id'=>$item['eventid']))?>', '_blank');return false;">
					<div class="li-pic">
						<a href="<?php echo tsurl($app,'show',array('id'=>$item['eventid']))?>" target="_blank"><img src="<?php echo $item['thumb'];?>"></a>
					</div>
					<div class="li-text">
						<a class="title wordfix" href="<?php echo tsurl($app,'show',array('id'=>$item['eventid']))?>" target="_blank"><?php echo $item['title'];?></a>
						<div class="baseinfo">
							<?php if($item['catename']) { ?>
							<dl class="clearfix">
								<dt>
									<span class="icon icon-tag"></span>
									<span class="t">活动类型：</span>
								</dt>
								<dd><?php echo $item['catename'];?></dd>
							</dl>
							<?php } ?>
							<?php if($item['PCA']) { ?>
							<dl class="clearfix">
								<dt>
									<span class="icon icon-location2"></span>
									<span class="t">活动地点：</span>
								</dt>
								<dd>
									<?php if($item['PCA']) { ?><?php echo $item['PCA'];?><?php } ?>
								</dd>
							</dl>
							<?php } ?>
							<dl class="clearfix">
								<dt>
									<span class="icon icon-clock"></span>
									<span class="t">开始时间：</span>
								</dt>
								<dd><?php echo $item['time_start'];?></dd>
							</dl>
						</div>
						<div class="desc"><?php echo cututf8(t($item['content']),'0','250')?></div>
					</div>
				</li>
				<?php }?>
			</ul>
			<div class="com-page"><?php echo $pageUrl;?></div>
			
		</div>
		
	</div>
	<div class="bd-right">
		<br>
		<?php if($TS_APP['options'][iscreate]==0 || $TS_USER['user'][isadmin]==1) { ?>
		<a class="btn3d btn3d-full" href="<?php if($cateid) { ?><?php echo tsurl($app, 'add', array('cateid'=>$cateid))?><?php } else { ?><?php echo tsurl($app, 'add')?><?php } ?>"><span class="icon-pen"></span> 发起活动</a><br><br>
		<?php } ?>
		
		<div id="event-cate-list" class="com-box">
			<div class="com-bar3 clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-tags"></span>
					活动分类
				</div>
				<div class="com-bar-more">
					&nbsp;&nbsp;
				</div>
			</div>
			<ul>
				<li>
					<a class="tag<?php if($cateid=='0') { ?> current<?php } ?>" href="<?php echo tsurl($app)?>"><span>全部</span></a>
					<a class="tag_count" href="<?php echo tsurl($app)?>"><?php echo $eventNumAll;?></a>
				</li>
				<?php foreach((array)$arrEventCate as $key=>$item) {?>
				<li>
					<a class="tag<?php if($cateid==$item['cateid']) { ?> current<?php } ?>" href="<?php echo tsurl($app,'index',array(cateid=>$item['cateid']))?>"><span><?php echo $item['catename'];?></span></a>
					<a class="tag_count" href="<?php echo tsurl($app,'index',array(cateid=>$item['cateid']))?>"><?php echo $item['count_event'];?></a>
				</li>
				<?php }?>
			</ul>
		</div>
		
		<!--广告位-->
		<?php doAction('gobad','300')?>
		
	</div>
</div>

<?php include template('footer'); ?>