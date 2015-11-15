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
				
				<div class="commlist">
					<ul>
						<?php foreach((array)$arrEvent as $key=>$item) {?>
						<li>
							<a href="<?php echo tsurl('event','show',array('id'=>$item['eventid']))?>"><?php echo htmlspecialchars($item['title'])?></a> <i><?php echo $item['count_comment'];?></i>
						</li>
						<?php }?>
					</ul>
				</div>
				
				<div class="com-page"><?php echo $pageUrl;?></div>
				
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