<?php defined('IN_TS') or die('Access Denied.'); ?><?php include pubTemplate("header");?>

<?php if($isAutoGo) { ?>
<meta http-equiv="refresh" content="0;url=<?php echo $url;?>" />
<?php } ?>

<div class="bd">
	<div id="com-tsnotice">
		<p><?php echo $notice;?></p>
		<p class="tolink"><?php if($button) { ?><a href="<?php echo $url;?>"><?php echo $button;?></a><?php } ?></p>
	</div>
</div>

<?php include pubTemplate("footer");?>