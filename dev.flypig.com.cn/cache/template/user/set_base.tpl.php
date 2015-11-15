<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div id="bd" class="bd clearfix">
	<h1 id="user-title">
		<span class="icon icon-cog"></span>
		用户设置
	</h1>
	<div class="bd-left">
		
		<div class="com-box">
			<div id="set-menu">
				<?php include template('set_menu'); ?>
			</div>
			<div id="set-body">
				
				<form method="post" action="<?php echo SITE_URL;?>index.php?app=user&ac=do&ts=setbase">
				<table class="com-table">
					<tr>
						<th>用户名：</th>
						<td><input style="width:300px;" name="username" value="<?php echo $strUser['username'];?>"  /></td>
					</tr>
					<tr>
						<th>性别：</th>
						<td>
							<input <?php if($strUser['sex']=='2') { ?>checked="select"<?php } ?> name="sex" type="radio" value="2" /> 女 &nbsp;
							<input <?php if($strUser['sex']=='1') { ?>checked="select"<?php } ?> name="sex" type="radio" value="1" /> 男 &nbsp;
							<input <?php if($strUser['sex']=='0') { ?>checked="select"<?php } ?> name="sex" type="radio" value="0" /> 保密 &nbsp;
						</td>
					</tr>
					<tr>
						<th>电话：</th>
						<td><input style="width:300px;" name="phone" value="<?php echo $strUser['phone'];?>"  /></td>
					</tr>
					<tr>
						<th valign="top">自我介绍：</th>
						<td><textarea style="height:100px;width:300px;" name="about"><?php echo $strUser['about'];?></textarea></td>
					</tr>
					<tr>
						<th valign="top">签名：</th>
						<td><textarea style="height:100px;width:300px" name="signed"><?php echo $strUser['signed'];?></textarea></td>
					</tr>
					<tr>
						<th></th>
						<td>
							<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
							<button class="btn btn-success" type="submit">修改</button>
						</td>
					</tr>
				</table>
				</form>
				
			</div>
		</div>
		
	</div>
	<div class="bd-right">
		
		<?php include template('set_right'); ?>
		
	</div>
</div>

<?php include template('footer'); ?>