<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div class="midder">

<div class="mc">
<div class="cleft">
<div class="bbox">
<?php include template('menu'); ?>

<div class="clear"></div>

<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#cccccc">
<tr><td>名称</td><td>积分</td><td>状态</td><td>时间</td></tr>
<?php foreach((array)$arrScore as $key=>$item) {?>
<tr><td><?php echo $item['scorename'];?></td><td><?php echo $item['score'];?></td><td><?php if($item['status']==0) { ?>+<?php } else { ?>-<?php } ?></td><td><?php echo date('Y-m-d H:i:s',$item['addtime'])?></td></tr>
<?php }?>
</table>

<div class="clear"></div>
<div class="page"><?php echo $pageUrl;?></div>
</div>
</div>

<div class="cright">
<?php include template('userinfo'); ?>
</div>

</div>
</div>
<?php include template('footer'); ?>