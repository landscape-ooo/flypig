<?php defined('IN_TS') or die('Access Denied.'); ?><div id="user-box" class="com-box clearfix">
	<div class="face">
		<a href="<?php echo tsurl('user','space',array('id'=>$strUser['userid']))?>" rel="face" uid="<?php echo $strUser['userid'];?>"><img title="<?php echo $strUser['username'];?>" alt="<?php echo $strUser['username'];?>" src="<?php echo $strUser['face'];?>" width="48"></a>
	</div>
	<div class="info">
		<h4><a href="<?php echo tsurl('user','space',array('id'=>$strUser['userid']))?>"><?php echo $strUser['username'];?></a></h4>
		<div>
			<?php if($strUser['userid'] != $TS_USER['user'][userid]) { ?>
			<?php if($strUser['isfollow']) { ?>
			<a class="btn btn-mini" href="javascript:void('0');" onclick="unfollow('<?php echo $strUser['userid'];?>','<?php echo $_SESSION['token'];?>');"><span class="icon icon-minus"></span> 取消关注</a>
			<?php } else { ?>
			<a class="btn btn-mini" href="javascript:void('0')" onclick="follow('<?php echo $strUser['userid'];?>','<?php echo $_SESSION['token'];?>');"><span class="icon icon-plus"></span> 关注</a>
			<?php } ?>
			<a href="<?php echo tsurl('user','message',array(ts=>add,touserid=>$strUser['userid']))?>" rel="nofollow" class="btn btn-mini"><span class="icon icon-envelope"></span> 发消息</a>
			<?php } ?>
		</div>
	</div>
	<div class="clear"></div>
	<ul class="other">
		<li class="br"><span class="fs14"><a href="<?php echo tsurl('user','follow',array('id'=>$strUser['userid']))?>"><?php echo $strUser['count_follow'];?></a></span><br />关注</li>
		<li class="br"><span class="fs14"><a href="<?php echo tsurl('user','followed',array('id'=>$strUser['userid']))?>"><?php echo $strUser['count_followed'];?></a></span><br />粉丝</li>
		<li><span class="fs14"><?php echo $strUser['count_score'];?></span><br />积分</li>
	</ul>
	<div class="clear"></div>
</div>

<div id="user-follow" class="com-box">
	<h3>
		<span class="icon icon-IcoMoon"></span>
		关注的用户<span class="pl">&nbsp;(<a href="<?php echo tsurl('user','follow',array('id'=>$strUser['userid']))?>">全部</a>) </span>
	</h3>
	<div class="content line23">
		<?php foreach((array)$arrFollowUser as $key=>$item) {?>
		<dl class="obu">
			<dt>
				<a class="nbg" href="<?php echo tsurl('user','space',array('id'=>$item['userid']))?>" rel="face" uid="<?php echo $item['userid'];?>"><img alt="<?php echo $item['username'];?>" class="m_sub_img" src="<?php echo $item['face'];?>" width="48" height="48"></a>
			</dt>
			<dd>
				<a href="<?php echo tsurl('user','space',array('id'=>$item['userid']))?>"><?php echo $item['username'];?></a>
			</dd>
		</dl>
		<?php }?>
	</div>
</div>
