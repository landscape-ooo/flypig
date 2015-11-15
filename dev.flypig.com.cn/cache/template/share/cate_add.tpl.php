<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div id="path" class="bd clearfix">
	<span class="icon icon-home"></span>
	<a href="<?php echo SITE_URL;?>" title="<?php echo $TS_SITE['base']['site_title'];?>首页">首页</a>  &gt;  <a href="<?php echo tsurl('share','index')?>" title="飞猪网好分享">好分享</a>  &gt;  添加分类
</div>

<div id="bd" class="bd clearfix">
	<div class="bd-left">
		
		<div class="com-bar clearfix">
			<div class="com-bar-tit">
				<span class="icon icon-plus"></span>
				添加分类
			</div>
			<div class="com-bar-more">
				&nbsp;&nbsp;<span class="icon icon-cog"></span> <a href="<?php echo tsurl('share','cate')?>">我的分类</a>
			</div>
		</div>
		
		<div id="cate-edit" class="com-box">
			
			<form method="POST" action="<?php echo tsurl('share','cate',array('ts'=>'add_do'))?>">
			<table class="com-table">
				<tr>
					<th>分类名称：</th>
					<td><input name="catename" value="" style="width:300px" /></td>
				</tr>
				<?php if($TS_SITE['base']['isauthcode']) { ?>
				<tr>
					<th>验证码：</th>
					<td>
						<input name="authcode" /> <img align="absmiddle" src="<?php echo tsurl('pubs','code')?>" onclick="javascript:newgdcode(this,this.src);" title="点击刷新验证码" alt="点击刷新验证码" style="cursor:pointer;"/>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<th></th>
					<td>
						<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
						<button class="btn btn-success" type="submit">添加分类</button>
						&nbsp;&nbsp;<a href="<?php echo tsurl('share','cate')?>">返回</a>
					</td>
				</tr>
			</table>
			</form>
			
		</div>
		
	</div>
	<div class="bd-right">
		
		<?php if($TS_APP['options']['iscreate']==0 || $TS_USER['user']['isadmin']==1) { ?>
		<a class="btn3d btn3d-full" href="<?php echo tsurl('share','add')?>" style="margin-top:30px;"><span class="icon-pen"></span> 发布分享</a>
		<?php } ?>
		
		<!--广告位-->
		<?php doAction('gobad','300')?>
		
	</div>
</div>

<?php include template('footer'); ?>