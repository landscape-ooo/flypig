<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div id="path" class="bd clearfix">
	<span class="icon icon-home"></span>
	<a href="<?php echo SITE_URL;?>" title="<?php echo $TS_SITE['base']['site_title'];?>首页">首页</a>  &gt;  <a href="<?php echo tsurl('share')?>" title="<?php echo $TS_APP['options']['appname'];?>"><?php echo $TS_APP['options']['appname'];?></a>  &gt;  <?php if(!empty($cateid)) { ?><a href="<?php echo tsurl('share','index',array('cateid'=>$cateid))?>"><?php echo $catename;?></a>  &gt;  <?php } ?>最新分享
</div>

<div id="bd" class="bd clearfix">
	<div class="bd-left">
		
		<div id="share_list">
			<ul>
				<?php foreach((array)$arrShare as $key=>$item) {?>
				<li class="share-box clearfix">
					<div class="li-pic">
						<a href="<?php echo tsurl('share','show',array('id'=>$item['shareid']))?>" target="_blank"><img src="<?php echo $item['thumb'];?>"></a>
					</div>
					<div class="li-text">
						<h2 class="title wordfix">
							<a href="<?php echo tsurl('share','show',array('id'=>$item['shareid']))?>" target="_blank"><?php echo $item['title'];?></a>
						</h2>
						<div class="content wordfix">
							<?php echo cututf8(t($item['summary']),'0','80')?>
						</div>
						<div class="mata">
							<?php echo $item['addtime'];?>&nbsp;&nbsp;来自 <a href="<?php echo tsurl('user','space',array('id'=>$item['userid']))?>" target="_blank"><?php echo $item['user']['username'];?></a>
						</div>
					</div>
				</li>
				<?php }?>
			</ul>
			<div class="com-page"><?php echo $pageUrl;?></div>
			
		</div>
		
	</div>
	<div class="bd-right">
		
		<?php if($TS_APP['options']['iscreate']=='0' || $TS_USER['user']['isadmin']=='1') { ?>
		<a class="btn3d btn3d-full" href="<?php if($cateid>0) { ?><?php echo tsurl('share', 'add', array('cateid'=>$cateid))?><?php } else { ?><?php echo tsurl('share', 'add')?><?php } ?>"><span class="icon-pencil"></span> 发布分享</a>
		<?php } ?>
		
		<?php if(isset($TS_USER['user']['userid'])) { ?>
		<div id="share-cate-list" class="com-box" style="margin-top:30px;">
			<div class="com-bar3 clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-tags"></span>
					我的分享分类
				</div>
				<div class="com-bar-more">
					&nbsp;&nbsp;<a href="<?php echo tsurl('share', 'cate', array('ts'=>'list'))?>">管理</a>
				</div>
			</div>
			<ul>
				<li>
					<a class="tag<?php if($cateid=='0') { ?> current<?php } ?>" href="<?php echo tsurl('share')?>"><span>全部</span></a>
					<a class="tag_count" href="<?php echo tsurl('share')?>"><?php echo $shareNumAll;?></a>
				</li>
				<?php foreach((array)$arrMyCate as $key=>$item) {?>
				<li>
					<a class="tag<?php if($cateid==$item['cateid']) { ?> current<?php } ?>" href="<?php echo tsurl('share','index',array(cateid=>$item['cateid']))?>"><span><?php echo $item['catename'];?></span></a>
					<a class="tag_count" href="<?php echo tsurl('share','index',array(cateid=>$item['cateid']))?>"><?php echo $item['count_share'];?></a>
				</li>
				<?php }?>
			</ul>
		</div>
		<?php } ?>
		
		
		<div id="hot_review" class="com-box">
			<h3>
				<span class="icon icon-fire"></span>
				热门分享
			</h3>
			<ul class="content">
				<?php foreach((array)$topvisitlist as $key=>$item) {?>
				<li>
					<h4><a href="<?php echo tsurl('review','show',array('id'=>$item['reviewid']))?>" target="_blank"><?php echo $item['title'];?></a></h4>
				</li>
				<?php }?>
			</ul>
		</div>
		<!--广告位-->
		<?php doAction('gobad','300')?>
		
	</div>
</div>

<?php include template('footer'); ?>