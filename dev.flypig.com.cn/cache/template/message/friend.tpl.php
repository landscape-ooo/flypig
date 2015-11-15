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
				
				<div class="msgbox">
					<ul>
						<?php foreach((array)$arrToUser as $key=>$item) {?>
						<li>
							<a href="<?php echo tsurl('message','user',array('touserid'=>$item['userid']))?>"><img alt="<?php echo $item['user'][username];?>" class="m_sub_img" width="16" src="<?php echo $item['user'][face];?>" align="absmiddle"> <?php echo $item['user'][username];?> </a>
							<?php if($item['count'] > 0) { ?>(<?php echo $item['count'];?>)<?php } ?>
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