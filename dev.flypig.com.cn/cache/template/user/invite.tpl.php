<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>
<!--main-->
<div class="midder">
<div class="mc">
<h1><?php echo $TS_SITE['base'][site_title];?>邀请码</h1>

<div class="bbox">
<p class="fs14 tac">物质匮乏，一码难求，今日您仅剩下 <span style="font-size:24px;color:#FF6600"><?php echo $codeNum;?></span> 个邀请码</p>

<?php if($codeNum=='0') { ?>
<p style="text-align:center;padding:50px;">
<a class="subab" href="<?php echo tsurl('user','invite',array(ts=>code))?>">点击申请邀请码</a>
</p>
<?php } else { ?>

<div class="invitecode">
<ul>
<?php foreach((array)$arrCode as $key=>$item) {?>
<li><?php echo $item['invitecode'];?></li>
<?php }?>
</ul>
</div>

<?php } ?>
</div>

</div>
</div>
<?php include template('footer'); ?>