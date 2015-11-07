<?php defined('IN_TS') or die('Access Denied.'); ?><div class="com-tabnav">
	<ul>
		<?php if(0) { ?>
		<li <?php if($ac=='space') { ?>class="on"<?php } ?>><a href="<?php echo tsurl('user','space',array('id'=>$strUser['userid']))?>">首页</a></li>
		<?php } ?>
		<li <?php if($ac=='review') { ?>class="on"<?php } ?>><a href="<?php echo tsurl('user','review',array('id'=>$strUser['userid']))?>">书评</a></li>
		<?php if(0) { ?>
		<li <?php if($ac=='book') { ?>class="on"<?php } ?>><a href="<?php echo tsurl('user','book',array('id'=>$strUser['userid']))?>">图书</a></li>
		<?php } ?>
		<li <?php if($ac=='ask') { ?>class="on"<?php } ?>><a href="<?php echo tsurl('user','ask',array('id'=>$strUser['userid']))?>">问答</a></li>
		<li <?php if($ac=='event') { ?>class="on"<?php } ?>><a href="<?php echo tsurl('user','event',array('id'=>$strUser['userid']))?>">活动</a></li>
		<li <?php if($ac=='guestbook') { ?>class="on"<?php } ?>><a href="<?php echo tsurl('user','guestbook',array('id'=>$strUser['userid']))?>">留言</a></li>
	</ul>
</div>
