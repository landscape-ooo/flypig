<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div id="bd" class="bd clearfix">
	<h1 id="user-title">
		<span class="icon-user2"></span>
		用户登陆
	</h1>
	<div class="bd-left">
		
		<div id="login-form">
			<form method="POST" action="<?php echo tsurl('user','login',array('ts'=>'do'))?>">
			<table class="com-table">
				<tr><th>Email：</th><td><input  type="text" name="email" /></td></tr>
				<tr><th>密码：</th><td><input  type="password" name="pwd" /></td></tr>
				<tr>
					<th>Cookie有效期：</th>
					<td>
						<select name="cktime">
						<option value="31536000">一年</option>
						<option value="2592000">一月</option>
						<option value="86400">一天</option>
						<option value="3600">一小时</option>
						<option value="0">即时</option>
						</select>
					</td>
				</tr>
				<tr>
					<th></th>
					<td>
						<input type="hidden" name="jump" value="<?php echo $jump;?>" />
						<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
						<button class="btn btn-success btn-large" type="submit">登陆</button> 
						&nbsp;&nbsp;<a href="<?php echo tsurl('user','register')?>">还没有注册？</a> | <a href="<?php echo tsurl('user','forgetpwd')?>">忘记密码？</a>
					</td>
				</tr>
			</table>
			</form>
		</div>
		
	</div>
	<div class="bd-right">
		
		<div id="passport">
			<?php doAction('user_login_footer')?>
		</div>
		
	</div>
</div>

<?php include template('footer'); ?>