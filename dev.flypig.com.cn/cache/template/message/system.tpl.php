<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div id="bd" class="bd clearfix">
	<h1 id="msg-title">
		<span class="icon icon-envelope"></span>
		消息中心
	</h1>
	<div class="bd-left">
		
		<div class="com-box">
			<div id="msg-menu">
				<?php include template('msg_menu'); ?>
			</div>
			<div id="msg-body">
				
				<div class="system">
					<ul>
						<?php foreach((array)$arrMessage as $key=>$item) {?>
						<li>
							<span style="color:#42b475;"><?php echo $item['user'][username];?> <?php echo date('H:i:s',$item['addtime'])?></span>
							<br><?php echo $item['content'];?>
						</li>
						<?php }?>
					</ul>
				</div>
				
			</div>
		</div>
		
	</div>
	<div class="bd-right">
		
		<?php include template('msg_right'); ?>
		
	</div>
</div>

<?php include template('footer'); ?>