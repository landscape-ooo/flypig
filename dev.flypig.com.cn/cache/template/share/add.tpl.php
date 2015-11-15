<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div id="path" class="bd clearfix">
	<span class="icon icon-home"></span>
	<a href="<?php echo SITE_URL;?>" title="<?php echo $TS_SITE['base']['site_title'];?>首页">首页</a>  &gt;  <a href="<?php echo tsurl($app)?>" title="<?php echo $TS_APP['options']['appname'];?>"><?php echo $TS_APP['options']['appname'];?></a>  &gt;  发布分享
</div>

<div id="bd" class="bd clearfix">
	<h1 id="edit-title">
		<span class="icon icon-pencil2"></span>
		发布分享
	</h1>
	<div class="bd-left">
		
		<div class="com-box">
			<div id="edit-body">
				
				<form method="POST" action="<?php echo tsurl('share','add',array('ts'=>'do'))?>" enctype="multipart/form-data" onsubmit="return mainFormCheck()">
				<table class="com-table">
					<tr>
						<th>分类：</th>
						<td>
							<select name="cateid">
								<option value='0' >请选择分类</option>
								<?php foreach((array)$arrCate as $key=>$item) {?>
								<option value="<?php echo $item['cateid'];?>"<?php if($cateid==$item['cateid']) { ?> selected<?php } ?>><?php echo $item['catename'];?></option>
								<?php }?>
							</select>
							&nbsp;&nbsp;<a href="<?php echo tsurl('share','cate',array('ts'=>'add'))?>">添加分类</a>
						</td>
					</tr>
					<tr>
						<th>标题：</th>
						<td><input type="text" name="title" style="width:494px;" /></td>
					</tr>
					<tr>
						<th>图片：</th>
						<td>
							<input type="file" name="photo">
						</td>
					</tr>
					<tr>
						<th valign="top">内容：</th>
						<td>
							<textarea type="text" name="content" id="content" style="width:500px;height:300px;"></textarea>
						</td>
					</tr>
					<?php if($TS_USER['user']['isadmin']=="1") { ?>
					<!--
					<tr>
						<th>标签：</th>
						<td><input style="width:250px;" type="text" name="tag" /> (多个标签请用,号分割)</td>
					</tr>
					<tr>
						<th>评论：</th>
						<td><input type="radio" checked="select" name="iscomment" value="0" />允许 <input type="radio" name="iscomment" value="1" />不允许</td>
					</tr>
					-->
					<?php } ?>
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
							<button class="btn btn-success" type="submit">提交</button>
							<?php if($cateid) { ?>
							<a href="<?php echo tsurl('share','index',array('cateid'=>$cateid))?>">返回</a>
							<?php } else { ?>
							<a href="<?php echo tsurl('share')?>">返回</a>
							<?php } ?>
						</td>
					</tr>
				</table>
				</form>
				<script type="text/javascript">
				function mainFormCheck(){
					var title = $("input[name='title']").val();
					var photo = $("input[name='photo']").val();
					var content = $("textarea[name='content']").val();
					if(title == '' || photo == '' || content == ''){
						alert('请填写标题、图片和内容');
						return false;
					}
					<?php if($TS_SITE['base']['isauthcode']) { ?>
					var authcode = $('input[name=authcode]').val();
					if(authcode == ''){
						alert('请填写验证码');
						return false;
					}
					<?php } ?>
					$("button[type='submit']").html('正在提交^_^').css({'background':'#ccc'}).removeAttr('type');
				}
				</script>
				
			</div>
		</div>
		
	</div>
	<div class="bd-right">
		
		<div class="com-box">
			<div class="content">
				&gt; <?php if($cateid) { ?><a href="<?php echo tsurl('share','index',array('cateid'=>$cateid))?>">返回</a><?php } else { ?><a href="<?php echo tsurl('share')?>">返回</a><?php } ?>
			</div>
		</div>
		
		<?php doAction('gobad','300')?>
		
	</div>
</div>

<?php doAction('tseditor2','#content')?>

<?php include template('footer'); ?>