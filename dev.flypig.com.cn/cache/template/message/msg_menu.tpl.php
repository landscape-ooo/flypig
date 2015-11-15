<?php defined('IN_TS') or die('Access Denied.'); ?><div class="com-tabnav">
	<ul>
		<li <?php if($ac=='my') { ?>class="on"<?php } ?>><a href="<?php echo tsurl('message','my')?>"><span>最新消息</span></a></li>
		<li <?php if($ac=='system') { ?>class="on"<?php } ?>><a href="<?php echo tsurl('message','system')?>"><span>系统消息</span></a></li>
		<li <?php if($ac=='friend' || $ac=='user') { ?>class="on"<?php } ?>><a  href="<?php echo tsurl('message','friend')?>">好友消息</a></li>
	</ul>
</div>
