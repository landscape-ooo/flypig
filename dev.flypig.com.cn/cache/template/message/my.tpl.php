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
				
				<div class="newmsg">
					<ul>
						<?php foreach((array)$arrMsg as $key=>$item) {?>
						<li><?php if($item['userid']) { ?><img src="<?php echo $item['user']['face'];?>" width="16" align="absmiddle" /> <?php echo $item['user']['username'];?>：<?php echo $item['content'];?> <a href="<?php echo tsurl('message','user',array('touserid'=>$item['userid']))?>">[回复]</a><?php } else { ?>系统消息：<a href="<?php echo tsurl('message','system')?>">[查看]</a><?php } ?></li>
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