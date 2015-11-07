<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div id="path" class="bd clearfix">
	<span class="icon icon-home"></span>
	<a href="<?php echo SITE_URL;?>" title="<?php echo $TS_SITE['base']['site_title'];?>首页">首页</a>  &gt;  <a href="<?php echo tsurl('special')?>" title="<?php echo $TS_APP['options']['appname'];?>"><?php echo $TS_APP['options']['appname'];?></a>  &gt;  <?php if(!empty($cateid)) { ?><a href="<?php echo tsurl('special','index',array('cateid'=>$cateid))?>"><?php echo $catename;?></a>  &gt;  <?php } ?>专题列表
</div>

<div id="bd" class="bd clearfix">
	<div class="bd-left">
		
		<div id="special_list">
			<ul>
				<?php foreach((array)$arrSpecial as $key=>$item) {?>
				<li class="special-box clearfix">
					<div class="li-pic">
						<a href="<?php echo tsurl('special','show',array('id'=>$item['specialid']))?>" target="_blank"><img src="<?php echo $item['thumb'];?>"></a>
					</div>
					<div class="li-text">
						<a class="title wordfix" href="<?php echo tsurl('special','show',array('id'=>$item['specialid']))?>" target="_blank"><?php echo $item['title'];?></a>
						<div class="desc wordfix"><?php echo cututf8(t($item['content']),'0','250')?></div>
						<?php if($TS_USER['user']['userid'] == $item['userid'] || $TS_USER['user']['isadmin']=='1') { ?>
						<div class="com-tool" style="text-align:right;">
							<a class="btn-tool" href="<?php echo tsurl('special','edit',array('specialid'=>$item['specialid']))?>">修改</a> 
							<?php if($TS_USER['user']['isadmin']=='1') { ?>
							<a class="btn-tool" href="<?php echo tsurl('special','do',array('ts'=>'isaudit','specialid'=>$item['specialid']))?>"><?php if($item['isaudit']==0) { ?>审核<?php } else { ?>取消审核<?php } ?></a>
							<a class="btn-tool" href="<?php echo tsurl('special','do',array('ts'=>'del','specialid'=>$item['specialid']))?>" onClick="return confirm('确定删除吗?')">删除</a>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
				</li>
				<?php }?>
			</ul>
			<div class="com-page"><?php echo $pageUrl;?></div>
			
		</div>
		
	</div>
	<div class="bd-right">
		
		<?php if($TS_APP['options']['iscreate']=='0' || $TS_USER['user']['isadmin']=='1') { ?>
		<a class="btn3d btn3d-full" href="<?php if($cateid>0) { ?><?php echo tsurl('special', 'add', array('cateid'=>$cateid))?><?php } else { ?><?php echo tsurl('special', 'add')?><?php } ?>"><span class="icon-pencil"></span> 发布专题</a>
		<?php } ?>
		
		<div id="special-cate-list" class="com-box" style="margin-top:20px;">
			<div class="com-bar3 clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-tags"></span>
					专题分类
				</div>
				<div class="com-bar-more">
					&nbsp;&nbsp;
				</div>
			</div>
			<ul>
				<li>
					<a class="tag<?php if($cateid=='0') { ?> current<?php } ?>" href="<?php echo tsurl('special')?>"><span>全部</span></a>
					<a class="tag_count" href="<?php echo tsurl('special')?>"><?php echo $specialNumAll;?></a>
				</li>
				<?php foreach((array)$arrSpecialCate as $key=>$item) {?>
				<li>
					<a class="tag<?php if($cateid==$item['cateid']) { ?> current<?php } ?>" href="<?php echo tsurl('special','index',array(cateid=>$item['cateid']))?>"><span><?php echo $item['catename'];?></span></a>
					<a class="tag_count" href="<?php echo tsurl('special','index',array(cateid=>$item['cateid']))?>"><?php echo $item['count_special'];?></a>
				</li>
				<?php }?>
			</ul>
		</div>
		
		<!--广告位-->
		<?php doAction('gobad','300')?>
		
	</div>
</div>

<?php include template('footer'); ?>