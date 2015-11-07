<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>
<?php if($TS_APP['options'][isregister]=='2') { ?>
<?php } else { ?>
<script type="text/javascript" src="<?php echo SITE_URL;?>public/js/Validform_v5.3.2_min.js"></script>
<script language="javascript">
$(document).ready(function(){
	$(".subform").Validform({
		btnSubmit:"#btnsub", 
		btnReset:".btnreset",
		tiptype:3,
	});
});
</script>
<?php } ?>


<div id="bd" class="bd clearfix">
	<h1 id="user-title">
		<span class="icon-user2"></span>
		用户注册
	</h1>
	<div class="bd-left">
		
		<div id="register-form">

			<?php if($TS_APP['options'][isregister]=='2') { ?>
			<p>系统升级中，暂时关闭用户注册！</p>
			<p><a href="<?php echo SITE_URL;?>">返回首页</a></p>
			<?php } else { ?>
			<form class="subform" method="POST" action="<?php echo tsurl('user','register',array('ts'=>'do'))?>">
			<table class="com-table" width="100%" border="0" cellspacing="0" cellpadding="0">
				<?php if($TS_SITE['base']['isinvite']=='1') { ?>
				<tr>
					<th><font color="red">邀请码：</font></th>
					<td><input name="invitecode" type="text" /> </td>
				</tr>
				<?php } ?>
				<tr>
					<th>Email：</th>
					<td><input name="email" type="text" datatype="e" ajaxurl="<?php echo SITE_URL;?>index.php?app=user&ac=check&ts=inemail" /> </td>
				</tr>
				<tr>
					<th>密码：</th>
					<td><input type="password" name="pwd"  datatype="*6-16" /> </td>
				</tr>
				<tr>
					<th>重复密码：</th>
					<td><input type="password" name="repwd"  datatype="*" recheck="pwd" /> </td>
				</tr>
				<tr>
					<th>用户名：</th>
					<td><input type="text" name="username" datatype="s2-18" ajaxurl="<?php echo SITE_URL;?>index.php?app=user&ac=check&ts=isusername" /> </td>
				</tr>
				<?php if($TS_SITE['base']['isauthcode']) { ?>
				<tr>
					<th>验证码：</th>
					<td><input name="authcode" datatype="*" ajaxurl="<?php echo SITE_URL;?>index.php?app=user&ac=check&ts=code" /> </td>
				</tr>
				<tr>
					<th></th>
					<td><img align="absmiddle" src="<?php echo tsurl('pubs','code')?>" onclick="javascript:newgdcode(this,this.src);" title="点击刷新验证码" alt="点击刷新验证码" style="cursor:pointer;" /></td>
				</tr>
				<?php } ?>
				<tr>
					<th></th>
					<td>
						<input type="hidden" name="fuserid" value="<?php echo $fuserid;?>" />
						<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
						<button id="btnsub" class="btn btn-success btn-large" type="submit">注册</button>
						&nbsp;&nbsp;<a href="<?php echo tsurl('user','login')?>">已有账户？登陆</a>
					</td>
				</tr>
			</table>
			</form>
			<?php } ?>

		</div>
		
	</div>
	<div class="bd-right">
		
		<div id="passport">
			<?php doAction('user_login_footer')?>
		</div>
		
	</div>
</div>

<?php include template('footer'); ?>