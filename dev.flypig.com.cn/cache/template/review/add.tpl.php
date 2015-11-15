<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div id="path" class="bd clearfix">
	<span class="icon icon-home"></span>
	<a href="<?php echo SITE_URL;?>" title="<?php echo $TS_SITE['base'][site_title];?>首页">首页</a>  &gt;  <a href="<?php echo tsurl('ask')?>" title="<?php echo $TS_APP['options'][appname];?>"><?php echo $TS_APP['options'][appname];?></a>  &gt;  发布《<?php echo $strBook['bookname'];?>》书评
</div>

<div id="bd" class="bd clearfix">
	<div class="bd-left">
		
		<div class="com-box">
			<div id="edit-body">
				
				<form method="POST" action="<?php echo SITE_URL;?>index.php?app=review&ac=add&ts=do" onsubmit="return newReviewFrom(this)">
				<table class="com-table">
					<tr>
						<th>书名：</th>
						<td><input type="text" name="bookname" value="<?php echo $strBook['bookname'];?>" disabled style="width:494px;" /></td>
					</tr>
					<tr>
						<th>标题：</th>
						<td><input type="text" name="title" style="width:494px;" /></td>
					</tr>
					<tr>
						<th>评价：</th>
						<td>
							<label><input type="radio" value="40" name="rating">很差</label>
							<label><input type="radio" value="50" name="rating">较差</label>
							<label><input type="radio" value="60" name="rating">还行</label>
							<label><input type="radio" value="80" name="rating">推荐</label>
							<label><input type="radio" value="90" name="rating">力荐</label>
						</td>
					</tr>
					<tr>
						<th valign="top">内容：</th>
						<td>
							<textarea type="text" id="content" name="content" style="width:500px;height:300px;"></textarea>
						</td>
					</tr>
					<!--
					<tr>
						<th>标签：</th>
						<td><input style="width:250px;" type="text" name="tag" /> (多个标签请用,号分割)</td>
					</tr>
					-->
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
							<input type="hidden" name="bookid" value="<?php echo $strBook['bookid'];?>" />
							<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
							<button class="btn btn-success" type="submit">提交</button>
							<a href="<?php echo tsurl('book','show',array('id'=>$strBook['bookid']))?>" id="back">返回</a>
						</td>
					</tr>
				</table>
				</form>

			</div>
		</div>
		
	</div>
	<div class="bd-right">
		
		<?php include template('edit_right'); ?>
		
	</div>
</div>

<?php doAction('tseditor2','#content')?>

<?php include template('footer'); ?>